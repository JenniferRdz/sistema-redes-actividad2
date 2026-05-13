<?php
session_start();
require_once 'db.php';

if (isset($_GET['id']) && isset($_GET['nuevo'])) {
    $id = $_GET['id'];
    $nuevo_estado = $_GET['nuevo'];

    $sql = "UPDATE Clientes SET estado = ? WHERE id = ?";
    $params = array($nuevo_estado, $id);
    $stmt = sqlsrv_query($conn, $sql, $params);

    if ($stmt === false) {
        die(print_r(sqlsrv_errors(), true));
    }

    header("Location: clientes.php");
}
?>
