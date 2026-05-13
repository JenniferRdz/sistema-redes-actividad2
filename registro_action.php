<?php
require_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'];
    $usuario = $_POST['usuario'];
    $password = $_POST['password'];

    // 1. Revalidación de seguridad en el servidor (por si saltan el JS)
    $pattern = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/';
    
    if (!preg_match($pattern, $password)) {
        die("La contraseña no cumple con los requisitos de seguridad.");
    }

    // 2. Hash con SALT automático (Bcrypt)
    // PHP maneja el salt internamente con PASSWORD_DEFAULT, lo cual es lo más seguro.
    $passwordHash = password_hash($password, PASSWORD_DEFAULT);

    // 3. Inserción en SQL Server
    $sql = "INSERT INTO Usuarios (usuario, password, nombre) VALUES (?, ?, ?)";
    $params = array($usuario, $passwordHash, $nombre);
    $stmt = sqlsrv_query($conn, $sql, $params);

    if ($stmt === false) {
        $errors = sqlsrv_errors();
        if ($errors[0]['code'] == 2627) { // Error de llave duplicada
            die("Error: El nombre de usuario ya existe.");
        }
        die(print_r($errors, true));
    }

    echo "<script>alert('Usuario registrado exitosamente'); window.location='login.php';</script>";
}
?>
