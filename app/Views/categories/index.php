<div class="bg-white rounded-xl shadow">
    <div class="px-6 py-4 border-b flex items-center justify-between">
        <h2 class="font-semibold">Categorías</h2>
        <a href="<?= BASE_URL ?>/categories/form" class="bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold px-4 py-1.5 rounded-lg">
            + Nueva
        </a>
    </div>
    <table class="w-full text-sm">
        <thead class="bg-gray-50 text-gray-500">
            <tr>
                <th class="text-left px-6 py-3">Nombre</th>
                <th class="text-right px-6 py-3">Productos</th>
                <th class="text-right px-6 py-3">Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($categories as $category): ?>
                <tr class="border-t">
                    <td class="px-6 py-3 font-medium"><?= htmlspecialchars($category['name']) ?></td>
                    <td class="px-6 py-3 text-right text-gray-500"><?= (int) $category['products_count'] ?></td>
                    <td class="px-6 py-3 text-right space-x-2">
                        <a href="<?= BASE_URL ?>/categories/edit/<?= (int) $category['id'] ?>"
                           class="text-indigo-600 hover:underline">Editar</a>
                        <form method="POST" action="<?= BASE_URL ?>/categories/delete" class="inline" onsubmit="return confirm('¿Eliminar esta categoría y todos sus productos?')">
                            <input type="hidden" name="id" value="<?= (int) $category['id'] ?>">
                            <button type="submit" class="text-red-600 hover:underline">Eliminar</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>