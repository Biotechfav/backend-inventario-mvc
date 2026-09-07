<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title) ?> · Inventario MVC</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen text-gray-800">
    <?php if (!$guestOnly): ?>
    <nav class="bg-indigo-700 text-white shadow">
        <div class="max-w-5xl mx-auto px-4 py-3 flex items-center justify-between">
            <a href="<?= BASE_URL ?>/" class="font-bold text-lg">📦 Inventario MVC</a>
            <div class="flex items-center gap-4 text-sm">
                <a href="<?= BASE_URL ?>/" class="hover:underline">Dashboard</a>
                <a href="<?= BASE_URL ?>/categories" class="hover:underline">Categorías</a>
                <a href="<?= BASE_URL ?>/products" class="hover:underline">Productos</a>
                <span class="bg-indigo-600 px-3 py-1 rounded-full">
                    👤 <?= htmlspecialchars($_SESSION['user_name'] ?? 'Usuario') ?>
                </span>
                <a href="<?= BASE_URL ?>/auth/logout" class="bg-white text-indigo-700 px-3 py-1 rounded font-semibold hover:bg-gray-200">Salir</a>
            </div>
        </div>
    </nav>
    <?php endif; ?>

    <main class="max-w-5xl mx-auto p-6">
        <?php if (!empty($_SESSION['flash'])): ?>
            <?php $flash = $_SESSION['flash']; unset($_SESSION['flash']); ?>
            <div class="mb-4 px-4 py-3 rounded-lg text-sm font-medium
                <?= $flash['type'] === 'error' ? 'bg-red-100 text-red-700 border border-red-300'
                    : 'bg-green-100 text-green-700 border border-green-300' ?>">
                <?= htmlspecialchars($flash['message']) ?>
            </div>
        <?php endif; ?>

        <?= $content ?>
    </main>
</body>
</html>