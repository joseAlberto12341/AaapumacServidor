<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Entrega de Pedimentos</title>
    <link rel="stylesheet" href="/Aaapumac/src/views/assets/css/listPedimentos.css">

   
</head>
<body>
    <a href="/Aaapumac/asociado/listaPedimentos">Regresar</a>
    <div class="container">
        <div class="header">
            <h1>Entrega de Pedimento</h1>
            <form id="formPedimentos" method="POST" action="/Aaapumac/asociado/guardarPedimentos">
                <input type="hidden" id="fecha" name="fecha">
                <input type="hidden" id="Hora" name="Hora">
                <input type="hidden" id="total_pedimentos" name="total_pedimentos">
                <input type="hidden" id="datos_pedimentos" name="datos_pedimentos">
            </form>
            <div class="date-field">
                <label for="fechaInput">Fecha:</label>
                <input type="date" id="fechaInput" value="<?php echo date('Y-m-d'); ?>">
            </div>
        </div>

        <div class="sync-info">
            Al seleccionar un valor en la primera celda de "Tipo de operación", todas las celdas de Tipo de operación se sincronizarán automáticamente.<br>
            Al seleccionar un valor en la primera celda de "CR", todas las celdas de CR se sincronizarán automáticamente.
        </div>

        <div class="controls">
            <div class="left-controls">
                <button class="btn btn-primary" id="addRow">+ Agregar Fila</button>
                <br>
                <button class="btn" id="deleteRow">Eliminar Fila</button>
            </div>
            <div class="right-controls">
                <button class="btn btn-success" id="saveData">Guardar en Base de Datos</button>
            </div>
        </div>

        <div class="table-container">
            <table class="excel-table" id="pedimentosTable">
                <thead>
                    <tr>
                        <th width="120px">Pedimento</th>
                        <th width="200px">Tipo de operación</th>
                        <th width="180px">Clave de pedimento</th>
                        <th width="100px">CR</th>
                        <th width="80px" class="action-cell"></th>
                    </tr>
                </thead>
                <tbody id="tableBody">
                    <!-- Las filas se generarán dinámicamente -->
                </tbody>
            </table>
        </div>

        <div class="footer">
            <button class="btn" id="cancelFormat">Cancelar</button>
        </div>
    </div>

    <div class="notification" id="notification">Datos guardados correctamente</div>

    <script src="/Aaapumac/src/views/assets/js/folioPedimentos.js"></script>
</body>
</html>