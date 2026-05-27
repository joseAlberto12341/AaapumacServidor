<?php
namespace App\Controllers;
use App\Repositories\AsociadoRepository;
use App\Repositories\NotificationRepository;
use App\Repositories\callacenterRepository; 
use PDO;

class AsociadoController
{
      public static function Home()
    {
        \Utils\AuthHelper::requireAuth(9);
        return [
            'view' => 'asociado/home.php',
            'scripts' => 'asociado',
            'action' => 'content',
        ];
    }

    public static function Profile()
    {
        \Utils\AuthHelper::requireAuth(9);
        return [
            'view' => 'asociado/home.php',
            'scripts' => 'asociado',
            'action' => 'content',
            'data' => [
                'title' => 'Mi Perfil',
                'subtitle' => 'Actualiza tu información personal',
            ],
        ];
    }

    public static function aso()
    {
        \Utils\AuthHelper::requireAuth(9);
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $user_id = $_SESSION['id_user'] ?? null;

        if (!$user_id) {
            $_SESSION['error_message'] = "No hay una sesión activa";
            header('Location: /Aaapumac/asociado');
            exit();
        }

        $informacionExistente = AsociadoRepository::obtenerInformacionGeneral($user_id);
        $usuarioInfo = AsociadoRepository::getPersonalById($user_id);

        return [
            'view' => 'asociado/home.php',
            'scripts' => 'asociado',
            'action' => 'aso',
            'data' => [
                'title' => 'Mi Perfil',
                'subtitle' => $usuarioInfo ? 'Bienvenido: ' . $usuarioInfo->getUsername() : 'Mi información personal',
                'icon' => 'mdi mdi-account',
                'user_id' => $user_id,
                'informacionExistente' => $informacionExistente,
                'usuarioInfo' => $usuarioInfo
            ]
        ];
    }

    public static function listaPedimentos()
    {
        \Utils\AuthHelper::requireAuth(9);
        $page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
        $perPage = isset($_GET['per_page']) ? (int)$_GET['per_page'] : 25;
        
        $filters = [
            'search' => $_GET['search'] ?? '',
            'estatus' => $_GET['estatus'] ?? '',
            'fecha_desde' => $_GET['fecha_desde'] ?? '',
            'fecha_hasta' => $_GET['fecha_hasta'] ?? ''
        ];
        
        $resultado = AsociadoRepository::listPedimentos($page, $perPage, $filters);
        
        return [
            'view' => 'asociado/home.php',
            'scripts' => 'asociado',
            'action' => 'listaPedimentos',
            'data' => [
                'title' => 'Gestor de Pedimentos',
                'subtitle' => 'Pedimentos registrados',
                'button' => 'Agregar nuevo pedimento',
                'icon' => 'mdi mdi-account-multiple',
                'listaPedimentos' => $resultado['data'],
                'pagination' => [
                    'total' => $resultado['total'],
                    'page' => $resultado['page'],
                    'per_page' => $resultado['per_page'],
                    'total_pages' => $resultado['total_pages']
                ],
                'filters' => $filters
            ]
        ];
    }
    public static function folioPedimentos()
    {
        \Utils\AuthHelper::requireAuth(9);
    return [
            'view' => 'asociado/home.php',  // Carga home.php
            'scripts' => 'asociado',
            'action' => 'folioPedimentos',  // Y home.php debe incluir el formulario
            'data' => [
                'title' => 'Alta de Pedimentos',  // ← Cambiar título
                'subtitle' => 'Registra nuevos pedimentos',  // ← Cambiar subtítulo
                'icon' => 'mdi mdi-plus-box',  // ← Icono apropiado
            ]
        ];
        }

    public static function serviAran(){
        \Utils\AuthHelper::requireAuth(9);
        return [
            'view' => 'asociado/home.php',
            'scripts' => 'asociado',
            'action' => 'serviAran',
            'data' => [
                'title' => 'Servicios Arancelarios',
                'subtitle' => 'Consulta nuestros servicios arancelarios disponibles',
                'icon' => 'mdi mdi-scale-balance',
            ]
        ];
    }

    public static function serviJuri(){
        \Utils\AuthHelper::requireAuth(9);
        return [
            'view' => 'asociado/home.php',
            'scripts' => 'asociado',
            'action' => 'serviJuri',
            'data' => [
                'title' => 'Servicios Jurídicos',
                'subtitle' => 'Consulta nuestros servicios legales y asesoría especializada',
                'icon' => 'mdi mdi-gavel',
            ]
        ];
    }

    // public static function altaPedimentos()
    // {
    //     \Utils\AuthHelper::requireAuth(9);
    //     if (session_status() === PHP_SESSION_NONE) {
    //         session_start();
    //     }

    //     $user_id = $_SESSION['id_user'] ?? null;

    //     if (!$user_id) {
    //         header('Location: /Aaapumac/asociado');
    //         exit;
    //     }

    //     $existeInfo = AsociadoRepository::existeInformacionGeneral($user_id);
        
    //     if (!$existeInfo) {
    //         $_SESSION['error_message'] = 'Debes completar tu información de contacto antes de registrar pedimentos';
    //         header('Location: /Aaapumac/asociado/Profile');
    //         exit;
    //     }

    //     return [
    //         'view' => 'asociado/altaPedimentos.php',
    //         'scripts' => 'asociado',
    //         'action' => 'altaPedimentos',
    //         'data' => [
    //             'title' => 'Alta de Pedimentos',
    //             'subtitle' => 'Registra nuevos pedimentos'
    //         ]
    //     ];
    // }

