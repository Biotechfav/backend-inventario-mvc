<?php

return [
    'database' => [
        'host'    => getenv('DB_HOST') ?: 'localhost',
        'name'    => getenv('DB_NAME') ?: 'inventario_db',
        'user'    => getenv('DB_USER') ?: 'favio',
        'pass'    => getenv('DB_PASS') ?: 'eshop_pass',
        'charset' => 'utf8mb4',
    ],
    'base_url' => getenv('BASE_URL') ?: 'http://localhost:8080',
    'timezone' => 'America/Lima',
];