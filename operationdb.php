<?php
/**
 * Database operation.
 */
class OperationDb
{
    /**
     * variantneme for placeHolder.
     * @var array
     */
    private $varNameArray;
    /**
     * Placeholder for SQL.
     * @var array
     */
    private $placeHolderArray;
    /**
     * DB handle.
     * @var object
     */
    private $dbhandle;
    /**
     * Placeholder.
     * @var string
     */
    private $sqlpre;
    /**
     * execute result.
     * @var array
    var_dump($item);
     */
    private $result;
    /**
     * anything data for execute.
     * @var array
     */
    private $value;
    /**
     * execute function object.
     * @var object
     */
    private $excute;
    /**
     * SQL query with Placeholder.
     * @var string
     */
    private $query;
    /**
     * set $excute,$value,$dbHandle.
     * @return void
     */
    public function __construct($dbhandle)
    {
        $this->dbhandle = $dbhandle;
    }
    public function insertPreparation
        (ExcuteInterface $excute, $value, $query)
    {
        $this->excute = $excute;
        $this->value = $value;
        $this->query = $query;
        $this->placeHolderArray = 
            $this->excute->queryInterpretation($this->query);
        $this->varNameArray = 
            $this->excute->varNameForPlaceHolder($this->placeHolderArray);
    }
    public function selectPreparation
        (ExcuteInterface $excute, $query, ...$threadSha)
    {
        $this->excute = $excute;
        $this->query = $query;
        $this->value = new Sc2chDataWrapper($threadSha[0]);
    }
    /**
     * Run SQL.
     * set $result.
     * @return void
     */
    public function runSql()
    {
        $this->sqlpre = $this->dbhandle->getHandle()->prepare($this->query);
        if($this->excute instanceof ABInsertExcute){
            $this->result = $this->excute->excute
                (
                    $this->varNameArray,
                    $this->sqlpre,
                    $this->value->getValue(),
                    $this->placeHolderArray
                );
        }elseif($this->excute instanceof ABSelectExcute){
            $this->result = $this->excute->excute($this->sqlpre);
        }else{
            $this->result = $this->excute->excute($this->sqlpre, $this->value->getValue());
        }
    }
    /**
     * Get result.
     */
    public function __get($name)
    {
        return $this->$name;
    }
}