    public static function guardarPedimentos()
    {
        \Utils\AuthHelper::requireAuth(9);
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $user_id = $_SESSION['id_user'] ?? null;

        if (!$user_id) {
            $_SESSION['error_message'] = "No hay una sesión activa";
            header('Location: /Aaapumac/asociado/folioPedimentos');
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $_SESSION['error_message'] = 'Método no permitido';
            header('Location: /Aaapumac/asociado/folioPedimentos');
            exit();
        }

        try {
            date_default_timezone_set('America/Mexico_City');
            $horaActual = (int) date('H');
            $fechaServidor = date('Y-m-d');
            $horaServidor = date('H:i:s');

            if ($horaActual >= 18) {
                $fechaServidor = date('Y-m-d', strtotime('+1 day'));
            }

            $fecha_formulario = $_POST['fecha'] ?? '';
            $total_pedimentos = $_POST['total_pedimentos'] ?? 0;
            $datos_pedimentos_json = $_POST['datos_pedimentos'] ?? '[]';

            if (empty($fecha_formulario) || empty($datos_pedimentos_json)) {
                $_SESSION['error_message'] = 'Datos incompletos';
                header('Location: /Aaapumac/asociado/folioPedimentos');
                exit();
            }

            $pedimentos_array = json_decode($datos_pedimentos_json, true);

            if (json_last_error() !== JSON_ERROR_NONE) {
                $_SESSION['error_message'] = 'Error en formato de datos';
                header('Location: /Aaapumac/asociado/folioPedimentos');
                exit();
            }

            if (!is_array($pedimentos_array) || count($pedimentos_array) === 0) {
                $_SESSION['error_message'] = 'No hay pedimentos válidos';
                header('Location: /Aaapumac/asociado/folioPedimentos');
                exit();
            }

            $pedimentosData = [];
            foreach ($pedimentos_array as $pedimento) {
                if (!empty($pedimento['pedimento']) && !empty($pedimento['tipo_operacion'])) {
                    $pedimentosData[] = [
                        'pedimento' => $pedimento['pedimento'],
                        'tipo_operacion' => $pedimento['tipo_operacion'],
                        'clave_pedimento' => $pedimento['clave_pedimento'] ?? '',
                        'CR' => $pedimento['cr'] ?? '',
                        'fecha' => $fechaServidor,
                        'Hora' => $horaServidor
                    ];
                }
            }

            if (empty($pedimentosData)) {
                $_SESSION['error_message'] = 'No hay pedimentos válidos para guardar';
                header('Location: /Aaapumac/asociado/folioPedimentos');
                exit();
            }

            $lastId = AsociadoRepository::guardarPedimentos($user_id, $pedimentosData);

            if ($lastId) {
                $fechaMostrar = date('d/m/Y', strtotime($fechaServidor));
                
                $_SESSION['success_message'] = "Se guardaron " . count($pedimentosData) . " pedimentos correctamente. " .
                    "Fecha registrada: " . $fechaMostrar . " (Hora: " . $horaServidor . ")";
                header('Location: /Aaapumac/asociado/listaPedimentos');
                exit();
            } else {
                $_SESSION['error_message'] = 'No se pudo guardar ningún pedimento';
                header('Location: /Aaapumac/asociado/folioPedimentos');
                exit();
            }

        } catch (\Exception $e) {
            error_log("Error en guardarPedimentos: " . $e->getMessage());
            $_SESSION['error_message'] = 'Error al guardar los pedimentos: ' . $e->getMessage();
            header('Location: /Aaapumac/asociado/folioPedimentos');
            exit();
        }
    }
    // Método para generar PDF manualmente
    public static function generarPDFPedimento($id)
    {
         \Utils\AuthHelper::requireAuth(9);
        // Iniciar sesión si no está iniciada
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        try {
            // Obtener datos del pedimento
            $pedimento = AsociadoRepository::getPedimentoById($id);

            if (!$pedimento) {
                $_SESSION['error_message'] = 'Pedimento no encontrado';
                header('Location: /Aaapumac/asociado/listaPedimentos');
                exit();
            }

            // Verificar si ya existe un PDF generado
            if ($pedimento->pdf_generado && $pedimento->pdf_filename) {
                // Redirigir al PDF existente
                header('Location: /Aaapumac/public/uploads/pedimentos/' . $pedimento->pdf_filename);
                exit();
            }

            // Generar nuevo PDF
            $filename = 'pedimento_' . $pedimento->folio . '_' . date('Ymd_His') . '.pdf';
            $pdfPath = __DIR__ . '/../../public/uploads/pedimentos/' . $filename;

            // Asegurarse de que el directorio exista
            if (!is_dir(dirname($pdfPath))) {
                mkdir(dirname($pdfPath), 0777, true);
            }

            // Generar PDF
            self::crearPDF($pedimento, $pdfPath);

            // Actualizar la base de datos
            AsociadoRepository::marcarPDFGenerado($id, $filename);

            // Redirigir al PDF
            header('Location: /Aaapumac/public/uploads/pedimentos/' . $filename);
            exit();

        } catch (\Exception $e) {
            error_log("Error al generar PDF: " . $e->getMessage());
            $_SESSION['error_message'] = 'Error al generar el PDF: ' . $e->getMessage();
            header('Location: /Aaapumac/asociado/listaPedimentos');
            exit();
        }
    }

    public static function generarPDF()
    {
         \Utils\AuthHelper::requireAuth(9);
        // Iniciar sesión si no está iniciada
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Obtener ID del pedimento desde GET
        $id = $_GET['id'] ?? null;

        if (!$id) {
            $_SESSION['error_message'] = 'ID de pedimento no especificado';
            header('Location: /Aaapumac/asociado/listaPedimentos');
            exit();
        }

        // Llamar al método existente
        return self::generarPDFPedimento($id);
    }

