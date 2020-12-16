<?php

class Product extends General{

    /**
     * Get products
     * method="GET"
     *
     * @return void
     */
    public function getAll()
    {
            $statement = "SELECT * FROM product";
            $products = $this->getData($statement);
            
            $this->sendData(200, "Products list", $products);
    }

    /**
     * Get one product
     * method="GET"
     *
     * @param integer $id
     * @return void
     */
    public function getOne(int $id)
    {
            $statement = "SELECT * FROM product WHERE product_id = $id";
            $product = $this->getData($statement, true);
            
            $this->sendData(200, "Product", $product);
    }

    /**
     * Post one product
     * method="POST"
     *
     * @param array $data
     * @return void
     */
    public function postOne(array $data)
    {
            $postStatement = "INSERT INTO product (name, infos, buyPrice, sellPrice) VALUES (:name, :infos, :buyPrice, :sellPrice)";
            $getStatement = "SELECT product_id FROM product WHERE `name` = '". $data["name"] . "'";
            
            $this->postData($postStatement, $data, 2);
            $product = $this->getData($getStatement, true);
            $stockStatement = "INSERT INTO stock (product_id, quantityInStock) VALUES ($product->product_id, 0)";
            $this->postData($stockStatement);

            $this->sendData(200, "Product saved et stock created");
    }

    /**
     * Update one product
     * method="PUT"
     *
     * @param int $id
     * @param string $json
     * @return void
     */
    public function updateOne(int $id, string $json)
    {
            $updateStatement = "UPDATE product SET 
                            name = :name,
                            infos = :infos,
                            buyPrice = :buyPrice,
                            sellPrice = :sellPrice
                            WHERE product_id = $id";
            $getStatement = "SELECT * FROM product WHERE product_id = $id";
            
            $product = $this->updateData($json, $updateStatement, $getStatement);

            $this->sendData(200, "Product updated", $product);
    }

    /**
     * Delete one product
     * method="DELETE"
     *
     * @param integer $id
     * @return void
     */
    public function deleteOne(int $id)
    {
            $postStatement = "DELETE FROM product WHERE product_id = $id";
            $getStatement = "SELECT * FROM product";
            $this->postData($postStatement);

            $products = $this->getData($getStatement);

            $this->sendData(200, "Product delete", $products);
    }

}