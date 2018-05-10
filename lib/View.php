<?php
/**
 * Created by PhpStorm.
 * User: liamb
 * Date: 3/30/2018
 * Time: 7:21 PM
 */

namespace Bummer;


class View
{
    /**
     * View constructor.
     * @param $session $_SESSION
     */
    public function __construct($session) {
        $this->session = $session;
    }

    /**
     * Create HTML for the page head
     * @return string HTML for the standard page head
     */
    public function head() {
        return <<<HTML
<meta charset="UTF-8">
<title>$this->title</title>
<link href="lib/css/bummer.css" type="text/css" rel="stylesheet" />
HTML;
    }

    /**
     * Create HTML for the page header
     * @return string HTML for the header of this page
     */
    public function header() {
        $html = <<<HTML
<nav>
<ul>
    <li><a href="./">Home</a></li>
</ul>
HTML;

        $links = $this->links;
        if (isset($this->session[User::SESSION_NAME])) {
            $links[] = array("href" => "post/logout.php", "text" => "Logout");
        }
        if(count($links) > 0) {
            $html .= '<ul>';
            foreach($links as $link) {
                $html .= '<li><a href="' .
                    $link['href'] . '">' .
                    $link['text'] . '</a></li>';
            }
            $html .= '</ul>';
        }

        $html .= <<<HTML
</nav>
<header>
<div><h1> $this->title</h1></div>
</header>
HTML;

        return $html;
    }

    /**
     * Set the title of this page
     * @param $title string new page title
     */
    public function setTitle($title) {
        $this->title = $title;
    }

    /**
     * Add a link that will appear on the nav bar
     * @param $href string What to link to
     * @param $text string
     */
    public function addLink($href, $text) {
        $this->links[] = array("href" => $href, "text" => $text);
    }

    private $title = "";                ///< Title of this page
    private $links = array();	        ///< Links to add to the nav bar
    protected $session;                 ///< SESSION array
}