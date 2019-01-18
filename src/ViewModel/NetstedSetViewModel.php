<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/1/14 0014
 * Time: 下午 3:47
 */

namespace DenDroGram\ViewModel;


use DenDroGram\Helpers\Func;

class NestedSetViewModel
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

    public function index($data,$expand,$column,$form_data)
    {
        $this->expand = $expand;
        $this->column = $column;
        $this->form_data = $form_data;

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

        $this->makeTree($data);

        return $this->tree_view;
    }

    private function makeTree($data)
    {
        foreach ($data as $d){
            $num = Func::quadraticArrayCount($data,['depth'=>$d['depth']]);

        }
    }


}