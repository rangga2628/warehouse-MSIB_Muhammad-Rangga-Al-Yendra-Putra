<?php
include_once 'Database.php';
include_once 'Gudang.php';

$database = new Database();
$db = $database->getConnection();
$gudang = new Gudang($db);

// Searching data by warehouse name
$result = null;
if (isset($_GET['search'])) {
    $search = htmlspecialchars(trim($_GET['search']));
    $query = "SELECT * FROM gudang WHERE name LIKE :search";
    $stmt = $db->prepare($query);
    $stmt->bindValue(':search', "%$search%");
    $stmt->execute();
    $result = $stmt;
} else {
    $result = $gudang->read();
}

// Handling status toggle through form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['toggleStatus'])) {
    $gudang->id = htmlspecialchars(trim($_POST['id']));
    $gudang->toggleStatus();
    header("Location: index.php"); // Reload the page after updating
    exit();
}

// Check for success or error messages
$message = isset($_GET['message']) ? htmlspecialchars($_GET['message']) : '';
$error = isset($_GET['error']) ? htmlspecialchars($_GET['error']) : '';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Gudang</title>
    <link rel="stylesheet" href="styless.css">
</head>
<body>
    <nav>
    <div class="logo-container">
        <img src="img\logo.png" alt="Logo Image">
        <div class="logo">WAREHOUSE MSIB</div>
    </div>
        <ul>
            <li><a href="index.php">Daftar Gudang</a></li>
            <li><a href="create_gudang.php">Tambah Gudang</a></li>
        </ul>
    </nav>

    <div class="notification">
        <?php if ($message): ?>
            <div class="success"><?php echo $message; ?></div>
        <?php elseif ($error): ?>
            <div class="error"><?php echo $error; ?></div>
        <?php endif; ?>
    </div>

    <div class="container">
        <h2>DAFTAR GUDANG</h2>
        <!-- Search Form -->
        <form action="index.php" method="get" class="form-container">
            <input type="text" name="search" placeholder="Cari Gudang" value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
            <input type="submit" value="Cari">
        </form>

        <!-- Warehouse List Table -->
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>No.</th> <!-- Added column for No. -->
                        <th>ID</th>
                        <th>Name</th>
                        <th>Location</th>
                        <th>Capacity</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($result) : ?>
                        <?php 
                        $no = 1; // Initialize counter
                        while ($row = $result->fetch(PDO::FETCH_ASSOC)) : ?>
                            <tr>
                                <td><?php echo $no++; ?></td> <!-- Display sequential number -->
                                <td><?php echo htmlspecialchars($row['id']); ?></td>
                                <td><?php echo htmlspecialchars($row['name']); ?></td>
                                <td><?php echo htmlspecialchars($row['location']); ?></td>
                                <td><?php echo htmlspecialchars($row['capacity']); ?></td>
                                <td id="status-<?php echo $row['id']; ?>"><?php echo htmlspecialchars($row['status']); ?></td>
                                <td class="table-actions">
                                    <!-- Edit Button -->
                                    <a href="update_gudang.php?id=<?php echo htmlspecialchars($row['id']); ?>" class="button edit">Edit</a>
                                    
                                    <!-- Delete Button -->
                                    <a href="delete_gudang.php?id=<?php echo htmlspecialchars($row['id']); ?>" class="button delete">Hapus</a>
                                    
                                    <!-- Toggle Status Form -->
                                    <form action="index.php" method="post" style="display: inline;">
                                        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                        <input type="submit" name="toggleStatus" class="button toggle-status <?php echo $row['status'] == 'aktif' ? 'active' : 'nonactive'; ?>" 
                                               value="<?php echo ($row['status'] == 'aktif') ? 'Nonaktifkan' : 'Aktifkan'; ?>">
                                    </form>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else : ?>
                        <tr>
                            <td colspan="7">No records found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
