<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/1/14 0014
 * Time: 下午 2:40
 */

namespace DenDroGram\Controller;

use DenDroGram\Helpers\Func;
use DenDroGram\Model\NestedSetModel;
use DenDroGram\ViewModel\NestedSetViewModel;

class NestedSet implements Structure
{
    private static $view = <<<EOF
<style>%s</style>
<script>%s</script>
<div class="dendrogram dendrogram-nested dendrogram-animation-fade">
%s
<div class="clear_both"></div>
</div>
<div id="mongolia"></div>
<script>dendrogram.tree.init();</script>
EOF;

    /**
     * @param $id
     * @param bool $expand
     * @param array $column
     * @param string $form_action
     * @param string $form_content
     * @return string
     */
    public static function buildTree($id,$expand = true,array $column = ['name'],$form_action='',$form_content = '')
    {
        $css = file_get_contents(__DIR__.'/../Static/dendrogram.css');
        $js = file_get_contents(__DIR__.'/../Static/dendrogram.js');
        if($form_action){
            sprintf($js,$form_action);
        }

        $data = NestedSetModel::getChildren($id);
        $html = (new NestedSetViewModel($expand,$column,$form_content))->index($data);
        return sprintf(self::$view,$css,$js,$html);
    }

    public static function getTreeData($id)
    {

    }

    public static function operateNode()
    {
        // TODO: Implement updateNode() method.
    }
}