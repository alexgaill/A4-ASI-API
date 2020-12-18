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