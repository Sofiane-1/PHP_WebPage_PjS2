<?php

/**
 * Class Form
 */
class Form {
    /**
     * @var string formulaire
     */
    private $form;
    /**
     * @var string méthode du formulaire
     */
    private $method;
    /**
     * @var string action du formulaire
     */
    private $action;

    /**
     * Form constructor.
     * @param string $method
     * @param string|null $action
     */
    public function __construct(string $method, string $action = null)
    {
        $this->method = $method;
        $this->action = $action;
    }

    /**
     * Méthode qui permet de creer un formulaire
     */
    public function createForm(){
        $this->form = <<<HTML
            <form class="mt-4" method="{$this->method}" action="{$this->action}">



HTML;

    }

    /**
     * Méthode qui permet de fermer un formulaire
     */
    public function closeForm(){
        $this->form .= '</form>';
    }

    /**
     * Méthode qui permet de générer un input dans un formulaire
     * @param $labelName
     * @param $name
     * @param $type
     * @param $id
     * @param $placeholder
     * @param null $value
     */
    public function input($labelName, $name, $type, $id, $placeholder, $value = null, $pattern = null){
        if ($pattern != null) {
            $this->form .= <<<HTML
        
        <div class="form-group">
                <label for="$id">$labelName</label>
                <input required name="$name" type="$type" class="form-control" id="$id" placeholder="$placeholder" value="$value" pattern="$pattern">
        </div>
HTML;
        }
        else {
            $this->form .= <<<HTML
        
            <div class="form-group">
                    <label for="$id">$labelName</label>
                    <input required name="$name" type="$type" class="form-control" id="$id" placeholder="$placeholder" value="$value">
            </div>
HTML;
        }
    }

    /**
     * Méthode qui permet de generer un textarea dans un formulaire
     * @param $labelName
     * @param $name
     * @param $id
     * @param $placeholder
     * @param null $value
     */
    public function textArea($labelName, $name, $id, $placeholder, $value = null){
        $this->form .= <<<HTML
              <label for="$id">$labelName</label>
              <div class="form-custom">
                <textarea required name ="$name" class="form-control" id="$id" rows="3" placeholder="$placeholder">$value</textarea>
              </div>

HTML;

    }

    public function appendRow(){
        $this->form .= '<div class="row">';
    }

    public function closeDiv(){
        $this->form .= '</div>';
    }

    public function appendCol(string $nb){
        $this->form .= "<div class='col-sm-$nb'>";
    }
    public function checkBox($id,$labelName,$nameCheckBox,$nameInput,$value,$placeholder,$option = null){

        $this->form .= <<<HTML
            <div class="form-custom">
                <label for="$id">$labelName</label>
                <div class="input-group mb-3 w-25">
                    <div class="input-group-prepend">
                        <div class="input-group-text">
                           <input class="" $option type="checkbox" name="$nameCheckBox" aria-label="Ingrédients">
                        </div>
                    </div>
                      <input type="text" name="$nameInput" class="w-25 form-control" aria-label="Text input with checkbox" value="$value" placeholder="$placeholder">
                </div>
            </div>

HTML;


    }

    /**
     * Méthode qui permet de generer un bouton dans un formulaire
     * @param $title
     * @param $color
     */
    public function button($title, $color=null){
        $this->form .= <<<HTML
        <div class="form-custom">
            <button class="btn btn-warning mt-5" name="btn-submit" type="submit">$title</button>
        </div>
HTML;

    }


    /**
     * Accesseur au formulaire
     * @return le formulaire
     */
    public function getForm(){
        return $this->form;
    }
}