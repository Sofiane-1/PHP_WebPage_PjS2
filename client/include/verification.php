<?php
include ('config.php');
if(!isset($_SESSION['id']) || !Auth::verifClient($_SESSION['id'])){
    header('HTTP/1.0 403 Forbidden');
    die('<h1>Erreur 403 Forbidden</h1>');
}