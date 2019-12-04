<?php
/**
 * Created by PhpStorm.
 * User: alla0023
 * Date: 18/06/2019
 * Time: 08:33
 */

class Table
{

    /**
     * @var array tableau des entete d'un tableau
     */
    private $entetes;
    /**
     * @var null
     */
    private $table = null;

    /**
     * Table constructor.
     * @param array $entetes
     */
    public function __construct(array $entetes)
    {
        $this->entetes = $entetes;
    }

    /**
     * Methode qui permet de creer une table
     * @return string
     */
    public function createTable():string{

        $this->table = <<<HTML
            <table class="table table-striped">
                <thead>
                    <tr>
HTML;

        foreach ($this->entetes as $entete) {
            $this->table .= <<<HTML
        
                      <th scope="col">{$entete}</th>
HTML;
        }
            $this->table .= '</tr></thead><tbody>';

        return $this->table;
    }

    /**
     * Methode qui permet d'ajouter des lignes dans une table suivant le nombre des valeurs de tableau entré en paramètre
     * @param array $values
     * @param null $modalPrefix
     */
    public function addLine(array $values, $modalPrefix = null){
        $this->table .= "<tr><th scope='row'>{$values[0]}</th>";
        for($i=1;$i<count($this->entetes)-1;$i++) {
            $this->table .= <<<HTML
            
              
              <td>$values[$i]</td>


HTML;
        }
            $modalId = $modalPrefix . '' . $values[0];
            $this->table .= <<<HTML
              <td>
                <a href="edit.php?entity=$modalPrefix&id={$values[0]}"><button class="btn btn-primary">Éditer</button></a>
                <button class="btn btn-danger" data-toggle="modal" data-target="#{$modalId}">Supprimer</button>
              </td>
            </tr>
HTML;


    }

    public function addLinePanier(array $values, $modalPrefix = null){
        $this->table .= "<tr><th scope='row'>{$values[0]}</th>";
        for($i=1;$i<count($this->entetes)-1;$i++) {
            $this->table .= <<<HTML
            
              
              <td>$values[$i]</td>


HTML;
        }
        $modalId = $modalPrefix . '' . $values[0];
        $this->table .= <<<HTML
              <td>
                <button class="btn btn-danger" data-toggle="modal" data-target="#{$modalId}">Supprimer</button>
              </td>
            </tr>
HTML;
    }

    public function addLinePanierTotal(array $values){
        $this->table .= "<tr><th scope='row'>{$values[0]}</th>";
        for($i=1;$i<count($this->entetes)-1;$i++) {
            $this->table .= <<<HTML
            
              
              <td>$values[$i]</td>


HTML;
        }
        $this->table .= <<<HTML
              <td>
                <button class="btn btn-warning" data-toggle="modal">Commander</button>
              </td>
            </tr>
HTML;
    }

    /**
     * Methode qui permet de fermer une table
     */
    public function closeTable(){
        $this->table .= '</tbody></table>';
    }

    /**
     * Accesseur à la table
     * @return la table (string)
     */
    public function getTable(){
        if($this->table != null){
            return $this->table;
        }

    }

}