<?php
require_once 'ImageAnalyzer.php';

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, X-Requested-With');

$method = $_SERVER['REQUEST_METHOD'] ?? 'GET';
$response = ['success' => false, 'data' => null, 'error' => ''];

if ($method === 'OPTIONS') {
    http_response_code(200);
    exit;
}

if ($method !== 'POST') {
    http_response_code(405);
    $response['error'] = 'Método não permitido.';
    echo json_encode($response);
    exit;
}

// 1. Verifica se o arquivo foi enviado corretamente (esperamos apenas um arquivo)
if (empty($_FILES['image_file'])) {
    http_response_code(400);
    $response['error'] = 'Nenhum arquivo enviado ou nome de campo incorreto (esperado "image_file").';
    echo json_encode($response);
    exit;
}

try {
    $analyzer = new ImageAnalyzer();
    
    // 2. Delega o processamento à classe
    $fileInfo = $analyzer->analyzeAndSave($_FILES['image_file']);
    
    $response['success'] = true;
    $response['data'] = $fileInfo;

} catch (Exception $e) {
    http_response_code(400); 
    $response['error'] = "ERRO de Processamento: " . $e->getMessage();
}

echo json_encode($response);
