<?php
/**
 * for 2ch.sc.
 */
class GetSc2chMenu
{
    /**
     * Dom from XPath.
     * @var object
     */
    private $purposeDom;
    /**
     * Query for ResponseHeader.
     * @var string
     */
    private $query;
    /**
     * HtmlBody.
     * @var string
     */
    private $html;
    function __construct($html, $queryHtml, $queryAnkar)
    {
        $this->html = mb_convert_encoding
            ($html->html, "UTF-8", "SJIS");
        $this->queryHtml = $queryHtml;
        $this->queryAnkar = $queryAnkar;
    }
    public function getMenu()
    {
        preg_match_all($this->queryHtml, $this->html, $menuHtmlArray);
        preg_match_all($this->queryAnkar, $this->html, $menuAnkarArray);
        foreach ($menuAnkarArray as $item) {
            $temp = preg_replace("/<A HREF=http:\/\/[a-z0-9\.]*\/?[a-z0-9\.]*\/?[a-z0-9\.]*\/?[a-zA-Z0-9\"_=\s\/]*>/", "", $item);
            $tempAnkarArray[] = preg_replace("/<\/A>/", "", $temp);
        }
        $countHtmlArray = count($menuHtmlArray[0]);
        $countBodyArray = count($menuAnkarArray[0]);
        for ($i=0; $i < $countHtmlArray; $i++) {
            static $menuArray = array();
            $menuArray[] = 
                [
                    'menu_url' => $menuHtmlArray[0][$i]."subback.html",
                    'menu_ankar' => $tempAnkarArray[0][$i],
                    'datetime' => date('Y-m-d H:i:s')
                ];
        }
        return $menuArray;
    }
}
