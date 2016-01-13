<?php
/**
 * for 2ch.sc Thread  Insert
 */
class Sc2chThreadInsert extends ABInsertExcute
{
    /**
     * Insert execute.
     * @return true
     */
    public function excute
        ($varNameArray, $sqlpre, $value, $placeHolderArray)
    {
        $countValueArray = count($value);
        $countVarNameArray = count($varNameArray);
        for ($i=0; $i < $countValueArray; $i++) {
            for($j=0; $j < $countVarNameArray; $j++) {
                $varName = "param".$j;
                $$varName = (string)$varNameArray[$j];
                $sqlpre->bindParam
                    (
                        $placeHolderArray[$j],
                        $$varName
                    );
            $$varName = $value[$i][$$varName];
            }
            $sqlpre->execute();
        }
        return true;
    }
    /**
     * Placeholder Interpretation. 
     * set $placeHolderArray.
     * @return void
     */
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
} 
class  Sc2chThreadInsertedFormResNo extends ABInsertExcute
{
    public function excute($varNameArray, $sqlpre, $value, $placeHolderArray)
    {
            $sqlpre->bindParam ( ":res_end", $res_end);
            $sqlpre->bindParam ( ":sha", $sha);
            $res_end = $value[0];
            $sha = $value[1];
            $sqlpre->execute();
        return true;
    }
    public function queryInterpretation($query)
    {
        return true;
    }
    public function varNameForPlaceHolder($placeHolderArray)
    {
        return true;
    }
}
class  Sc2chThreadInsertedFormOldlog extends ABInsertExcute
{
    public function excute($varNameArray, $sqlpre, $value, $placeHolderArray)
    {
            $sqlpre->bindParam ( ":is_oldlog", $isoldlog);
            $sqlpre->bindParam ( ":sha", $sha);
            $isoldlog = $value[2];
            $sha = $value[1];
            $sqlpre->execute();
        return true;
    }
    public function queryInterpretation($query)
    {
        return true;
    }
    public function varNameForPlaceHolder($placeHolderArray)
    {
        return true;
    }
}
class  Sc2chThreadInsertedForArticled extends ABInsertExcute
{
    public function excute($varNameArray, $sqlpre, $value, $placeHolderArray)
    {
            $sqlpre->bindParam ( ":articled", $articled);
            $sqlpre->bindParam ( ":sha", $sha);
            $articled = 1;
            $sha = $value;
            $sqlpre->execute();
        return true;
    }
    public function queryInterpretation($query)
    {
        return true;
    }
    public function varNameForPlaceHolder($placeHolderArray)
    {
        return true;
    }
}


