<?php

declare(strict_types=1);

class ProductController extends Controller
{
    public function index(): void
    {
        $this->requireLogin();

        $this->view('products/index', [
            'title'    => 'Productos',
            'products' => (new Product())->all($_GET),
            'q'        => $_GET['q'] ?? '',
            'low'      => isset($_GET['low']),
        ]);
    }

    public function create(): void
    {
        $this->requireLogin();
        $this->view('products/form', [
            'title'      => 'Nuevo producto',
            'categories' => (new Category())->all(),
        ]);
    }

    public function store(): void
    {
        $this->requireLogin();

        $data = [
            'name'        => trim((string) ($_POST['name'] ?? '')),
            'description' => trim((string) ($_POST['description'] ?? '')),
            'price'       => (float) ($_POST['price'] ?? 0),
            'stock'       => (int) ($_POST['stock'] ?? 0),
            'category_id' => (int) ($_POST['category_id'] ?? 0),
        ];

        if ($data['name'] === '' || $data['price'] < 0 || $data['stock'] < 0
            || !(new Category())->exists($data['category_id'])) {
            $this->flash('Datos inválidos: revisa nombre, precio, stock y categoría.', 'error');
            $this->redirect('/products/form');
        }

        (new Product())->create($data);
        $this->flash('Producto registrado.');
        $this->redirect('/products');
    }

    public function edit(int $id): void
    {
        $this->requireLogin();
        $product = (new Product())->find($id);
        if (!$product) {
            $this->flash('Producto no encontrado.', 'error');
            $this->redirect('/products');
        }
        $this->view('products/form', [
            'title'      => 'Editar producto',
            'product'    => $product,
            'categories' => (new Category())->all(),
        ]);
    }

    public function update(): void
    {
        $this->requireLogin();

        $id = (int) ($_POST['id'] ?? 0);
        $data = [
            'name'        => trim((string) ($_POST['name'] ?? '')),
            'description' => trim((string) ($_POST['description'] ?? '')),
            'price'       => (float) ($_POST['price'] ?? 0),
            'stock'       => (int) ($_POST['stock'] ?? 0),
            'category_id' => (int) ($_POST['category_id'] ?? 0),
        ];

        if ($data['name'] === '' || $data['price'] < 0 || $data['stock'] < 0
            || !(new Product())->find($id) || !(new Category())->exists($data['category_id'])) {
            $this->flash('Datos inválidos.', 'error');
            $this->redirect('/products');
        }

        (new Product())->update($id, $data);
        $this->flash('Producto actualizado.');
        $this->redirect('/products');
    }

    public function delete(): void
    {
        $this->requireLogin();
        $id = (int) ($_POST['id'] ?? 0);

        if ((new Product())->find($id)) {
            (new Product())->delete($id);
            $this->flash('Producto eliminado.');
        }

        $this->redirect('/products');
    }
}