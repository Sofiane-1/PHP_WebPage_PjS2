<?php

/**
 * Class Scooter
 */
class Scooter
{
    /**
     * @var int numero de scooter
     */
    private $nScooter;
    /**
     * @var string numero d'immatriculation
     */
    private $immatriculation;

    /**
     * Méthode qui retourne tous les scooter sous forme de tableau
     * @return tableau de tous les sccoters (array)
     * @throws Exception
     */
    public static function getAll()
    {
        $stmt = MyPDO::getInstance()->prepare(<<<SQL
        select *
        from scooter
SQL
    );
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_CLASS,Scooter::class);
        return $stmt->fetchAll();
    }

    /**
     * Methode qui retourne le scooter qui a l'id passe en paramètre
     * @param int $id
     * @return un scooter (scooter)
     * @throws Exception
     */
    public static function getFromId(int $id)
    {
        $stmt = MyPDO::getInstance()->prepare(<<<SQL
        select *
        from scooter
        where nScooter = ?
SQL
    );
        $stmt->execute([$id]);
        $stmt->setFetchMode(PDO::FETCH_CLASS,Scooter::class);
        $scoot = $stmt->fetch();
        if (!$scoot)
            throw new Exception();
        return $scoot;
    }

    /**
     * Méthode qui retourne les livraisons d'un scooter
     * @return tableau des livraisons d'un scooter (array)
     * @throws Exception
     */
    public function getLiv()
    {
        $stmt = myPDO::getInstance()->prepare(<<<SQL
        select *
        from livraison
        where nScooter = ?
SQL
    );
        $stmt->execute($this->nScooter);
        $stmt->setFetchMode(PDO::FETCH_CLASS,Scooter::class);
        return $stmt->fetchAll();
    }

    /**
     * Methode qui permet d'ajouter un scooter à la base de données
     * @param array $values
     * @throws Exception
     */
    public static function addScooter(array $values)
    {
        $num = myPDO::getInstance()->prepare(<<<SQL
        select max(nScooter) as n
        from scooter
SQL
    );
        $num->execute();
        $num = $num->fetch();
        $num = intval($num['n']) +1;
        $stmt = myPDO::getInstance()->prepare(<<<SQL
            insert into scooter
            values ($num,?)
SQL
    );
        $stmt->execute($values);
    }

    /**
     * Méthode qui permet de supprimer un scooter de la base de données
     * @param int $nScooter
     * @throws Exception
     */
    public static function delPers(int $nScooter)
    {
        $stmt = myPDO::getInstance()->prepare(<<<SQL
        delete from scooter
        where nScooter = ?
SQL
    );
        $stmt->execute([$nScooter]);
    }

    /**
     * /!\ $modif de format [colonneA, modifA, colonneB, modifB ...] /!\
     *
     * Methode qui permet de modifier un scooter
     * @param int $id
     * @param array $modif
     */
    public static function updateScooter(int $id, array $modif)
    {
        $req = 'update scooter set';
        for ($i = 0; $i < count($modif); $i += 2)
        {
            $req .=" {$modif[$i]} = '{$modif[$i+1]}' ";
            if ($i != count($modif)-2) {
                $req.= ',';
            }
        }
        $req.= "where nScooter = $id";
        $stmt = myPDO::getInstance()->prepare($req);
        $stmt->execute();
    }
}