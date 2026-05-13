<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
require_once 'db.php';

// --- REQUISITO: ARREGLOS (Arrays) ---
// Definimos un arreglo para mapear el estado con el color de Bootstrap
$colores_estado = [
    'Activo' => 'table-light',      // Normal
    'Suspendido' => 'table-warning', // Amarillo
    'Baja' => 'table-danger'        // Rojo
];

// --- REQUISITO: BASES DE DATOS (Entidad Clientes) ---
$sql = "SELECT * FROM Clientes ORDER BY estado ASC, nombre ASC";
$stmt = sqlsrv_query($conn, $sql);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Clientes - Redes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        .card-header { background: #4e73df; color: white; }
        .btn-add { background: #1cc88a; color: white; border: none; }
        .btn-add:hover { background: #17a673; color: white; }
    </style>
</head>
<body class="bg-light">

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="dashboard.php">Sistema Redes</a>
        <div class="navbar-nav ms-auto">
            <a class="nav-link" href="logout.php">Cerrar Sesión</a>
        </div>
    </div>
</nav>

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class="bi bi-people-fill"></i> Control de Clientes</h2>
        <button class="btn btn-add" data-bs-toggle="modal" data-bs-target="#modalCliente">
            <i class="bi bi-person-plus-fill"></i> Nuevo Cliente
        </button>
    </div>

    <div class="card shadow">
        <div class="card-header fw-bold">Lista de Clientes (Siguiendo lógica de Excel)</div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th>Nombre</th>
                            <th>Teléfono</th>
                            <th>Dirección</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // --- REQUISITO: CICLOS (Loops) ---
                        if ($stmt) {
                            while($cliente = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                                
                                // --- REQUISITO: SENTENCIAS (If/Else) ---
                                // Buscamos el color en el arreglo según el estado
                                $clase_fila = isset($colores_estado[$cliente['estado']]) ? $colores_estado[$cliente['estado']] : '';
                        ?>
                            <tr class="<?php echo $clase_fila; ?>">
                                <td class="fw-bold"><?php echo $cliente['nombre']; ?></td>
                                <td><?php echo $cliente['telefono']; ?></td>
                                <td><?php echo $cliente['direccion']; ?></td>
                                <td>
                                    <?php if($cliente['estado'] == 'Activo'): ?>
                                        <span class="badge bg-success">Activo</span>
                                    <?php elseif($cliente['estado'] == 'Suspendido'): ?>
                                        <span class="badge bg-warning text-dark">Suspendido</span>
                                    <?php else: ?>
                                        <span class="badge bg-danger">Baja Definitiva</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <a href="cliente_estado_action.php?id=<?php echo $cliente['id']; ?>&nuevo=Suspendido" class="btn btn-outline-warning" title="Suspender"><i class="bi bi-pause-fill"></i></a>
                                        <a href="cliente_estado_action.php?id=<?php echo $cliente['id']; ?>&nuevo=Baja" class="btn btn-outline-danger" title="Dar de Baja"><i class="bi bi-x-circle-fill"></i></a>
                                        <a href="cliente_estado_action.php?id=<?php echo $cliente['id']; ?>&nuevo=Activo" class="btn btn-outline-success" title="Reactivar"><i class="bi bi-play-fill"></i></a>
                                    </div>
                                </td>
                            </tr>
                        <?php 
                            }
                        } 
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal para Nuevo Cliente -->
<div class="modal fade" id="modalCliente" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="cliente_alta_action.php" method="POST">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">Registrar Nuevo Cliente</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nombre del Cliente</label>
                        <input type="text" name="nombre" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Teléfono</label>
                        <input type="text" name="telefono" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Dirección</label>
                        <textarea name="direccion" class="form-control" rows="2"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Guardar Cliente</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
