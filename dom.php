<?php
/**
 * Get html
 */
class HtmlBody
{
    /**
     * Htmlbody
     * @var string
     */
    private $html;
    /**
     * url.
     * @var string
     */
    private $url;
    /**
     * set Htmlbody to $html
     * @return void
     */
    public function __construct($url)
    {
        $this->html = file_get_contents($url);
        $this->url = $url;
    }
    /**
     * Getter
     * @return string $html
     */
    public function __get($name)
    {
        return $this->$name;
    }
}

/**
 * Get Xpath from htmlbody
 */
class GetXPath
{
    /**
     * XPathObject
     * @var object
     */
    private $xPathObj;
    private $html;
    /**
     * Create XPath
     */
    public function __construct($html)
    {
        $this->html = $html;
        $domDoc = new DOMDocument();
        @$domDoc->loadHTML($html);
        $this->xPathObj = new DOMXpath($domDoc);
    }
    /**
     * Getter
     * @return object $xPathObj
     */
    public function __get($name)
    {
        return $this->$name;
    }
}
/**
 * Purpose Dom form XPath.
 */
class PurposeDom
{
    /**
     * DomObject.
     * @var object 
     */
    private $html;
    /**
     * XPathObject.
     * @var object
     */
    private $xPathObj;
    /**
     * baseUrl
     * @var string
     */
    private $url;
    /**
     * @return void
     */
    public function __construct($url)
    {
        $this->url = $url;
        $this->html = new HtmlBody($url);
        $this->xPathObj = new GetXPath($this->html->html);
    }
    /**
     * Get Node.
     * @param string $query
     * @return object
     */
    public function pDQuery($query)
    {
        return $this->xPathObj->xPathObj->evaluate($query);
    }
    /**
     * Get Node with contextnode.
     * @param string $query
     * @return object
     */
    public function pDQueryContext($query, $node)
    {
        return $this->xPathObj->xPathObj->evaluate($query, $node);
    }
    /**
     * Getter.
     * @return object
     */
    public function __get($name)
    {
        return $this->$name;
    }
}

