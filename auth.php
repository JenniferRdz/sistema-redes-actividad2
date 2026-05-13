<?php
session_start();
require_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $usuario = $_POST['usuario'];
    $password = $_POST['password'];

    // 1. Buscar al usuario
    $sql = "SELECT id, usuario, password, nombre FROM Usuarios WHERE usuario = ?";
    $params = array($usuario);
    $stmt = sqlsrv_query($conn, $sql, $params);

    if ($stmt === false) {
        die(print_r(sqlsrv_errors(), true));
    }

    if ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
        // 2. Verificar el hash de la contraseña (compara con el salt interno)
        if (password_verify($password, $row['password'])) {
            // Login exitoso
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['user_name'] = $row['nombre'];
            $_SESSION['user_login'] = $row['usuario'];
            
            header("Location: dashboard.php");
            exit();
        }
    }

    // Si llega aquí, falló el login
    header("Location: login.php?error=1");
    exit();
}
?>
