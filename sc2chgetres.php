<?php
/**
 * for 2ch.sc.
 */
class GetSc2chRes
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
    function __construct($html, $queryBody, $queryHandle, $queryRowBody, $threadSha, $siteimgurl)
    {
        $this->html = mb_convert_encoding
            ($html->html, "UTF-8", "SJIS");
        $this->url = $html->url;
        $this->queryBody = $queryBody;
        $this->queryHandle = $queryHandle;
        $this->queryRowBody = $queryRowBody;
        $this->threadSha = $threadSha;
        $this->siteimgurl = $siteimgurl;
    }
    public function getRes()
    {
        $isoldlog = preg_match("/<hr .+>\n<center><.+>■ このスレッドは過去ログ倉庫に格納されています<\/font>/u", $this->html, $oldlog);
        // var_dump($isoldlog);
        $resBodyArray = $this->pMa($this->queryBody, $this->html);
        $resHandleArray= $this->pMa($this->queryHandle, $this->html);
        $resRowBodyArray= $this->pMa($this->queryRowBody, $this->html);

        $divideArray = array();
        $i = 0;
        foreach ($resHandleArray[0] as $item) {
            $temp = preg_replace("/<dt>/", "", $item);
            $temp = preg_replace("/<dd>/", "", $temp);
            preg_match("/^[0-9]+/", $temp, $no);
            preg_match("/：.+：/", $temp, $nametemp);
            $name = preg_replace("/(<b>)?(<\/b>)?(<font [a-z]+=[a-z]+>)?(<\/font>)?(<a [a-zA-Z]+=[a-zA-Z\":]+>)?(<\/a>)?(：)?/", "", $nametemp[0]);
            preg_match("/20[0-9][0-9]\/[0-1][0-9]\/[0-3][0-9]\(月?火?水?木?金?土?日?\)/u", $temp, $date);
            preg_match("/[0-9A-Z][0-9A-Z]:[0-9A-Z][0-9A-Z]:[0-9A-Z][0-9A-Z]\.[0-9A-Z][0-9A-Z]/", $temp, $clock);
            preg_match("/ID:.+/", $temp, $id);
            preg_match("/\[[1-9]?[1-9]?[1-9]?\/[1-9]?[1-9]?[1-9]?\]$/", $temp, $idnum);
            $tempresrowbody = htmlspecialchars(preg_replace("/(<dd>)?/", "", $resBodyArray[0][$i]));
            $sha = sha1((string)$resHandleArray[0][$i].$this->url);
            //$imgo = ($this->imgExtraction($resBodyArray[0][$i], $no, $sha, $this->siteimgurl));
            //var_dump($imgo);
            $tempresbody0 = preg_replace("/(<dd>)?/", "", $resBodyArray[0][$i]);
            $is_ankaruser = preg_match_all
                (
                    "/<a\s?href=\"..\/test\/read.cgi\/[a-zA-Z0-9]+\/[0-9]+\/[0-9]{1,3}-*[0-9]*\"\s? [a-zA-Z\"_=]+>&gt;&gt;([0-9]{1,3}-?[0-9]*)<\/a>/",
                    $tempresbody0, $ankaruser
                );
            // var_dump($ankaruser);
            if($ankaruser[0]){
                $countAnkarUser = count($ankaruser[0]);
                $replacebody = $tempresbody0;
                for ($j=0; $j < $countAnkarUser; $j++) {
                    $tempcolon = preg_replace("/\"/", "\\\"", $ankaruser[0][$j]);
                    $tempbs = preg_replace("/\//", "\\/", $tempcolon);
                    $regex = preg_replace("/\./", "\.", $tempbs);
                    $replacebody = preg_replace("/".$regex."/", ">>".$ankaruser[1][$j], $replacebody);
                }
            }else{
                $replacebody = $tempresbody0;
            }
            $imgInfo = serialize($this->imgExtraction($replacebody, $no, $sha, $this->siteimgurl));
            $divideArray[] = 
            [
                'res_no'        => empty($no[0]) ? "" : (int)$no[0],
                'res_name'      => empty($name) ? "" : $name,
                'res_date'      => empty($date[0]) ? "" : $date[0],
                'res_clock'     => empty($clock[0]) ? "" : $clock[0],
                'res_id'        => empty($id[0]) ? "" : $id[0],
                'res_idnum'     => "",
                'datetime'      => date('Y-m-d H:i:s'),
                'res_body'      => empty($replacebody) ? "" : $replacebody,
                'res_rowhandle' => empty($resHandleArray[0][$i]) ? "" : $resHandleArray[0][$i],
                'thread_url'    => empty($this->url) ? "" : $this->url,
                'res_rowbody'   => empty($tempresrowbody) ? "" : $tempresrowbody,
                'sha'           => $sha,
                'thread_sha'    => empty($this->threadSha) ? "" : $this->threadSha,
                'img_info'      => empty($imgInfo) ? "" : $imgInfo,
                'is_oldlog'      => empty($isoldlog) ? 0 : $isoldlog
            ];
            $i++;
        }
       return $divideArray;
   }
    public function imgExtraction($data, $no, $sha, $siteimgurl)
    {
            $tempbody = $data;
            preg_match_all("/<[aA] href=\"http[s]?:\/\/([a-zA-Z0-9\._-]+\/)+([a-z-A-Z0-9_-]+)*\.[jpeggifpn]{3,4}\" (target=\"_blank\")?>http[s]?:\/\/([a-zA-Z0-9\._-]+\/)+([a-z-A-Z0-9_-]+)*\.[jpeggifpn]{3,4}<\/[aA]>( )?(<br>)*/", $data, $matchAllImgATag);
            preg_match_all("/\"http[s]?:\/\/([a-zA-Z0-9\._-]+\/)+([a-z-A-Z0-9_-]+)*\.[jpegpnif]{3,4}\"/", $data, $matchImgUrl);
            if(!empty($matchImgUrl[0][0])){
                $count = count($matchImgUrl[0]);
                $tempArray = null;
                for ($i=0; $i < $count; $i++) {
                    $imgUrltemp = preg_replace("/\/2ch\.io/", "", $matchImgUrl[0][$i]);
                    preg_match("/\.[jpegpnif]{3,4}/", $imgUrltemp, $imgUrlex);
                    $imgrename = $no[0] . "_" . $i . "_" . $sha . $imgUrlex[0];
                    $imgtag = "<a href=\"".$siteimgurl.$imgrename."\" target=\"_blank\"><img src=\"".$siteimgurl.$imgrename."\"></a>";
                    $imgUrltempend = preg_replace("/\"/", "", $imgUrltemp);
                    $regex = preg_quote($matchAllImgATag[0][$i], "/");
                    $tempbody = preg_replace("/{$regex}/", $imgtag, $tempbody);
                    $tempArray[] = [
                        'imgurl'        => $imgUrltempend,
                        'img_rename'    => $no[0] . "_" . $i . "_" . $sha . $imgUrlex[0],
                        'all_img_atag'  => $matchAllImgATag[0][$i]
                    ];
                }
                $tempArrayend[] = 
                    [
                        'info' => $tempArray,
                        'retag_body' =>$tempbody
                    ];
            }else{
                $tempArrayend = array();
            }
        return $tempArrayend;
    }
    public function putImg($array)
    {
        foreach ($array as $item) {
        }
        $imgData = file_get_contents($temp);
        $savepath = "/var/www/html/matome/". $match[1][0];
        file_put_contents($savepath, $imgData);
    }
   public function adapteRowBody($html)
   {
       preg_match_all
           (
               "/<dd>.+/", 
               mb_convert_encoding
               (
                   $html, "UTF-8", "SJIS"
               ),
               $match
           );
       return $match;
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
}
