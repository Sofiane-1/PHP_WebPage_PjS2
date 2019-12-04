<?php

/**
 * Class LigneCommande
 */
class LigneCommande
{
    private $nLigneCommande;

    /**
     * @return mixed
     */
    public function getNLigneCommande()
    {
        return $this->nLigneCommande;
    }

    /**
     * @return int
     */
    public function getNCmde(): int
    {
        return $this->nCmde;
    }

    /**
     * @return int
     */
    public function getNPizza(): int
    {
        return $this->nPizza;
    }

    /**
     * @return int
     */
    public function getNPers(): int
    {
        return $this->nPers;
    }

    /**
     * @return mixed
     */
    public function getEtatPizza()
    {
        return $this->etatPizza;
    }
    /**
     * @var int numero de commande
     */
    private $nCmde;
    /**
     * @var int numero de pizza
     */
    private $nPizza;
    /**
     *  @var int Numero de personne qui s'occupe de la pizza en 
     *  préparation
     */
    private $nPers;
    private $etatPizza;

    /**
     * Méthode qui retourne toutes les lignes commandes
     * @return array
     * @throws Exception
     */
    public static function getAll()
    {
        $stmt = MyPDO::getInstance()->prepare(<<<SQL
        select *
        from ligneCommande
SQL
    );
    $stmt->execute();
    $stmt->setFetchMode(PDO::FETCH_CLASS,LigneCommande::class);
    return $stmt->fetchAll();
    }

    /**
     * Méthode qui permet de retourner les pizza qui sont dans la commande entré en paramètre
     * @param int $cmde
     * @return un tableau de pizza qui sont dans la commande rentré en paramètre(array)
     * @throws Exception
     */
    public static function getPizzaFromCmde(int $cmde)
    {
        $stmt = MyPDO::getInstance()->prepare(<<<SQL
        select *
        from pizza
        where nPizza in(select nPizza
                        from ligneCommande
                        where nCmde = ?)
SQL
    );
    $stmt->execute([$cmde]);
    $stmt->setFetchMode(PDO::FETCH_CLASS,Pizza::class);
    return $stmt->fetchAll();
    }

    /**
     * Accesseur à l'attribut rentré en paramètre
     * @param l'atribut à acceder (string)
     * @return l'attribut des ingredients (string)
     */
    public function getAttr(string $name)
    {
        return $this->$name;
    }


    /**
     * Méthode qui permet d'ajouter une ligne de commande
     * @param int $nCmde
     * @param int $nPizza
     * @throws Exception
     */
    public static function addLigne(int $nCmde, int $nPizza)
    {
        $test = MyPDO::getInstance()->prepare('SELECT MAX(nLigneCommande) as max FROM ligneCommande');
        $test->execute();
        $max = $test->fetch();

        $stmt = MyPDO::getInstance()->prepare(<<<SQL
            insert into ligneCommande
            values (?,?,?,?,?)
SQL
    );
        $stmt->execute([$max['max']+1,$nCmde,$nPizza,null,null]);
    }

    /**
     * Méthode qui permet de supprimer une ligne de commande
     * @param int $nCmde
     * @param int $nPizza
     * @throws Exception
     */
    public static function delLigne(int $nLigneCommande)
    {
            
            $stmt = MyPDO::getInstance()->prepare(<<<SQL
            delete from ligneCommande
            where nligneCommande = ?
SQL
        );
            $stmt->execute([$nLigneCommande]);
    }

    public function getPers (int $nCmde, int $nPizza)
    {
        $stmt = MyPDO::getInstance()->prepare(<<<SQL
        select *
        from personnel
        where nPers IN (select nPers
                        from ligneCommande
                        where nCmde = :nCmde
                        and nPizza = :nPizza)
SQL
    );
        //echo "\n<!-- cmde: $nCmde pizza: $nPizza -->\n" ;
        $stmt->execute([":nCmde" => $nCmde, ":nPizza" => $nPizza]);
        $stmt->setFetchMode(PDO::FETCH_CLASS,Personnel::class);
        $pers = $stmt->fetch();
        //var_dump($pers);
        if ($pers === false){
            throw new Exception("Personnel non trouvé");
        }
        return $pers;
    }

    public static function updateLigneCommande(int $id,array $modif)
    {
        $req = 'update ligneCommande set';
        for ($i = 0; $i < count($modif); $i += 2) {
            $req .=" {$modif[$i]} = '{$modif[$i+1]}' ";
            if ($i != count($modif)-2) {
                $req.= ',';
            }
        }
        $req.= "where nLigneCOmmande = $id";
        $stmt = MyPDO::getInstance()->prepare($req);
        $stmt->execute();
    }

    public static function getLigneFromClient(int $nCmde, int $nClient){
        $req = MyPDO::getInstance()->prepare('SELECT * FROM ligneCommande l, commande c WHERE l.nCmde = c.nCmde AND l.nCmde = ? AND c.nClient = ?');
        $req->execute([$nCmde,$nClient]);
        return $req->fetchAll(PDO::FETCH_CLASS, 'LigneCommande');
    }

}