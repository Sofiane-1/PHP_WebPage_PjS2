<?php

/**
 * Class Livraison
 */
class Livraison
{
    /**
     * @var int numero de livraison
     */
    private $nLivraison;
    /**
     * @var int numero de personnel
     */
    private $nPers;
    /**
     * @var int numero du scooter
     */
    private $nScooter;
    /**
     * @var string état de la livraison
     */
    private $etatLiv;
    /**
     * @var date date de livraison
     */
    private $dateLiv;

    /**
     * Méthode qui permet de retourner toutes les livraisons
     * @return array
     * @throws Exception
     */
    public static function getAll()
    {
        $stmt = myPDO::getInstance()->prepare(<<<SQL
        select *
        from livraison
SQL
        );
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_CLASS,Livraison::class);
        return $stmt->fetchAll();
    }

    /**
     * Méthode qui permet de trouver une livraison suivant son id
     * @param int $id
     * @return la livraison de l'id (livraison)
     * @throws Exception
     */
    public static function getFromId(int $id)
    {
        $stmt = myPDO::getInstance()->prepare(<<<SQL
        select *
        from livraison
        where nLivraison = ?
SQL
        );
        $stmt->execute([$id]);
        $stmt->setFetchMode(PDO::FETCH_CLASS,Livraison::class);
        $liv = $stmt->fetch();
        if (!$liv)
            throw new Exception ("sa marche po lol");
        return $liv;
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
     * Méthode qui permet d'ajouter une livraison
     * @param array $values
     * @throws Exception
     */
    public static function addLivraison(array $values)
    {
        $num = myPDO::getInstance()->prepare(<<<SQL
        select max(nLivraison) as n
        from livraison
SQL
    );
        $num->execute();
        $num = $num->fetch();
        $num = intval($num['n']) +1;
        $stmt = myPDO::getInstance()->prepare(<<<SQL
            insert into livraison
            values ($num,?,?,STR_TO_DATE(?,'%d/%m/%Y'),?)
SQL
    );
        $stmt->execute($values);
    }

    /**
     * Méthode qui permet de supprimer des livraisons
     * @param int $nLivraison
     * @throws Exception
     */
    public static function delLivraison(int $nLivraison)
    {
        $stmt = myPDO::getInstance()->prepare(<<<SQL
        delete from livraison
        where nLivraison = ?
SQL
    );
        $stmt->execute([$nLivraison]);
    }

    /**
     * /!\ $modif de format [colonneA, modifA, colonneB, modifB ...] /!\
     *
     * Méthode qui permet de modifier une livraisons
     * @param int $id de la livraison à modifier
     * @param array $modif le tableau des nouvelles valeur qu'il faut remplacer
     */
    public static function updateLivraison(int $id, array $modif)
    {
        $req = 'update livraison set';
        for ($i = 0; $i < count($modif); $i += 2)
        {
            $req .=" {$modif[$i]} = '{$modif[$i+1]}' ";
            if ($i != count($modif)-2) {
                $req.= ',';
            }
        }
        $req.= "where nLivraison = $id";
        $stmt = myPDO::getInstance()->prepare($req);
        $stmt->execute();
    }
}