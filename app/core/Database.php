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
            // Check if the query is a SELECT statement
            if (stripos($query, 'SELECT') === 0) {
                $result = $stm->get_result();

                $rows = [];

                while ($row = $result->fetch_assoc()){
                    $rows[] = $row; 
                }

                if(is_array($rows) && count($rows)){
                    return $rows;
                }

                // if (is_array($result) && count($result)) {
                //     return $result;
                // }
            }
            return true;  // For INSERT/UPDATE/DELETE queries
        }
        return false;
    }
}