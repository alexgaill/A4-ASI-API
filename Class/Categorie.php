<?php

class Categorie extends Database{

    /**
     * Get List of Categories
     *
     * @return void
     */
    public function getAll()
    {
        try {
            $query = $this->pdo->query("SELECT * FROM categorie");
            General::sendData(200, "Liste des categories", $query->fetchAll(PDO::FETCH_OBJ));

        } catch (\PDOException $e) {
            General::sendError(400, $e->getMessage());
        }

    }

    /**
     * Get one category by id
     *
     * @param integer $id
     * @return void
     */
    public function getOne(int $id)
    {
        try {
            if (is_int($id)) {
                $query = $this->pdo->query("SELECT * FROM categorie WHERE id = $id");
                General::sendData(200, "Données de la categorie." , $query->fetch(PDO::FETCH_OBJ));
                
            } else {
                General::sendError(400, "Erreur d'identifiant, nécessite un integer");
            }

        } catch (\PDOException $e) {
            General::sendError(400, $e->getMessage());
        }
    }

    /**
     * Save category in DB
     *
     * @param array $data
     * @return void
     */
    public function postOne(array $data)
    {
        try {
            foreach ($data as $key => $value) {
                $data[$key] = htmlspecialchars($value);
            }
            var_dump($data);
            $prepare = $this->pdo->prepare("INSERT INTO categorie (name)
                                            VALUES (:name)");
            $prepare->execute($data);

            General::sendData(200, "Categorie enregistré!");

        } catch (\PDOException $e) {
            General::sendError(400, $e->getMessage());
        }
    }

    /**
     * update category in DB
     *
     * @param array $data
     * @return void
     */
    public function updateOne(int $id, string $json)
    {
        try {
            $data = json_decode($json);
            foreach ($data as $key => $value) {
                $data[$key] = htmlspecialchars($value);
            }

            $prepare = $this->pdo->prepare("UPDATE categorie SET 
                name = :title,
                WHERE id = $id
            ");
            $prepare->bindParam(":name", $data->title);
            $prepare->execute();

            $query = $this->pdo->query("SELECT * FROM categorie WHERE id = $id");

            General::sendData(200, "Categorie modifié!", $query->fetch(PDO::FETCH_OBJ));

        } catch (\PDOException $e) {
            General::sendError(400, $e->getMessage());
        }
    }

    /**
     * Delete categorie
     *
     * @param integer $id
     * @return void
     */
    public function deleteOne(int $id)
    {
        try {
            if (is_int($id)) {
                $prepare = $this->pdo->prepare("DELETE FROM categorie WHERE id = $id");
                $prepare->execute();
                
                General::sendData(200, "Categorie supprimé!");
            } else {
            General::sendError(400, "Erreur d'identifiant, nécessite un integer");
            }

        } catch (\PDOException $e) {
            General::sendError(400, $e->getMessage());
        }
    }
}