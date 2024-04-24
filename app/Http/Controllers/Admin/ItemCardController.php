<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ItemCardRequestRequest;
use App\Models\Item_card;
use App\Models\Itemcard_category;
use App\Models\Uom;
use App\Traits;
use Illuminate\Support\Facades\Storage;

class ItemCardController extends Controller
{
    use Traits\GeneralTrait;

    public function index()
    {
        $data = $this->get_cols_where(new Item_card, 'id', 'DESC', PAGINATION_COUNT);
        $Itemcard_categories = Itemcard_category::selectionActive()->get();

        return view('admin.item_cards.index', compact('data', 'Itemcard_categories'));
    }

    public function create()
    {
        try {
            $Itemcard_categories = Itemcard_category::selectionActive()->get();
            $uoms = Uom::SelectionActiveAndMaster()->get();
            $retail_uoms = Uom::SelectionActiveAndNotMaster()->get();
            $child_item_cards = Item_card::AllChildItemCardActive()->get();

            return view('admin.item_cards.create', compact('Itemcard_categories', 'uoms', 'retail_uoms', 'child_item_cards'));
        } catch (\Exception $ex) {
            session()->flash('error', 'حدث خطاء ما'.' => '.$ex->getMessage());

            return redirect()->back();
        }
    }

    public function store(ItemCardRequestRequest $request)
    {
        try {
            $com_code = auth()->user()->com_code;
            if ($request->has('photo') and $request->photo != 'default.png') {
                //validate image
                $request->validate([
                    'photo' => 'required | mimes:png,jpg,jpeg | max:2000',
                ]);
                //save image by Traits
                $image_path = $this->saveImage($request->photo, 'item_cards_imgs');
                $data_insert['photo'] = $image_path;
            } else {
                $data_insert['photo'] = 'default.png';
            }
            //item code
            $item_code = $child_item_cards = Item_card::Selection()->orderby('id', 'DESC')->first();
            if (! empty($item_code)) {
                $data_insert['item_code'] = $item_code->id + 1;
            } else {
                $data_insert['item_code'] = 1;
            }
            //barcode
            if (! empty($request->barcode)) {
                $checkExists = Item_card::Selection()->where(['barcode' => $request->barcode])->first();
                if ($checkExists != null) {
                    session()->flash('error', 'باركود الصنف موجود بالفعل');

                    return redirect()->back()->withInput();
                } else {
                    $data_insert['barcode'] = $request->barcode;
                }
            } else {
                $random = random_int(10000, 99999);
                $random = substr($random, 0, 5);
                $data_insert['barcode'] = 'item'.$data_insert['item_code'].$random;
            }
            //check exist name
            $checkExists = Item_card::Selection()->where(['name' => $request->name])->first();
            if ($checkExists != null) {
                session()->flash('error', 'اسم الصنف موجود بالفعل');

                return redirect()->back()->withInput();
            }
            $data_insert['name'] = $request->name;
            $data_insert['item_type'] = $request->item_type;
            $data_insert['itemcard_category_id'] = $request->itemcard_category_id;
            $data_insert['item_card_id'] = $request->item_card_id;
            $data_insert['uom_id'] = $request->uom_id;
            $data_insert['price'] = $request->price;
            $data_insert['nos_gomal_price'] = $request->nos_gomal_price;
            $data_insert['gomal_price'] = $request->gomal_price;
            $data_insert['cost_price'] = $request->cost_price;

            $data_insert['does_has_retailunit'] = $request->does_has_retailunit;
            if ($data_insert['does_has_retailunit'] == 1) {
                $data_insert['retail_uom_id'] = $request->retail_uom_id;
                $data_insert['retail_uom_quntToparent'] = $request->retail_uom_quntToparent;
                $data_insert['price_retail'] = $request->price_retail;
                $data_insert['nos_gomal_price_retail'] = $request->nos_gomal_price_retail;
                $data_insert['gomal_price_retail'] = $request->gomal_price_retail;
                $data_insert['cost_price_retail'] = $request->cost_price_retail;
            }

            $data_insert['has_fixced_price'] = $request->has_fixced_price;
            $data_insert['active'] = $request->active;
            $data_insert['com_code'] = $com_code;
            $data_insert['added_by'] = auth()->user()->id;
            $data_insert['date'] = date('Y-m-d');
            Item_card::create($data_insert);
            session()->flash('success', 'تم اضافة الصنف بنجاح');

            return redirect()->route('item_cards.index');
        } catch (\Exception $ex) {
            session()->flash('error', 'حدث خطاء ما'.' => '.$ex->getMessage());

            return redirect()->back();
        }

    }

    public function show(string $id)
    {
        try {
            $data = Item_card::selection()->find($id);
            $data = $this->added_byAndUpdated_by($data);
            if (empty($data)) {
                session()->flash('error', 'عفوا الصنف غير موجود');

                return redirect()->back();
            }

            return view('admin.item_cards.show', compact('data'));
        } catch (\Exception $ex) {
            session()->flash('error', 'حدث خطاء ما'.' => '.$ex->getMessage());

            return redirect()->back();
        }
    }

