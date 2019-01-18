<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/1/14 0014
 * Time: 下午 3:47
 */

namespace DenDroGram\ViewModel;


use DenDroGram\Helpers\Func;

class AdjacencyListViewModel
{
    private $tree_view;

    private $expand;
    private $column;
    private $form_data;

    private $icon = [
        'expand'=>'<span class="dendrogram-icon"><svg width="14" height="14" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"> <circle fill="none" stroke="#fff" stroke-width="1.1" cx="9.5" cy="9.5" r="9"></circle> <line fill="none" stroke="#fff" x1="9.5" y1="5" x2="9.5" y2="14"></line> <line fill="none" stroke="#fff" x1="5" y1="9.5" x2="14" y2="9.5"></line></svg></span>',
        'shrink'=>'<span class="dendrogram-icon"><svg width="14" height="14" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"> <circle fill="none" stroke="#fff" stroke-width="1.1" cx="9.5" cy="9.5" r="9"></circle> <line fill="none" stroke="#fff" x1="5" y1="9.5" x2="14" y2="9.5"></line></svg></span>',
        'grow'=>'<span class="dendrogram-icon"><svg width="14" height="14" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" data-svg="social"><line fill="none" stroke="#fff" stroke-width="1.1" x1="13.4" y1="14" x2="6.3" y2="10.7"></line><line fill="none" stroke="#fff" stroke-width="1.1" x1="13.5" y1="5.5" x2="6.5" y2="8.8"></line><circle fill="none" stroke="#fff" stroke-width="1.1" cx="15.5" cy="4.6" r="2.3"></circle><circle fill="none" stroke="#fff" stroke-width="1.1" cx="15.5" cy="14.8" r="2.3"></circle><circle fill="none" stroke="#fff" stroke-width="1.1" cx="4.5" cy="9.8" r="2.3"></circle></svg></span> ',
        'ban'=>'<span class="dendrogram-icon"><svg width="14" height="14" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><circle fill="none" stroke="#fff" stroke-width="1.1" cx="9.5" cy="9.5" r="9"></circle><line fill="none" stroke="#fff" stroke-width="1.1" x1="4" y1="3.5" x2="16" y2="16.5"></line></svg></span> '
    ];

    private $root = <<<EOF
<ul class="dendrogram dendrogram-adjacency-list dendrogram-animation-fade">%s</ul>
EOF;

    private $branch = <<<EOF
<ul class="dendrogram dendrogram-adjacency-branch" style="display:%s">%s</ul>
EOF;

    private $leaf = <<<EOF
<li>
    <div data-v=%s data-sign=%d class="dendrogram-adjacency-node">
            <a href="javascript:void(0);" class="dendrogram-adjacency-tab dendrogram-adjacency-node">
                %s
             </a>
             <button class="dendrogram-button" href="#form">
                %s
             </button>
         <a href="#form" class="dendrogram-adjacency-grow">
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
         <a href="javascript:void(0);" class="dendrogram-adjacency-ban dendrogram-adjacency-node">
            %s 
         </a>
             <button class="dendrogram-button" href="#form">
                %s
             </button>
         <a href="#form" class="dendrogram-adjacency-grow">
            %s
         </a>
         <div class="clear_both"></div>
    </div>
    %s
</li>
EOF;

    private $form = <<<EOF
<div id="form">
    <div class="uk-modal-dialog">
        <button class="uk-modal-close-default" type="button"></button>
        <div class="uk-modal-header">
            <h2 class="uk-modal-title">Headline</h2>
        </div>
        <div class="uk-modal-body">
            %s
        </div>
        <div class="uk-modal-footer uk-text-right"> 
            <button class="uk-button uk-button-danger" type="button">删除</button>
            <button class="uk-button uk-button-primary" type="button">保存</button>
        </div>
    </div>
</div>
EOF;

    private $input = <<<EOF
<div class="uk-margin">
     <input class="uk-input" type="text" placeholder="%s" name="%s" value="">
</div>
EOF;

    public function index($data,$expand,$column,$form_data)
    {
        $this->expand = $expand;
        $this->column = $column;
        $this->form_data = $form_data;

        if($this->expand){
            $this->branch = Func::firstSprintf($this->branch,'block');
        }else{
            $this->branch = Func::firstSprintf($this->branch,'none');
        }

        $this->makeTree('id', 'p_id', $data, $tree);
        //$this->tree_view = $this->tree_view.$this->makeForm();
        return $this->tree_view;
    }

    private function makeForm()
    {
        $inputs = '';
        foreach ($this->elements as $element) {
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

        $left_buttun = $this->expand ? $this->icon['shrink'] : $this->icon['expand'];

        if (empty($tree)) {
            $item = array_shift($array);
            $tree[$item[$id]] = [];
            if (empty($array)) {
                //无子节点
                $this->tree_view = sprintf($this->root, sprintf($this->leaf_apex, Func::arrayToJsonString($item),$this->icon['ban'], $this->makeColumn($item),$this->icon['grow'], ''));
                return;
            } else {
                $this->tree_view = sprintf($this->root, sprintf($this->leaf, Func::arrayToJsonString($item),(int)$this->expand,$left_buttun, $this->makeColumn($item),$this->icon['grow'], $this->branch));
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
            $left_buttun = $this->expand ? $this->icon['shrink'] : $this->icon['expand'];
            return sprintf($this->leaf, Func::arrayToJsonString($data),(int)$this->expand,$left_buttun, $this->makeColumn($data),$this->icon['grow'], $this->branch);
        }
        return sprintf($this->leaf_apex, Func::arrayToJsonString($data),$this->icon['ban'], $this->makeColumn($data),$this->icon['grow'], '');
    }
}