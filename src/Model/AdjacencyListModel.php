<?php
/**
 * Created by VsCode.
 * User: ShawnPuth
 * Date: 2019/4/11 
 * Time: 下午 17:05
 */

namespace DenDroGram\Model;


class AdjacencyListModel extends Model
{
    /**
     * @var string 
     */
    protected $table = 'dendrogram_adjacency';

    /**
     * @var bool 
     */
    public $timestamps = false;

    /**
     * @var array 
     */
    // protected $guarded = ['id','agent_id'];

    /**
     * Create a new Eloquent model instance.
     *
     * @param  array  $attributes
     * @return void
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->table = config('dendrogram.adjacency_table','dendrogram_adjacency');
    }

    public static function getChildren($id, $pid)
    {   
        $data = self::whereRaw("FIND_IN_SET(id,dendrogramAdjacencyGetChildren($id))")->orderBy($pid, 'ASC')->orderBy('sort', 'DESC')->get();
        if(!$data){
            return [];
        }
        return $data->toArray();
    }
    
    public static function deleteAll($id)
    {
        return self::whereRaw("FIND_IN_SET(id,dendrogramAdjacencyGetChildren($id))")->delete();
    }
}