    public function edit(string $id)
    {
        try {
            $data = Item_card::selection()->find($id);
            $Itemcard_categories = Itemcard_category::selectionActive()->get();
            $uoms = Uom::SelectionActiveAndMaster()->get();
            $retail_uoms = Uom::SelectionActiveAndNotMaster()->get();
            $child_item_cards = Item_card::AllChildItemCardActive()->get();
            if ($data == null) {
                session()->flash('error', 'عفوا الصنف غير موجوده');

                return redirect()->back();
            } else {
                return view('admin.item_cards.edit', compact('data', 'Itemcard_categories', 'uoms', 'retail_uoms', 'child_item_cards'));
            }
        } catch (\Exception $ex) {
            session()->flash('error', 'حدث خطاء ما'.' => '.$ex->getMessage());

            return redirect()->back();
        }
    }

    public function update(ItemCardRequestRequest $request, string $id)
    {
        try {
            $data = Item_card::selection()->find($id);
            if (empty($data)) {
                session()->flash('error', 'عفوا الصنف غير موجود');

                return redirect()->back()->withInput();
            }
            $com_code = auth()->user()->com_code;
            if ($request->has('photo') and $request->photo != $data->photo) {
                //validate image
                $request->validate([
                    'photo' => 'required | mimes:png,jpg,jpeg | max:2000',
                ]);
                //save image by Traits
                $image_path = $this->saveImage($request->photo, 'item_cards_imgs');
                if ($request->photo != 'default.png') {
                    Storage::disk('item_cards_imgs')->delete($request->photo);
                }
                $data_update['photo'] = $image_path;
            }
            //barcode
            if (! empty($request->barcode)) {
                $checkExists = Item_card::Selection()->where(['barcode' => $request->barcode])->where('id', '!=', $id)->first();
                if ($checkExists != null) {
                    session()->flash('error', 'باركود الصنف موجود بالفعل');

                    return redirect()->back()->withInput();
                } else {
                    $data_update['barcode'] = $request->barcode;
                }
            } else {
                session()->flash('error', 'من فضلك ادخل باركود الصنف');

                return redirect()->back()->withInput();
                //$random = random_int(10000, 99999);
                //$random = substr($random, 0, 5);
                //$data_insert['barcode'] = 'item'.$data_insert['item_code'].$random;
            }
            //check exist name
            $checkExists = Item_card::Selection()->where(['name' => $request->name])->where('id', '!=', $id)->first();
            if ($checkExists != null) {
                session()->flash('error', 'اسم الصنف موجود بالفعل');

                return redirect()->back()->withInput();
            }
            $data_update['name'] = $request->name;
            $data_update['item_type'] = $request->item_type;
            $data_update['itemcard_category_id'] = $request->itemcard_category_id;
            $data_update['item_card_id'] = $request->item_card_id;
            $data_update['uom_id'] = $request->uom_id;
            $data_update['price'] = $request->price;
            $data_update['nos_gomal_price'] = $request->nos_gomal_price;
            $data_update['gomal_price'] = $request->gomal_price;
            $data_update['cost_price'] = $request->cost_price;

            $data_update['does_has_retailunit'] = $request->does_has_retailunit;
            if ($data_update['does_has_retailunit'] == 1) {
                $data_update['retail_uom_id'] = $request->retail_uom_id;
                $data_update['retail_uom_quntToparent'] = $request->retail_uom_quntToparent;
                $data_update['price_retail'] = $request->price_retail;
                $data_update['nos_gomal_price_retail'] = $request->nos_gomal_price_retail;
                $data_update['gomal_price_retail'] = $request->gomal_price_retail;
                $data_update['cost_price_retail'] = $request->cost_price_retail;
            } else {
                $data_update['retail_uom_id'] = 0;
                $data_update['retail_uom_quntToparent'] = 0;
                $data_update['price_retail'] = 0;
                $data_update['nos_gomal_price_retail'] = 0;
                $data_update['gomal_price_retail'] = 0;
                $data_update['cost_price_retail'] = 0;
            }

            $data_update['has_fixced_price'] = $request->has_fixced_price;
            $data_update['active'] = $request->active;
            $data_update['com_code'] = $com_code;
            $data_update['added_by'] = auth()->user()->id;
            $data_update['date'] = date('Y-m-d');
            $data_update['updated_by'] = auth()->user()->id;
            Item_card::Selection()->where(['id' => $id])->update($data_update);
            session()->flash('success', 'تم تحديث الصنف بنجاح');

            return redirect()->route('item_cards.show', $data->id);
        } catch (\Exception $ex) {
            session()->flash('error', 'حدث خطاء ما'.' => '.$ex->getMessage());

            return redirect()->back();
        }
    }

    public function destroy(string $id)
    {
        //
    }
}
