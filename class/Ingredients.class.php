<?php


/**
 * Class Ingredients
 */
class Ingredients
{
    /**
     * @var int numero d'ingredient
     */
    private $nIng;

    /**
     * @var string libele de l'ingredient
     */
    private $libIng;
    /**
     * @var int stock de l'ingredient
     */
    private $stockIng;
    /**
     * @var float prix de l'ingredient
     */
    private $prixIng;

    /**
     * Accesseur au numéro de l'ingredient
     * @return le numero d'ingredient (int)
     */
    public function getNIng()
    {
        return $this->nIng;
    }

    /**
     * Accessur au libele de l'ingredient
     * @return le libele de l'ingredient (string)
     */
    public function getLibIng()
    {
        return $this->libIng;
    }

    /**
     * Accesseur du stock de l'ingredient
     * @return le stock de l'ingredient (int)
     */
    public function getStockIng()
    {
        return $this->stockIng;
    }

    /**
     * Accesseur au prix de l'ingredient
     * @return le prix de l'ingredient (float)
     */
    public function getPrixIng()
    {
        return $this->prixIng;
    }


    /**
     * Méthode qui retourne tous les ingredients et leurs attribut sous forme d'un tableau
     * @return le tableau des ingredients (array)
     * @throws Exception
     */
    public static function getAll()
    {
        $stmt = myPDO::getInstance()->prepare(
            <<<SQL
        select *
        from ingredients
SQL
    );
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_CLASS, Ingredients::class);
        return $stmt->fetchAll();
    }

    /**
     * Méthode qui retourne un ingredient qui a l'id en paramètre
     * @param int $id
     * @return un ingredient qui possède cette id (ingredient)
     * @throws Exception
     */
    public static function getFromId(int $id)
    {
        $stmt = myPDO::getInstance()->prepare(
            <<<SQL
        select *
        from ingredients
        where nIng = ?
SQL
    );
        $stmt->execute([$id]);
        $stmt->setFetchMode(PDO::FETCH_CLASS, Ingredients::class);
        $ing = $stmt->fetch();
        if (!$ing) {
            throw new Exception();
        }
        return $ing;
    }

    /**
     * Accesseur a la constitution des pizzas qui ont l'ingredient rentre en paramètre
     * @return la constitution des pizzas (array)
     */
    public function getPizza()
    {
        return Constitution::getPizza($this->nIng);
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
     * Méthode qui permet d'ajouter un ingredient à la base de données
     * @param array $values
     * @throws Exception
     */
    public static function addIng(array $values)
    {
        $num = myPDO::getInstance()->prepare(
            <<<SQL
        select max(nIng) as n
        from ingredients
SQL
    );
        $num->execute();
        $num = $num->fetch();
        $num = intval($num['n']) +1;
        $stmt = myPDO::getInstance()->prepare(
            <<<SQL
            insert into ingredients
            values ($num,?,?,?)
SQL
    );
        $stmt->execute($values);
    }

    /**
     * Méthode qui permet de supprimer un ingrédient de la base de données
     * @param int $nIng
     * @throws Exception
     */
    public static function delIng(int $nIng)
    {
        $stmt = myPDO::getInstance()->prepare(
            <<<SQL
        delete from ingredients
        where nIng = ?
SQL
    );
        $stmt->execute([$nIng]);
    }

    /**
     * /!\ $modif de format [colonneA, modifA, colonneB, modifB ...] /!\
     *
     * Méthode qui permet de modifier un ingredient de la base de données
     * @param array $modif
     * @param int $id
     */
    public static function updateIng(int $id, array $modif)
    {
        $req = 'update ingredients set';
        for ($i = 0; $i < count($modif); $i += 2) {
            $req .=" {$modif[$i]} = '{$modif[$i+1]}' ";
            if ($i != count($modif)-2) {
                $req.= ',';
            }
        }
        $req.= "where nIng = $id";
        $stmt = myPDO::getInstance()->prepare($req);
        $stmt->execute();
    }
}