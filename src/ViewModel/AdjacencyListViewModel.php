<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/1/14 0014
 * Time: 下午 3:47
 */

namespace DenDroGram\ViewModel;


use DenDroGram\Helpers\Func;

class AdjacencyListViewModel extends ViewModel
{
    private $root = <<<EOF
<ul class="dendrogram dendrogram-adjacency-list dendrogram-animation-fade">%s</ul>
EOF;

    private $branch = <<<EOF
<ul class="dendrogram dendrogram-adjacency-branch" style="display:%s">%s</ul>
EOF;

    private $leaf = <<<EOF
<li>
    <div data-v=%s data-sign=%d class="dendrogram-adjacency-node">
            <a href="javascript:void(0);" class="dendrogram-tab dendrogram-adjacency-node">
                %s
             </a>
             <button class="dendrogram-button" href="javascript:void(0);">
                %s
             </button>
         <a href="#form" class="dendrogram-grow">
            %s   
         </a>
         <div class="clear_both"></div>
    </div>
    %s
</li>
EOF;

    private $leaf_apex = <<<EOF
<li>
    <div data-v=%s class="dendrogram-adjacency-node">
         <a href="javascript:void(0);" class="dendrogram-ban dendrogram-adjacency-node">
            %s 
         </a>
             <button class="dendrogram-button" href="javascript:void(0);">
                %s
             </button>
         <a href="#form" class="dendrogram-grow">
            %s
         </a>
         <div class="clear_both"></div>
    </div>
    %s
</li>
EOF;

    private $form = <<<EOF
<div id="dendrogram-form">
    <button id="dendrogram-form-close" type="button">
    <svg width="14" height="14" viewBox="0 0 14 14" xmlns="http://www.w3.org/2000/svg" data-svg="close-icon"><line fill="none" stroke="#000" stroke-width="1.1" x1="1" y1="1" x2="13" y2="13"></line><line fill="none" stroke="#000" stroke-width="1.1" x1="13" y1="1" x2="1" y2="13"></line></svg>
    </button>
    <div class="dendrogram-form-header">
        <h2 id="dendrogram-form-theme"></h2>
    </div>
    <div class="dendrogram-form-body">
        %s
    </div>
    <div class="dendrogram-form-footer"> 
        <button class="delete" type="button">删除</button>
        <button class="conserve" type="button">保存</button>
    </div>
</div>
EOF;

    private $input = <<<EOF
<div class="uk-margin">
     <input class="uk-input" type="text" placeholder="%s" name="%s" value="">
</div>
EOF;

    public function index($data,$sign,$column,$form_data)
    {
        $this->sign = $sign;
        $this->column = $column;
        $this->form_data = $form_data;

        if($this->sign){
            $this->branch = Func::firstSprintf($this->branch,'block');
        }else{
            $this->branch = Func::firstSprintf($this->branch,'none');
        }

        $this->makeTree('id', 'p_id', $data, $tree);
        $this->tree_view = $this->tree_view.$this->makeForm();
        return $this->tree_view;
    }

    private function makeForm()
    {
        $inputs = '';
        foreach ($this->form_data as $element) {
            $inputs .= sprintf($this->input, $element, $element);
        }

        return sprintf($this->form, $inputs);
    }

    /**
     * @param string $id
     * @param string $p_id
     * @param array $array
     * @param $tree
     */
    private function makeTree($id, $p_id, &$array, &$tree)
    {
        if (empty($array)) {
            return;
        }

        $left_button = $this->sign ? $this->icon['shrink'] : $this->icon['expand'];

        if (empty($tree)) {
            $item = array_shift($array);
            $tree[$item[$id]] = [];
            if (empty($array)) {
                //无子节点
                $this->tree_view = sprintf($this->root, sprintf($this->leaf_apex, Func::arrayToJsonString($item),$this->icon['ban'], $this->makeColumn($item),$this->icon['grow'], ''));
                return;
            } else {
                $this->tree_view = sprintf($this->root, sprintf($this->leaf, Func::arrayToJsonString($item),(int)$this->sign,$left_button, $this->makeColumn($item),$this->icon['grow'], $this->branch));
            }
        }

        foreach ($tree as $branch => &$leaves) {
            $shoot = [];
            foreach ($array as $key => $value) {
                if ($value[$p_id] == $branch) {
                    $leaves[$value[$id]] = [];
                    unset($array[$key]);
                    if (Func::quadraticArrayGetIndex($array, [$p_id => $value[$id]]) === false) {
                        //无子节点
                        $shoot[] = $this->makeBranch($value, false);
                    } else {
                        $shoot[] = $this->makeBranch($value);
                    }
                }
            }

            if (!empty($leaves) && $array) {
                $this->tree_view = Func::firstSprintf($this->tree_view, join('', $shoot));
                $this->makeTree($id, $p_id, $array, $leaves);
            } elseif (empty($leaves)) {
                return;
            } else {
                $this->tree_view = Func::firstSprintf($this->tree_view, join('', $shoot));
            }
        }
    }

    private function makeColumn($data)
    {
        $text = '<div class="text">%s</div>';
        $html = '';
        foreach ($this->column as $column){
            $html.=sprintf($text,isset($data[$column])?$data[$column]:'');
        }

        return $html;
    }

    /**
     * 枝
     * @param $data
     * @param bool $node
     * @return string
     */
    private function makeBranch($data, $node = true)
    {
        if ($node) {
            $left_button = $this->sign ? $this->icon['shrink'] : $this->icon['expand'];
            return sprintf($this->leaf, Func::arrayToJsonString($data),(int)$this->sign,$left_button, $this->makeColumn($data),$this->icon['grow'], $this->branch);
        }
        return sprintf($this->leaf_apex, Func::arrayToJsonString($data),$this->icon['ban'], $this->makeColumn($data),$this->icon['grow'], '');
    }
}