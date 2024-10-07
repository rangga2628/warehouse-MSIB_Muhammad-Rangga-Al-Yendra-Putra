<?php
include_once 'Database.php';
include_once 'Gudang.php';

$database = new Database();
$db = $database->getConnection();

$gudang = new Gudang($db);

$stmt = $gudang->read();
$num = $stmt->rowCount();

if ($num > 0) {
    echo "<table>";
    echo "<tr><th>ID</th><th>Nama Gudang</th><th>Lokasi</th><th>Kapasitas</th><th>Status</th><th>Jam Buka</th><th>Jam Tutup</th></tr>";
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        extract($row);
        echo "<tr>";
        echo "<td>{$id}</td>";
        echo "<td>{$name}</td>";
        echo "<td>{$location}</td>";
        echo "<td>{$capacity}</td>";
        echo "<td>{$status}</td>";
        echo "<td>{$opening_hour}</td>";
        echo "<td>{$closing_hour}</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "Tidak ada data gudang.";
}
?>
