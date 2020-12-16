<?php

class Stock extends General{

    /**
     * Get stock list
     * method="GET"
     *
     * @return void
     */
    public function getAll()
    {
            $statement = "SELECT * FROM stock
                            LEFT JOIN product 
                            ON stock.product_id = product.product_id";
            
            $stocks = $this->getData($statement);

            $this->sendData(200, "Stock list", $stocks);
    }

    /**
     * get stock
     * method = "GET"
     *
     * @param int $id
     * @return void
     */
    public function getOne(int $id)
    {
            $statement = "SELECT * FROM stock 
                            LEFT JOIN product
                            ON stock.product_id = product.product_id
                            WHERE stock_id = $id";
            
            $stock = $this->getData($statement, true);

            $this->sendData(200, "Stock datas", $stock);
    }

    /**
     * Update stock
     * method="PUT"
     *
     * @param integer $id
     * @param string $json
     * @return void
     */
    public function updateOne(int $id, string $json)
    {
            $updateStatement = "UPDATE stock SET quantityInStock = :quantityInStock WHERE stock_id = $id";
            $getStatement = "SELECT * FROM stock WHERE stock_id = $id";
            
            $stock = $this->updateData($json, $updateStatement, $getStatement);

            $this->sendData(200, "Stock updated", $stock);
    }
}