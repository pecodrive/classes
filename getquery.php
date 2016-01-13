<?php
/**
 * Get query. 
 */
class GetQuery extends ABSelectExcute
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
    public function resultReArray($array)
    {
        foreach ($array as $item) {
            $name = $item["queryname"];
            $query = $item["query"];
            $reArray[$name] = $query;
        }
        return $reArray;
    }
}

class GetRegex extends ABSelectExcute
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
    public function resultReArray($array)
    {
        foreach ($array as $item) {
            $name = $item["name"];
            $regextext = $item["regextext"];
            $classname = $item["classname"];
            $functionname = $item["functionname"];
            $reArray[$name] = $item["regextext"];
                //array($classname=>array($functionname=>$regextext));
        }
        return $reArray;
    }
}
class GetLogingData extends ABSelectExcute
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
    public function resultReArray($array)
    {
        foreach ($array as $item) {
            $reArray["user"] = $item["user"];
            $reArray["password"] = $item["password"];
        }
        return $reArray;
    }
}
class RegexBiluder 
{
    private $obj;
    private $regex;
    public function __construct($dbhandle, $query)
    {
        $this->obj = new OperationDb($dbhandle);
        $this->obj->selectPreparation
        (
            new GetRegex(),
            "SELECT * FROM regex;"
        );
        $this->regex = $this->obj->runSql();
    }
    public function __get($name)
    {
        return $this->$name;
    }
}
class QueryBiluder
{
    private $obj;
    private $query;
    public function __construct($dbhandle, $query)
    {
        $this->obj = new OperationDb($dbhandle);
        $this->obj->selectPreparation
        (
            new GetQuery(),
            "SELECT * FROM query;"
        );
        $this->query = $this->obj->runSql();
    }
    public function __get($name)
    {
        return $this->$name;
    }
}

