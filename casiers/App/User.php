<?php

use Firebase\JWT\JWT;

class User extends General{

    public function signup($data)
    {
        foreach ($data as $key => $value) {
            if ($key === "password") {
                $data[$key] = password_hash($value, PASSWORD_DEFAULT);
            } else {
                $data[$key] = htmlspecialchars($value);
            }
        }
        $roles = [["ROLE_USER"], ["ROLE_ADMIN"]];
        $data["role"] = json_encode($roles[rand(0,1)]);
        $statement = "INSERT INTO user (email, password, role) VALUES (:email, :password, :role)";

        $this->postData($statement, $data, 2);

        $this->sendData(200, "User sauvegardé!");
    }

    public function login($data)
    {
        $statement = "SELECT * FROM user WHERE email = '" . $data["email"] ."'";
        $user = $this->getData($statement, true);

        if ($user) {
            if (password_verify($data["password"], $user->password) ) {
                $user->role = json_decode($user->role);
                $key = "casier";
                $payload = [
                    "user" => $user,
                    'exp' => 1272508903998
                ];
                $jwt = JWT::encode($payload, $key);

                $this->sendData(200, "Utilisateur reconnu", $jwt);
            } else {
                $this->sendError(400, "Erreur de password");
            }
        } else {
            $this->sendError(400, "Utilisateur non reconnu");
        }
    }
}