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

    private $elements = ["name", "value", "sort"];

    private $root = <<<EOF
<ul class="dendrogram dendrogram-adjacency-list dendrogram-animation-fade">%s</ul>
EOF;

    private $branch = <<<EOF
<ul class="dendrogram dendrogram-adjacency-branch">%s</ul>
EOF;

    private $leaf = <<<EOF
<li>
    <div data-v=%s>
         <div class="dendrogram-adjacency-line"></div>
            <a href="javascript:void(0);" class="dendrogram-adjacency-retract" data-sign="1">
                <svg class="dendrogram-icon">
                    <svg width="14" height="14" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <circle fill="none" stroke="#fff" stroke-width="1.1" cx="9.5" cy="9.5" r="9"></circle>
                    <svg width="20" height="20" stroke="#fff" fill="#fff" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><polygon points="8 5 13 10 8 15"></polygon></svg>
                    </svg>
                </span>
             </a>
             <button class="dendrogram-button" href="#form">
                <div class="text">%s<div>
             </button>
         <a href="#form" class="dendrogram-adjacency-grow">
            <span class="dendrogram-icon">
                <svg width="14" height="14" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                <circle fill="none" stroke="#fff" stroke-width="1.1" cx="9.5" cy="9.5" r="9"></circle>
                <line fill="none" stroke="#fff" x1="9.5" y1="5" x2="9.5" y2="14"></line>
                <line fill="none" stroke="#fff" x1="5" y1="9.5" x2="14" y2="9.5"></line>
                </svg>
            </span>    
         </a>
         <div class="clear_both"></div>
    </div>
    %s
</li>
EOF;

    private $leaf_apex = <<<EOF
<li>
    <div data-v=%s>
         <div class="dendrogram-adjacency-line"></div>
         <a href="javascript:void(0);" class="dendrogram-adjacency-ban">
            <span class="dendrogram-icon">
                <svg width="14" height="14" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                <circle fill="none" stroke="#fff" stroke-width="1.1" cx="9.5" cy="9.5" r="9"></circle>
                <line fill="none" stroke="#fff" stroke-width="1.1" x1="4" y1="3.5" x2="16" y2="16.5"></line>
                </svg>
             </span>  
         </a>
             <button class="dendrogram-button" href="#form">
                <div class="text">%s<div>
             </button>
         <a href="#form" class="dendrogram-adjacency-grow">
            <span class="dendrogram-icon">
                <svg width="14" height="14" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                <circle fill="none" stroke="#fff" stroke-width="1.1" cx="9.5" cy="9.5" r="9"></circle>
                <line fill="none" stroke="#fff" x1="9.5" y1="5" x2="9.5" y2="14"></line>
                <line fill="none" stroke="#fff" x1="5" y1="9.5" x2="14" y2="9.5"></line>
                </svg>
            </span> 
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

    public function index($data)
    {
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

        if (empty($tree)) {
            $item = array_shift($array);
            $tree[$item[$id]] = [];
            if (empty($array)) {
                //无子节点
                $this->tree_view = sprintf($this->root, sprintf($this->leaf_apex, Func::arrayToJsonString($item), $item['name'], ''));
                return;
            } else {
                $this->tree_view = sprintf($this->root, sprintf($this->leaf, Func::arrayToJsonString($item), $item['name'], $this->branch));
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

    /**
     * 枝
     * @param $data
     * @param bool $node
     * @return string
     */
    private function makeBranch($data, $node = true)
    {
        if ($node) {
            return sprintf($this->leaf, Func::arrayToJsonString($data), $data['name'], $this->branch);
        }
        return sprintf($this->leaf_apex, Func::arrayToJsonString($data), $data['name'], '');
    }
}