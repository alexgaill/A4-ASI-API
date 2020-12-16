<?php

class Client extends General{

    public function verifyKey($apikey)
    {
        $statement = "SELECT * FROM client WHERE apikey = '$apikey'";

        return $this->getData($statement, true);

    }
}