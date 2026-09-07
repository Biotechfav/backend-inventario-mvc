<?php $id = $product['id'] ?? null; ?>

<div class="max-w-lg bg-white rounded-xl shadow p-6">
    <h2 class="font-semibold text-lg mb-4"><?= $id ? 'Editar' : 'Nuevo' ?> producto</h2>

    <form method="POST" action="<?= BASE_URL ?>/products/<?= $id ? 'update' : 'store' ?>" class="space-y-4">
        <?php if ($id): ?>
            <input type="hidden" name="id" value="<?= (int) $id ?>">
        <?php endif; ?>

        <div>
            <label class="block text-sm font-medium mb-1">Nombre</label>
            <input type="text" name="name" required value="<?= htmlspecialchars($product['name'] ?? '') ?>"
                   class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Descripción</label>
            <textarea name="description" rows="2"
                      class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500"><?= htmlspecialchars($product['description'] ?? '') ?></textarea>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium mb-1">Precio (S/)</label>
                <input type="number" name="price" step="0.01" min="0" required value="<?= htmlspecialchars((string) ($product['price'] ?? '')) ?>"
                       class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Stock</label>
                <input type="number" name="stock" min="0" required value="<?= (int) ($product['stock'] ?? 0) ?>"
                       class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Categoría</label>
            <select name="category_id" required
                    class="w-full border rounded-lg px-3 py-2 bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500">
                <?php foreach ($categories as $category): ?>
                    <option value="<?= (int) $category['id'] ?>"
                        <?= ($product['category_id'] ?? null) == $category['id'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($category['name']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="flex gap-3">
            <a href="<?= BASE_URL ?>/products" class="px-4 py-2 rounded-lg border text-gray-600 hover:bg-gray-50">Cancelar</a>
            <button type="submit" class="flex-1 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-lg py-2">
                Guardar
            </button>
        </div>
    </form>
</div>