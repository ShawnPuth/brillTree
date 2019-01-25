<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/1/21 0021
 * Time: 下午 5:35
 */

namespace DenDroGram\Model;

use Illuminate\Support\Facades\DB;

class NestedSetModel extends Model
{
    /**
     * @var string 
     */
    protected $table = 'dendrogram_nested';

    /**
     * @var bool 
     */
    public $timestamps = false;

    /**
     * @var array 
     */
    protected $guarded = ['id'];

    public static function add($data)
    {
        $p_id = $data['p_id'];
        unset($data['p_id']);
        DB::beginTransaction();
        $result = (array)DB::selectOne("SELECT dendrogramNestedParentIncreament(?) as p_right,dendrogramNestedCountLayer(?) as layer",[$p_id,$p_id]);
        if(!$result){
            DB::rollBack();
            return false;
        }
        $right = $result['p_right'];
        $layer = $result['layer'] + 1;
        $data['left'] = $right;
        $data['right'] = $right + 1;
        $data['layer'] = $layer;
        $result = self::insertGetId($data);
        if(!$result){
            DB::rollBack();
            return false;
        }
        DB::commit();
        return true;
    }

    public static function getChildren($id)
    {
        $child = self::where('id',$id)->first();
        if(!$child){
            return [];
        }
        $left = $child->left;
        $right = $child->right;
        $children = self::whereBetween('left', [$left, $right])->get();
        if(!$children){
            return [$child->toArray()];
        }
        $children = $children->toArray();
        array_unshift($children,$child->toArray());
        return $children;
    }
    
    public static function deleteAll($id)
    {

    }
}