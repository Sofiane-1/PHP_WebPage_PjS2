<?php

/**
 * Class Realisation
 */
class Realisation
{
    /**
     * @var int numero de la commande
     */
    private $nCmde;
    /**
     * @var int numero du personnel
     */
    private $nPers;

    /**
     * Méthode qui retourne toutes les réalisation de commandes sous forme de tableau
     * @return le tableau de toutes les realisation (array)
     * @throws Exception
     */
    public static function getALl()
    {
        $stmt = myPDO::getInstance()->prepare(<<<SQL
            select *
            from realisation
SQL
    );
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_CLASS,Realisation::class);
        return $stmt->fetchAll();
    }

    /**
     * Methode qui permet de voir la personne qui ont realisée la commande passé en paramètre
     * @param int $id
     * @return le personnel qui a réalisé la commande (personnel)
     * @throws Exception
     */
    public static function getPers(int $id)
    {
        $stmt = myPDO::getInstance()->prepare(<<<SQL
            select *
            from personnel
            where nPers = (select nPers
                            from realisation
                            where nCmde = ?)
SQL
    );
        $stmt->execute([$id]);
        $stmt->setFetchMode(PDO::FETCH_CLASS,Personnel::class);
        $real = $stmt->fetch();
        if (!$real)
            throw new Exception('c pa bon mdr');
        return $real;
    }

    /**
     * Méthode qui permet de voir les commandes realisé par une personne entré en paramètre
     * @param int $pers
     * @return tableau des commande réalisé par la personne (array)
     * @throws Exception
     */
    public function getCmde(int $pers)
    {
        $stmt = myPDO::getInstance()->prepare(<<<SQL
            select *
            from commande
            where nCmde in (select nCmde
                            from realisation
                            where nPers = ?)
SQL
    );
        $stmt->execute([$pers]);
        $stmt->setFetchMode(PDO::FETCH_CLASS,Commande::class);
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
     * Méthode qui permet d'ajouter une réalisation
     * @param int $nCmde
     * @param int $nPers
     * @throws Exception
     */
    public static function addRealisation(int $nCmde, int $nPers)
    {
        $stmt = myPDO::getInstance()->prepare(<<<SQL
            insert into realisation
            values (?,?)
SQL
    );
        $stmt->execute($nCmde,$nPers);
    }

    /**
     * Méthode qui permet de supprimer une realisation
     * @param int $nCmde
     * @param int $nPers
     * @throws Exception
     */
    public static function delRealisation(int $nCmde, int $nPers)
    {
        if (!is_null($nCmde)) {
            $stmt = myPDO::getInstance()->prepare(<<<SQL
            delete from realisation
            where nCmde = ?
SQL
        );
            $stmt->execute([$nCmde]);
        } else if (!is_null($nPers)) {
            $stmt = myPDO::getInstance()->prepare(<<<SQL
            delete from realisation
            where nPers = ?
SQL
        );
            $stmt->execute([$nPers]);
        } else {
            $stmt = myPDO::getInstance()->prepare(<<<SQL
            delete from realisation
            where nPers = ?
            and nCmde = ?
SQL
        );
            $stmt->execute([$nPers,$nCmde]);
        }
    }
}