<?php
/**
 * Created by VsCode.
 * User: ShwanPuth
 * Date: 2019/4/11 
 * Time: 下午 4:51
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
     * @param array $column
     * @return mixed|string
     */
    public function buildTree($id, array $column = ['name'], string $pid = 'pid')
    {   
        // var_dump($pid);die;
        $css = file_get_contents(__DIR__ . '/../Static/dendrogram.css');
        $js = file_get_contents(__DIR__ . '/../Static/dendrogram.js');
        if(($form_action = config('dendrogram.form_action',''))){
            $js = sprintf($js,$form_action);
        }

        $data = AdjacencyListModel::getChildren($id, $pid);
        $html = (new AdjacencyListViewModel($column, $pid))->index($data, $pid);
        return sprintf(self::$view, $css, $js, $html);
    }

    /**
     * @param $id
     * @return array
     */
    public function getTreeData($id)
    {
        $data = AdjacencyListModel::getChildren($id);
        $tree = Func::quadraticArrayToTreeData($data, 'id', 'agent_id', 'children');
        return $tree;
    }

    /**
     * @param $action
     * @param $data
     * @return bool
     */
    public function operateNode($action,$data)
    {
        if($action == 'add'){
            if(array_key_exists('sort',$data)){
                $data['sort'] = (int)$data['sort'];
            }
            return AdjacencyListModel::insertGetId($data);
        }elseif ($action == 'update' && isset($data['id'])){
            return AdjacencyListModel::where('id',$data['id'])->update($data);
        }elseif ($action == 'delete' && isset($data['id'])){
            return AdjacencyListModel::deleteAll($data['id']);
        }
        return false;
    }

}