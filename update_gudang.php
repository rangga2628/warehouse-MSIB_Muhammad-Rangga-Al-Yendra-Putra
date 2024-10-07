<?php
include_once 'Database.php';
include_once 'Gudang.php';

$database = new Database();
$db = $database->getConnection();

$gudang = new Gudang($db);

if (isset($_GET['id'])) {
    $gudang->id = $_GET['id'];
    $query = "SELECT * FROM gudang WHERE id = :id";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':id', $gudang->id);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($_POST) {
        $gudang->name = $_POST['name'];
        $gudang->location = $_POST['location'];
        $gudang->capacity = $_POST['capacity'];
        $gudang->status = $_POST['status'];
        $gudang->opening_hour = $_POST['opening'];
        $gudang->closing_hour = $_POST['closing'];

        if ($gudang->update()) {
            echo "Gudang berhasil diperbarui.";
        } else {
            echo "Gagal memperbarui gudang.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Gudang</title>
    <link rel="stylesheet" href="styles.css">
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
    <div class="form-container">
        <a href="index.php" class="button back-button">Kembali</a>
        <h2>EDIT GUDANG</h2>
        <form action="update_gudang.php?id=<?php echo $gudang->id; ?>" method="post">
            <label for="name">Name</label>
            <input type="text" id="name" name="name" value="<?php echo $row['name']; ?>" required>

            <label for="location">Location</label>
            <input type="text" id="location" name="location" value="<?php echo $row['location']; ?>" required>

            <label for="capacity">Capacity</label>
            <input type="number" id="capacity" name="capacity" value="<?php echo $row['capacity']; ?>" required>

            <label for="status">Status</label>
            <select id="status" name="status">
                <option value="aktif" <?php if ($row['status'] == 'aktif') echo 'selected'; ?>>Aktif</option>
                <option value="tidak_aktif" <?php if ($row['status'] == 'tidak_aktif') echo 'selected'; ?>>Tidak Aktif</option>
            </select>

            <label for="opening">Opening</label>
            <input type="time" id="opening" name="opening" value="<?php echo $row['opening_hour']; ?>" required>

            <label for="closing">Closing</label>
            <input type="time" id="closing" name="closing" value="<?php echo $row['closing_hour']; ?>" required>

            <input type="submit" value="UPDATE">
        </form>
    </div>
</body>
</html>
