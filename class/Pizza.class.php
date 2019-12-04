<?php


/**
 * Class Pizza
 */
class Pizza {
    /**
     * @var int numero de la pizza
     */
    private $nPizza;
    /**
     * @var int numero du client
     */
    private $nClient;
    /**
     * @var string libele de la pizza
     */
    private $libPizza;
    /**
     * @var string description de la pizza
     */
    private $descPizza;
    /**
     * @var float prix de la pizza
     */
    private $prixPizza;
    /**
     * @var date date de la creation de la pizza
     */
    private $dateCreaPizza;

    /**
     * Accesseur au numéro de la pizza
     * @return le numero de la pizza (int)
     */
    public function getNPizza()
    {
        return $this->nPizza;
    }

    /**
     * Modificateur du numero de pizza
     * @param int $nPizza
     */
    public function setNPizza(int $nPizza): void
    {
        $this->nPizza = $nPizza;
    }

    /**
     * Accesseur au numero du client
     * @return le numero du client (int)
     */
    public function getNClient()
    {
        return $this->nClient;
    }

    /**
     * Modificateur du numero du client
     * @param int $nClient
     */
    public function setNClient(int $nClient): void
    {
        $this->nClient = $nClient;
    }

    /**
     * Accesseur au libele de la pizza
     * @return le libele de la pizza (string)
     */
    public function getLibPizza()
    {
        return $this->libPizza;
    }

    /**
     * Modificateur du libele de la pizza
     * @param string $libPizza
     */
    public function setLibPizza($libPizza): void
    {
        $this->libPizza = $libPizza;
    }

    /**
     * Accesseur à la description de la pizza
     * @return la description de la pizza (string)
     */
    public function getDescPizza()
    {
        return $this->descPizza;
    }

    /**
     * Modificateur de la descritption de la pizza
     * @param string $descPizza
     */
    public function setDescPizza($descPizza): void
    {
        $this->descPizza = $descPizza;
    }

    /**
     * Accesseur au prix de la pizza
     * @return le prix de la pizza (float)
     */
    public function getPrixPizza()
    {
        return $this->prixPizza;
    }

    /**
     * Modificateur du prix de la pizza
     * @param float $prixPizza
     */
    public function setPrixPizza($prixPizza): void
    {
        $this->prixPizza = $prixPizza;
    }

    /**
     * Accesseur à la date de creation de la pizza
     * @return la date de creation d'une pizza (date)
     */
    public function getDateCreaPizza()
    {
        return $this->dateCreaPizza;
    }

    /**
     * Modificateur à la date de creation de la pizza
     * @param date $dateCreaPizza
     */
    public function setDateCreaPizza($dateCreaPizza): void
    {
        $this->dateCreaPizza = $dateCreaPizza;
    }

    /**
     * Methode qui permet de retourner toutes les pizzas sous forme de tableau
     * @return tableau de toutes les pizzas de la base (array)
     * @throws Exception
     */
    public static function getAll():array{
        $req = MyPDO::getInstance()->prepare(<<<SQL
        SELECT nPizza, nClient,libPizza,descPizza, prixPizza 
        FROM pizza
SQL
        );
        $req->execute();
        $res = $req->fetchAll(PDO::FETCH_CLASS,Pizza::class);
        return $res;
    }

    /**
     * Méthode qui retourne la pizza qui a l'id entre en paramètre
     * @param int $id
     * @return la pizza qui a cette id (pizza)
     * @throws Exception
     */
    public static function createFromId(int $id){
        $req = MyPDO::getInstance()->prepare(<<<SQL
        SELECT nPizza, nClient,libPizza,descPizza, prixPizza 
        FROM pizza 
        where nPizza = ?
SQL
        );
        $req->execute([$id]);
        $req->setFetchMode(PDO::FETCH_CLASS,Pizza::class);
        $res = $req->fetch();
        if($res == false){
            throw new Exception("cliId - l'id est introuvable");
        }
        return $res;
    }

    /**
    * Get the value of img
    * @return la valeur de l'image
    */ 
   public function getImg()
   {
    $req = MyPDO::getInstance()->prepare(<<<SQL
    SELECT img
    FROM pizza 
    where nPizza = ?
SQL
    );
    $req->execute([$this->nPizza]);
    $res = $req->fetch();
    if($res == false){
        throw new Exception("NPizza - l'id est introuvable");
    }
    return $res;
   }




    /**
     * Methode qui retourne les pizza des client sous forme de tableau
     * @return le tableau des pizzas des client (array)
     * @throws Exception
     */
    public static function getCliPizza()
    {
        $stmt = MyPDO::getInstance()->prepare(<<<SQL
        select *
        from pizza
        where nClient is not null
SQL
    );
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_CLASS,Pizza::class);
        $res = $stmt->fetchAll();
        if($res == false){
            throw new Exception("cliId - l'id est introuvable");
        }
        return $res;
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
     * Accesseur aux ingredients d'une pizza
     * @return un tableau qui liste les ingrédient de la pizza (array)
     */
    public function getIng()
    {
        return Constitution::getIng($this->nPizza);
    }

    /**
     * Methode qui permet de modifié une pizza de la base de données
     * @param array $values
     * @throws Exception
     */
    public static function updatePizza(array $values){
        $req = MyPDO::getInstance()->prepare(<<<SQL
            UPDATE pizza 
            SET libPizza = ?, 
            descPizza = ?, 
            prixPizza = ?
            WHERE nPizza = ? 
SQL
            );
        $req->execute($values);

    }

    /**
     * Méthode qui permet de supprimer une pizza de la base de données
     * @param int $nPizza
     * @throws Exception
     */
    public static function delPizza(int $nPizza){
        $req = MyPDO::getInstance()->prepare(<<<SQL
        DELETE FROM pizza 
        WHERE nPizza = ?
SQL
    );
        $req->execute([$nPizza]);
    }

    /**
     * @param array $values
     * Méthode qui permet d'ajouter une Pizza dans la base de données
     * le tableau donné en paramètre contient ces valeurs dans l'ordre :
     * nPizza, libPizza, descPizza, prixPizza
     */
    public static function add(array $values){
        if(in_array($values[0],Pizza::getIds())){
            throw new Exception('add() - l\'id est déjà présent');
        }
        $req = MyPDO::getInstance()->prepare('Insert into pizza (nPizza,libPizza,descPizza,prixPizza) values (?,?,?,?)');
        $req->execute($values);
    }

    /**
     * Methode qui retourne tous les numero de pizza
     * @return le tableau des numero de pizza (array)
     * @throws Exception
     */
    public static function getIds():array{
        $req = MyPDO::getInstance()->prepare('SELECT nPizza from pizza');
        $req->execute();
        return $req->fetchAll();
    }


}