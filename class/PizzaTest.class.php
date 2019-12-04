<?php

require_once 'MyPDO.class.php';

/**
 * Class Pizza
 */
class Pizza {
    /**
     * @var
     */
    public $nPizza;
    /**
     * @var
     */
    public $nClient;
    /**
     * @var
     */
    public $libPizza;
    /**
     * @var
     */
    public $descPizza;
    /**
     * @var
     */
    public $prixPizza;
    /**
     * @var
     */
    public $dateCreaPizza;

    /**
     * @return array
     * @throws Exception
     */
    public static function all():array{
        $req = myPDO::getInstance()->prepare('SELECT * FROM pizza');
        $req->execute();
        $res = $req->fetchAll(PDO::FETCH_CLASS,'Pizza');
        return $res;
    }

    /**
     * @param int $id
     * @throws Exception si id introuvable
     */
    public static function createFromId(int $id){
        $req = MyPDO::getInstance()->prepare('SELECT * FROM pizza where nPizza = ?');
        $req->execute([$id]);
        $req->setFetchMode(PDO::FETCH_CLASS,'Pizza');
        $res = $req->fetch();
        if($res == false){
            throw new Exception("createFromId - l'id est introuvable");
        }

        return $res;
    }

    /**
     * @param array $values
     * @throws Exception
     */
    public function update(array $values){
        $req = MyPDO::getInstance()->prepare('
            UPDATE pizza SET libPizza = ?, descPizza = ?, prixPizza = ?
            WHERE nPizza = ? ');
        $req->execute($values);

    }

    /**
     * @param int $id
     * @throws Exception
     */
    public function delete(int $id){
        $req = MyPDO::getInstance()->prepare('DELETE FROM pizza WHERE nPizza = ?');
        $req->execute([$this->nPizza]);
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
     * @return array
     * @throws Exception
     */
    public static function getIds():array{
        $req = MyPDO::getInstance()->prepare('SELECT nPizza from pizza');
        $req->execute();
        return $req->fetchAll();
    }


}