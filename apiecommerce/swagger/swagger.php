<?php

use OpenApi\Annotations as OA;

/**
 * @OA\Info(title="Mon api ecommerce",
 *          version="0.1")
 * @OA\Server(url="localhost:8888/cours/IPSSI/A4/API/apiecommerce",
 *             description="Une api d'entrainement")
 */

/**
 * @OA\RequestBody(
 *      request="postProduct",
 *      required=true,
 *      @OA\JsonContent(
 *          required={"name", "infos", "buyPrice", "sellPrice"},
 *          @OA\Property(type="string", property="name"),
 *          @OA\Property(type="string", property="infos"),
 *          @OA\Property(type="integer", property="buyPrice"),
 *          @OA\Property(type="integer", property="sellPrice"),
 *      )
 * )
 */


/**
 * @OA\RequestBody(
 *  request="postStock",
 *  required=true,
 *  @OA\JsonContent(
 *      required={"product_id", "quantityInStock"},
 *      @OA\Property(property="product_id", type="integer"),
 *      @OA\Property(property="quantityInStock", type="integer")
 *  )
 * )
 */

/**
 * @OA\RequestBody(
 *  request="postUser",
 *  required=true,
 *  @OA\JsonContent(
 *      required={"firstname", "lastname", "email", "password"},
 *      @OA\Property(property="firstname", type="string", example="John"),
 *      @OA\Property(property="lastname", type="string", example="Doe"),
 *      @OA\Property(property="email", type="string", example="john@doe.fr"),
 *      @OA\Property(property="password", type="string", example="password")
 *  )
 * )
 */

 /**
 * @OA\RequestBody(
 *  request="updateUser",
 *  required=true,
 *  @OA\JsonContent(
 *      required={"firstname", "lastname", "email"},
 *      @OA\Property(property="firstname", type="string", example="John"),
 *      @OA\Property(property="lastname", type="string", example="Doe"),
 *      @OA\Property(property="email", type="string", example="john@doe.fr")
 *  )
 * )
 */

/**
 * @OA\RequestBody(
 *  request="login",
 *  required=true,
 *  @OA\JsonContent(
 *      required={"email", "password"},
 *      @OA\Property(property="email", type="string", example="john@doe.fr"),
 *      @OA\Property(property="password", type="string", example="password")
 *  )
 * )
 */