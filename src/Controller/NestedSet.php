<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/1/14 0014
 * Time: 下午 2:40
 */

namespace DenDroGram\Controller;


class NestedSet implements Structure
{
    private static $view = <<<EOF
<style>%s</style>
<script>%s</script>
%s
<script>
dendrogram.tree.init();
</script>
EOF;

    /**
     * @param bool $expand
     * @param array $column
     * @param array $form_data
     * @return mixed|string
     */
    public static function buildTree($expand = true,array $column = ['name'],array $form_data = ['name'])
    {
        $css = file_get_contents(__DIR__.'/../Static/dendrogram.css');
        $js = file_get_contents(__DIR__.'/../Static/dendrogram.js');

        $data = [
            ["id"=>1,"left"=>1,"right"=>22,"depth"=>0,"name"=>"衣服"],
            ["id"=>2,"left"=>2,"right"=>9,"depth"=>1,"name"=>"男衣"],
            ["id"=>3,"left"=>10,"right"=>21,"depth"=>1,"name"=>"女衣"],
            ["id"=>4,"left"=>3,"right"=>8,"depth"=>2,"name"=>"正装"],
            ["id"=>5,"left"=>4,"right"=>5,"depth"=>3,"name"=>"衬衫"],
            ["id"=>6,"left"=>6,"right"=>7,"depth"=>3,"name"=>"夹克"],
            ["id"=>7,"left"=>11,"right"=>16,"depth"=>2,"name"=>"裙子"],
            ["id"=>8,"left"=>17,"right"=>18,"depth"=>2,"name"=>"短裙"],
            ["id"=>9,"left"=>19,"right"=>20,"depth"=>2,"name"=>"开衫"],
        ];


    }

    /**
     * @return mixed
     */
    public static function getTreeStructure()
    {

    }

    public static function getTreeData()
    {

    }

    public static function operateNode()
    {
        // TODO: Implement updateNode() method.
    }
}