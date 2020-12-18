<?php

use Firebase\JWT\JWT;

class User extends General{

    /**
     * Save user in DB
     * method="POST"
     *
     * @param array $data
     * @return void
     */
    public function signup(array $data)
    {
            foreach ($data as $key => $value) {
                if ($key === "password") {
                    $data[$key] = password_hash($value, PASSWORD_DEFAULT);
                } else{
                    $data[$key] = htmlspecialchars($value);
                }
            }
            $data["role"] = ["ROLE_USER"];
            $statement = "INSERT INTO user (firstname, lastname, email, password, role) VALUES (:firstname, :lastname, :email, :password, :role)";
            $this->postData($statement, $data, 2);

            $this->sendData(200, "User saved");
    }

    /**
     * Verify user in DB
     * method="POST"
     *
     * @param array $data
     * @return void
     */
    public function login(array $data)
    {
            $statement = "SELECT * FROM user WHERE email = '". $data["email"] ."'";
            $user = $this->getData($statement, true);
            if (password_verify($data["password"], $user->password) ) {
                $key = "toto";
                $payload = array(
                    "exp" => 1272508903998, // Now + 20 minutes
                    "user" => $user,
                );
                $jwt = JWT::encode($payload, $key);

                $this->sendData(200, "User ok", $jwt);
            } else {
                $this->sendError(400, "Invalid parameter");
            }
    }

    /**
     * get users
     * method="GET"
     *
     * @return void
     */
    public function getAll()
    {
            $statement = "SELECT * FROM user";
            $users = $this->getData($statement);

            $this->sendData(200, "User list", $users);
    }

    /**
     * Update user
     * method="PUT"
     *
     * @param integer $id
     * @param string $json
     * @return void
     */
    public function updateOne(int $id, string $json)
    {
            $updateStatement = "UPDATE user SET
                            firstname = :firstname,
                            lastname = :lastname,
                            email = :email
                            WHERE user_id = $id";
            $getStatement = "SELECT * FROM user WHERE user_id = $id";

            $user = $this->updateData($json, $updateStatement, $getStatement);
            $this->sendData(200, "User updated", $user);
    }

    /**
     * Delete user
     * method="DELETE"
     *
     * @param integer $id
     * @return void
     */
    public function deleteOne(int $id)
    {
            $deleteStatement = "DELETE FROM user WHERE user_id = $id";
            $getStatement = "SELECT * FROM user";

            $this->postData($deleteStatement);
            $users = $this->getData($getStatement);

            $this->sendData(200, "User removed", $users);
    }
}