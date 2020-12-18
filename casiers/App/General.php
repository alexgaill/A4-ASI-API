<?php

class General extends Database{

    /**
     * basic function sending data
     *
     * @param integer $code
     * @param string $message
     * @param array||object $data
     * @return void
     */
    public function sendData(int $code, string $message, $data = [])
    {
        header("Content-type: Application/json");
        echo json_encode([
            "statutCode" => $code,
            "message" => $message,
            "data" => $data
        ]);
    }

    /**
     * basic function sending error message
     *
     * @param integer $code
     * @param string $message
     * @return void
     */
    public function sendError(int $code, string $message)
    {
        http_response_code($code);
        header("Content-type: Application/json");
        echo json_encode([
            "statutCode" => $code,
            "message" => $message
        ]);
    }

    /**
     * Data secure
     *
     * @param array $data
     * @return array
     */
    public function secureData(array $data):array
    {
        foreach ($data as $key => $value) {
            $data[$key] = htmlspecialchars($value);
        }
        return $data;
    }

    public function getData(string $statement, bool $one = false)
    {
        try {
            $query = $this->pdo->query($statement);
            if ($one) {
                return $query->fetch(PDO::FETCH_OBJ);
            }
            return $query->fetchAll(PDO::FETCH_OBJ);

        } catch (\PDOException $e) {
            $this->sendError(400, $e->getMessage());
        }
    }

    public function postData(string $statement, array $data = array(), int $mode = 1)
    {
        try{
            var_dump($data);
            // $data = $this->secureData($data);
            $prepare = $this->pdo->prepare($statement);

            if ($mode === 1) {
                $prepare->execute();
            } elseif ($mode === 2) {
                $prepare->execute($data);
            } 
        } catch (\PDOException $e) {
            $this->sendError(400, $e->getMessage());
        }

    }

    public function updateData($json, $updateStatement, $getStatement)
    {
        try{
            $json = str_replace("+"," ", $json);
            $array = explode("&", $json);
            $data = array();
            foreach ($array as $value) {
                $info = explode("=", $value);
                $data[$info[0]] = $info[1];
            }

            $this->postData($updateStatement, $data, 2);

            return $this->getData($getStatement);
        
        } catch(\PDOException $e){
            $this->sendError(400, $e->getMessage());
        }
    }
}