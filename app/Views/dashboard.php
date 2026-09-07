<div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
    <div class="bg-white rounded-xl shadow p-6">
        <p class="text-sm text-gray-500">Productos</p>
        <p class="text-3xl font-bold text-indigo-700"><?= (int) $totalProducts ?></p>
    </div>
    <div class="bg-white rounded-xl shadow p-6">
        <p class="text-sm text-gray-500">Categorías</p>
        <p class="text-3xl font-bold text-indigo-700"><?= (int) $totalCategories ?></p>
    </div>
    <a href="<?= BASE_URL ?>/products?low=1" class="bg-white rounded-xl shadow p-6 hover:shadow-md">
        <p class="text-sm text-gray-500">Stock bajo (≤ 5)</p>
        <p class="text-3xl font-bold <?= count($lowStock) > 0 ? 'text-red-600' : 'text-green-600' ?>">
            <?= count($lowStock) ?>
        </p>
    </a>
</div>

<div class="bg-white rounded-xl shadow">
    <div class="px-6 py-4 border-b flex items-center justify-between">
        <h2 class="font-semibold">⚠️ Productos con stock bajo</h2>
        <a href="<?= BASE_URL ?>/products/form" class="bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold px-4 py-1.5 rounded-lg">
            + Nuevo producto
        </a>
    </div>
    <?php if (count($lowStock) === 0): ?>
        <p class="p-6 text-gray-500">Todo en orden: no hay productos por reponer. ✅</p>
    <?php else: ?>
    <table class="w-full text-sm">
        <thead class="bg-gray-50 text-gray-500">
            <tr>
                <th class="text-left px-6 py-3">Producto</th>
                <th class="text-left px-6 py-3">Categoría</th>
                <th class="text-right px-6 py-3">Stock</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($lowStock as $product): ?>
                <tr class="border-t">
                    <td class="px-6 py-3 font-medium"><?= htmlspecialchars($product['name']) ?></td>
                    <td class="px-6 py-3 text-gray-500"><?= htmlspecialchars($product['category_name']) ?></td>
                    <td class="px-6 py-3 text-right">
                        <span class="px-2 py-0.5 rounded-full text-xs font-bold bg-red-100 text-red-700">
                            <?= (int) $product['stock'] ?>
                        </span>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?php endif; ?>
</div>