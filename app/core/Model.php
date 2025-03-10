<?php
# Main Model

namespace App\Core;

trait Model
{
    use Database;
    // protected $table = 'users';
    protected $limit = 10;
    protected $offset = 0;
    protected $order_type = "DESC";
    protected $order_column = "id";
    public $errors = [];

    function findAll()
    {
        $query = "SELECT * FROM $this->table ORDER BY $this->order_column $this->order_type LIMIT $this->limit OFFSET $this->offset";
        return $this->query($query);
    }

    function where($data, $data_not = [])
    {
        $keys = array_keys($data);
        $keys_not = array_keys($data_not);
        $query = "SELECT * FROM $this->table WHERE ";

        foreach ($keys as $key) {
            $query .= $key . " = ? AND ";
        }

        foreach ($keys_not as $key) {
            $query .= $key . " != ? AND ";
        }

        $query = rtrim($query, " AND ");
        $query .= " LIMIT $this->limit OFFSET $this->offset";

        $values = array_merge(array_values($data), array_values($data_not));
        return $this->query($query, $values);
    }

    function first($data, $data_not = []): mixed
    {
        $keys = array_keys($data);
        $keys_not = array_keys($data_not);
        $query = "SELECT * FROM $this->table WHERE ";

        foreach ($keys as $key) {
            $query .= $key . " = ? AND ";
        }

        foreach ($keys_not as $key) {
            $query .= $key . " != ? AND ";
        }

        $query = rtrim($query, " AND ");
        $query .= " LIMIT $this->limit OFFSET $this->offset";

        $values = array_merge(array_values($data), array_values($data_not));
        $result = $this->query($query, $values);
        if ($result) {
            return $result[0];
        }
        return false;
    }

    function insert($data): bool
    {
        $keys = array_keys($data);
        $query = "INSERT INTO $this->table (" . implode(",", $keys) . ") VALUES (";
        $placeholders = array_fill(0, count($keys), "?");
        $query .= implode(",", $placeholders) . ")";
        $result = $this->query($query, array_values($data));

        if ($result) {
            return true;
        }
        return false;
    }

    function update($id, $data, $id_column = 'id')
    {
        $keys = array_keys($data);
        $query = "UPDATE $this->table SET ";

        foreach ($keys as $key) {
            $query .= "$key = ?, ";
        }

        $query = rtrim($query, ", ");

        $query .= " WHERE $id_column = ?";

        $values = array_merge(array_values($data), [$id]);

        return $this->query($query, $values);
    }

    function delete($id, $id_column = 'id')
    {
        $query = "DELETE FROM $this->table WHERE $id_column = ?";

        return $this->query($query, [$id]);
    }
}
