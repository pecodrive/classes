<?php

class Sc2chResImageExtraction
{
    public function imgExtraction($array)
    {
        foreach ($array as $item) {
            preg_match_all("/\"http[s]?:\/\/([a-zA-Z0-9\._-]+\/)+([a-z-A-Z0-9_-]+)*\.[jpeggifpn]{3,4}\"/", $item["res_body"], $match);
            if(!empty($match[0][0])){
                $count = count($match[0]);
                $tempArray = null;
                for ($i=0; $i < $count; $i++) {
                    $temp = preg_replace("/\/2ch\.io/", "", $match[0][$i]);
                    $tempend = preg_replace("/\"/", "", $temp);
                    $tempArray[] = $tempend;
                }
            $tempArrayend[] = $tempArray;
            }
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
}
