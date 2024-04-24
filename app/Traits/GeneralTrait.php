<?php

namespace App\Traits;

use App\Models\Admin;

trait GeneralTrait
{
    public function saveImage($image, $folder)
    {

        $image->hashName();
        $path = $image->store('/', $folder);

        return $path;
    }

    // add added_by and updated_by to data (array)
    public function added_byAndUpdated_by_array($data)
    {
        if ($data->count() > 0) {
            foreach ($data as $info) {
                $info->added_by_admin = Admin::where('id', $info->added_by)->value('name');
                if ($info->updated_by > 0 and $info->updated_by != null) {
                    $info->updated_by_admin = Admin::where('id', $info->updated_by)->value('name');
                }
            }
        }

        return $data;
    }

    //get name added by and updated by to data (single)
    public function added_byAndUpdated_by($data)
    {
        if ($data->count() > 0) {
            $data->added_by_admin = Admin::where('id', $data->added_by)->value('name');
            if ($data->updated_by > 0 and $data->updated_by != null) {
                $data->updated_by_admin = Admin::where('id', $data->updated_by)->value('name');
            }
        }

        return $data;
    }

    //get some cols table
    public function get_cols_where($model, $order_field, $order_type, $pagination_counter)
    {
        $data = $model::selection()->orderby($order_field, $order_type)->paginate($pagination_counter);
        if ($data->count() > 0) {
            foreach ($data as $info) {
                $info->added_by_admin = Admin::where('id', $info->added_by)->value('name');
                if ($info->updated_by > 0 and $info->updated_by != null) {
                    $info->updated_by_admin = Admin::where('id', $info->updated_by)->value('name');
                }
            }
        }

        return $data;

    }

    //get some cols table
    public function get_cols_where_row($model, $columns_names, $where)
    {
        $data = $modelDB::select($columns_names)->where($where)->first();

        return $data;
    }
}
//////////////more////////////
/****
 *
 * public function get_cols_where($model, $columns_names, $where, $order_field, $order_type, $pagination_counter)
    {
        $data = $modelDB::select($columns_names)->orderby($order_field, $order_type)->paginate($pagination_counter);

        return $data;

    }
 */
