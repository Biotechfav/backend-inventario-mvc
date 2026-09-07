<?php

declare(strict_types=1);

/**
 * Inicializa la base: crea las tablas (si no existen) y carga datos de prueba.
 * Uso:  php database/seed.php
 *        DB_NAME=inventario_test_db php database/seed.php  # para la base de pruebas
 */

require __DIR__ . '/../config/config.php';
require __DIR__ . '/../app/Core/Database.php';

$db = Database::getConnection();

$schema = file_get_contents(__DIR__ . '/schema.sql');
if ($schema === false) {
    fwrite(STDERR, "No se pudo leer schema.sql\n");
    exit(1);
}

$db->exec($schema);
echo "Tablas aseguradas.\n";

// Limpieza (hijos primero por las llaves foráneas)
$db->exec('DELETE FROM products;');
$db->exec('DELETE FROM categories;');
$db->exec('DELETE FROM users;');

// Usuario administrador (demo)
$db->prepare('INSERT INTO users (name, email, password) VALUES (?, ?, ?)')
   ->execute(['Administrador', 'admin@tecnor.com', password_hash('admin123', PASSWORD_DEFAULT)]);
echo "Usuario creado: admin@tecnor.com / admin123\n";

// Categorías
$categorias = ['Tecnología', 'Hogar', 'Ropa'];
$catIds = [];
foreach ($categorias as $i => $name) {
    $db->prepare('INSERT INTO categories (name) VALUES (?)')->execute([$name]);
    $catIds[$i + 1] = (int) $db->lastInsertId();
}
echo "Categorías creadas: " . implode(', ', $categorias) . "\n";

// Productos (varios con stock bajo para probar la alerta del dashboard)
$productos = [
    ['Teclado RGB mecánico', 'Teclado gamer retroiluminado', 149.90, 3,  $catIds[1]],
    ['Mouse inalámbrico',    'Mouse ergonómico 2.4 GHz',      59.50, 12, $catIds[1]],
    ['Monitor 24" Full HD',  'Monitor IPS 75Hz',              549.00, 8, $catIds[1]],
    ['Olla a presión 6L',    'Acero inoxidable',              129.00, 2,  $catIds[2]],
    ['Set de cocina',        'Juego de 5 útiles de cocina',    89.90, 1,  $catIds[2]],
    ['Polo algodón',         'Polo color sólido',              39.90, 25, $catIds[3]],
    ['Jeans slim',           'Jean de corte moderno',          99.00, 4,  $catIds[3]],
];

$stmt = $db->prepare(
    'INSERT INTO products (name, description, price, stock, category_id) VALUES (?, ?, ?, ?, ?)'
);
foreach ($productos as $p) {
    $stmt->execute($p);
}
echo "Productos creados: " . count($productos) . "\n";
echo "✅ Listo.\n";