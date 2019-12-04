<?php
/**
 * Created by PhpStorm.
 * User: alla0023
 * Date: 17/06/2019
 * Time: 10:09
 */
session_start();
require_once 'autoload.php';
require_once '../class/FlashMessages.class.php';
include 'include/verification.php';
$p = new WebPage('Édition');
$p->appendToHead("<link href=\"https://fonts.googleapis.com/css?family=Montserrat:400,500,600,700&display=swap\" rel=\"stylesheet\"> ");
$p->appendCssUrl('../ressource/css/form.css');
//$p->appendBootstrap();
if(isset($_GET['id']) && !empty($_GET['id']) && is_numeric($_GET['id'])){
    try{
        $id = $_GET['id'];
        if(isset($_GET['entity']) && $_GET['entity'] === "pizza"){


            $pizza = Pizza::createFromId($id);
            $p->appendContent("<h1 class='text-center'>Édition Pizza {$pizza->getLibPizza()}</h1>");
            $form = new Form("post");
            $form->createForm();
            $form->input("Libellé","name","text","name","","{$pizza->getLibPizza()}");
            $form->textArea("Description","description","description","description","{$pizza->getDescPizza()}");
            $form->input("Prix","price","text","price","","{$pizza->getPrixPizza()}");
            //Ingrédients
            $ingredients = Ingredients::getAll();
            $form->appendRow();
            $form->appendCol("3");
            $nb = 0;
            $ingPizzas = Constitution::getConstitution($pizza->getNPizza());
            $ings = Constitution::getIng($pizza->getNPizza());
            $ingsId = array();
            $ingsQte = array();
            foreach($ingPizzas as $ing){
                $ingsId[] = $ing->getNIng();
                $ingsQte[$ing->getNIng()] = $ing->getQte();
            }

            //Ajout des checkBox pour les ingrédients
            foreach($ingredients as $ingredient){
                if($nb>5){
                    $nb = 0;
                    $form->closeDiv();
                    $form->appendCol("3");
                }

                if(in_array($ingredient->getNIng(),$ingsId)){
                    $options = "checked";
                    $value = $ingsQte[$ingredient->getNIng()];

                } else {
                    $options = null;
                    $value = null;
                }
                $form->checkBox("{$ingredient->getNIng()}","{$ingredient->getLibIng()}","{$ingredient->getNIng()}check","{$ingredient->getNIng()}text", $value,"Qte",$options);
                $nb += 1;
            }
                $form->closeDiv();
            $form->button("Modifier","warning");
            $form->closeForm();
            $p->appendContent($form->getForm());


        }
        elseif(isset($_GET['entity']) && $_GET['entity'] === "ingredient"){
            $ing = Ingredients::getFromId($id);
            $p->appendContent("<h1 class='text-center'>Édition Ingrédient {$ing->getLibIng()}</h1>");
            $p->appendContent(<<<HTML
                <form class="form-center mt-4" method="post">
                <label for="name">Libellé</label>
                  <div class="form-group">
                    
                    <input required name="name" type="text" class="input-custom" id="name" value="{$ing->getLibIng()}">
                  </div>
                  <label for="description">Stock</label>
                  <div class="form-group">
                    
                    <input required name ="stock" class="input-custom" id="stock" rows="3" value="{$ing->getStockIng()}"></input>
                  </div>
                  <label for="price">Prix</label>
                  <div class="form-group">
                    
                    <input required name="price" type="texte" class="input-custom" id="price" value="{$ing->getPrixIng()}">
                  </div>
                  <div class="form-group">
                    <input class="btn-custom" name="btn-submit" value="Éditer" type="submit"></input>
                  </div>
                </form>


HTML
            ) ;
        }
    } catch (Exception $e){
        header("HTTP/1.0 404 Not Found");
        $p->appendContent('Erreur 404, l\'id est introuvable');
    }




} else {
    header("HTTP/1.0 404 Not Found");
    $p->appendContent('Erreur 404, Page introuvable');
}

//Vérification Formulaire
if(isset($_POST['btn-submit'])){
    if(is_numeric($_POST['price'])){
        if(isset($_GET['entity']) && $_GET['entity'] === "pizza"){
            //Modification des valeurs dans la base de données
            $pizza = Pizza::createFromId($_GET['id']);
            $pizza->updatePizza([$_POST['name'],$_POST['description'],$_POST['price'],$pizza->getNPizza()]);
            foreach($ingredients as $ingredient){
                if(isset($_POST["{$ingredient->getNIng()}check"]) && isset($_POST["{$ingredient->getNIng()}text"]) && !in_array($ingredient->getNIng(),$ingsId)){

                    Constitution::addConstitution((int) $pizza->getNPizza(),(int) $ingredient->getNIng(),(float) $_POST["{$ingredient->getNIng()}text"]);
                }

                elseif(isset($_POST["{$ingredient->getNIng()}check"]) && isset($_POST["{$ingredient->getNIng()}text"])){
                    Constitution::updateConstitution((int) $pizza->getNPizza(),(int) $ingredient->getNIng(),$_POST["{$ingredient->getNIng()}text"]);
                }

                elseif(empty($_POST["{$ingredient->getNIng()}check"]) && in_array($ingredient->getNIng(),$ingsId)){
                    Constitution::delConstitution($pizza->getNPizza(),$ingredient->getNIng());
                }
            }
        }

        elseif (isset($_GET['entity']) && $_GET['entity'] === "ingredient"){
            if (is_numeric($_POST['stock'])){
                Ingredients::updateIng($_GET['id'],['libIng',$_POST['name'],'stockIng',$_POST['stock'],'prixIng',$_POST['price']]);
            }
        }



        FlashMessages::fsuccess("Modification Effectuée");
        header('Location: index.php');
    } else {
        $p->appendContent(Alert::alert('Modification échouée','danger'));
    }
}

echo $p->toHTML();