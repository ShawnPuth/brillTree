<?php
/**
 * Created by VsCode.
 * User: ShwanPuth
 * Date: 2019/4/11
 * Time: 16:49
 */

namespace DenDroGram\Controller;


use Mockery\Exception;

class DenDroGram implements Structure
{
    /**
     * @var Structure
     */
    private $instance;

    public function __construct($structure)
    {
        $this->instance = new $structure;
        if(!($this->instance instanceof Structure)){
            throw new \DendrogramException('import instance is not instanceof structure');
        }
    }

    /**
     * 生成树状图视图
     * @param $id
     * @param array $column
     * @return mixed
     * @throws \DendrogramException
     */
    public function buildTree($id, array $column = ['name'], string $pid = 'p_id')
    {
        try {
            $result = $this->instance->buildTree($id, $column, $pid);
        }catch (Exception $e){
            throw new \DendrogramException($e->getMessage());
        }
        return $result;
    }

    /**
     * 获取树状图结构数据
     * @param $id
     * @return mixed
     * @throws \DendrogramException
     */
    public function getTreeData($id)
    {
        try {
            $result = $this->instance->getTreeData($id);
        }catch (Exception $e){
            throw new \DendrogramException($e->getMessage());
        }
        return $result;
    }

    /**
     * 操作节点
     * @param $action
     * @param $data
     * @return mixed
     * @throws \DendrogramException
     */
    public function operateNode($action, $data)
    {
        try {
            $result = $this->instance->operateNode($action, $data);
        }catch (Exception $e){
            throw new \DendrogramException($e->getMessage());
        }
        return $result;
    }

}