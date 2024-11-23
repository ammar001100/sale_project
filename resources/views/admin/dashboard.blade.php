@extends('admin.layouts.app')
@section('css')
@endsection
@section('headTitle')
الرئيسية
@endsection
@section('pageTitle')
لوحة التحكم
@endsection
@section('breadcrumb')
<ol class="breadcrumb float-sm-right">
    <li class="breadcrumb-item active">الريئسية</li>
</ol>
@endsection
@section('content')
<div class="row">
    <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box" style="background-color: #cea3a3 ;text-align: center">
            <div class="inner">
                <h3>{{ App\Models\Sale_invoice::count() }}</h3>
                <p>فواتير المبيعات</p>
            </div>
            <div class="icon">
                <i class="ion ion-bag"></i>
            </div>
            <a href="{{ route("sale_invoices.index") }}" class="small-box-footer">عرض <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box" style="background-color: #78c778 ;text-align: center">
            <div class="inner">
                <h3>{{ App\Models\Supplier_with_order::selection()->count() }}<sup style="font-size: 20px"></sup></h3>

                <p>فواتير المشتريات</p>
            </div>
            <div class="icon">
                <i class="ion ion-stats-bars"></i>
            </div>
            <a href="{{ route("supplier_orders.index") }}" class="small-box-footer">عرض <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box" style="background-color: #826fcb ;text-align: center">
            <div class="inner">
                <h3>{{ App\Models\Item_card::selection()->count() }}</h3>

                <p>الاصناف</p>
            </div>
            <div class="icon">
                <i class="ion ion-person-add"></i>
            </div>
            <a href="{{ route("item_cards.index") }}" class="small-box-footer">عرض <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box" style="background-color: #d07fb9 ;text-align: center">
            <div class="inner">
                <h3>{{ App\Models\Customer::selection()->count() }}</h3>

                <p>العملاء</p>
            </div>
            <div class="icon">
                <i class="ion ion-pie-graph"></i>
            </div>
            <a href="{{ route("customers.index") }}" class="small-box-footer">عرض <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <!-- ./col -->
</div>
<!-- /.row -->
<div class="row">
    <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box" style="background-color: #de7f94 ;text-align: center">
            <div class="inner">
                <h3>{{ App\Models\Supplier::selection()->count() }}</h3>
                <p> الموردين</p>
            </div>
            <div class="icon">
                <i class="ion ion-bag"></i>
            </div>
            <a href="{{ route("suppliers.index") }}" class="small-box-footer">عرض <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box" style="background-color: #abb777 ;text-align: center">
            <div class="inner">
                <h3>{{ App\Models\Delegate::selection()->count() }}<sup style="font-size: 20px"></sup></h3>

                <p>المناديب</p>
            </div>
            <div class="icon">
                <i class="ion ion-stats-bars"></i>
            </div>
            <a href="#" class="small-box-footer">عرض <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box" style="background-color: #b179d1 ;text-align: center">
            <div class="inner">
                <h3>0</h3>

                <p>الموظفين</p>
            </div>
            <div class="icon">
                <i class="ion ion-person-add"></i>
            </div>
            <a href="#" class="small-box-footer">عرض <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box" style="background-color: #caa46e ;text-align: center">
            <div class="inner">
                <h3>{{ App\Models\Store::selection()->count() }}</h3>

                <p>المخازن</p>
            </div>
            <div class="icon">
                <i class="ion ion-pie-graph"></i>
            </div>
            <a href="{{ route("admin.stores") }}" class="small-box-footer">عرض <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <!-- ./col -->
</div>
<!-- /.row -->
<div class="row">
    <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box" style="background-color: #96e6e3 ;text-align: center">
            <div class="inner">
                <h3>{{ App\Models\Account::selection()->count() }}</h3>
                <p>الحسابات المالية</p>
            </div>
            <div class="icon">
                <i class="ion ion-bag"></i>
            </div>
            <a href="{{ route("accounts.index") }}" class="small-box-footer">عرض <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box" style="background-color: #74c6c1 ;text-align: center">
            <div class="inner">
                <h3>{{ App\Models\Treasury_transaction::selection()->count() }}<sup style="font-size: 20px"></sup></h3>

                <p>حركات مالية</p>
            </div>
            <div class="icon">
                <i class="ion ion-stats-bars"></i>
            </div>
            <a href="#" class="small-box-footer">عرض <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box" style="background-color: #d17a7a ;text-align: center">
            <div class="inner">
                <h3>{{ App\Models\Uom::selection()->count() }}</h3>

                <p>الوحدات</p>
            </div>
            <div class="icon">
                <i class="ion ion-person-add"></i>
            </div>
            <a href="{{ route("admin.uoms") }}" class="small-box-footer">عرض <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box" style="background-color: #cae079 ;text-align: center">
            <div class="inner">
                <h3>{{ App\Models\Itemcard_category::selection()->count() }}</h3>

                <p>فئات الاصناف</p>
            </div>
            <div class="icon">
                <i class="ion ion-pie-graph"></i>
            </div>
            <a href="{{ route("itemcard_categories.index") }}" class="small-box-footer">عرض <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <!-- ./col -->
</div>
<!-- /.row -->
@endsection
@section('script')
@endsection
