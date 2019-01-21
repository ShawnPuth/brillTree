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
}