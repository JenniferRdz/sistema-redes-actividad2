<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Control - Sistema Redes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

    <nav class="navbar navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="#">Sistema Redes Inalámbricas</a>
            <div class="d-flex text-white align-items-center">
                <span class="me-3">Bienvenido, <strong><?php echo $_SESSION['user_name']; ?></strong></span>
                <a href="logout.php" class="btn btn-sm btn-outline-danger">Cerrar Sesión</a>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-10 text-center mb-5">
                <h1 class="display-4 fw-bold text-primary">Panel de Control</h1>
                <p class="lead text-muted">Bienvenido al sistema de gestión de tu negocio</p>
            </div>

            <!-- Tarjeta Clientes -->
            <div class="col-md-4 mb-4">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-body text-center p-4">
                        <div class="display-1 text-success mb-3">
                            <i class="bi bi-people"></i>
                        </div>
                        <h3 class="card-title fw-bold">Clientes</h3>
                        <p class="card-text text-muted">Registra nuevos clientes y cambia sus estados (Baja/Activo).</p>
                        <a href="clientes.php" class="btn btn-success w-100 py-2 fw-bold">Administrar Clientes</a>
                    </div>
                </div>
            </div>

            <!-- Tarjeta Pagos -->
            <div class="col-md-4 mb-4">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-body text-center p-4">
                        <div class="display-1 text-primary mb-3">
                            <i class="bi bi-currency-dollar"></i>
                        </div>
                        <h3 class="card-title fw-bold">Pagos</h3>
                        <p class="card-text text-muted">Controla las mensualidades y detecta deudores automáticamente.</p>
                        <a href="pagos.php" class="btn btn-primary w-100 py-2 fw-bold">Control de Pagos</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Cargar Iconos de Bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
</body>

</html>