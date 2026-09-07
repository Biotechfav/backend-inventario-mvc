<?php

declare(strict_types=1);

class Category
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getConnection();
    }

    public function all(): array
    {
        $stmt = $this->db->query(
            'SELECT c.*, COUNT(p.id) AS products_count
             FROM categories c
             LEFT JOIN products p ON p.category_id = c.id
             GROUP BY c.id
             ORDER BY c.name'
        );
        return $stmt->fetchAll();
    }

    public function find(int $id): array|false
    {
        $stmt = $this->db->prepare('SELECT * FROM categories WHERE id = :id LIMIT 1');
        $stmt->execute([':id' => $id]);
        return $stmt->fetch();
    }

    public function create(string $name): int
    {
        $stmt = $this->db->prepare('INSERT INTO categories (name) VALUES (:name)');
        $stmt->execute([':name' => $name]);
        return (int) $this->db->lastInsertId();
    }

    public function update(int $id, string $name): void
    {
        $stmt = $this->db->prepare('UPDATE categories SET name = :name WHERE id = :id');
        $stmt->execute([':name' => $name, ':id' => $id]);
    }

    public function delete(int $id): void
    {
        // El borrado en cascada lo maneja la FK (ON DELETE CASCADE)
        $stmt = $this->db->prepare('DELETE FROM categories WHERE id = :id');
        $stmt->execute([':id' => $id]);
    }

    public function count(): int
    {
        return (int) $this->db->query('SELECT COUNT(*) FROM categories')->fetchColumn();
    }

    public function exists(int $id): bool
    {
        $stmt = $this->db->prepare('SELECT 1 FROM categories WHERE id = :id LIMIT 1');
        $stmt->execute([':id' => $id]);
        return $stmt->fetch() !== false;
    }
}