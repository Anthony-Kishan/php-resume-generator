<?php


class Model extends Database
{
    protected $table = 'users';

    function where($data)
    {
        $keys = array_keys($data);

        $query = "SELECT * FROM $this->table WHERE id = :id";
        $this->query($query, ['id'=>23 ]);
    }

    function first($data)
    {
        $query = "SELECT * FROM `resumes`";
        $result = $this->query($query);
        show($result);
    }

    function insert($data)
    {
        $query = "SELECT * FROM `resumes`";
        $result = $this->query($query);
        show($result);
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
