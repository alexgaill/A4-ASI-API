<?php

use Firebase\JWT\JWT;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema()
 */
class User extends General{

    /**
     * @OA\Property(
     *      type="integer",
     *      example=1
     * )
     */
    private $id;

    /**
     * @OA\Property(
     *      type="string",
     *      example="John"
     * )
     */
    private $firstname;

    /**
     * @OA\Property(
     *      type="string",
     *      example="Doe"
     * )
     */
    private $lastname;

    /**
     * @OA\Property(
     *      type="string",
     *      example="john@doe.fr"
     * )
     */
    private $email;

    /**
     * @OA\Property(
     *      type="string",
     *      example="password"
     * )
     */
    private $password;

    /**
     * Save user in DB
     * @OA\Post(
     *      path="/user/signup",
     *      tags={"User"},
     *      @OA\RequestBody(ref="#/components/requestBodies/postUser"),
     *      @OA\Response(
     *          response="200",
     *          description="Utilisateur enregistré",
     *          @OA\JsonContent(
     *              type="string",
     *              example="L'utilisateur a bien été enregistré"
     *          )
     *      )
     * )
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
     * @OA\Post(
     *      path="/user/login",
     *      tags={"User"},
     *      @OA\RequestBody(ref="#/components/requestBodies/login"),
     *      @OA\Response(
     *          response="200",
     *          description="Utilisateur enregistré",
     *          @OA\JsonContent(
     *              type="string",
     *              example="L'utilisateur a bien été enregistré"
     *          )
     *      )
     * )
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
     * @OA\Get(
     *      path="/user",
     *      tags={"User"},
     *      @OA\Response(
     *          response="200",
     *          description="récupération d'un stock suivant son id",
     *          @OA\JsonContent(
     *              type= "array",
     *              @OA\Items(ref="#/components/schemas/User")
     *          )
     *      )
     * )
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
     * @OA\Put(
     *      path="/user/{id}",
     *      tags={"User"},
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          @OA\Schema(type="integer"),
     *          required=true,
     *          description="Id de l'utilisateur"
     *      ),
     *      @OA\RequestBody(ref="#/components/requestBodies/updateUser"),
     *      @OA\Response(
     *          response="200",
     *          description="Mise à jour de l'utilisateur",
     *          @OA\JsonContent(
     *              type="array",
     *              @OA\Items(ref="#/components/schemas/User")
     *          )
     *      )
     * )
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
     * @OA\Delete(
     *      path="/user/{id}",
     *      tags={"User"},
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          @OA\Schema(type="integer"),
     *          required=true
     *      ),
     *      @OA\Response(
     *          response="200",
     *          description="Suppression de l'utilisateur ok",
     *          @OA\JsonContent(
     *              type="array",
     *              @OA\Items(ref="#components/schemas/User")
     *          )
     *      )
     * )
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