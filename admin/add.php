<?php
session_start();
require_once 'autoload.php';
include 'include/verification.php';
$p = new WebPage('Édition');
$p->appendBootstrap();
$p->appendToHead("<link href=\"https://fonts.googleapis.com/css?family=Montserrat:400,500,600,700&display=swap\" rel=\"stylesheet\"> ");
$p->appendCssUrl('../ressource/css/form.css');
    if(isset($_GET['entity']) && $_GET['entity'] === 'pizza') {


        $p->appendContent("<div class='container'></div><h1 class='text-center'>Création Pizza</h1>");
        //Valeurs pour les inputs
        $postId = $_POST['id'] ?? null;
        $textArea = $_POST['description'] ?? null;
        $postName = $_POST['name'] ?? null;
        $postPrice = $_POST['price'] ?? null;

        //Création du Formulaire
        $form = new Form("post");
        $form->createForm();
        $form->input("Id","id","text","id","Id",$postId);
        $form->input("Libellé","name","text","name","Libellé",$postName);
        $form->textArea("Description","description","description","Description...",$textArea);
        $form->input("Prix","price","text","price","Prix",$postPrice);


        //Ingrédients
        $ingredients = Ingredients::getAll();
        $form->appendRow();
        $form->appendCol("3");
        $nb = 0;
        //Ajout des checkBox pour les ingreédients
        foreach($ingredients as $ingredient){
            if($nb>5){
                $nb = 0;
                $form->closeDiv();
                $form->appendCol("3");
            }
            $postLib = $_POST["{$ingredient->getNIng()}text"] ?? null;
            $form->checkBox("{$ingredient->getNIng()}","{$ingredient->getLibIng()}","{$ingredient->getNIng()}check","{$ingredient->getNIng()}text", $postLib,"Qte");
            $nb += 1;
        }
        $form->closeDiv();
        $form->button("Ajouter","primary");
        $p->appendContent($form->getForm());



    }

    elseif (isset($_GET['entity']) && $_GET['entity'] === "ingredient"){


        $p->appendContent("<h1 class='text-center'>Ajout d'Ingrédients</h1>");
        //Valeurs pour les inputs
        $postId = $_POST['id'] ?? null;
        $postStock = $_POST['stock'] ?? null;
        $postName = $_POST['name'] ?? null;
        $postPrice = $_POST['price'] ?? null;

        //Création du Formulaire
        $form = new Form("post");
        $form->createForm();
        $form->input("Libellé","name","text","name","Libellé",$postName);
        $form->input("Stock","stock","number","Stock",$postStock);
        $form->input("Prix","price","text","price","Prix",$postPrice);

        //Création des checksBox pour les ingrédients

        $form->button("Ajouter","primary");
        $p->appendContent($form->getForm());
        $p->appendContent('</div>');



    }

//Vérification Formulaire
if (isset($_POST['btn-submit'])) {
    if (is_numeric($_POST['price'])) {
        //Ajout des valeurs dans la base de données
        if($_GET['entity'] == 'pizza'){
            try {
                Pizza::add([$_POST['id'], $_POST['name'], $_POST['description'], $_POST['price']]);
            }catch (Exception $e) {
                    $p->appendContent("<div class='alert alert-danger'>Erreur, La Pizza ayant l'id {$_POST['id']} existe déjà</div>");
                }
                try {
                foreach($ingredients as $ingredient){
                    if(isset($_POST["{$ingredient->getNIng()}check"]) && isset($_POST["{$ingredient->getNIng()}text"])){
                        Constitution::addConstitution((int) $_POST['id'],(int) $ingredient->getNIng(),$_POST["{$ingredient->getNIng()}text"]);
                    }
                }
                FlashMessages::fsuccess("La pizza a bien été ajoutée");
                header('Location: index.php');
            } catch (Exception $e) {
                $p->appendContent("<div class='alert alert-danger'>Erreur, impossible d'insérer cet ingreédient</div>");
            }
        }

        else {
            try {
                Ingredients::addIng([$_POST['name'],$_POST['stock'],$_POST['price']]);
                FlashMessages::fsuccess("L'ingrédient a bien été ajoutée");
                header('Location: index.php');
            } catch (Exception $e) {
                $p->appendContent("<div class='alert alert-danger'>Erreur, L'ingrédient ayant cet id existe déjà</div>");
            }
        }


    } else {

        $p->appendContent(Alert::alert('Echec de l\'ajout','danger'));
    }
}
    echo $p->toHTML();

