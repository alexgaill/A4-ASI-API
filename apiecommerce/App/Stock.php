<?php
use OpenApi\Annotations as OA;

/**
 * @OA\Schema
 */
class Stock extends General{

        /**
         * @OA\Property(
         *      type="integer",
         *      example=1
         * )
         *
         * @var [type]
         */
        private $id;
        
        /**
         * @OA\Property(
         *      type="integer",
         *      example=1
         * )
         *
         * @var [type]
         */
        private $product_id;

        /**
         * @OA\Property(
         *      type="integer",
         *      example=132
         * )
         *
         * @var [type]
         */
        private $quantityInStock;

    /**
     * Get stock list
     * @OA\Get(
     *          path="/stock",
     *          tags={"Stock"},
     *          @OA\Response(
     *                  response="200",
     *                  description="Récupère l'ensemble des stocks",
     *                  @OA\JsonContent(
     *                          type="array",
     *                          @OA\Items(ref="#/components/schemas/Stock")
     *                  )
     *          )
     * )
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
     * @OA\Get(
     *          path="stock/{id}",
     *          tags={"Stock"},
     *          @OA\Parameter(
     *                  name="id",
     *                  in="path",
     *                  required=true,
     *                  @OA\Schema(type="integer")
     *          ),
     *          @OA\Response(
     *                  response="200",
     *                  description="récupération d'un stock suivant son id",
     *                  @OA\JsonContent(
     *                          type= "array",
     *                          @OA\Items(ref="#/components/schemas/Stock")
     *                  )
     *          )
     * )
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
     * @OA\Put(
     *          path="stock/{id}",
     *          tags={"Stock"},
     *          @OA\Parameter(
     *                  name="id",
     *                  in="path",
     *                  required=true,
     *                  @OA\Schema(type="integer")
     *          ),
     *          @OA\RequestBody(
     *                  ref="#/components/requestBodies/postStock"
     *          ),
     *          @OA\Response(
     *                  response="200",
     *                  description="récupération d'un stock suivant son id",
     *                  @OA\JsonContent(
     *                          type= "array",
     *                          @OA\Items(ref="#/components/schemas/Stock")
     *                  )
     *          )
     * )
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