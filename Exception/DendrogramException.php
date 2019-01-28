<?php
/**
 * Created by PhpStorm.
 * User: ydtg1
 * Date: 2019/1/28
 * Time: 13:08
 */

class DendrogramException extends Exception
{
    public function __toString()
    {
        return __CLASS__ . "{$this->getFile()}: {$this->getLine()} : {$this->message}\n";
    }
}