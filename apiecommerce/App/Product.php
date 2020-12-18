<?php
use OpenApi\Annotations as OA;

/**
 * @OA\Schema()
 */
class Product extends General{

        /**
         * @OA\Property(
         *      type="integer",
         * )
         *
         * @var int
         */
        private $id;

        /**
         * @OA\Property(
         *      type="string",
         *      nullable=false
         * )
         *
         * @var [type]
         */
        private $name;

        /**
         * @OA\Property(
         *      type="string",
         *      nullable=false
         * )
         *
         * @var [type]
         */
        private $infos;

        /**
         * @OA\Property(
         *      type="integer",
         *      nullable=false
         * )
         *
         * @var [type]
         */
        private $buyPrice;

        /**
         * @OA\Property(
         *      type="integer",
         *      nullable=false
         * )
         *
         * @var [type]
         */
        private $sellPrice;

    /**
     * Get products
     * @OA\Get(
     *          path="/product",
     *          tags={"Product"},
     *          @OA\Response(
     *                  response = "200",
     *                  description="Récupère tous les produits",
     *                  @OA\JsonContent(
     *                          type="array",
     *                          description="description",
     *                          @OA\Items(
     *                                  @OA\Property(
     *                                          property="id",
     *                                          type="integer",
     *                                          nullable=true,
     *                                          example="1"
     *                                  ),
     *                                  @OA\Property(
     *                                          property="name",
     *                                          type="string",
     *                                          nullable=false,
     *                                          example="product n°1"
     *                                  ),
     *                                  @OA\Property(
     *                                          property="infos",
     *                                          type="string",
     *                                          nullable=false
     *                                  ),
     *                                  @OA\Property(
     *                                          property="buyPrice",
     *                                          type="integer",
     *                                          nullable=false
     *                                  ),
     *                                  @OA\Property(
     *                                          property="sellPrice",
     *                                          type="integer",
     *                                          nullable=false
     *                                  ),
     *                          )
     *                  )
     *          ),
     *          @OA\Response(
     *                  response="400",
     *                  description="Erreur lors de la récupération des produits",
     *                  @OA\JsonContent(
     *                          type="string",
     *                          description="Erreur lors de la récupéréation des produits"
     *                  )
     *          )
     * )
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
     * @OA\Get(
     *          path="/product/{id}",
     *          tags={"Product"},
     *          @OA\Parameter(
     *                  name="id",
     *                  in="path",
     *                  description="id du produit que l'on souhaite récupérer",
     *                  required=true,
     *                  @OA\Schema(type="integer")
     *          ),
     *          @OA\Response(
     *                  response = "200",
     *                  description="Récupère un produit en fonction de son id",
     *                  @OA\JsonContent(
     *                          type="array",
     *                          @OA\Items(
     *                                  ref="#/components/schemas/Product"
     *                          ),
     *                          description="description"
     *                  ),
     *                  @OA\XmlContent(
*                                  type="array",
*                                  @OA\Items(
*                                          ref="#/components/schemas/Product"
*                                  ),
*                                  description="description"
     *                  )
     *          ),
     *          @OA\Response(
     *                  response="400",
     *                  description="Erreur lors de la récupération du produit",
     *                  @OA\JsonContent(
     *                          type="string",
     *                          description="Erreur lors de la récupéréation des produits"
     *                  )
     *          )
     * )
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
     * @OA\Post(
     *          path="/product/{id}",
     *          tags={"Product"},
     *          @OA\RequestBody(ref="#/components/requestBodies/postProduct"),
     *          @OA\Response(
     *                  response="200", 
     *                  description="post product"
     *          )
     * )
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
     * @OA\Put(
     *          path="/product",
     *          tags={"Product"},
     *          @OA\Parameter(
     *                  name="id",
     *                  in="path",
     *                  description="id du produit que l'on souhaite récupérer",
     *                  required=true,
     *                  @OA\Schema(type="integer")
     *          ),
     *          @OA\RequestBody(ref="#/components/requestBodies/postProduct"),
     *          @OA\Response(
     *                  response="200", 
     *                  description="post product",
     *                  @OA\JsonContent(
     *                          type="array",
     *                          @OA\Items(
     *                                  ref="#/components/schemas/Product"
     *                          ),
     *                          description="description"
     *                  )
     *          )
     * )
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
     * @OA\Delete(
     *          path="product/{id}",
     *          tags={"Product"},
     *          @OA\Parameter(
     *                  name="id",
     *                  in="path",
     *                  required=true,
     *                  @OA\Schema(type="integer")
     *          ),
     *          @OA\Response(
     *                  response="200",
     *                  description="Validation de suppression",
     *                  @OA\JsonContent(
     *                          type="string",
     *                          example="Produit bien supprimé"
     *                  )
     *          )
     * )
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