<?php

declare(strict_types=1);

class Product
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getConnection();
    }

    /** @param array<string, mixed> $filters */
    public function all(array $filters = []): array
    {
        $sql = 'SELECT p.*, c.name AS category_name
                FROM products p
                JOIN categories c ON c.id = p.category_id
                WHERE 1 = 1';
        $params = [];

        if (!empty($filters['q'])) {
            $sql .= ' AND (p.name LIKE :q OR c.name LIKE :q2)';
            $params[':q'] = '%' . $filters['q'] . '%';
            $params[':q2'] = $params[':q'];
        }

        if (!empty($filters['low'])) {
            $sql .= ' AND p.stock <= 5';
        }

        $sql .= ' ORDER BY p.id DESC';

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    public function find(int $id): array|false
    {
        $stmt = $this->db->prepare(
            'SELECT p.*, c.name AS category_name
             FROM products p
             JOIN categories c ON c.id = p.category_id
             WHERE p.id = :id LIMIT 1'
        );
        $stmt->execute([':id' => $id]);
        return $stmt->fetch();
    }

    public function create(array $data): int
    {
        $stmt = $this->db->prepare(
            'INSERT INTO products (category_id, name, description, price, stock)
             VALUES (:category_id, :name, :description, :price, :stock)'
        );
        $stmt->execute([
            ':category_id' => $data['category_id'],
            ':name'        => $data['name'],
            ':description' => $data['description'] ?? null,
            ':price'       => $data['price'],
            ':stock'       => $data['stock'],
        ]);
        return (int) $this->db->lastInsertId();
    }

    public function update(int $id, array $data): void
    {
        $stmt = $this->db->prepare(
            'UPDATE products
             SET category_id = :category_id, name = :name, description = :description,
                 price = :price, stock = :stock
             WHERE id = :id'
        );
        $stmt->execute([
            ':category_id' => $data['category_id'],
            ':name'        => $data['name'],
            ':description' => $data['description'] ?? null,
            ':price'       => $data['price'],
            ':stock'       => $data['stock'],
            ':id'          => $id,
        ]);
    }

    public function delete(int $id): void
    {
        $stmt = $this->db->prepare('DELETE FROM products WHERE id = :id');
        $stmt->execute([':id' => $id]);
    }

    public function count(): int
    {
        return (int) $this->db->query('SELECT COUNT(*) FROM products')->fetchColumn();
    }

    public function lowStock(): array
    {
        return $this->all(['low' => true]);
    }
}