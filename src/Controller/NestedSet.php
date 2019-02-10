<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/1/14 0014
 * Time: 下午 2:40
 */

namespace DenDroGram\Controller;

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
     * @param array $column
     * @return mixed|string
     */
    public function buildTree($id,array $column = ['name'])
    {
        $css = file_get_contents(__DIR__.'/../Static/dendrogram.css');
        $js = file_get_contents(__DIR__.'/../Static/dendrogram.js');
        if(($form_action = config('dendrogram.form_action',''))){
            $js = sprintf($js,$form_action);
        }

        $data = NestedSetModel::getChildren($id);
        $html = (new NestedSetViewModel($column))->index($data);
        return sprintf(self::$view,$css,$js,$html);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getTreeData($id)
    {
        $data = NestedSetModel::getChildren($id);
        self::makeTeeData($data,$tree);
        return current($tree);
    }

    private static function makeTeeData(&$array, &$branch = [])
    {
        if(empty($array)){
            return;
        }

        if (empty($branch)) {
            $item = array_shift($array);
            $item['children'] = [];
            $branch[] = $item;
            if (!empty($array)) {
                self::makeTeeData($array,$branch);
            }
            return;
        }

        foreach ($branch as $k=>&$b) {
            $b['children'] = [];
            $shoot = [];
            foreach ($array as $key => $value) {
                if (($b['layer'] + 1) == $value['layer'] && $b['left'] < $value['left'] && $b['right'] > $value['left']) {
                    $value['children'] = [];
                    $shoot[] = $value;
                    unset($array[$key]);
                }
            }

            if (!empty($array) && !empty($shoot)) {
                self::makeTeeData($array,$shoot);
                $b['children'] = $shoot;
            }elseif (empty($array) && !empty($shoot)){
                self::makeTeeData($array,$shoot);
                $b['children'] = $shoot;
            }
        }
    }

    /**
     * @param $action
     * @param $data
     * @return bool
     */
    public function operateNode($action,$data)
    {
        if($action == 'add' && isset($data['p_id'])){
            return NestedSetModel::add($data);
        }elseif ($action == 'update' && isset($data['id'])){
            return NestedSetModel::where('id',$data['id'])->update($data);
        }elseif ($action == 'delete' && isset($data['id'])){
            return NestedSetModel::deleteAll($data['id']);
        }
        return false;
    }
}