<?php
//     ____  __    _       _ __ 
//    / __ \/ /_  (_)___  (_) /_
//   / / / / __ \/ / __ \/ / __/
//  / /_/ / /_/ / / / / / / /_  
// /_____/_.___/_/_/ /_/_/\__/  
/**
 * Class definition for manipulating database. 
 *
 * @category
 * @package
 * @subpackage
 * @license    http://www.opensource.org/licenses/gpl-2.0.php GNU General Public License, version 2
 * @copyright  Copyright (c) 2015 minoru
 * @link       http://hellooooworld.com 
 * @version
 * @since      File available since Release 0.1.0
 * @author     pecodrive@github 
 */
//namespace DB;
/**
 * Connect and disconnect to the database
 */
class DbInit
{
    /**
     * database-infomation-object 
     * databasename,password,username.
     * @var DbInfo 
     */
    private $dbInfo;
    /**
     * PDOobject DataBaseHandle
     * @var PDO 
     */
    private $dbHandle;
    /**
     * Connect to the database, set DbHandle to $dbHandle.
     * @param DbInfo
     * @return bool 
     */
    public function __construct(DbInfo $dbInfoObj)
    {
        $this->dbInfo = $dbInfoObj;
        $dbs = "mysql:dbname=" . 
            "{$this->dbInfo->dataBase};host=localhost;charset-utf8";
        try
        {
            $this->dbHandle = new PDO
            (
                $dbs,
                $this->dbInfo->user,
                $this->dbInfo->passWord
            );
            return true;
        }
        catch(PDOException $exception)
        {
            echo $exception->getMessage();
            return false;
        }
    }
    /**
     * Get DbHandle. 
     * @return PDO
     */
    public function getHandle()
    {
        return $this->dbHandle;
    }
    /**
     * Disconnect Database. 
     * @return bool 
     */
    public function DisconectDbHandle()
    {
        $this->dbHandle = null;
        if(!$this->dbHandle){
            return true;
        }else{
            return false;
        }
    }
    public function __get($name)
    {
        return $this->$name;
    }
}
