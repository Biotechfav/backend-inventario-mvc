<?php $id = $category['id'] ?? null; ?>

<div class="max-w-md bg-white rounded-xl shadow p-6">
    <h2 class="font-semibold text-lg mb-4"><?= $id ? 'Editar' : 'Nueva' ?> categoría</h2>

    <form method="POST" action="<?= BASE_URL ?>/categories/<?= $id ? 'update' : 'store' ?>" class="space-y-4">
        <?php if ($id): ?>
            <input type="hidden" name="id" value="<?= (int) $id ?>">
        <?php endif; ?>

        <div>
            <label class="block text-sm font-medium mb-1">Nombre</label>
            <input type="text" name="name" required value="<?= htmlspecialchars($category['name'] ?? '') ?>"
                   class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
        </div>

        <div class="flex gap-3">
            <a href="<?= BASE_URL ?>/categories" class="px-4 py-2 rounded-lg border text-gray-600 hover:bg-gray-50">Cancelar</a>
            <button type="submit" class="flex-1 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-lg py-2">
                Guardar
            </button>
        </div>
    </form>
</div>