    private static function crearPDF($pedimento, $pdfPath)
    {
         \Utils\AuthHelper::requireAuth(9);
        require_once(__DIR__ . '/../../vendor/setasign/fpdf/fpdf.php');

        // AGREGAR ESTA FUNCIÓN AL INICIO DEL MÉTODO
        function convertirTexto($texto)
        {
            // Convertir acentos a caracteres compatibles con FPDF
            $acentos = array(
                'á' => chr(225),
                'é' => chr(233),
                'í' => chr(237),
                'ó' => chr(243),
                'ú' => chr(250),
                'Á' => chr(193),
                'É' => chr(201),
                'Í' => chr(205),
                'Ó' => chr(211),
                'Ú' => chr(218),
                'ñ' => chr(241),
                'Ñ' => chr(209),
                'ü' => chr(252),
                'Ü' => chr(220),
                '€' => chr(128),
                '£' => chr(163),
                '¥' => chr(165),
                '©' => chr(169),
                '®' => chr(174)
            );
            return strtr($texto, $acentos);
        }

        // FUNCIÓN PARA CREAR UNA PÁGINA COMPLETA CON DATOS ESPECÍFICOS DE LA TABLA
        function crearPaginaCompleta($pdf, $pedimento, $datos_pagina, $numero_pagina)
        {
            $pdf->AddPage();

            $margen = 10;

            // LOGO OFICIAL IZQUIERDA
            $rutaLogoOficial = $_SERVER['DOCUMENT_ROOT'] . '/aaapumac/src/views/assets/img/aaapumac2.png';
            $anchoLogoOficial = 35;

            if (file_exists($rutaLogoOficial)) {
                @$pdf->Image($rutaLogoOficial, $margen, $margen, $anchoLogoOficial);
            }

            // LOGO AAA PUMAC DERECHA
            $rutaLogoDerecha = $_SERVER['DOCUMENT_ROOT'] . '/aaapumac/src/views/assets/img/aaapumac.png';
            $anchoLogoDerecha = 30;

            if (file_exists($rutaLogoDerecha)) {
                $xDerecha = $pdf->GetPageWidth() - $anchoLogoDerecha - $margen;
                @$pdf->Image($rutaLogoDerecha, $xDerecha, $margen, $anchoLogoDerecha);
            }

            // Espacio después de los logos
            $pdf->SetFont('Arial', '', 12);

            // Solo agregar "(CONTINUACIÓN)" si no es la primera página
            if ($numero_pagina > 1) {
                $pdf->Cell(0, 10, convertirTexto('FORMATO DE ENTREGA DE PEDIMENTOS (CONTINUACIÓN)'), 0, 1, 'C');
            } else {
                $pdf->Cell(0, 10, convertirTexto('FORMATO DE ENTREGA DE PEDIMENTOS'), 0, 1, 'C');
            }

            $pdf->SetFont('Arial', 'B', 10);
            $pdf->Cell(0, 8, convertirTexto('MODULOS DE GESTIONES'), 0, 1, 'C');
            $pdf->Cell(0, 8, convertirTexto('(Exportación, Importación Ferrocarril y Tránsitos)'), 0, 1, 'C');

            $pdf->Ln(5);

            // Guardar posición Y inicial
            $startY = $pdf->GetY();

            // ====== COLUMNA IZQUIERDA ======

            // Patente - ESCRIBIR DATO SOBRE LA LÍNEA
            $pdf->SetFont('Arial', '', 8);
            $pdf->SetX(20);
            $pdf->Cell(25, 8, convertirTexto('Patente:'), 0, 0, 'L');
            $pdf->SetFont('Arial', '', 8);
            $texto_patente = isset($pedimento->patente) ? $pedimento->patente : '';
            $pdf->Cell(60, 8, convertirTexto($texto_patente), 0, 0, 'L');
            $pdf->SetX(45);
            $pdf->Cell(60, 8, '___________________________________________________________________', 0, 1, 'L');

            // Agente aduanal
            $pdf->SetFont('Arial', '', 8);
            $pdf->SetX(20);
            $pdf->Cell(25, 8, convertirTexto('Agente aduanal:'), 0, 0, 'L');
            $pdf->SetFont('Arial', '', 8);
            $texto_agente = isset($pedimento->agente_aduanal) ? $pedimento->agente_aduanal : '';
            $pdf->Cell(60, 8, convertirTexto($texto_agente), 0, 0, 'L');
            $pdf->SetX(45);
            $pdf->Cell(60, 8, '___________________________________________________________________', 0, 1, 'L');

            // Agencia aduanal
            $pdf->SetFont('Arial', '', 8);
            $pdf->SetX(20);
            $pdf->Cell(25, 8, convertirTexto('Agencia aduanal:'), 0, 0, 'L');
            $pdf->SetFont('Arial', '', 8);
            $texto_agencia = isset($pedimento->agencia_aduanal) ? $pedimento->agencia_aduanal : '';
            $pdf->Cell(60, 8, convertirTexto($texto_agencia), 0, 0, 'L');
            $pdf->SetX(45);
            $pdf->Cell(60, 8, '___________________________________________________________________', 0, 1, 'L');

            // Nombre ejecutivo
            $pdf->SetFont('Arial', '', 8);
            $pdf->SetX(20);
            $pdf->Cell(25, 8, convertirTexto('Nombre ejecutivo:'), 0, 0, 'L');
            $pdf->SetFont('Arial', '', 8);
            $texto_nombre = isset($pedimento->nombre_completo) ? $pedimento->nombre_completo : '';
            $pdf->Cell(60, 8, convertirTexto($texto_nombre), 0, 0, 'L');
            $pdf->SetX(45);
            $pdf->Cell(60, 8, '___________________________________________________________________', 0, 1, 'L');

            // Correo electronico
            $pdf->SetFont('Arial', '', 8);
            $pdf->SetX(20);
            $pdf->Cell(25, 8, convertirTexto('Correo electrónico:'), 0, 0, 'L');
            $pdf->SetFont('Arial', '', 8);
            $texto_correo = isset($pedimento->correo_electronico) ? $pedimento->correo_electronico : '';
            $pdf->Cell(60, 8, convertirTexto($texto_correo), 0, 0, 'L');
            $pdf->SetX(45);
            $pdf->Cell(60, 8, '___________________________________________________________________', 0, 1, 'L');

            // ====== COLUMNA DERECHA ======
            $pdf->SetY($startY);
            $pdf->Ln(2);

            // PRIMER CUADRO: "folio aduana"
            $pdf->SetDrawColor(192, 192, 192);
            $pdf->SetFont('Arial', '', 6);
            $pdf->SetX(160);
            $pdf->Cell(23, 8, convertirTexto('Folio aduana:'), 1, 0, 'L');

            $pdf->SetFont('Arial', '', 5);
            $pdf->SetX(183);
            $texto_folio = isset($pedimento->folios_aduana) ? $pedimento->folios_aduana : '';
            $pdf->Cell(18, 8, convertirTexto($texto_folio), 1, 1, 'L');

            // SEGUNDO CUADRO: Fecha y Teléfono
            // Fila 1: Fecha
            $pdf->SetFont('Arial', '', 5);
            $pdf->SetXY(160, $startY + 16);
            $pdf->Cell(23, 8, convertirTexto('Fecha:'), 1, 0, 'L');

            $pdf->SetFont('Arial', '', 5);
            $pdf->SetX(183);
            $fecha = isset($pedimento->fecha) ? date('d/m/Y', strtotime($pedimento->fecha)) : '';
            $pdf->Cell(18, 8, convertirTexto($fecha), 1, 0, 'L');

            // Fila 2: Teléfono
            $pdf->SetFont('Arial', '', 5);
            $pdf->SetXY(160, $startY + 24);
            $pdf->Cell(23, 8, convertirTexto('Teléfono:'), 1, 0, 'L');

            $pdf->SetFont('Arial', '', 5);
            $pdf->SetX(183);
            $texto_telefono = isset($pedimento->telefono) ? $pedimento->telefono : '';
            $pdf->Cell(18, 8, convertirTexto($texto_telefono), 1, 0, 'L');

            // Ajustar posición Y para continuar
            $finalY = max($startY + 40, $startY + 30);
            $pdf->SetY($finalY);
            $pdf->Ln(10);

            // ====== CREAR TABLA CON LOS PEDIMENTOS DE ESTA PÁGINA ======
            $rowHeight = 8;
            $widths = array(25, 40, 15, 15, 45, 55);
            $totalWidth = array_sum($widths);
            $tableX = ($pdf->GetPageWidth() - $totalWidth) / 2;

            $headers = array(
                convertirTexto('Pedimento'),
                convertirTexto('Tipo de operación'),
                convertirTexto('Clave'),
                convertirTexto('CR'),
                convertirTexto('Resultado'),
                convertirTexto('Observaciones')
            );

            // Dibujar encabezados
            $pdf->SetDrawColor(0, 0, 0);
            $pdf->SetFont('Arial', '', 5);
            $pdf->SetX($tableX);

            for ($i = 0; $i < count($headers); $i++) {
                if ($i == 2) { // Columna de "Clave de pedimentos"
                    $x = $pdf->GetX();
                    $y = $pdf->GetY();

                    $pdf->Cell($widths[$i], 10, '', 1, 0, 'C');

                    $pdf->SetXY($x, $y + 1);
                    $pdf->Cell($widths[$i], 4, convertirTexto('Clave de'), 0, 0, 'C');

                    $pdf->SetXY($x, $y + 5);
                    $pdf->Cell($widths[$i], 4, convertirTexto('pedimentos'), 0, 0, 'C');

                    $pdf->SetXY($x + $widths[$i], $y);

                } elseif ($i == 3) { // Columna "CR"
                    $x = $pdf->GetX();
                    $y = $pdf->GetY();
                    $pdf->Cell($widths[$i], 10, $headers[$i], 1, 0, 'C');

                } elseif ($i == 4) { // Columna "Resultado" dividida en dos
                    $x = $pdf->GetX();
                    $y = $pdf->GetY();

                    $pdf->Cell($widths[$i], 10, '', 1, 0, 'C');

                    $pdf->SetXY($x, $y);
                    $pdf->Cell($widths[$i], 4, convertirTexto('Resultado'), 0, 0, 'C');

                    $pdf->SetXY($x, $y + 6);
                    $pdf->Cell($widths[$i] / 2, 4, 'V', 0, 0, 'C');

                    $pdf->SetXY($x + $widths[$i] / 2, $y + 6);
                    $pdf->Cell($widths[$i] / 2, 4, 'R', 0, 0, 'C');

                    $pdf->SetXY($x + $widths[$i], $y);

                } elseif ($i == 5) { // Columna "Observaciones" dividida en dos
                    $x = $pdf->GetX();
                    $y = $pdf->GetY();

                    $pdf->Cell($widths[$i], 10, '', 1, 0, 'C');

                    $pdf->SetXY($x, $y);
                    $pdf->Cell($widths[$i], 4, convertirTexto('Observaciones'), 0, 0, 'C');

                    $pdf->SetXY($x, $y + 6);
                    $pdf->Cell($widths[$i] / 2, 4, convertirTexto('Motivo'), 0, 0, 'C');

                    $pdf->SetXY($x + $widths[$i] / 2, $y + 6);
                    $pdf->Cell($widths[$i] / 2, 4, convertirTexto('Estado'), 0, 0, 'C');

                    $pdf->SetXY($x + $widths[$i], $y);

                } else {
                    $pdf->Cell($widths[$i], 10, $headers[$i], 1, 0, 'C');
                }
            }
            $pdf->Ln(10);

            // Definir los textos específicos para cada fila en la columna "Motivo"
            // Estos son los MISMOS en TODAS las páginas
            $textos_motivo = array(
                convertirTexto('No ingresado'),
                'RFC',
                convertirTexto('Razón social'),
                convertirTexto('Peso'),
                convertirTexto('Bultos'),
                convertirTexto('Mercancía'),
                convertirTexto('Sin anexo 29'),
                convertirTexto('Incidencias'),
                convertirTexto('Salida no programada'),
                'OVMT'
            );

            // Mostrar 10 filas (siempre 10 filas por página)
            for ($row = 0; $row < 10; $row++) {
                $pdf->SetX($tableX);

                // Obtener datos para esta fila (si existen)
                $fila_datos = isset($datos_pagina[$row]) ? $datos_pagina[$row] : array();

                // Primera columna: Pedimento
                $valor_pedimento = isset($fila_datos['pedimento']) ? $fila_datos['pedimento'] : '';
                $pdf->Cell($widths[0], $rowHeight, convertirTexto($valor_pedimento), 1, 0, 'C');

                // Segunda columna: Tipo de operacion
                $valor_tipo_operacion = isset($fila_datos['tipo_operacion']) ? $fila_datos['tipo_operacion'] : '';
                $pdf->Cell($widths[1], $rowHeight, convertirTexto($valor_tipo_operacion), 1, 0, 'C');

                // Tercera columna: Clave
                $valor_clave = isset($fila_datos['clave']) ? $fila_datos['clave'] : '';
                $pdf->Cell($widths[2], $rowHeight, convertirTexto($valor_clave), 1, 0, 'C');

                // Cuarta columna: CR
                $valor_cr = isset($fila_datos['CR']) ? $fila_datos['CR'] : '';
                $pdf->Cell($widths[3], $rowHeight, convertirTexto($valor_cr), 1, 0, 'C');

                // Quinta columna: Resultado - Subcolumna V
                $x = $pdf->GetX();
                $y = $pdf->GetY();
                $valor_v = isset($fila_datos['resultado_v']) ? $fila_datos['resultado_v'] : '';
                $pdf->Cell($widths[4] / 2, $rowHeight, convertirTexto($valor_v), 1, 0, 'C');

                // Sexta columna: Resultado - Subcolumna R
                $pdf->SetXY($x + $widths[4] / 2, $y);
                $valor_r = isset($fila_datos['resultado_r']) ? $fila_datos['resultado_r'] : '';
                $pdf->Cell($widths[4] / 2, $rowHeight, convertirTexto($valor_r), 1, 0, 'C');

                // Séptima columna: Observaciones - Subcolumna Motivo
                $pdf->Cell($widths[5] / 2, $rowHeight, '', 1, 0, 'C');

                // Escribir el texto del motivo PREdefinido (SIEMPRE los mismos textos)
                $motivo_texto = $textos_motivo[$row]; // Usar el texto predefinido correspondiente

                $textHeight = 4;
                $yOffset = ($rowHeight - $textHeight) / 2;

                // Para la última fila con texto más largo
                if ($row == 9) {
                    $pdf->SetXY($x + $widths[4] + 1, $y + 1);
                    $pdf->MultiCell(($widths[5] / 2) - 2, 3, $motivo_texto, 0, 'C');
                } else {
                    $pdf->SetXY($x + $widths[4], $y + $yOffset);
                    $pdf->Cell($widths[5] / 2, $textHeight, $motivo_texto, 0, 0, 'C');
                }

                // Octava columna: Observaciones - Subcolumna Estado
                $pdf->SetXY($x + $widths[4] + ($widths[5] / 2), $y);
                $valor_estado = isset($fila_datos['estado']) ? $fila_datos['estado'] : '';
                $pdf->Cell($widths[5] / 2, $rowHeight, convertirTexto($valor_estado), 1, 0, 'C');

                $pdf->Ln();
            }

            // ====== PIE DE PÁGINA (en todas las páginas) ======
            $pdf->Ln(20);
            $startY = $pdf->GetY();

            // Firma de aduana
            $pdf->SetFont('Arial', '', 8);
            $pdf->SetX(20);
            $pdf->Cell(25, 8, convertirTexto('Firma de aduana:'), 0, 1, 'C');
            $pdf->SetX(10);
            $pdf->Cell(60, 8, '_____________________________________', 0, 0, 'C');

            // Volver a la posición inicial Y
            $pdf->SetY($startY);
            $pdf->Ln(2);

            // CD
            $pdf->SetFont('Arial', '', 6);
            $pdf->SetX(160);
            $pdf->Cell(23, 8, convertirTexto('CD:'), 0, 0, 'L');
            $pdf->SetFont('Arial', '', 6);
            $pdf->SetX(165);
            $pdf->Cell(23, 8, convertirTexto('_____________________________'), 0, 1, 'L');
            $pdf->Ln(2);


            // Agrega esta función al inicio de tu clase o método
            function convertirHora12h($hora_24h)
            {
                if (empty($hora_24h))
                    return '';

                // Extraer hora y minutos
                $partes = explode(':', $hora_24h);
                if (count($partes) < 2)
                    return $hora_24h;

                $hora = (int) $partes[0];
                $minutos = $partes[1];

                // Determinar AM/PM
                $periodo = ($hora < 12) ? 'AM' : 'PM';

                // Convertir a formato 12h
                if ($hora == 0) {
                    $hora_12h = 12;
                } elseif ($hora > 12) {
                    $hora_12h = $hora - 12;
                } else {
                    $hora_12h = $hora;
                }

                // Formatear con ceros a la izquierda si es necesario
                return sprintf('%d:%02d %s', $hora_12h, $minutos, $periodo);
            }

            // Luego en tu código del PDF:
            $pdf->SetFont('Arial', '', 6);
            $pdf->SetX(157);
            $pdf->Cell(23, 8, convertirTexto('Hora:'), 0, 0, 'L');
            $pdf->SetFont('Arial', '', 6);

            $texto_hora = isset($pedimento->Hora) ? convertirHora12h($pedimento->Hora) : '';
            $pdf->Cell(60, 8, convertirTexto($texto_hora), 0, 0, 'L');
            $pdf->SetX(164);
            $pdf->Cell(23, 8, convertirTexto('_____________________________'), 0, 1, 'L');
            // Dependiente que resivio el resultado
            $pdf->SetFont('Arial', '', 6);
            $pdf->SetX(129);
            $pdf->Cell(23, 8, convertirTexto('Dependiente que resivio el resultado:'), 0, 0, 'L');
            $pdf->SetFont('Arial', '', 6);
            $pdf->SetX(165);
            $pdf->Cell(23, 8, convertirTexto('_____________________________'), 0, 1, 'L');

            // En la sección del pie de página donde está "Token de verificación":
            $pdf->SetFont('Arial', '', 6);
            $pdf->SetX(143);
            $pdf->Cell(23, 8, convertirTexto('Token de verificación:'), 0, 0, 'L');
            $pdf->SetFont('Arial', '', 6); // Negrita y tamaño más grande
            $texto_token = isset($pedimento->token) ? $pedimento->token : 'NO TOKEN';
            $pdf->Cell(60, 8, convertirTexto($texto_token), 0, 0, 'L');
            $pdf->SetX(165);
            $pdf->Cell(23, 8, '_____________________________', 0, 1, 'L');
        }

        $pdf = new \FPDF('P', 'mm', 'A4');

        // ====== OBTENER TODOS LOS DATOS DE LOS PEDIMENTOS ======
        $todos_datos = array();

        // 1. Obtener datos del JSON (pedimentos_json)
        if (isset($pedimento->pedimentos_json) && !empty($pedimento->pedimentos_json)) {
            $pedimentos_data = json_decode($pedimento->pedimentos_json, true);

            if (is_array($pedimentos_data) && count($pedimentos_data) > 0) {
                // Para cada pedimento en el JSON
                foreach ($pedimentos_data as $index => $pedimento_data) {
                    $todos_datos[] = array(
                        'pedimento' => isset($pedimento_data['pedimento']) ? $pedimento_data['pedimento'] : '',
                        'tipo_operacion' => isset($pedimento_data['tipo_operacion']) ? $pedimento_data['tipo_operacion'] : '',
                        'clave' => isset($pedimento_data['clave_pedimento']) ? $pedimento_data['clave_pedimento'] : '',
                        'CR' => isset($pedimento_data['CR']) ? $pedimento_data['CR'] : '',
                        'resultado_v' => '',
                        'resultado_r' => '',
                        'motivo' => '',
                        'estado' => ''
                    );
                }
            }
        }

        // 2. Si no hay datos en el JSON, usar datos directos
        if (empty($todos_datos)) {
            $todos_datos[] = array(
                'pedimento' => isset($pedimento->pedimento) ? $pedimento->pedimento : '',
                'tipo_operacion' => isset($pedimento->tipo_operacion) ? $pedimento->tipo_operacion : '',
                'clave' => isset($pedimento->clave_pedimento) ? $pedimento->clave_pedimento : '',
                'CR' => isset($pedimento->CR) ? $pedimento->CR : '',
                'resultado_v' => '',
                'resultado_r' => '',
                'motivo' => '',
                'estado' => isset($pedimento->Estatus) ? $pedimento->Estatus : ''
            );
        }

        // Calcular número de páginas necesarias (10 filas por página)
        $total_registros = count($todos_datos);
        $total_paginas = ceil($total_registros / 10);

        // Crear cada página COMPLETA con sus respectivos datos
        for ($pagina_actual = 1; $pagina_actual <= $total_paginas; $pagina_actual++) {
            // Calcular qué datos van en esta página
            $inicio = ($pagina_actual - 1) * 10;
            $fin = min($inicio + 10, $total_registros);

            // Obtener solo los datos para esta página
            $datos_pagina = array();
            for ($i = $inicio; $i < $fin; $i++) {
                $datos_pagina[] = $todos_datos[$i];
            }

            // Si hay menos de 10 datos en la última página, agregar filas vacías
            while (count($datos_pagina) < 10) {
                $datos_pagina[] = array(
                    'pedimento' => '',
                    'tipo_operacion' => '',
                    'clave' => '',
                    'CR' => '',
                    'resultado_v' => '',
                    'resultado_r' => '',
                    'motivo' => '',
                    'estado' => ''
                );
            }

            // Crear página completa con los datos de esta página
            crearPaginaCompleta($pdf, $pedimento, $datos_pagina, $pagina_actual);
        }

        // Guardar PDF
        $pdf->Output('F', $pdfPath);
    }
    //sistema de notificaciones 
    public static function Notificaciones()
    {
        \Utils\AuthHelper::requireAuth(9);
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $user_id = $_SESSION['id_user'] ?? null;

        if (!$user_id) {
            return [
                'view' => 'asociado/home.php',
                'scripts' => 'asociado',
                'action' => 'notificaciones',
                'data' => [
                    'title' => 'Notificaciones',
                    'subtitle' => 'No hay sesión activa',
                    'notificaciones' => [],
                    'no_leidas' => 0
                ]
            ];
        }

        // Obtener todas las notificaciones
        $todas_notificaciones = \App\Repositories\NotificationRepository::getNotificacionesUsuario($user_id);

        // Contar no leídas
        $no_leidas = 0;
        foreach ($todas_notificaciones as $notif) {
            if (!$notif->is_read) {
                $no_leidas++;
            }
        }

        return [
            'view' => 'asociado/home.php',
            'scripts' => 'asociado',
            'action' => 'notificaciones',
            'data' => [
                'title' => 'Notificaciones',
                'subtitle' => 'Tus notificaciones',
                'notificaciones' => $todas_notificaciones,
                'no_leidas' => $no_leidas
            ]
        ];
    }

