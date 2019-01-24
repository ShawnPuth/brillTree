<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/1/14 0014
 * Time: 下午 2:43
 */

namespace DenDroGram\Controller;


interface Structure
{
    /**
     * @param $id
     * @param array $column
     * @return mixed
     */
    public static function buildTree($id,array $column = ['name']);

    /**
     * @param $id
     * @return mixed
     */
    public static function getTreeData($id);

    /**
     * @return mixed
     */
    public static function operateNode($action,$data);
}