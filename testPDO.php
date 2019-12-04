
<?php

require_once 'class/MyPDO.class.php';
require_once 'autoload.php';
MyPDO::setConfiguration('mysql:host=mysql;dbname=infs2_prj15_bis;charset=utf8', 'infs2_prj15', 'Azerty01');


$instance = MyPDO::getInstance();

/*

foreach (Pizza::getAll() as $c){
    echo 'La ' . $c->getAttr('libPizza').' coûte '. $c->getAttr('prixPizza') . ' €<br>';

}

echo '<br>';

foreach (Personnel::getAll() as $p){
    echo  $p->getAttr('nomPers') . ' ' . $p->getAttr('pnomPers') . ' est ' . $p->getAttr('rolePers') . '<br>';
}

foreach (Client::getAll() as $cli) {
    var_dump($cli);
}

var_dump(Client::getFromId(1));

echo Client::getFromId(1)->getAttr('nomCli');

var_dump(Commande::getAll());

var_dump(Commande::getFromId(3));

var_dump(LigneCommande::getAll());

var_dump(LigneCommande::getPizzaFromCmde(1));
var_dump(Commande::getFromId(1)->getDetail());

var_dump(Livraison::getAll());

var_dump(Livraison::getFromId(1));

var_dump(Realisation::getAll());

var_dump(Realisation::getCmde(3));

var_dump(Realisation::getPers(3));

var_dump(Pizza::getAll());
echo("JNFEHieufhi");
var_dump(Pizza::createFromId(3)->getAttr('nPizza'));
var_dump(Constitution::getAll());
var_dump(Pizza::createFromId(3)->getIng());

var_dump(Ingredients::getAll());
var_dump(Ingredients::getFromId(2));

var_dump(Ingredients::getFromId(9)->getPizza());

var_dump(Pizza::getCliPizza());

var_dump(Client::getFromId(1)->getCustomPizza());

/
/
/
/
Client::updateCli(4,['pnomCli','rrr','cp','zzo','ville','pas ailleurs']);

Commande::updateCmde(3,['prixCmde','50']);

//Ingredients::delIng(10);

//Livraison::addLivraison(['1','1','06/09/2014','en cours']);

//Livraison::updateLivraison(4,['nPers','2']);

//Livraison::delLivraison(4);

//Personnel::addPers(['jean-mi','jean-bon','jean-raoul','321','directeur','actif']);

//Personnel::updatePers(4,['nomPers','jean-jean']);

Personnel::delPers(4);

*/

var_dump(LigneCommande::getpers(1,1));
