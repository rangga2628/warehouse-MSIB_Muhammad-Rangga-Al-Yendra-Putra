<?php
include_once 'Database.php';
include_once 'Gudang.php';

$database = new Database();
$db = $database->getConnection();

$gudang = new Gudang($db);

if (isset($_GET['id'])) {
    $gudang->id = htmlspecialchars($_GET['id']); // Sanitize the input
    if ($gudang->delete()) {
        // Redirect back to index.php after successful deletion
        header("Location: index.php?message=Gudang berhasil dihapus.");
        exit();
    } else {
        // Redirect back to index.php with an error message
        header("Location: index.php?error=Gagal menghapus gudang.");
        exit();
    }
}
?>
