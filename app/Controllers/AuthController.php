<?php

declare(strict_types=1);

class AuthController extends Controller
{
    public function showLogin(): void
    {
        if (!empty($_SESSION['user_id'])) {
            $this->redirect('/');
        }
        $this->view('auth/login', ['title' => 'Iniciar sesión', 'guestOnly' => true]);
    }

    public function login(): void
    {
        $email = trim((string) ($_POST['email'] ?? ''));
        $password = (string) ($_POST['password'] ?? '');

        $user = (new User())->findByEmail($email);

        if ($user && password_verify($password, $user['password'])) {
            session_regenerate_id(true);
            $_SESSION['user_id'] = (int) $user['id'];
            $_SESSION['user_name'] = $user['name'];
            $this->redirect('/');
        }

        $this->view('auth/login', [
            'title' => 'Iniciar sesión',
            'guestOnly' => true,
            'error' => 'Email o contraseña incorrectos.',
        ]);
    }

    public function logout(): void
    {
        session_unset();
        session_destroy();
        $this->redirect('/auth/login');
    }
}