<?php
/**
 * Created by VsCode.
 * User: ShwanPuth
 * Date: 2019/4/11 
 * Time: 下午 4:58
 */

namespace DenDroGram\Controller;


interface Structure
{
    /**
     * @param $id
     * @param array $column
     * @return mixed
     */
    public function buildTree($id,array $column = ['name'],  string $pid = 'p_id');

    /**
     * @param $id
     * @return mixed
     */
    public function getTreeData($id);

    /**
     * @param $action
     * @param $data
     * @return mixed
     */
    public function operateNode($action,$data);
}