    public static function MarcarLeida()
    {
        \Utils\AuthHelper::requireAuth(9);
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $notificacion_id = $_POST['notificacion_id'] ?? 0;

            if ($notificacion_id) {
                $success = \App\Repositories\NotificationRepository::marcarComoLeida($notificacion_id);

                header('Content-Type: application/json');
                echo json_encode(['success' => $success]);
                exit();
            }
        }

        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'message' => 'Solicitud inválida']);
        exit();
    }

    public static function MarcarTodasLeidas()
    {
        \Utils\AuthHelper::requireAuth(9);
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $user_id = $_SESSION['id_user'] ?? null;

        if ($user_id) {
            $success = \App\Repositories\NotificationRepository::marcarTodasLeidas($user_id);

            header('Content-Type: application/json');
            echo json_encode(['success' => $success]);
            exit();
        }

        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'message' => 'Usuario no autenticado']);
        exit();
    }

    public static function getNotificationCount()
    {
        \Utils\AuthHelper::requireAuth(9);
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $user_id = $_SESSION['id_user'] ?? null;
        $count = 0;

        if ($user_id) {
            $count = \App\Repositories\NotificationRepository::contarNoLeidas($user_id);
        }

        header('Content-Type: application/json');
        echo json_encode(['count' => $count]);
        exit();
    }

    public static function getNotificacionesAjax()
    {
        \Utils\AuthHelper::requireAuth(9);
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $user_id = $_SESSION['id_user'] ?? null;

        if (!$user_id) {
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => 'Usuario no autenticado']);
            exit();
        }

        // Obtener parámetros
        $tipo = $_GET['tipo'] ?? 'pendientes'; // pendientes o vistas
        $pagina = isset($_GET['pagina']) ? max(1, intval($_GET['pagina'])) : 1;
        $por_pagina = 10;

        // Obtener todas las notificaciones
        $todas_notificaciones = \App\Repositories\NotificationRepository::getNotificacionesUsuario($user_id, 1000);

        // Filtrar por tipo
        if ($tipo === 'pendientes') {
            $notificaciones = array_filter($todas_notificaciones, function ($notif) {
                return !$notif->is_read;
            });
        } else {
            $notificaciones = array_filter($todas_notificaciones, function ($notif) {
                return $notif->is_read;
            });
        }

        // Reindexar el array
        $notificaciones = array_values($notificaciones);

        // Paginación
        $total = count($notificaciones);
        $total_paginas = ceil($total / $por_pagina);
        $inicio = ($pagina - 1) * $por_pagina;
        $notificaciones_paginadas = array_slice($notificaciones, $inicio, $por_pagina);

        // Preparar datos para JSON
        $datos_notificaciones = [];
        foreach ($notificaciones_paginadas as $notif) {
            $datos_notificaciones[] = [
                'id' => $notif->id,
                'title' => $notif->title,
                'message' => $notif->message,
                'is_read' => (bool) $notif->is_read,
                'id_related_record' => $notif->id_related_record,
                'created_at' => $notif->created_at,
                'created_at_formatted' => date('d/m H:i', strtotime($notif->created_at))
            ];
        }

        // Contar no leídas para actualizar badges
        $no_leidas = 0;
        foreach ($todas_notificaciones as $notif) {
            if (!$notif->is_read) {
                $no_leidas++;
            }
        }

        header('Content-Type: application/json');
        echo json_encode([
            'success' => true,
            'tipo' => $tipo,
            'pagina_actual' => $pagina,
            'total_paginas' => $total_paginas,
            'total_notificaciones' => $total,
            'mostrando' => count($notificaciones_paginadas),
            'notificaciones' => $datos_notificaciones,
            'no_leidas' => $no_leidas
        ]);
        exit();
    }
    // Agrega este método en AsociadoController
