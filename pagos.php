<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
require_once 'db.php';

$anio_actual = date("Y");

// --- REQUISITO: ARREGLOS ---
$meses = [
    1 => "Ene", 2 => "Feb", 3 => "Mar", 4 => "Abr", 5 => "May", 6 => "Jun",
    7 => "Jul", 8 => "Ago", 9 => "Sep", 10 => "Oct", 11 => "Nov", 12 => "Dic"
];

// Obtenemos todos los clientes que no estén dados de baja definitiva
$sql_clientes = "SELECT id, nombre, estado FROM Clientes WHERE estado != 'Baja' ORDER BY nombre ASC";
$stmt_clientes = sqlsrv_query($conn, $sql_clientes);

// Obtenemos todos los pagos del año actual para cargarlos en memoria (Eficiencia)
$pagos_realizados = [];
$sql_pagos = "SELECT id_cliente, mes FROM Pagos WHERE anio = ?";
$stmt_pagos = sqlsrv_query($conn, $sql_pagos, array($anio_actual));

if ($stmt_pagos) {
    while ($p = sqlsrv_fetch_array($stmt_pagos, SQLSRV_FETCH_ASSOC)) {
        $pagos_realizados[$p['id_cliente']][] = $p['mes'];
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Control de Pagos - <?php echo $anio_actual; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        .table-pagos td { text-align: center; vertical-align: middle; cursor: pointer; }
        .table-pagos td:hover { background-color: #f8f9fa; }
        .bg-paid { background-color: #d1e7dd !important; color: #0f5132; }
        .bg-debt { background-color: #f8d7da !important; color: #842029; }
        .sticky-col { position: sticky; left: 0; background-color: white; z-index: 1; border-right: 2px solid #dee2e6 !important; }
    </style>
</head>
<body class="bg-light">

<nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow">
    <div class="container">
        <a class="navbar-brand fw-bold" href="dashboard.php">SISTEMA REDES</a>
        <div class="navbar-nav ms-auto">
            <a class="nav-link active" href="clientes.php">Clientes</a>
            <a class="nav-link" href="logout.php">Salir</a>
        </div>
    </div>
</nav>

<div class="container-fluid mt-4 px-4">
    <div class="card shadow-sm">
        <div class="card-header bg-white py-3">
            <div class="row align-items-center">
                <div class="col">
                    <h5 class="mb-0 text-primary fw-bold"><i class="bi bi-calendar-check"></i> Control de Mensualidades <?php echo $anio_actual; ?></h5>
                </div>
                <div class="col-auto">
                    <span class="badge bg-success">Pagado</span>
                    <span class="badge bg-danger">Pendiente</span>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-pagos table-sm">
                    <thead class="table-dark">
                        <tr>
                            <th class="sticky-col" style="min-width: 200px;">Cliente</th>
                            <?php foreach($meses as $m): ?>
                                <th><?php echo $m; ?></th>
                            <?php endforeach; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        // --- REQUISITO: CICLO 1 (Clientes) ---
                        while($c = sqlsrv_fetch_array($stmt_clientes, SQLSRV_FETCH_ASSOC)): 
                            $id_c = $c['id'];
                        ?>
                        <tr>
                            <td class="sticky-col text-start fw-bold">
                                <?php echo $c['nombre']; ?>
                                <?php if($c['estado'] == 'Suspendido'): ?>
                                    <span class="badge bg-warning text-dark" style="font-size: 0.6rem;">SUSP</span>
                                <?php endif; ?>
                            </td>
                            
                            <?php 
                            // --- REQUISITO: CICLO 2 (Meses - Ciclo Anidado) ---
                            for($i = 1; $i <= 12; $i++): 
                                // --- REQUISITO: SENTENCIAS (Verificar pago) ---
                                $pagado = (isset($pagos_realizados[$id_c]) && in_array($i, $pagos_realizados[$id_c]));
                                $mes_actual = date('n');
                                $es_futuro = ($i > $mes_actual);
                            ?>
                                <td class="<?php echo $pagado ? 'bg-paid' : ($es_futuro ? '' : 'bg-debt'); ?>" 
                                    onclick="confirmarPago(<?php echo $id_c; ?>, <?php echo $i; ?>, '<?php echo $c['nombre']; ?>', '<?php echo $meses[$i]; ?>')">
                                    
                                    <?php if($pagado): ?>
                                        <i class="bi bi-check-circle-fill text-success"></i>
                                    <?php elseif(!$es_futuro): ?>
                                        <i class="bi bi-exclamation-triangle-fill text-danger"></i>
                                    <?php else: ?>
                                        <small class="text-muted opacity-25">-</small>
                                    <?php endif; ?>
                                    
                                </td>
                            <?php endfor; ?>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal para confirmar pago -->
<script>
function confirmarPago(idCliente, mes, nombre, nombreMes) {
    if(confirm(`¿Registrar pago de ${nombreMes} para ${nombre}?`)) {
        window.location.href = `pago_registrar_action.php?id_cliente=${idCliente}&mes=${mes}&anio=<?php echo $anio_actual; ?>`;
    }
}
</script>

</body>
</html>
