<?php
require_once __DIR__ . '/../../../utils/config.php';

// Obtener los datos de la patente desde la solicitud POST
$patente = isset($_POST['patente']) ? $_POST['patente'] : '';

if (!$patente) {
    echo "La patente es obligatoria.";
    exit;
}

// Preparar la consulta SQL para buscar la patente y el estatus
$sql = "SELECT * FROM tbl_agentesaduanales WHERE patente = :patente";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':patente', $patente, PDO::PARAM_STR);
$stmt->execute();

// Verificar si se encontró el registro
if ($stmt->rowCount() > 0) {
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    // Verificar si el estatus es 1 (activo)
    if ($row['id_estatus'] == 1) {
        // Si la patente está activa, devolver los datos
        echo "<h3>Resultados</h3>";
        echo "<p><strong>Patente:</strong> " . $row['patente'] . "</p>";
        echo "<p><strong>Nombre:</strong> " . $row['nombre'] . "</p>";
        echo "<p><strong>Agencia:</strong> " . $row['nombreCorto'] . "</p>";
        echo "<p><strong>Estatus:</strong> " . ($row['id_estatus'] == 1 ? 'Activo' : 'Inactivo') . "</p>";
    } else {
        // Si el estatus no es activo, mostrar mensaje de invalidez
        echo "<p><strong>La patente no está activa.</strong></p>";
    }
} else {
    // Si no se encuentra la patente, mostrar mensaje de error
    echo "<p><strong>No se encontraron datos para esta patente.</strong></p>";
}
?>
