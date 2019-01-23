<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/1/21 0021
 * Time: 下午 5:35
 */

namespace DenDroGram\Model;


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

    public static function getChildren($id)
    {
        $child = self::where('id',$id)->first();
        if(!$child){
            return [];
        }
        $left = $child->left;
        $right = $child->right;
        $depth = $child->depth;
        $children = self::where([
            ['depth','>=',$depth],
            ['left','>=',$left],
            ['right','<=',$right]
        ])->get();
        if(!$children){
            return [$child->toArray()];
        }
        $children = $children->toArray();
        array_unshift($children,$child);
        return $children;
    }
}