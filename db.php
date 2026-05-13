<?php
// Configuración de la conexión con tus datos específicos
$serverName = ".\\SQLEXPRESS02"; 
$connectionInfo = array(
    "Database" => "SistemaRedes",
    "UID" => "sa",
    "PWD" => "232003",
    "CharacterSet" => "UTF-8",
    "TrustServerCertificate" => true
);

$conn = sqlsrv_connect($serverName, $connectionInfo);

if (!$conn) {
    echo "<div style='color:red; padding:20px; border:1px solid red; background:#fff0f0;'>";
    echo "<strong>Error de Conexión:</strong> No se pudo conectar a SQL Server.<br><br>";
    echo "Verifica que:<br>";
    echo "1. El servicio SQL Server (SQLEXPRESS02) esté corriendo.<br>";
    echo "2. El usuario 'sa' tenga permisos.<br>";
    echo "3. Los drivers 'sqlsrv' estén instalados en PHP.<br><br>";
    echo "Detalles del error:<pre>";
    print_r(sqlsrv_errors());
    echo "</pre></div>";
    die();
}
?>
