<?php

require_once 'WebPage.class.php';
setlocale(LC_ALL, 'fr_FR.UTF-8');

class SectionWebPage extends WebPage
{
    /**
     * Les sections de la page Web
     *
     * @var array $sections
     */
    private $sections;


    /**
     * __construct()
     * @param string $title
     */
    public function __construct(string $title = null)
    {
        parent::__construct($title);
    }

    public function appendSection(string $sectionTitle, string $sectionContent): void
    {
        $this->sections[$sectionTitle] = $sectionContent;
    }

    public static function slugify(string $text):string
    {
        $retour = iconv('UTF-8', 'ASCII//TRANSLIT', $text);
        $retour = mb_ereg_replace('\\P{Alnum}', '-', $retour);

        return $retour;
    }

    public function generateMenu()
    {
        $menu = "<ul>\n";

        foreach ($this->sections as $name => $content) {
            $menu .= <<<HTML
                <li><a href="#$name" >$name</a></li>
HTML;
        }

        $menu .= "</ul>\n";

        return $menu;
    }

    public function generateSectionContent()
    {
        $_ = function ($v) {
            return $v;
        };

        $section = '';
        foreach ($this->sections as $name => $content) {
            $section .= <<<HTML
                <section id="$name"><h1>{$_(SectionWebPage::slugify($name))}</h1>
                <p>$content</p>
                </section>
HTML;
        }

        return $section;
    }

    public function body():string
    {
        $body = parent::body();
        $body .= $this->generateMenu();
        $body .= $this->generateSectionContent();

        return $body;
    }
}
