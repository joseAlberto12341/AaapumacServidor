<?php
// Obtener la ruta actual
$currentPath = $_SERVER['REQUEST_URI'];

// Dividir la ruta en segmentos
$segments = explode('/', $currentPath);

// Eliminar el primer segmento vacío
array_shift($segments);

// Inicializar el breadcrumb
$breadcrumb = '
                                        <li class="breadcrumb-item"><a href="/">Inicio</a></li>';

// Construir los enlaces del breadcrumb
$path = '/';
foreach ($segments as $segment) {
    $path .= $segment;
    if ($segment == end($segments)) {
        $breadcrumb .= '
                                        <li class="breadcrumb-item active"><a href="' . $path . '">' . ucfirst($segment);
    } else {
        $breadcrumb .= '
                                        <li class="breadcrumb-item"><a href="' . $path . '">' . ucfirst($segment);
    }
}

// Imprimir el breadcrumb
echo '
            <div class="row">
                <div class="col-md-12 stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <div class="template-demo">
                                <nav aria-label="breadcrumb">
                                    <ol class="breadcrumb bg-light">'
    . $breadcrumb . '</a></li>
                                    </ol>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
';
