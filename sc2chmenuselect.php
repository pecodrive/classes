<?php
/**
 * Get Menu. 
 */
class Sc2chMenuSelect extends ABSelectExcute
{
    /**
     * Select execute.
     * @return true
     */
    public function excute ($sqlpre)
    {
        $sqlpre->execute();
        return $this->resultReArray($sqlpre->fetchAll());
    }
    /**
     * Re Array   
     * @return array
     */
    public function resultReArray($array)
    {
        foreach ($array as $item) {
            $id = $item["id"];
            $menuurl = $item["menu_url"];
            $menuankar = $item["menu_ankar"];
            $datetime = $item["datetime"];
            $reArray[] =
                [
                    "id" => $id,
                    "menu_url" => $menuurl,
                    "menu_ankar" => $menuankar,
                    "datetime" => $datetime
                ];
        }
        return $reArray;
    }
}
