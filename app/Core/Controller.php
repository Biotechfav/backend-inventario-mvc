<?php

declare(strict_types=1);

class Controller
{
    protected function view(string $view, array $data = []): void
    {
        extract($data);
        $title = $data['title'] ?? 'Inventario MVC';
        $guestOnly = $data['guestOnly'] ?? false;

        ob_start();
        require __DIR__ . "/../Views/{$view}.php";
        $content = ob_get_clean();

        require __DIR__ . '/../Views/layout.php';
    }

    protected function redirect(string $path): void
    {
        header('Location: ' . BASE_URL . $path);
        exit;
    }

    protected function flash(string $message, string $type = 'success'): void
    {
        $_SESSION['flash'] = compact('message', 'type');
    }

    protected function requireLogin(): void
    {
        if (empty($_SESSION['user_id'])) {
            $this->redirect('/auth/login');
        }
    }

    protected function isPost(): bool
    {
        return ($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST';
    }
}