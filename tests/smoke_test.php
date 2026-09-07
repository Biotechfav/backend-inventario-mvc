<?php

declare(strict_types=1);

/**
 * Prueba de humo (CLI): verifica conexión PDO, creación de tablas y CRUD
 * contra la base de prueba inventario_test_db.
 *
 * Uso:  DB_PASS=eshop_pass php tests/smoke_test.php
 * Sale con código 0 si todo pasa, 1 si algo falla.
 */

putenv('DB_NAME=inventario_test_db');
putenv('DB_PASS=eshop_pass');

require __DIR__ . '/../app/Core/Database.php';
require __DIR__ . '/../app/Models/Category.php';
require __DIR__ . '/../app/Models/Product.php';

$failures = 0;

function check(string $label, bool $condition): void
{
    global $failures;
    if ($condition) {
        echo "  ✓ $label\n";
    } else {
        echo "  ✗ $label\n";
        $failures++;
    }
}

echo "Prueba de humo - Inventario MVC (inventario_test_db)\n";

try {
    $db = Database::getConnection();
    check('conexión PDO a MySQL', true);
} catch (PDOException $e) {
    check('conexión PDO a MySQL (' . $e->getMessage() . ')', false);
    exit(1);
}

$db->exec(file_get_contents(__DIR__ . '/../database/schema.sql'));
$db->exec('DELETE FROM products;');
$db->exec('DELETE FROM categories;');

$category = new Category();
$product = new Product();

$catId = $category->create('Prueba');
check('insertar categoría', $catId > 0);
check('categoría única (existe)', $category->exists($catId));

$prodId = $product->create([
    'category_id' => $catId,
    'name'        => 'Artículo de prueba',
    'description' => 'Prueba automatizada',
    'price'       => 25.5,
    'stock'       => 3,
]);
check('insertar producto (sentencias preparadas)', $prodId > 0);

$found = $product->find($prodId);
check('leer producto', $found !== false && $found['name'] === 'Artículo de prueba');
check('precio correcto', $found !== false && abs((float) $found['price'] - 25.5) < 0.001);

$product->update($prodId, [
    'category_id' => $catId,
    'name'        => 'Artículo actualizado',
    'description' => null,
    'price'       => 30,
    'stock'       => 1,
]);
check('actualizar producto', ($product->find($prodId))['stock'] == 1);

check('listar con stock bajo', count($product->lowStock()) === 1);

$category->delete($catId);
check('eliminar categoría (cascada de FK borra el producto)', count($product->all()) === 0);

if ($failures === 0) {
    echo "\n✅ Todas las pruebas pasaron.\n";
    exit(0);
}

echo "\n❌ $failures prueba(s) fallaron.\n";
exit(1);