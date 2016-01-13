<?php

/**
 * for execute Argument
 */
class Sc2chDataWrapper implements Sc2chDataWrapperInterface
{
    private $value;
    public function __construct($value)
    {
        $this->value = $value;
    }
    public function getValue()
    {
        return $this->value;
    }
}
/**
 * for SelectSQL
 */
class SelectResult
{
    private $obj;
    private $result;
    public function __construct($dbhandle, $excute, $query, ...$threadSha)
    {
        $this->threadSha = empty($threadSha[0]) ? "donot" : $threadSha[0];
        $this->obj = new OperationDb($dbhandle);
        $this->obj->selectPreparation($excute, $query, $this->threadSha);
        $this->result = $this->obj->runSql();
    }
    public function __get($name)
    {
        return $this->$name;
    }
}
class ExecuteInsert
{
    public function __construct($value, $sqlquery, $excute, $dbhandle)
    {
        $this->value = $value;
        $this->sqlquery = $sqlquery;
        $this->dbhandle = $dbhandle;
        $this->excute = $excute;
        $this->excuteInserter($this->value, $this->sqlquery, $this->excute, $this->dbhandle);
    }
    public function excuteInserter($value, $sqlquery, $excute, $dbhandle)
    {
        $insert = new OperationDb($this->dbhandle);
        $insert->insertPreparation
            (
                $this->excute,
                new Sc2chDataWrapper($this->value),
                $this->sqlquery
            );
        $insert->runSql();
    }
}
