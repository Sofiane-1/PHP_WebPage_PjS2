<?php


class Alert {

    private function __construct(){

    }
    public static function alert($message, $type){

        return " 
        <div class='alert alert-{$type}' role='alert'>
            $message
        </div>";
    }


}