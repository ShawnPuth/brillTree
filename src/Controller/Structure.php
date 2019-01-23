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
     * @param bool $expand
     * @param array $column
     * @param string $form_action
     * @param string $form_content
     * @return mixed
     */
    public static function buildTree($id, $expand = true, array $column = ['name'], $form_action = '', $form_content = '');

    /**
     * @param $id
     * @return mixed
     */
    public static function getTreeData($id);

    /**
     * @return mixed
     */
    public static function operateNode();
}