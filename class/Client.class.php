<?php

/**
 * Class Client
 */
class Client
{
    /**
     * @var int numéro de client
     */
    private $nClient;
    /**
     * @var string nom du client
     */
    private $nomCli;
    /**
     * @var string prenom du client
     */
    private $pnomCli;
    /**
     * @var int code postal
     */
    private $cp;
    /**
     * @var string ville
     */
    private $ville;
    /**
     * @var string addresse
     */
    private $adresse;
    /**
     * @var string pseudo du client
     */
    private $pseudoCli;
    /**
     * @var string mot de passe du client
     */
    private $mdpCli;

    /**
     * Méthode qui retourne tous les attributs de la table client sous forme d'un tableau.
     * @return le tableau des attribut de la table client (array)
     *
     */
    public static function getAll()
    {
        $stmt = MyPDO::getInstance()->prepare(<<<SQL
                select *
                from client
SQL
);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_CLASS,Client::class);
        return $stmt->fetchAll();
    }
    

    /**
     * Méthode qui permet de retourner un client qui a l'id rentré en paramètre. La méthode lance une exception si le client n'existe pas.
     * @param l'id du client a recherché (int)
     * @return le client egale à l'id (client)
     */
    public static function getFromId(int $id)
    {
        $stmt = MyPDO::getInstance()->prepare(<<<SQL
        select *
        from client
        where nClient = ?
SQL
);
        $stmt->execute([$id]);
        $stmt->setFetchMode(PDO::FETCH_CLASS,Client::class);
        $cli = $stmt->fetch();
        if (!$cli)
            throw new Exception ("Erreur, pas de client trouvé pour cet id");
        return $cli;
    }

    /**
     * @return array
     * @throws Exception
     */
    public function getCustomPizza()
    {
        $stmt = MyPDO::getInstance()->prepare(<<<SQL
        select *
        from pizza
        where nClient = ?
SQL
    );
        $stmt->execute([$this->nClient]);
        $stmt->setFetchMode(PDO::FETCH_CLASS,Pizza::class);
        return $stmt->fetchAll();
    }
    
    /**
     * Accesseur à l'attribut rentré en paramètre
     * @param l'atribut à acceder (string) 
     * @return l'attribut du client (string)
     */
    public function getAttr(string $nom)
    {
        return $this->$nom;
    }
    
    /**
     * Méthode qui permet d'ajouter un client à la base de données
     * @param le tableau des attributs du client à ajouter (client)
     */
    public static function addCli(array $values)
    {
        $num = MyPDO::getInstance()->prepare(<<<SQL
        select max(nClient) as n
        from client
SQL
);
        $num->execute();
        $num = $num->fetch();
        $num = intval($num['n']) +1;
        $stmt = MyPDO::getInstance()->prepare(<<<SQL
            insert into client
            values ($num,?,?,?,?,?,?,?)
SQL
);
        $stmt->execute($values);
    }
    
    /**
     * Méthode qui permet de supprimer un client de la base de donnée 
     * @param le numéro du client à supprimer (int)
     */
    public static function delCli(int $nClient)
    {
        $stmt = MyPDO::getInstance()->prepare(<<<SQL
        delete from client
        where nClient = ?
SQL
    );
        $stmt->execute([$nClient]);
    }

    /**
     * /!\ $modif de format [colonneA, modifA, colonneB, modifB ...] /!\
     *
     * Méthode qui permet de modifier un client de la base de données 
     * @param l'id du client (int)
     */
    public static function updateCli(int $id, array $modif)
    {
        $req = 'update client set';
        for ($i = 0; $i < count($modif); $i += 2)
        {
            $req .=" {$modif[$i]} = '{$modif[$i+1]}' ";
            if ($i != count($modif)-2) {
                $req.= ',';
            }
        }
        $req.= "where nClient = $id";
        $stmt = MyPDO::getInstance()->prepare($req);
        $stmt->execute();
    }

    /**
     * Get numéro de client
     *
     * @return  int
     */ 
    public function getNClient()
    {
        return $this->nClient;
    }

    /**
     * Get pseudo du client
     *
     * @return  string
     */ 
    public function getPseudoCli()
    {
        return $this->pseudoCli;
    }

    /**
     * Get mot de passe du client
     *
     * @return  string
     */ 
    public function getMdpCli()
    {
        return $this->mdpCli;
    }

    public static function findPseudo(string $pseudo){
        $req = MyPDO::getInstance()->prepare('SELECT * FROM client WHERE pseudoCli = ?');
        $req->execute([$pseudo]);
        $req->setFetchMode(PDO::FETCH_CLASS,'Client');
        return $req->fetch();
    }

    /**
     * Get nom du client
     *
     * @return  string
     */ 
    public function getNomCli()
    {
        return $this->nomCli;
    }

    /**
     * Get prenom du client
     *
     * @return  string
     */ 
    public function getPnomCli()
    {
        return $this->pnomCli;
    }

    /**
     * Get code postal
     *
     * @return  int
     */ 
    public function getCp()
    {
        return $this->cp;
    }

    /**
     * Get ville
     *
     * @return  string
     */ 
    public function getVille()
    {
        return $this->ville;
    }
}
