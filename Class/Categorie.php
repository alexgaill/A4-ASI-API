<?php

class Categorie extends Database{

    
    public function getAll()
    {
        $query = $this->pdo->query("SELECT * FROM categorie");
        header("Content-type:Application/json");
        echo json_encode($query->fetchAll(PDO::FETCH_OBJ));
        // fetchAll retourne un tableau de données
        //fetch retourne un jeu de donnée accessible sans avoir à faire de boucle.
        // Pour récupérer une valeur d'un tableau, je fais $array[key]
        // Pour récupérer une valeur d'un objet, je fais $array->key
    }
    public function getOne($id)
    {
        $query = $this->pdo->query("SELECT * FROM categorie WHERE id = $id");
        header("Content-type:Application/json");
        echo json_encode($query->fetch(PDO::FETCH_OBJ));
    }

    public function postOne($data)
    {
        try {

            $prepare = $this->pdo->prepare("INSERT INTO categorie (name) VALUES (:name)");
            $prepare->execute($data);


            header("Content-type:Application/json");
            echo json_encode([
                "statutCode" => 203,
                "message" => "Categorie bien enregistrée",
                "data" => []
            ]);
        } catch (\Throwable $th) {
            var_dump($th);
            http_response_code(400);
            echo json_encode([
                "statutCode" => 400,
                "message" => "Categorie bien enregistrée",
                "data" => []
            ]);
        }
    }

    public function deleteOne($id)
    {
        try {
            $prepare = $this->pdo->prepare("DELETE FROM categorie WHERE id = $id");
            $prepare->execute();


            header("Content-type:Application/json");
            echo json_encode([
                "statutCode" => 200,
                "message" => "Categorie bien supprimée",
                "data" => []
            ]);
        } catch (\PDOException $e) {
            http_response_code(400);
            echo json_encode([
                "statutCode" => 400,
                "message" => "Erreur lors de la suppression",
                "data" => [$e->getMessage()]
            ]);
        }
    }
    public function updateOne($data)
    {
        try {
            $prepare = $this->pdo->prepare("UPDATE categorie SET name = :name WHERE id = :id");
            $prepare->execute($data);

            header("Content-type:Application/json");
            echo json_encode([
                "statutCode" => 200,
                "message" => "Categorie bien modifiée",
                "data" => []
            ]);
        } catch (\PDOException $e) {
            http_response_code(400);
            echo json_encode([
                "statutCode" => 400,
                "message" => "Erreur lors de la suppression",
                "data" => [$e->getMessage()]
            ]);
        }
    }
}