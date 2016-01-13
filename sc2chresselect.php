<?php
/**
 * Get Thread. 
 */
class Sc2chResSelect implements ExcuteInterface
{
    /**
     * Select execute.
     * @return true
     */
    public function excute ($sqlpre, $threadSha)
    {
                $sqlpre->bindParam
                    (
                        ":thread_sha",
                        $placeHolder
                    );
            $placeHolder = $threadSha;
            $sqlpre->execute();
        return $this->resultReArray($sqlpre->fetchAll());
    }
    public function queryInterpretation($query)
    {
        $pattern = '/:[a-zA-z]+/';
        static $matchArray = array();
        preg_match_all($pattern, $query, $match);
        foreach ($match as $item) {
            $matchArray = $item;
        }
        return $matchArray;
    }
    /**
     * Create variantname for placeHolder.
     * set $varNameArray.
     * @return void
     */
    public function varNameForPlaceHolder($placeHolderArray)
    {
        $varName = array();
        $count = count($placeHolderArray);
        for ($i=0; $i < $count; $i++) {
            $varName[] = preg_replace
                ("/:/", "", $placeHolderArray[$i]);
        }
        return $varName;
    }
    /**
     * Re Array   
     * @return array
     */
    public function resultReArray($array)
    {
        foreach ($array as $item) {
            $reArray[] =
                [
                    "thread_sha"     =>      $item["thread_sha"],
                    "datetime"       =>      $item["datetime"],
                    "res_no"         =>      $item["res_no"],
                    "res_name"       =>      $item["res_name"],
                    "res_date"       =>      $item["res_date"],
                    "res_clock"      =>      $item["res_clock"],
                    "res_id"         =>      $item["res_id"],
                    "res_body"       =>      $item["res_body"],
                    "res_rowhandle"  =>      $item["res_rowhandle"],
                    "thread_url"     =>      $item["thread_url"],
                    "res_rowbody"    =>      $item["res_rowbody"],
                    "sha"            =>      $item["sha"],
                    "img_info"       =>      $item["img_info"]
                ];
        }
        return $reArray;
    }
}
