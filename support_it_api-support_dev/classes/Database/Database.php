<?php

declare(strict_types=1);

namespace Support\Database;

class Database
{
    //Daca exista eroare la query, o intaorce
    public function queryErr($id): void
    {
        global $db, $app;

        if (!$id) {
            $app->error("Error: " . $db->getLastError());
        }
    }
    public function emptyErr($id, $errMessage): void
    {
        global $app;

        if (!$id) {
            $app->error($errMessage);
        }
        $this->queryErr($id);
    }
    //Creaza intrare in tabel cu datele selectate
    public function createEntry(string $table, array $data): int
    {
        global $db;

        $q = $db->insert($table, $data);
        $this->queryErr($q);

        return $q;
    }
    public function updateEntry(string $table, array $data, ?int $id): void
    {
        global $db;

        $db->where('id', $id);
        $q = $db->update($table, $data);
        $this->queryErr($q);
    }
    public function getEntry(string $table, string $col, $data): array
    {
        global $db;

        $db->where($col, $data);
        $q = $db->get($table);

        return $q;
    }
    public function getOne(string $table, string $col, $data): ?array
    {
        global $db;

        $db->where($col, $data);
        $q = $db->getOne($table);

        return $q;
    }
    public function deleteEntry(string $table, int $id): void
    {
        global $db;

        $db->where('id', $id);
        $db->delete($table);
    }
}
