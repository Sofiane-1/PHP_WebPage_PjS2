<?php

class Commande
{
    private $nCmde;

    /**
     * @return mixed
     */
    public function getNCmde()
    {
        return $this->nCmde;
    }

    /**
     * @return mixed
     */
    public function getNLivraison()
    {
        return $this->nLivraison;
    }

    /**
     * @return mixed
     */
    public function getNClient()
    {
        return $this->nClient;
    }

    /**
     * @return mixed
     */
    public function getLibCmde()
    {
        return $this->libCmde;
    }

    /**
     * @return mixed
     */
    public function getDateCmde()
    {
        return $this->dateCmde;
    }

    /**
     * @return mixed
     */
    public function getInstructionsCmde()
    {
        return $this->instructionsCmde;
    }

    /**
     * @return mixed
     */
    public function getEtatCmde()
    {
        return $this->etatCmde;
    }

    /**
     * @return mixed
     */
    public function getPrixCmde()
    {
        return $this->prixCmde;
    }

    /**
     * @return mixed
     */
    public function getHeurePrevueCmde()
    {
        return $this->heurePrevueCmde;
    } /* @param le numéro de la commande (int) */
    private $nLivraison; /* @param le numéro de la livraison (int) */
    private $nClient; /* @param le numéro du client (int) */
    private $libCmde; /* @param le libélé de la commande (int) */
    private $dateCmde; /* @param la date de la commande (date) */
    private $instructionsCmde; /* @param les instructions de la commande (string)*/
    private $etatCmde; /* @param l'état de la commande (string) */
    private $prixCmde; /* @param le prix de la commande (float) */
    private $heurePrevueCmde; /* @param l'heure prevue de la commande (float) */


    /**
     * Méthode qui retourne tous les attributs de la table commande sous forme d'un tableau.
     * @return le tableau des attribut de la table commande (array)
     *
     */    
    public static function getAll()
    {
        $stmt = MyPDO::getInstance()->prepare(<<<SQL
            select *
            from commande
SQL
    );
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_CLASS,Commande::class);
        return $stmt->fetchAll();
    }

    /**
     * Méthode qui permet de retourner une commande qui a l'id rentré en paramètre. La méthode lance une exception si la commande n'existe pas.
     * @param l'id de la commande a recherché (int)
     * @return la commande egale à l'id (commande)
     */    
    public static function getFromId(int $id)
    {
        $stmt = MyPDO::getInstance()->prepare(<<<SQL
            select *
            from commande
            where nCmde = ?
SQL
    );
        $stmt->execute([$id]);
        $stmt->setFetchMode(PDO::FETCH_CLASS,Commande::class);
        $cmde = $stmt->fetch();
        if (!$cmde)
            throw new Exception ("Id de commande invalide");
        return $cmde;
    }

    /**
     * Accesseur à l'attribut rentré en paramètre
     * @param l'atribut à acceder (string) 
     * @return l'attribut de la commande (string)
     */
    public function getAttr(string $name)
    {

        return $this->$name;
    }
    
    /**
     * Méthode qui permet de retourner les détails de la commande
     * @return les détails de la commande (string)
     *
     */
    public function getDetail()
    {
        return LigneCommande::getPizzaFromCmde((int) $this->nCmde);
    }

    /**
     * Méthode qui permet d'ajouter une commande à la base de données
     * @param le tableau des attributs de la table commande à ajouter (commande)
     */
    public static function addCmde(array $values)
    {
        $num = myPDO::getInstance()->prepare(<<<SQL
        select max(nCmde) as n
        from commande
SQL
    );
        $num->execute();
        $num = $num->fetch();
        $num = intval($num['n']) +1;
        $stmt = myPDO::getInstance()->prepare(<<<SQL
            insert into commande
            values ($num,?,?,?,?,?,?,?)
SQL
    );
        $stmt->execute($values);
    }

    /**
     * Méthode qui permet de supprimer une commande de la base de donnée 
     * @param le numéro de la commande à supprimer (int)
     */
    public static function delCmde(int $nCmde)
    {
        $stmt = myPDO::getInstance()->prepare(<<<SQL
        delete from commande
        where nCmde = ?
SQL
    );
        $stmt->execute([$nCmde]);
    }

    /**
     * /!\ $modif de format [colonneA, modifA, colonneB, modifB ...] /!\
     * Méthode qui permet de modifier une commande de la base de données 
     * @param l'id de la commande (int)
     */
    public function updateCmde(int $id, array $modif)
    {
        $req = 'update commande set';
        for ($i = 0; $i < count($modif); $i += 2)
        {
            $req .=" {$modif[$i]} = '{$modif[$i+1]}' ";
            if ($i != count($modif)-2) {
                $req.= ',';
            }
     
        }
        $req.= "where nCmde = {$id}";
        $stmt = myPDO::getInstance()->prepare($req);
        $stmt->execute();
    }

    public static function isDisponible($nClient):bool{
        $req = MyPDO::getInstance()->prepare('SELECT * FROM commande WHERE nClient = ?');
        $req->execute([$nClient]);
        $res = $req->fetchAll();
        $bool = true;
        foreach($res as $etat){
            if($etat['etatCmde'] == "en attente"){
                $bool = false;
            }

        }
        return $bool;
    }

    public static function getCmdeAttente($nClient){
        $req = MyPDO::getInstance()->prepare('SELECT * FROM commande WHERE nClient = ? AND etatCmde = "en attente"');
        $req->execute([$nClient]);
        $req->setFetchMode(PDO::FETCH_CLASS, 'Commande');
        return $req->fetch();
    }
}
