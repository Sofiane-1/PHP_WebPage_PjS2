<?php

require_once 'Ingredients.class.php';

class Constitution {
    private $nPizza; /* @param le numero de la pizza (int) */
    private $nIng;

    /**
     * @return mixed
     */
    public function getNIng()
    {
        return $this->nIng;
    } /* @param le numero de l'ingrédient (int) */
    private $qte;

    /**
     * @return mixed
     */
    public function getQte()
    {
        return $this->qte;
    } /* @param la quantite (int) */

    /*
    public static function getComposition(int $id){
        $req = MyPDO::getInstance()->prepare(<<<SQL
        SELECT * 
        from constitution
        WHERE nPizza = ?
SQL
        );
        $req->execute([$id]);
        return $req->fetchAll(PDO::FETCH_CLASS,Constitution::class);
    }*/

    /**
     * Méthode qui retourne tous les attributs de la table constitution sous forme d'un tableau.
     * @return le tableau des attribut de la table constitution (array)
     *
     */
    public static function getAll()
    {
        $stmt = MyPDO::getInstance()->prepare(<<<SQL
        select *
        from constitution
SQL
    );
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_CLASS,Constitution::class);
        return $stmt->fetchAll();
    }

    /**
     * Accesseur au nombre d'ingrédient d'une pizza passé en paramètre
     * @param le numéro de la pizza à rechercher (int)
     * @return un tableau qui liste les ingrédient de la pizza (array) 
     *
     */
    public static function getIng(int $nPizza)
    {
        $stmt = MyPDO::getInstance()->prepare(<<<SQL
        select distinct *
        from ingredients
        where nIng in (select nIng
                        from constitution
                        where nPizza = ?)
SQL
        );
        $stmt->execute([$nPizza]);
        $stmt->setFetchMode(PDO::FETCH_CLASS,Ingredients::class);
        return $stmt->fetchAll();
    }

    /**
     * Accesseur au nombre de pizza qui possède l'ingrédient passé en paramètre
     * @param le numéro d'ingredient à rechercher (int)
     * @return un tableau qui liste les pizza qui possède l'ingrédient passé en paramètre (array) 
     *
     */
    public static function getPizza(int $nIng)
    {
        $stmt = MyPDO::getInstance()->prepare(<<<SQL
        select *
        from pizza
        where nPizza in (select nPizza
                        from constitution
                        where nIng = ?)
SQL
        );
        $stmt->execute([$nIng]);
        $stmt->setFetchMode(PDO::FETCH_CLASS,Pizza::class);
        return $stmt->fetchAll();
    }

    /**
     * Accesseur à l'attribut rentré en paramètre
     * @param l'atribut à acceder (string) 
     * @return l'attribut de constitution (string)
     */
    public function getAttr(string $nom)
    {
        return $this->$nom;
    }
    
    /**
     * Méthode qui permet d'ajouter une constitution à la base de données
     * @param le tableau des attributs de constitution à ajouter (constitution)
     */    
    public static function addConstitution(int $nPizza, int $nIng,float $qte)
    {
        $stmt = myPDO::getInstance()->prepare(<<<SQL
            insert into constitution
            values (?,?,?)
SQL
    );
        $stmt->execute([$nPizza,$nIng,$qte]);
    }

    /**
     * Méthode qui permet de supprimer une Constitution de la base de donnée 
     * @param le numéro de pizza et d'ingrédient de la constitution à supprimer (int)
     */
    public static function delConstitution(int $nPizza = null, int $nIng = null)
    {

            $stmt = myPDO::getInstance()->prepare(<<<SQL
            delete from constitution
            where nPizza = ?
            and nIng = ?
SQL
        );
            $stmt->execute([$nPizza,$nIng]);

    }

    /**
     * /!\ $modif de format [colonneA, modifA, colonneB, modifB ...] /!\
     *
     * Méthode qui permet de modifier une constitution de la base de données 
     * @param l'id du constitution (int)
     */
    public static function updateConstitution(int $nPizza,int $nIng, int $qte)
    {
        $stmt = myPDO::getInstance()->prepare(<<<SQL
        update constitution
        set qte = ?
        where nPizza = ?
        and nIng = ?
SQL
    );
        $stmt->execute([$qte,$nPizza,$nIng]);
    }

    /**
     * Get the value of nPizza
     */ 
    public function getNPizza()
    {
        return $this->nPizza;
    }

    public static function getConstitution(int $nPizza){
        $req = MyPDO::getInstance()->prepare("SELECT * FROM constitution WHERE nPizza = ?");
        $req->execute([$nPizza]);
        $req->setFetchMode(PDO::FETCH_CLASS,'Constitution');
        return $req->fetchAll();
    }

    
}
