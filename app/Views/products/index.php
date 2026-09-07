<div class="bg-white rounded-xl shadow">
    <div class="px-6 py-4 border-b flex items-center justify-between gap-4">
        <h2 class="font-semibold">Productos</h2>
        <a href="<?= BASE_URL ?>/products/form" class="bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold px-4 py-1.5 rounded-lg">
            + Nuevo producto
        </a>
    </div>

    <form method="GET" action="<?= BASE_URL ?>/products" class="px-6 py-3 border-b flex flex-wrap items-center gap-3">
        <input type="text" name="q" value="<?= htmlspecialchars($q) ?>" placeholder="Buscar por producto o categoría…"
               class="flex-1 min-w-[200px] border rounded-lg px-3 py-1.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
        <label class="flex items-center gap-2 text-sm text-gray-600">
            <input type="checkbox" name="low" value="1" <?= $low ? 'checked' : '' ?> class="accent-red-600">
            Stock bajo (≤ 5)
        </label>
        <button type="submit" class="bg-gray-700 hover:bg-gray-800 text-white text-sm font-medium px-4 py-1.5 rounded-lg">Filtrar</button>
    </form>

    <table class="w-full text-sm">
        <thead class="bg-gray-50 text-gray-500">
            <tr>
                <th class="text-left px-6 py-3">Producto</th>
                <th class="text-left px-6 py-3">Categoría</th>
                <th class="text-right px-6 py-3">Precio</th>
                <th class="text-right px-6 py-3">Stock</th>
                <th class="text-right px-6 py-3">Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php if (count($products) === 0): ?>
                <tr><td colspan="5" class="px-6 py-6 text-center text-gray-500">No hay productos con esos filtros.</td></tr>
            <?php endif; ?>
            <?php foreach ($products as $product): ?>
                <tr class="border-t">
                    <td class="px-6 py-3">
                        <p class="font-medium"><?= htmlspecialchars($product['name']) ?></p>
                        <?php if (!empty($product['description'])): ?>
                            <p class="text-gray-400 text-xs"><?= htmlspecialchars($product['description']) ?></p>
                        <?php endif; ?>
                    </td>
                    <td class="px-6 py-3 text-gray-500"><?= htmlspecialchars($product['category_name']) ?></td>
                    <td class="px-6 py-3 text-right font-medium">S/ <?= number_format((float) $product['price'], 2) ?></td>
                    <td class="px-6 py-3 text-right">
                        <?php if ((int) $product['stock'] <= 5): ?>
                            <span class="px-2 py-0.5 rounded-full text-xs font-bold bg-red-100 text-red-700">
                                <?= (int) $product['stock'] ?>
                            </span>
                        <?php else: ?>
                            <?= (int) $product['stock'] ?>
                        <?php endif; ?>
                    </td>
                    <td class="px-6 py-3 text-right space-x-2">
                        <a href="<?= BASE_URL ?>/products/edit/<?= (int) $product['id'] ?>" class="text-indigo-600 hover:underline">Editar</a>
                        <form method="POST" action="<?= BASE_URL ?>/products/delete" class="inline" onsubmit="return confirm('¿Eliminar este producto?')">
                            <input type="hidden" name="id" value="<?= (int) $product['id'] ?>">
                            <button type="submit" class="text-red-600 hover:underline">Eliminar</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>