<?php

declare(strict_types=1);

class DashboardController extends Controller
{
    public function index(): void
    {
        $this->requireLogin();

        $this->view('dashboard', [
            'title'         => 'Dashboard',
            'totalProducts'  => (new Product())->count(),
            'totalCategories' => (new Category())->count(),
            'lowStock'      => (new Product())->lowStock(),
        ]);
    }
}