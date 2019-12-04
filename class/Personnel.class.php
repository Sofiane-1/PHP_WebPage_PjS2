<?php


/**
 * Class Personnel
 */
class Personnel {
    /**
     * @var int numero du personnel
     */
    private $nPers;

    /**
     * @return int
     */
    public function getNPers(): int
    {
        return $this->nPers;
    }

    /**
     * @return string
     */
    public function getNomPers(): string
    {
        return $this->nomPers;
    }

    /**
     * @return string
     */
    public function getPnomPers(): string
    {
        return $this->pnomPers;
    }

    /**
     * @return string
     */
    public function getPseudoPers(): string
    {
        return $this->pseudoPers;
    }

    /**
     * @return string
     */
    public function getMdpPers(): string
    {
        return $this->mdpPers;
    }

    /**
     * @return string
     */
    public function getRolePers(): string
    {
        return $this->rolePers;
    }

    /**
     * @return string
     */
    public function getStatutPers(): string
    {
        return $this->statutPers;
    }
    /**
     * @var string nom du personnel
     */
    private $nomPers;
    /**
     * @var string prenom du personnel
     */
    private $pnomPers;
    /**
     * @var string pseudo du personnel
     */
    private $pseudoPers;
    /**
     * @var string mot de passe du personnel
     */
    private $mdpPers;
    /**
     * @var string role du personnel
     */
    private $rolePers;
    /**
     * @var string statut du personnel
     */
    private $statutPers;

    /**
     * Méthode qui retourne tout le personnel de la pizzeria avec leurs attributs sous forme de tableau
     * @return le tableau de tout le personnel (array)
     * @throws Exception
     */
    public static function getAll(){
        $req = MyPDO::getInstance()->prepare(<<<SQL
        SELECT * 
        FROM personnel
SQL
    );
        $req->execute();
        $res = $req->fetchAll(PDO::FETCH_CLASS,Personnel::class);
        return $res;
    }

    /**
     * Méthode qui retourne une personne qui a l'id entré en paramètre
     * @param int $id
     * @return une personne (personnel)
     * @throws Exception
     */
    public static function getFromId(int $id)
    {
        $stmt = MyPDO::getInstance()->prepare(<<<SQL
        select *
        from personnel
        where nPers = ?
SQL
    ); 
        $stmt->execute([$id]);
        $stmt->setFetchMode(PDO::FETCH_CLASS,Personnel::class);
        $pers = $stmt->fetch();
        if (!$pers)
            throw new Exception("erreur");
        return $pers;
    }

    /**
     * Accesseur aux commandes réalisés par une personne
     */
    public function getCmde()
    {
        Realisation::getCmde($this->nPers);
    }

    /**
     * Accesseur à l'attribut rentré en paramètre
     * @param l'atribut à acceder (string)
     * @return l'attribut des ingredients (string)
     */
    public function getAttr(string $nom)
    {
        return $this->$nom;
    }

    /**
     * Méthode qui permet d'ajouter une personne dans la table personnel
     * @param array $values
     * @throws Exception
     */
    public static function addPers(array $values)
    {
        $num = MyPDO::getInstance()->prepare(<<<SQL
        select max(nPers) as n
        from personnel
SQL
    );
        $num->execute();
        $num = $num->fetch();
        $num = intval($num['n']) +1;
        $stmt = MyPDO::getInstance()->prepare(<<<SQL
            insert into personnel
            values ($num,?,?,?,?,?,?)
SQL
    );
        $stmt->execute($values);
    }

    /**
     * Méthode qui permet supprimer une personne de la table personnel
     * @param int $nPers
     * @throws Exception
     */
    public static function delPers(int $nPers)
    {
        $stmt = MyPDO::getInstance()->prepare(<<<SQL
        delete from personnel
        where nPers = ?
SQL
    );
        $stmt->execute([$nPers]);
    }

    /**
     * /!\ $modif de format [colonneA, modifA, colonneB, modifB ...] /!\
     *
     * Méthode qui permet de modifier une personne de la table personnel
     * @param $id de la personne (int)
     * @param $modif le tableau des nouvelles valeurs
     */
    public static function updatePers(int $id, array $modif)
    {
        $req = 'update personnel set';
        for ($i = 0; $i < count($modif); $i += 2)
        {
            $req .=" {$modif[$i]} = '{$modif[$i+1]}' ";
            if ($i != count($modif)-2) {
                $req.= ',';
            }
        }
        $req.= "where nPers = $id";
        $stmt = MyPDO::getInstance()->prepare($req);
        $stmt->execute();
    }

    public static function findPseudo(string $pseudo){
        $req = MyPDO::getInstance()->prepare('SELECT * FROM personnel WHERE pseudoPers = ?');
        $req->execute([$pseudo]);
        $req->setFetchMode(PDO::FETCH_CLASS,'Personnel');
        return $req->fetch();
    }

 



}