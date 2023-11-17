<?php

namespace App\Custom;

class StatusController
{

    /**
     * Error $e->getMessage() root
     *
     * @param array $eMesagge
     *
     * @return array
     *
     */
    public static function eMessageError($eMesagge, $error):Array
    {


        return [
            'code'    => 500,
            'message' => $eMesagge,
            'success' => false,
            'error'   => $error,
        ];

    }


     /**
     * message error not entry data product
     *
     * @return array
     */
    public static function notFoundMessage():Array
    {

        return [
            'code'    => 404,
            'message' => 'Note not found',
            'success' => false,
        ];

    }

    /**
     * Message data response succesfull
     *
     * @param string $code
     * @param string $message
     * @param boolean $status
     * @param int $count
     * @param array $payload
     *
     * @return array
     *
     */
    public static function successfullMessage($code, $message, $status, $count, $payload):Array
    {

        return [
            'code'    => $code,
            'message' => $message,
            'success' => $status,
            'count'   => $count,
            'data'    => $payload,
        ];

    }

}
