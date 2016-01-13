<?php
/**
 * for 2ch.sc Responce Insert
 */
class Sc2chResInsert extends ABInsertExcute
{
    /**
     * Insert execute.
     * @return true
     */
    public function __construct($forInsertedNoQuery,$isoldlog,  $dbhandle)
    {
        $this->query = $forInsertedNoQuery;
        $this->isoldlog = $isoldlog;
        $this->dbhandle = $dbhandle;
    }
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
        (new Sc2chResInsertedtoOldlog)->inserteIsOldlog($countValueArray, $sqlpre, array($value[$i]["thread_sha"], $value[$i]["is_oldlog"]), $this->dbhandle, $this->isoldlog);
        }
        (new Sc2chResInsertedtoThreadColumn)->insertedNo($countValueArray, $sqlpre, $value[0]["thread_sha"], $this->dbhandle, $this->query);
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
class Sc2chResInsertedtoThreadColumn
{
   public function insertedNo($arrayCount, $sqlpre, $sha, $dbhandle, $query)
   {
        new ExecuteInsert
            (
                array($arrayCount,$sha),
                $query,
                new Sc2chThreadInsertedFormResNo(),
                $dbhandle
            );
   } 
}
class Sc2chResInsertedtoOldlog
{
    public function inserteIsOldlog($arrayCount, $sqlpre, $sha, $dbhandle, $query)
    {
        new ExecuteInsert
            (
                array($arrayCount,$sha[0],$sha[1]),
                $query,
                new Sc2chThreadInsertedFormOldlog(),
                $dbhandle
            );
   } 
}
class Sc2chResInsertedtoArticled
{
    public function inserteArticled($arrayCount, $sqlpre, $sha, $dbhandle, $query)
    {
        new ExecuteInsert
            (
                array($arrayCount,$sha[0],$sha[1]),
                $query,
                new Sc2chThreadInsertedForArticled(),
                $dbhandle
            );
   } 
}
