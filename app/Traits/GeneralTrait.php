<?php

namespace App\Traits;

use App\Models\Admin;
use App\Models\Admin_shifts;
use App\Models\Treasury_transaction;

trait GeneralTrait
{
    public function saveImage($image = null, $folder = null)
    {

        $image->hashName();
        $path = $image->store('/', $folder);

        return $path;
    }

    // add added_by and updated_by to data (array)
    public function added_byAndUpdated_by_array($data = null)
    {
        if (count($data) > 0) {
            //$admins = Admin::get();
            foreach ($data as $info) {
                $admin_name = Admin::where('id', $info->added_by)->value('name');
                if ($admin_name) {
                    $info->added_by_admin = $admin_name;
                } else {
                    $info->added_by_admin = '';
                }
                if ($info->updated_by > 0 and $info->updated_by != null) {
                    $info->updated_by_admin = $admin_name;
                } else {
                    $info->updated_by_admin = '';
                }
            }
        }

        return $data;
    }

    //get name added by and updated by to data (single)
    public function added_byAndUpdated_by($data = null)
    {
        if ($data->count() > 0) {
            $data->added_by_admin = Admin::where('id', $data->added_by)->value('name');
            if ($data->updated_by > 0 and $data->updated_by != null) {
                $data->updated_by_admin = Admin::where('id', $data->updated_by)->value('name');
            }
        }

        return $data;
    }

    public function get_user_shift()
    {
        $admin_shift = Admin_shifts::selection()->where(['admin_id' => auth()->user()->id, 'is_finished' => 1])->with('Treasury_transactions', 'treasury', 'admin')->first();
        if ($admin_shift) {
            return $admin_shift;
        } else {
            return false;
        }
    }

    public function get_current_balance()
    {
        $admin_shift = $this->get_user_shift();
        if ($admin_shift) {
            $money = Treasury_transaction::Selection()
                ->where(['admin_shift_id' => $admin_shift->id])
                ->sum('money');
            return $money;
        } else {
            return false;
        }
    }
    public function refresh_account_blance($account_number = null,
        $AccountModel = null, $TableModel = null,
        $Treasury_transactionModel = null, $TablInvoiceeModel = null,
        $account_type_id = null, $returnFlag = false) {
        $account_data = $AccountModel
            ->selection()
            ->select('id', 'start_balance', 'account_type_id')
            ->where('account_number', $account_number)
            ->first();
        if ($account_data) {
            if ($account_data->account_type_id == $account_type_id) {
                //صافي مجموع المشتريات و المرتجعات
                $the_net_in_table_with_order = $TablInvoiceeModel
                    ->selection()
                    ->where([
                        'account_number' => $account_number,
                    ])
                    ->sum('money_for_account') ?? 0.0;
                //صافي الحركة النقدية بالخزنة
                $the_net_in_treasury_transaction = $Treasury_transactionModel::selection()
                    ->where([
                        'account_id' => $account_data->id,
                        'is_account' => 1,
                    ])
                    ->sum('money_for_account') ?? 0.0;
                $the_final_balance = $account_data->start_balance +
                    $the_net_in_table_with_order + $the_net_in_treasury_transaction;
                $data_to_update_account['current_balance'] = $the_final_balance;
                $AccountModel
                    ->selection()
                    ->where('account_number', $account_number)
                    ->update($data_to_update_account);
                $data_to_update_table['current_balance'] = $the_final_balance;
                $TableModel
                    ->selection()
                    ->where([
                        'account_number' => $account_number,
                    ])
                    ->update($data_to_update_table);
                if ($returnFlag) {
                    return $the_final_balance;
                }
            }
        }
    }
    public function do_update_itemcard_quantity($Itemcard_batcheModel = null, $Item_cardModel = null, $item_card_id = null, $retail_uom_quntToparent = null, $is_master_uom = null)
    {
        if ($retail_uom_quntToparent == 0 or $retail_uom_quntToparent == null) {
            $retail_uom_quntToparent = 1;
        }
        $all_quantity_in_batche = $Itemcard_batcheModel
            ->where(['item_card_id' => $item_card_id, 'is_send_to_archived' => 0])
            ->sum('quantity');
        $main_quantity_in_batche = $all_quantity_in_batche * $retail_uom_quntToparent;
        $parent_quantity_in_batche = intdiv($main_quantity_in_batche, $retail_uom_quntToparent);
        if ($is_master_uom == 1) {
            $data_to_update_itemcard_quantity['quentity'] = $parent_quantity_in_batche;
            $data_to_update_itemcard_quantity['all_quentity'] = $all_quantity_in_batche;
            $data_to_update_itemcard_quantity['quentity_all_retails'] = $main_quantity_in_batche;
        } else {
            $data_to_update_itemcard_quantity['quentity'] = $parent_quantity_in_batche;
            $data_to_update_itemcard_quantity['all_quentity'] = $all_quantity_in_batche;
            $data_to_update_itemcard_quantity['quentity_retail'] = $main_quantity_in_batche - ($parent_quantity_in_batche * $retail_uom_quntToparent);
            $data_to_update_itemcard_quantity['quentity_all_retails'] = $main_quantity_in_batche;
        }
        $Item_cardModel
            ->selection()->where('id', $item_card_id)
            ->update($data_to_update_itemcard_quantity);
    }

    /**********************************************************************/

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
    //public function get_cols_where_row($model, $columns_names, $where)
    //{
    //$data = $modelDB::select($columns_names)->where($where)->first();

    //return $data;
    //}
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
