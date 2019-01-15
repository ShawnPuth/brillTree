<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/1/14 0014
 * Time: 下午 2:40
 */

namespace DenDroGram\Controller;


use DenDroGram\ViewModel\AdjacencyListViewModel;

class AdjacencyList implements Structure
{
    private static $view = <<<EOF
<style>%s</style>
<script>%s</script>
%s
EOF;

    public static function buildTree()
    {
        $css = file_get_contents(__DIR__.'/../Static/dendrogram.css');
        $js = file_get_contents(__DIR__.'/../Static/dendrogram.js');

        $data = [
     ["id"=>1,"p_id"=>0,"name"=>"中国"],
     ["id"=>2,"p_id"=>1,"name"=>"四川"],
     ["id"=>3,"p_id"=>1,"name"=>"北京"],
     ["id"=>4,"p_id"=>2,"name"=>"成都"]];

        $html = (new AdjacencyListViewModel())->index($data);

        return sprintf(self::$view,$css,$js,$html);
    }

    public static function operateNode()
    {
        // TODO: Implement updateNode() method.
    }

}