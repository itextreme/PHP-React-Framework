<?php

require_once __DIR__ . '/../bootstrap.php';

use App\Models\Todo;

// 1. Detect Request Path
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// 2. Handle API Routes
if (strpos($uri, '/api') === 0) {
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
    header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");

    if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
        exit;
    }

    $method = $_SERVER['REQUEST_METHOD'];
    $path = str_replace('/api', '', $uri);
    header('Content-Type: application/json');

    try {
        if ($path === '/todos') {
            if ($method === 'GET') {
                echo Todo::all()->toJson();
                exit;
            } elseif ($method === 'POST') {
                $input = file_get_contents('php://input');
                $data = json_decode($input, true);

                if (json_last_error() !== JSON_ERROR_NONE) {
                    throw new \Exception('Invalid JSON payload provided.');
                }

                if (empty($data['title'])) {
                    http_response_code(400);
                    echo json_encode(['error' => 'Task title is required.']);
                    exit;
                }

                $todo = Todo::create(['title' => $data['title'], 'completed' => false]);
                echo $todo->toJson();
                exit;
            }
        } elseif (preg_match('/\/todos\/(\d+)/', $path, $matches)) {
            $id = $matches[1];
            $todo = Todo::find($id);
            
            if (!$todo) {
                http_response_code(404);
                echo json_encode(['error' => "Task #$id not found."]);
                exit;
            }

            if ($method === 'GET') {
                echo $todo->toJson();
                exit;
            } elseif ($method === 'PUT') {
                $data = json_decode(file_get_contents('php://input'), true);
                if ($data === null) throw new \Exception('Invalid update data.');
                
                $todo->update($data);
                echo $todo->toJson();
                exit;
            } elseif ($method === 'DELETE') {
                $todo->delete();
                echo json_encode(['success' => true, 'id' => $id]);
                exit;
            }
        }
    } catch (\Exception $e) {
        // Log the actual error for the developer
        error_log("[TaskFlow Error] " . $e->getMessage() . " in " . $e->getFile() . ":" . $e->getLine());
        
        http_response_code(500);
        echo json_encode([
            'error' => 'Internal Server Error',
            'message' => (getenv('APP_ENV') === 'development') ? $e->getMessage() : 'An unexpected error occurred.'
        ]);
        exit;
    }

    http_response_code(404);
    echo json_encode(['error' => 'API Endpoint Not Found']);
    exit;
}

// 3. Serve Static Files or SPA index.html
$publicPath = __DIR__ . '/dist';
$file = $publicPath . $uri;

if ($uri !== '/' && file_exists($file) && is_file($file)) {
    // Robust Mime type detection
    $mimes = [
        'css'  => 'text/css',
        'js'   => 'application/javascript',
        'json' => 'application/json',
        'png'  => 'image/png',
        'jpg'  => 'image/jpeg',
        'jpeg' => 'image/jpeg',
        'gif'  => 'image/gif',
        'svg'  => 'image/svg+xml',
        'webp' => 'image/webp',
        'ico'  => 'image/x-icon',
        'woff' => 'font/woff',
        'woff2'=> 'font/woff2',
        'ttf'  => 'font/ttf',
        'otf'  => 'font/otf'
    ];
    
    $extension = strtolower(pathinfo($file, PATHINFO_EXTENSION));
    if (isset($mimes[$extension])) {
        header('Content-Type: ' . $mimes[$extension]);
    } else {
        header('Content-Type: ' . mime_content_type($file));
    }
    
    header('Content-Length: ' . filesize($file));
    readfile($file);
    exit;
}

// 4. Default to React SPA
if (file_exists($publicPath . '/index.html')) {
    readfile($publicPath . '/index.html');
} else {
    echo "Frontend not built yet. Run 'npm run build'.";
}
