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
     * @param bool $expand
     * @param array $column
     * @param array $form_data
     * @return mixed
     */
    public static function buildTree($expand = true,array $column = ['name'],array $form_data = ['name']);

    /**
     * @return mixed
     */
    public static function getTreeStructure();

    /**
     * @return mixed
     */
    public static function getTreeData();

    /**
     * @return mixed
     */
    public static function operateNode();
}