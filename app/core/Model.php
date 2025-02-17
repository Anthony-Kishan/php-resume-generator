<?php
# Main Model

class Model extends Database
{
    protected $table = 'users';
    protected $limit = 10;
    protected $offset = 0;

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


    function first($data, $data_not = [])
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

    function insert($data)
    {
        $keys = array_keys($data);
        $query = "INSERT INTO $this->table () VALUE ()";
    }

    function update($id, $data, $id_column = 'id')
    {
        $query = "SELECT * FROM `resumes`";
        $result = $this->query($query);
        show($result);
    }

    function delete($id, $id_column = 'id')
    {
        $query = "SELECT * FROM `resumes`";
        $result = $this->query($query);
        show($result);
    }
}
