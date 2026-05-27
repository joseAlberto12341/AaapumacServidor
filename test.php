<?php
// test.php
echo "<h1>Test de rutas</h1>";

// Probar URL directa
$url = 'http://' . $_SERVER['HTTP_HOST'] . '/Aaapumac/Gestion/getFoliosAjax';
echo "<h2>URL a probar:</h2>";
echo "<pre>$url</pre>";

echo "<h2>Resultado:</h2>";
try {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HEADER, true);
    $response = curl_exec($ch);
    $info = curl_getinfo($ch);
    curl_close($ch);
    
    echo "<pre>";
    echo "Status: {$info['http_code']}\n";
    echo "Content-Type: {$info['content_type']}\n\n";
    echo "Respuesta completa:\n";
    echo htmlspecialchars($response);
    echo "</pre>";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}