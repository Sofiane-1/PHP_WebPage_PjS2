<?php

class WebPage
{
    /**
     * @var $head la tête
     */
    private $head = '';
    /**
     * @var $title le titre de la page
     */
    private $title;
    /**
     * @var $body le corps
     */
    private $body = '';

    /**
     * Constructeur
     * @param String $title titre de la page
     */
    public function __construct(string $title = null)
    {
        $this->title = $title;
    }

    /**
     * Retourne le contenu de $this->body
     * @return String body
     */
    public function body(): string
    {
        return $this->body;
    }

    /**
     * Retourne le contenu de $this->head
     * @return String head
     */
    public function head():string
    {
        return $this->head;
    }

    /**
     * Donner la date et l'heure de la dernière modification du script principal
     * @return String
     */
    public function getLastModification():String
    {
        return strftime('%d,%b,%Y,%H,%M,%S', getlastmod());
    }

    /**
    * Protéger les caractères spéciaux pouvant dégrader la page
    * @param String $string la chaine à protéger
    */
    public static function escapeString(string $string)
    {
        return htmlentities($string, ENT_QUOTES | ENT_HTML5);
    }

    /**
     * Affecter le titre de la page
     * @param String $title le titre
     */
    public function setTitle(string $title):void
    {
        $this->title = $title;
    }

    /**
     * Ajouter un contenu dans head
     * @param String $content
     */
    public function appendToHead(string $content):void
    {
        $this->head .= $content;
    }

    /**
     * Ajouter un contenu CSS dans head
     * @param String $css contenu CSS à ajouter
     */
    public function appendCss(string $css):void
    {
        $this->appendToHead("<style>$css</style>\n");
    }

    /**
     * ajouter l'url d'un script CSS dans head
     * @param String $url url du script
     */
    public function appendCssUrl(string $url):void
    {
        $this->appendToHead("<link rel='stylesheet' href='{$url}'/>\n");
    }

    /**
     * Ajouter un contenu JavaScript dans head
     * @param String $js Le contenu JavaScript à ajouter
     */
    public function appendJs(string $js):void
    {
        $this->appendToHead("<script>$js</script>\n");
    }

    /**
     * Ajouter l'URL d'un script JavaScript dans head
     * @param String $url l'url du script JavaScript
     */
    public function appendJsUrl(string $url):void
    {
        $this->appendToHead("<script src='{$url}'");
    }

    /**
     * Ajouter un contenu dans le body
     * @param String $content le contenu à ajouter
     */
    public function appendContent(string $content):void
    {
        $this->body .= $content;
    }

    public function appendBootstrap(){
        $this->appendToHead('<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">');
    }

    public function appendBootstrapJS(){
        $this->appendToHead('<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>');
    }

    public function appendHeader(){
        return include './ressource/fichiersPHP/header.php';
    }

    public function appendFooter(){
        return include './ressource/fichiersPHP/footer.php';
    }

    /**
     * Produire la page Web Complète
     * @return String $html la page complète
     */
    public function toHTML():string
    {
        if ($this->title == null) {
            throw new Exception("toHTML - le titre n'est pas défini");
        }
        return <<<HTML
<!doctype html>
<html lang="fr">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <title>{$this->title}</title>
{$this->head()}
    </head>
    <body>
        <div id='page'>
{$this->body()}
        </div>
    </body>
</html>
HTML;
    }
}
