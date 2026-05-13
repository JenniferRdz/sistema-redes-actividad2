<?php
session_start();
require_once 'db.php';

if (isset($_GET['id_cliente']) && isset($_GET['mes']) && isset($_GET['anio'])) {
    $id_cliente = $_GET['id_cliente'];
    $mes = $_GET['mes'];
    $anio = $_GET['anio'];

    // 1. Verificar si ya existe el pago para evitar duplicados
    $sql_check = "SELECT id FROM Pagos WHERE id_cliente = ? AND mes = ? AND anio = ?";
    $params = array($id_cliente, $mes, $anio);
    $stmt_check = sqlsrv_query($conn, $sql_check, $params);

    if (sqlsrv_fetch_array($stmt_check, SQLSRV_FETCH_ASSOC)) {
        // Ya existe, podrías borrarlo si quieres que el clic sea "toggle"
        $sql = "DELETE FROM Pagos WHERE id_cliente = ? AND mes = ? AND anio = ?";
    } else {
        // No existe, lo insertamos
        $sql = "INSERT INTO Pagos (id_cliente, mes, anio, monto) VALUES (?, ?, ?, 0.00)";
    }

    $stmt = sqlsrv_query($conn, $sql, $params);

    if ($stmt === false) {
        die(print_r(sqlsrv_errors(), true));
    }

    header("Location: pagos.php");
}
?>