public static function verificarNotificacionesTest()
{
    \Utils\AuthHelper::requireAuth(9);
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    
    $user_id = $_SESSION['id_user'] ?? null;
    
    if (!$user_id) {
        echo "Usuario no autenticado";
        exit;
    }
    
    // Test 1: Verificar tabla de notificaciones
    echo "<h3>Test de Notificaciones - Usuario ID: {$user_id}</h3>";
    
    try {
        $pdo = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME, DB_USER, DB_PASS);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        // Verificar estructura de la tabla
        $sql = "DESCRIBE aaanotifications";
        $stmt = $pdo->query($sql);
        $estructura = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        echo "<h4>Estructura de la tabla aaanotifications:</h4>";
        echo "<table border='1'>";
        echo "<tr><th>Campo</th><th>Tipo</th><th>Null</th><th>Key</th><th>Default</th><th>Extra</th></tr>";
        foreach ($estructura as $campo) {
            echo "<tr>";
            echo "<td>{$campo['Field']}</td>";
            echo "<td>{$campo['Type']}</td>";
            echo "<td>{$campo['Null']}</td>";
            echo "<td>{$campo['Key']}</td>";
            echo "<td>{$campo['Default']}</td>";
            echo "<td>{$campo['Extra']}</td>";
            echo "</tr>";
        }
        echo "</table>";
        
        // Verificar notificaciones existentes para este usuario
        $sql = "SELECT COUNT(*) as total FROM aaanotifications WHERE id_user = :user_id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':user_id' => $user_id]);
        $result = $stmt->fetch(PDO::FETCH_OBJ);
        
        echo "<h4>Notificaciones para este usuario: {$result->total}</h4>";
        
        // Listar notificaciones
        $sql = "SELECT * FROM aaanotifications WHERE id_user = :user_id ORDER BY created_at DESC LIMIT 10";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':user_id' => $user_id]);
        $notificaciones = $stmt->fetchAll(PDO::FETCH_OBJ);
        
        echo "<h4>Últimas 10 notificaciones:</h4>";
        echo "<table border='1'>";
        echo "<tr><th>ID</th><th>Título</th><th>Mensaje</th><th>Tipo</th><th>Leída</th><th>Fecha</th></tr>";
        foreach ($notificaciones as $notif) {
            echo "<tr>";
            echo "<td>{$notif->id}</td>";
            echo "<td>{$notif->title}</td>";
            echo "<td>" . htmlspecialchars(substr($notif->message, 0, 100)) . "...</td>";
            echo "<td>{$notif->tipo}</td>";
            echo "<td>" . ($notif->is_read ? 'Sí' : 'No') . "</td>";
            echo "<td>{$notif->created_at}</td>";
            echo "</tr>";
        }
        echo "</table>";
        
        // Verificar si hay folios con folios_aduana
        $sql = "SELECT id, folio, Token, user_id, folios_aduana, Estatus 
                FROM folio_pedimento 
                WHERE user_id = :user_id 
                AND folios_aduana IS NOT NULL 
                AND folios_aduana != ''
                ORDER BY updated_at DESC 
                LIMIT 5";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':user_id' => $user_id]);
        $folios = $stmt->fetchAll(PDO::FETCH_OBJ);
        
        echo "<h4>Folios con folio aduana asignado:</h4>";
        echo "<table border='1'>";
        echo "<tr><th>ID</th><th>Folio</th><th>Token</th><th>Folio Aduana</th><th>Estatus</th></tr>";
        foreach ($folios as $folio) {
            echo "<tr>";
            echo "<td>{$folio->id}</td>";
            echo "<td>{$folio->folio}</td>";
            echo "<td>{$folio->Token}</td>";
            echo "<td>{$folio->folios_aduana}</td>";
            echo "<td>{$folio->Estatus}</td>";
            echo "</tr>";
        }
        echo "</table>";
        
    } catch (\Exception $e) {
        echo "<h4>Error en la prueba:</h4>";
        echo "<p>" . htmlspecialchars($e->getMessage()) . "</p>";
    }
    
    exit;
}
   public static function debugNotificacionesUsuario()
    {
        \Utils\AuthHelper::requireAuth(9);
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        $user_id = $_SESSION['id_user'] ?? null;
        
        if (!$user_id) {
            echo json_encode(['error' => 'No hay sesión activa']);
            exit;
        }
        
        try {
            $pdo = new \PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME, DB_USER, DB_PASS);
            $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            
            $resultado = [
                'usuario_id' => $user_id,
                'timestamp' => date('Y-m-d H:i:s')
            ];
            
            // 1. Verificar notificaciones del usuario
            $notificaciones = NotificationRepository::getNotificacionesUsuario($user_id, 10);
            $resultado['notificaciones'] = $notificaciones;
            $resultado['total_notificaciones'] = count($notificaciones);
            
            // 2. Contar no leídas
            $no_leidas = NotificationRepository::contarNoLeidas($user_id);
            $resultado['no_leidas'] = $no_leidas;
            
            // 3. Verificar folios con folio aduana
            $sql = "SELECT id, folio, Token, folios_aduana, Estatus, updated_at 
                    FROM folio_pedimento 
                    WHERE user_id = ? 
                    AND folios_aduana IS NOT NULL 
                    AND folios_aduana != ''
                    ORDER BY updated_at DESC 
                    LIMIT 5";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$user_id]);
            $resultado['folios_con_aduana'] = $stmt->fetchAll(\PDO::FETCH_ASSOC);
            
            // 4. Verificar si hay notificaciones para estos folios
            if (!empty($resultado['folios_con_aduana'])) {
                foreach ($resultado['folios_con_aduana'] as &$folio) {
                    $sql = "SELECT COUNT(*) as total FROM aaanotifications 
                            WHERE id_user = ? 
                            AND id_related_record = ? 
                            AND tipo = 'folio_aduana'";
                    $stmt = $pdo->prepare($sql);
                    $stmt->execute([$user_id, $folio['id']]);
                    $folio['tiene_notificacion'] = $stmt->fetch(\PDO::FETCH_ASSOC)['total'] > 0;
                }
            }
            
            header('Content-Type: application/json');
            echo json_encode($resultado, JSON_PRETTY_PRINT);
            
        } catch (\Exception $e) {
            echo json_encode([
                'error' => $e->getMessage(),
                'timestamp' => date('Y-m-d H:i:s')
            ], JSON_PRETTY_PRINT);
        }
        exit;
    }

