<?php

class General{

    /**
     * basic function sending data
     *
     * @param integer $code
     * @param string $message
     * @param array||object $data
     * @return void
     */
    public static function sendData(int $code, string $message, $data = [])
    {
        header("Content-type: Application/json");
        echo json_encode([
            "statutCode" => $code,
            "message" => $message,
            "data" => $data
        ]);
    }

    /**
     * basic function sending error message
     *
     * @param integer $code
     * @param string $message
     * @return void
     */
    public static function sendError(int $code, string $message)
    {
        http_response_code($code);
        header("Content-type: Application/json");
        echo json_encode([
            "statutCode" => $code,
            "message" => $message
        ]);
    }
}