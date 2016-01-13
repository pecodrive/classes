<?php
/**
 * for 2ch.sc.
 */
class GetSc2chThread
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
    function __construct($html, $queryHtml, $queryAnkar)
    {
        $this->html = mb_convert_encoding
            ($html->html, "UTF-8", "SJIS");
        $this->queryHtml = $queryHtml;
        $this->queryAnkar = $queryAnkar;
    }
    public function getthread()
    {
        preg_match_all ($this->queryHtml, $this->html, $threadHtmlArray);
        preg_match_all ($this->queryAnkar, $this->html, $threadAnkarArray);

        foreach ($threadHtmlArray as $item) {
            $tempThreadHtmlArray[] = 
                preg_replace("/=\"/", "", $temp);
        }
        foreach ($threadAnkarArray as $item) {
            $tempThreadAnkarArray[] = 
                preg_replace("/><\//", "", $temp);
        }

        $countHtmlArray = count($threadHtmlArray[0]);
        for ($i=0; $i < $countHtmlArray; $i++) {
            static $threadArray = array();
            $threadArray[] = 
                [
                    'thread_url' => $threadHtmlArray[0][$i],
                    'thread_name' => $tempThreadAnkarArray[0][$i],
                    'thread_id' => $threadArray[0][$i],
                    'datetime' => date('Y-m-d H:i:s'),
                    'sha' => sha1($threadqueryHtml[0][$i].$tempThreadAnkarArray[0][$i])
                ];
        }
        return $threadArray;
    }
}
