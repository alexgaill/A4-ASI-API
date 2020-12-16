<?php

class Article extends Database{

    /**
     * Get List of Articles
     *
     * @return void
     */
    public function getAll()
    {
        try {
            $query = $this->pdo->query("SELECT * FROM article");
            General::sendData(200, "Liste des articles", $query->fetchAll(PDO::FETCH_OBJ));

        } catch (\PDOException $e) {
            General::sendError(400, $e->getMessage());
        }

    }

    /**
     * Get one article by id
     *
     * @param integer $id
     * @return void
     */
    public function getOne(int $id)
    {
        try {
            if (is_int($id)) {
                $query = $this->pdo->query("SELECT * FROM article WHERE id = $id");
                General::sendData(200, "Données de l'article." , $query->fetch(PDO::FETCH_OBJ));
                
            } else {
                General::sendError(400, "Erreur d'identifiant, nécessite un integer");
            }

        } catch (\PDOException $e) {
            General::sendError(400, $e->getMessage());
        }
    }

    /**
     * Save an article in DB
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
            $prepare = $this->pdo->prepare("INSERT INTO article (title, content, categorie_id)
                                            VALUES (:title, :content, :categorie_id)");
            $prepare->execute($data);

            General::sendData(200, "Article enregistré!");

        } catch (\PDOException $e) {
            General::sendError(400, $e->getMessage());
        }
    }

    /**
     * update an article in DB
     *
     * @param array $data
     * @return void
     */
    public function updateOne(int $id, string $json)
    {
        try {
            $data = json_decode($json);
            // foreach ($data as $key => $value) {
            //     $data[$key] = htmlspecialchars($value);
            // }

            $prepare = $this->pdo->prepare("UPDATE article SET 
                title = :title,
                content = :content,
                categorie_id = :categorie_id
                WHERE id = $id
            ");
            $prepare->bindParam(":title", $data->title);
            $prepare->bindParam(":content", $data->content);
            $prepare->bindParam(":categorie_id", $data->categorie_id);
            $prepare->execute();

            $query = $this->pdo->query("SELECT * FROM article WHERE id = $id");

            General::sendData(200, "Article modifié!", $query->fetch(PDO::FETCH_OBJ));

        } catch (\PDOException $e) {
            General::sendError(400, $e->getMessage());
        }
    }

    /**
     * Delete an article
     *
     * @param integer $id
     * @return void
     */
    public function deleteOne(int $id)
    {
        try {
            if (is_int($id)) {
                $prepare = $this->pdo->prepare("DELETE FROM article WHERE id = $id");
                $prepare->execute();
                
                General::sendData(200, "Article supprimé!");
            } else {
            General::sendError(400, "Erreur d'identifiant, nécessite un integer");
            }

        } catch (\PDOException $e) {
            General::sendError(400, $e->getMessage());
        }
    }
}