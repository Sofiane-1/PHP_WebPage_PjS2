<?php

class Auth
{
    private $buttonName;
    private $pseudoField;
    private $passField;

    public function __construct(string $buttonName, string $pseudoField, string $passField)
    {
        $this->buttonName = $buttonName;
        $this->passField = $passField;
        $this->pseudoField = $pseudoField;
    }

    public function verifConnexion()
    {
        $message = null;
        if (isset($_POST["{$this->buttonName}"])) {
            if (isset($_POST["{$this->pseudoField}"]) && !empty($_POST["{$this->pseudoField}"])) {
                if (isset($_POST["{$this->passField}"]) && !empty($_POST["{$this->passField}"])) {
                    $personnel = Personnel::findPseudo($_POST["{$this->pseudoField}"]);
                    $client = Client::findPseudo($_POST["{$this->pseudoField}"]);
                    if ($personnel !=false) {
                        if (SHA1($_POST["{$this->passField}"]) == $personnel->getMdpPers()) {
                            $_SESSION['id'] = $personnel->getNPers();
                            $_SESSION['role'] = $personnel->getRolePers();
                            header("location:".  $_SERVER['HTTP_REFERER']);
                            //header('Location: index.php');
                        } else {
                            $message = "Mauvais Identifiants";
                        }
                    } else if($client!=false){
                        if(SHA1($_POST["{$this->passField}"]) == $client->getMdpCli()){
                            $_SESSION['id'] = $client->getNClient();
                            $_SESSION['role'] = null;
                            header('Location: index.php');
                        } else{
                            $message = "Mauvais Identifiants";
                        }
                    }
                } else {
                    $message = "Saisir un mot de passe";
                }
            } else {
                $message = "Saisir un identifiant";
            }
        }

        return $message;
    }


    public static function verifAdmin(int $id)
    {
        try {
            $p = Personnel::getFromId($id);
            if ($p->getRolePers() == "directeur" && $p->getStatutPers() == "actif") {
                return true;
            }
        } catch (Exception $e) {
            $e->getMessage();
        }
        

        return false;
    }


    public static function verifLivreur(int $id)
    {
        try {
            $p = Personnel::getFromId($id);
            if (($p->getRolePers() == "livreur" && $p->getStatutPers() == "actif") || ($p->getRolePers() == "directeur" && $p->getStatutPers() == "actif")) {
                return true;
            }
        } catch (Exception $e) {
            $e->getMessage();
        }
        return false;
    }


    public static function verifClient(int $id)
    {
        try {
            $c = Client::getFromId($id);
 
            
        } catch (Exception $e) {
            $e->getMessage();
        }
        return true;
    }

    public static function verifPizzaiolo(int $id) : bool {
        try{
        $p = Personnel::getFromId($id);
        if (($p->getRolePers() == "pizzaiolo" && $p->getStatutPers() == "actif") || ($p->getRolePers() == "directeur" && $p->getStatutPers() == "actif")) {
            return true;
        }
        } catch (Exception $e) {
            $e->getMessage();
        }
        return false;
    }
}