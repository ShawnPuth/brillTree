<?php
/**
 * Created by VsCode.
 * User: ShawnPuth
 * Date: 2019/4/11 
 * Time: 下午 17:00
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

    protected $guarded;

    public function __construct($column, $pid)
    {
        parent::__construct($column, $pid);
        $this->guarded = ['id', $pid];
    }

    public function index($data, $pid)
    {
        if($this->sign){
            $this->branch = Func::firstSprintf($this->branch,'block');
        }else{
            $this->branch = Func::firstSprintf($this->branch,'none');
        }
        $struct = $this->getDataStruct($data);
        $this->makeTree('id', $pid, $data, $tree);
        $this->makeForm($struct);
        return $this->tree_view;
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
                $this->tree_view = sprintf($this->root, sprintf($this->leaf_apex, json_encode($item),$this->icon['ban'], $this->makeColumn($item),$this->icon['grow'], ''));
                return;
            } else {
                $this->tree_view = sprintf($this->root, sprintf($this->leaf, json_encode($item),(int)$this->sign,$left_button, $this->makeColumn($item),$this->icon['grow'], $this->branch));
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
            } elseif (!empty($leaves)) {
                $this->tree_view = Func::firstSprintf($this->tree_view, join('', $shoot));
            }
        }
    }

    private function getDataStruct($data)
    {
        $item = current($data);
        return array_keys($item);
    }

    private function makeForm($struct)
    {
        $input = '<input class="dendrogram-input" name="%s" value="%s">';
        $form_content = '';
        foreach ($struct as $item){
            if(in_array($item,$this->guarded)){
                continue;
            }
            $form_content.=sprintf($input,$item,'{'.$item.'}');
        }
        $this->tree_view = $this->tree_view.sprintf($this->form,$form_content);
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
            return sprintf($this->leaf, json_encode($data),$this->sign,$left_button, $this->makeColumn($data),$this->icon['grow'], $this->branch);
        }
        return sprintf($this->leaf_apex, json_encode($data),$this->icon['ban'], $this->makeColumn($data),$this->icon['grow'], '');
    }
}