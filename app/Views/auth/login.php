<div class="max-w-md mx-auto mt-16 bg-white rounded-xl shadow p-8">
    <h1 class="text-2xl font-bold text-center">📦 Inventario MVC</h1>
    <p class="text-gray-500 text-center text-sm mb-6">Administra tu stock de productos</p>

    <?php if (isset($error)): ?>
        <div class="mb-4 px-4 py-3 rounded-lg text-sm bg-red-100 text-red-700 border border-red-300">
            <?= htmlspecialchars($error) ?>
        </div>
    <?php endif; ?>

    <form method="POST" action="<?= BASE_URL ?>/auth/login" class="space-y-4">
        <div>
            <label class="block text-sm font-medium mb-1">Email</label>
            <input type="email" name="email" required
                   class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
        </div>
        <div>
            <label class="block text-sm font-medium mb-1">Contraseña</label>
            <input type="password" name="password" required
                   class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
        </div>
        <button type="submit"
                class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-lg py-2">
            Ingresar
        </button>
    </form>

    <p class="text-xs text-gray-400 text-center mt-4">
        Usuario demo: <code>admin@tecnor.com</code> / <code>admin123</code>
    </p>
</div>