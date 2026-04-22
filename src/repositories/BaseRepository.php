<?php 

namespace App\Repositories;

class BaseRepository{
    protected static $model;

    public static function new(){
        return new static::$model();
    }

    public static function all(){
        $item = new static::$model();
        return $item->select();
    }

    public static function find($id){
        $item = new static::$model();
        return $item->select(
            '*',
            [
                'where' => 'id = :id',
                'replaces' => [':id' => $id],
            ],
            true
        );
    }
    
    public static function findAll($ids){
        $item = new static::$model();
        $tokens = array_map(function($id){ return ":id_$id"; },$ids);
        $list_ids = implode(",", $tokens);
        $list_replaces = array_combine($tokens, $ids);

        return $item->select(
            '*',
            [
                'where' => "id IN ($list_ids)",
                'replaces' => $list_replaces,
            ],
            false
        );
    }

    public static function delete($item){
        // $item = new static::$model();
        $item->delete();
    }
}