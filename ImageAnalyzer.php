<?php

class ImageAnalyzer {
    private const UPLOADS_DIR = __DIR__ . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR;
    private const THUMBS_DIR = __DIR__ . DIRECTORY_SEPARATOR . 'thumbs' . DIRECTORY_SEPARATOR;
    
    // Prefixos de URL para o frontend
    private const UPLOADS_URL_PREFIX = '/src/uploads/';
    private const THUMBS_URL_PREFIX = '/src/thumbs/';

    public function __construct() {
        $this->checkDirectories();
    }
    
    // --- Funções Auxiliares ---
    
    private function checkDirectories(): void {
        foreach ([self::UPLOADS_DIR, self::THUMBS_DIR] as $dir) {
            if (!is_dir($dir)) {
                if (!mkdir($dir, 0777, true)) {
                    throw new Exception("Falha ao criar o diretório: " . basename($dir) . ". Verifique as permissões.");
                }
            }
        }
    }

    private function getMimeType(string $filePath): string {
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime = finfo_file($finfo, $filePath);
        finfo_close($finfo);
        return $mime;
    }
    
    // --- Processamento de Imagem (GD) ---

    /**
     * Gera um thumbnail de 200px de largura mantendo a proporção.
     */
    private function createThumbnail(string $sourcePath, string $destPath, string $mimeType): void {
        list($width, $height) = getimagesize($sourcePath);
        $newWidth = 200;
        $newHeight = (int)($height * ($newWidth / $width));

        switch ($mimeType) {
            case 'image/jpeg':
                $sourceImage = imagecreatefromjpeg($sourcePath);
                break;
            case 'image/png':
                $sourceImage = imagecreatefrompng($sourcePath);
                break;
            default:
                throw new Exception("Formato de imagem não suportado para thumbnail.");
        }

        $thumb = imagecreatetruecolor($newWidth, $newHeight);
        imagecopyresampled($thumb, $sourceImage, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
        
        // Salva a imagem (sempre JPEG para consistência e tamanho menor)
        imagejpeg($thumb, $destPath, 80); // 80 é a qualidade

        imagedestroy($sourceImage);
        imagedestroy($thumb);
    }

    // --- Ação Principal ---

    /**
     * Recebe um arquivo do $_FILES, salva, analisa e retorna os metadados.
     */
    public function analyzeAndSave(array $file): array {
        if ($file['error'] !== UPLOAD_ERR_OK) {
            throw new Exception("Erro de upload: Código " . $file['error']);
        }
        
        $mimeType = $this->getMimeType($file['tmp_name']);
        if (!in_array($mimeType, ['image/jpeg', 'image/png'])) {
             throw new Exception("Tipo de arquivo não permitido. Apenas JPG e PNG.");
        }
        
        $fileName = uniqid('img_', true) . '.jpg'; // Nome final unificado para .jpg
        $originalFilePath = self::UPLOADS_DIR . $fileName;
        $thumbnailFilePath = self::THUMBS_DIR . 'thumb_' . $fileName;
        
        // 1. Salva o arquivo original
        if (!move_uploaded_file($file['tmp_name'], $originalFilePath)) {
            throw new Exception("Falha ao salvar o arquivo original.");
        }
        
        // 2. Cria o Thumbnail
        $this->createThumbnail($originalFilePath, $thumbnailFilePath, $mimeType);
        
        // 3. Coleta Metadados
        $fileSize = filesize($originalFilePath);
        list($width, $height) = getimagesize($originalFilePath);

        return [
            'original_name' => $file['name'],
            'file_size_mb' => round($fileSize / 1024 / 1024, 2) . ' MB',
            'dimensions' => "{$width}x{$height} px",
            'original_url' => self::UPLOADS_URL_PREFIX . $fileName,
            'thumbnail_url' => self::THUMBS_URL_PREFIX . 'thumb_' . $fileName,
            'processed_at' => date('Y-m-d H:i:s')
        ];
    }
}