public static function crearNotificacionPrueba()
{
    \Utils\AuthHelper::requireAuth(9);
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $user_id = $_POST['user_id'] ?? 18;
        
        try {
            $pdo = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME, DB_USER, DB_PASS);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            // Crear notificación de prueba NO LEÍDA
            $sql = "INSERT INTO aaanotifications 
                    (user, title, message, is_read, created_at) 
                    VALUES (:user, 'Prueba Sistema', 'Esta es una notificación de prueba', 0, NOW())";
            
            $stmt = $pdo->prepare($sql);
            $stmt->execute([':user' => $user_id]);
            
            $id = $pdo->lastInsertId();
            
            echo json_encode([
                'success' => true,
                'message' => 'Notificación de prueba creada (NO LEÍDA)',
                'id' => $id,
                'user_id' => $user_id
            ]);
            
        } catch (\Exception $e) {
            echo json_encode([
                'success' => false,
                'error' => $e->getMessage()
            ]);
        }
        exit;
    }
}
// En el Controller
public static function seguimiento(){
    \Utils\AuthHelper::requireAuth(9);
    
    $folio = $_GET['folio'] ?? '';
    $token = $_GET['token'] ?? '';
    
    // Inicializa el array de datos - DEBE estar dentro de 'data'
    $data = [
        'title' => 'Seguimiento de Pedimentos',
        'subtitle' => 'Monitorea el estado de tus pedimentos en tiempo real',
        'folio_buscado' => $folio,
        'token_buscado' => $token,
        'encontrado' => false,
        'mensaje_error' => '',
        'folio_info' => null,
        'pedimentos' => []
    ];
    
    // Si se proporcionó folio o token, buscar
    if (!empty($folio) || !empty($token)) {
        $resultado = \App\Repositories\GestionRepository::buscarPorFolioOToken($folio, $token);
        
        if ($resultado['success']) {
            $data['folio_info'] = $resultado['folio'];
            $data['pedimentos'] = $resultado['pedimentos'];
            $data['encontrado'] = true;
        } else {
            $data['encontrado'] = false;
            $data['mensaje_error'] = $resultado['message'];
        }
    }
    
    // Esto es lo que tu home.php espera
    return [
        'view' => 'asociado/home.php',
        'scripts' => 'asociado',
        'action' => 'seguimiento',
        'data' => $data  // ¡IMPORTANTE! Los datos deben estar en 'data'
    ];
}
public static function Avisos(){
    \Utils\AuthHelper::requireAuth(9);
     $modalList = callacenterRepository::getModalList();
     return [
            'view' => 'asociado/home.php',
            'scripts' => 'asociado',
            'action' => 'aviso',
            'data' => [
                'title' => 'Avisos',
                'subtitle' => 'Tienes ' . count($modalList) . ' avisos registrados',
                'button' => 'Agregar nuevo aviso',
                'icon' => 'mdi mdi-bell-ring-outline',
            ],
            'modal' => $modalList,
        ];
        }

 public static function contacto(){
    \Utils\AuthHelper::requireAuth(9);
     return [
            'view' => 'asociado/home.php',
            'scripts' => 'asociado',
            'action' => 'contacto',
            'data' => [
                'title' => 'Contacto',
                'subtitle' => 'Contáctanos para cualquier duda o soporte',
                'button' => 'Enviar mensaje',
                'icon' => 'mdi mdi-email-outline',
            ],
        ];
 }
}