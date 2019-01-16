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
    public static function buildTree($expand = true,array $column = ['name'],array $form_data = ['name']);
    public static function operateNode();
}