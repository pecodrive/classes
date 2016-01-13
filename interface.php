<?php
interface ExcuteInterface
{
}

/**
 * interface for DB execute to insert.
 */
interface InsertExcuteInterface extends ExcuteInterface
{
    public function excute($di1, $di2, $di3, $di4);
    public function queryInterpretation($query); 
    public function varNameForPlaceHolder($placeHolderArray);
}

/**
 * interface for DB execute to select.
 */
interface SelectExcuteInterface extends ExcuteInterface
{
    public function excute($di1);
}

interface Sc2chDataWrapperInterface
{
    public function getValue();
}
/**
 * AbstractClass for DB execute to .
 */
abstract class ABInsertExcute implements InsertExcuteInterface
{
    public function excute($di1, $di2, $di3, $di4)
    {
    }
}
/**
 * AbstractClass for DB execute to select.
 */
abstract class ABSelectExcute implements SelectExcuteInterface
{
    public function excute($di1)
    {
    }
}
