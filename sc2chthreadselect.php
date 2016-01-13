<?php
/**
 * Get Thread. 
 */
class Sc2chThreadSelect extends ABSelectExcute
{
    /**
     * Select execute.
     * @return true
     */
    public function excute ($sqlpre)
    {
        $sqlpre->execute();
        //return $this->diffReArray($this->resultReArray($sqlpre->fetchAll()));
        return ($this->resultReArray($sqlpre->fetchAll()));
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
                    "thread_url" => $item["thread_url"],
                    "thread_name" => $item["thread_name"],
                    "thread_id" => $item["thread_id"],
                    "thread_now_res_no" => $item["thread_now_res_no"],
                    "sha" => $item["sha"],
                    "datetime" => $item["datetime"],
                    "res_end" => $item["res_end"],
                    "articled" => $item["articled"],
                    "is_oldlog" => $item["is_oldlog"],
                ];
        }
        return $reArray;
    }
    public function diffReArray($reArray)
    {
        $i = 0;
        foreach ($reArray as $item) {
            $diff = (int)$item["res_end"] - (int)$item["thread_now_res_no"]; 
            if($diff > 1 || (int)$item["res_end"] === 0){
                $diffArray[] = $reArray[$i];
            }
            $i++;
        }
        return $diffArray;
    }
}
