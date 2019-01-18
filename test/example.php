<?php
/**
 * Created by PhpStorm.
 * User: Hikki
 * Date: 2018/11/27 0027
 * Time: 下午 5:55
 */
require_once __DIR__.'/../autoload.php';

test1();

function test1()
{
    var_dump(\DenDroGram\Controller\AdjacencyList::getTreeData());exit;
   echo \DenDroGram\Controller\AdjacencyList::buildTree(true);
}
