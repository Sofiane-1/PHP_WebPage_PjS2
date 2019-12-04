<?php
/**
 * Created by PhpStorm.
 * User: alla0023
 * Date: 17/06/2019
 * Time: 14:04
 */

class FlashMessages
{

    /**
     * @param $message
     */
    public static function fsuccess($message){
        $_SESSION["flash"] = ["message" => $message, "state" => "success"];
    }

    /**
     * @param $message
     */
    public static function ferror($message){
        $_SESSION["flash"] = ["message" => $message, "state" => "error"];
    }
}