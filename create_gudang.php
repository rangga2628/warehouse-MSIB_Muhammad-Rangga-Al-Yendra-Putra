<?php
include_once 'Database.php';
include_once 'Gudang.php';

$database = new Database();
$db = $database->getConnection();

$gudang = new Gudang($db);

if ($_POST) {
    $gudang->name = $_POST['name'];
    $gudang->location = $_POST['location'];
    $gudang->capacity = $_POST['capacity'];
    $gudang->status = $_POST['status'];
    $gudang->opening_hour = $_POST['opening'];
    $gudang->closing_hour = $_POST['closing'];

    if ($gudang->create()) {
        echo "Gudang berhasil ditambahkan.";
    } else {
        echo "Gagal menambahkan gudang.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Gudang</title>
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
        <h2>TAMBAH GUDANG</h2>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <label for="name">Name</label>
            <input type="text" id="name" name="name" required>

            <label for="location">Location</label>
            <input type="text" id="location" name="location" required>

            <label for="capacity">Capacity</label>
            <input type="number" id="capacity" name="capacity" required>

            <label for="status">Status</label>
            <select id="status" name="status">
                <option value="aktif">Aktif</option>
                <option value="tidak_aktif">Tidak Aktif</option>
            </select>

            <label for="opening">Opening</label>
            <input type="time" id="opening" name="opening" required>

            <label for="closing">Closing</label>
            <input type="time" id="closing" name="closing" required>

            <input type="submit" value="CREATE">
        </form>
    </div>
</body>
</html>
