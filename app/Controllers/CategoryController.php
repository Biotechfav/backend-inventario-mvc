<?php

declare(strict_types=1);

class CategoryController extends Controller
{
    public function index(): void
    {
        $this->requireLogin();
        $this->view('categories/index', [
            'title'      => 'Categorías',
            'categories' => (new Category())->all(),
        ]);
    }

    public function create(): void
    {
        $this->requireLogin();
        $this->view('categories/form', ['title' => 'Nueva categoría']);
    }

    public function store(): void
    {
        $this->requireLogin();
        $name = trim((string) ($_POST['name'] ?? ''));

        if ($name === '') {
            $this->flash('El nombre es obligatorio.', 'error');
            $this->redirect('/categories/form');
        }

        (new Category())->create($name);
        $this->flash('Categoría creada correctamente.');
        $this->redirect('/categories');
    }

    public function edit(int $id): void
    {
        $this->requireLogin();
        $category = (new Category())->find($id);
        if (!$category) {
            $this->flash('Categoría no encontrada.', 'error');
            $this->redirect('/categories');
        }
        $this->view('categories/form', [
            'title'    => 'Editar categoría',
            'category' => $category,
        ]);
    }

    public function update(): void
    {
        $this->requireLogin();
        $id = (int) ($_POST['id'] ?? 0);
        $name = trim((string) ($_POST['name'] ?? ''));

        if ($name === '' || !(new Category())->find($id)) {
            $this->flash('Datos inválidos.', 'error');
            $this->redirect('/categories');
        }

        (new Category())->update($id, $name);
        $this->flash('Categoría actualizada.');
        $this->redirect('/categories');
    }

    public function delete(): void
    {
        $this->requireLogin();
        $id = (int) ($_POST['id'] ?? 0);

        if ((new Category())->find($id)) {
            (new Category())->delete($id);
            $this->flash('Categoría eliminada (y sus productos).');
        }

        $this->redirect('/categories');
    }
}