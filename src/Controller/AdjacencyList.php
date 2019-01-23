<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/1/14 0014
 * Time: 下午 2:40
 */

namespace DenDroGram\Controller;

use DenDroGram\Helpers\Func;
use DenDroGram\Model\AdjacencyListModel;
use DenDroGram\ViewModel\AdjacencyListViewModel;

class AdjacencyList implements Structure
{
    private static $view = <<<EOF
<style>%s</style>
<script>%s</script>
%s
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
    public static function buildTree($id, $expand = true, array $column = ['name'], $form_action = '', $form_content = '')
    {
        $css = file_get_contents(__DIR__ . '/../Static/dendrogram.css');
        $js = file_get_contents(__DIR__ . '/../Static/dendrogram.js');
        if($form_action){
            sprintf($js,$form_action);
        }

        $p_id = ($id - 1) > 0 ? ($id - 1) : 0;
        $result = AdjacencyListModel::where('p_id', '>=', $p_id)->orderBy('p_id', 'ASC')->orderBy('sort', 'DESC')->get();
        $data = [];
        if ($result) {
            $data = $result->toArray();
        }

        $html = (new AdjacencyListViewModel($expand, $column, $form_content))->index($data);
        return sprintf(self::$view, $css, $js, $html);
    }

    /**
     * @param $id
     * @return array
     */
    public static function getTreeData($id)
    {
        $p_id = ($id - 1) > 0 ? ($id - 1) : 0;
        $data = AdjacencyListModel::where('p_id', '<=', $p_id)->orderBy('p_id', 'ASC')->orderBy('sort', 'DESC')->get();
        $tree = Func::quadraticArrayToTreeData($data, 'id', 'p_id', 'children');
        return $tree;
    }

    public static function operateNode()
    {
        // TODO: Implement updateNode() method.
    }

}