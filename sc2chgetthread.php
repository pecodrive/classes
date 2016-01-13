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
    /**
     * HtmlBody. 
     * @var object
     */
    private $html;
    private $url;
    function __construct($html, $queryHtml, $queryAnkar)
    {
        $this->html = mb_convert_encoding
            ($html->html, "UTF-8", "SJIS");
        $this->url = $this->pR("/subback.html/", "", $html->url);
        $this->queryHtml = $queryHtml;
        $this->queryAnkar = $queryAnkar;
    }
    public function getthread()
    {
        $threadHtmlArray = $this->pMa($this->queryHtml, $this->html);
        $threadAnkarArray= $this->pMa($this->queryAnkar, $this->html);
        foreach ($threadHtmlArray as $item) {
            $tempThreadHtmlArray[] = 
                $this->pR("/=\"/", "", $item);
        }
        foreach ($threadAnkarArray[0] as $item) {
            $tempNo1 = $this->pMa("/\([0-9]+/", $item);
            $tempNo2[] = (int)$this->pR("/\(/", "", $tempNo1[0][0]);
            $temp1 = $this->pR("/\">[0-9]+:\s/u", "", $item);
            $temp2 = $this->pR("/\([0-9]+\)/u", "", $temp1); 
            $tempThreadAnkarArray[] = 
                $this->pR("/\s<\//", "", $temp2); 
        }

        //var_dump($tempNo2);
        $countHtmlArray = count($threadHtmlArray[0]);
        for ($i=0; $i < $countHtmlArray; $i++) {
            static $threadArray = array();
            $threadArray[] = 
                [
                    'thread_url' => $this->urlBuilder($this->url, $tempThreadHtmlArray[0][$i]),
                    'thread_name' => $tempThreadAnkarArray[$i],
                    'thread_id' => $tempThreadHtmlArray[0][$i],
                    'thread_now_res_no' =>$tempNo2[$i],
                    'sha' => sha1($tempThreadHtmlArray[0][$i].$tempThreadAnkarArray[$i]),
                    'datetime' => date('Y-m-d H:i:s')

                ];
        }
        return $threadArray;
    }
    public function pMa($query, $html)
    {
        preg_match_all($query, $html, $array);
        return $array;
    }
    public function pR($query, $replace, $data)
    {
        return preg_replace($query, $replace, $data);
    }
    public function urlBuilder($url, $urlid)
    {
        preg_match("/http:\/\/[a-z0-9\.]+\//", $url, $hit);
        preg_match("/\/[a-z0-9]+\//", $url, $hit2);
        return $hit[0]."test/read.cgi".$hit2[0].$urlid;
    }
}
