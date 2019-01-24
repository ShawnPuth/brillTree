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
     * @return string
     */
    public static function buildTree($id, array $column = ['name'])
    {
        $css = file_get_contents(__DIR__ . '/../Static/dendrogram.css');
        $js = file_get_contents(__DIR__ . '/../Static/dendrogram.js');
        if(config('dendrogram.form_action','')){
            sprintf($js,$form_action);
        }

        $p_id = ($id - 1) > 0 ? ($id - 1) : 0;
        $data = AdjacencyListModel::getChildren($id);

        $html = (new AdjacencyListViewModel($column))->index($data);
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

    public static function operateNode($action,$data)
    {
        if($action == 'add'){
            return AdjacencyListModel::insertGetId($data);
        }elseif ($action == 'update' && isset($data['id'])){
            return AdjacencyListModel::where('id',$data['id'])->update($data);
        }elseif ($action == 'delete' && isset($data['id'])){
            return AdjacencyListModel::deleteAll($id);
        }
        return false;
    }

}