<?php
trait Database
{
    private function connect()
    {
        $conn = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);
        return $conn;

    }

    public function query($query, $data = [])
    {
        $conn = $this->connect();
        $stm = $conn->prepare($query); // $stm - Statement

        $check = $stm->execute($data);
        if ($check) {
            $result = $stm->get_result();
            $result = $result->fetch_assoc();
            if (is_array($result) && count($result)) {
                return $result;
            }
        }
        return false;
    }
}