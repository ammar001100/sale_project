<aside class="main-sidebar sidebar-dark-primary elevation-4 sidebar_style">
    <!-- Brand Logo -->
    <a href="{{ route('admin.setting.general') }}" class="brand-link">
        <img src="{{ URL::asset('assets/admin/uploads/admin_sttings_imgs/' . auth()->user()->generalSetting->photo) }}" alt="صورة" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">ammar.com</span>
    </a>
    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{ URL::asset('assets/admin/dist/img/avatar04.png') }}" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">{{ auth()->user()->name }}</a>
            </div>
        </div>
        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- الرئيسية -->
                <li class="nav-item">
                    <a href="{{ route('dashboard') }}" class="nav-link {{ request()->is('admin') ? 'active' : '' }}">
                        <i class="fa fa-home"></i>
                        <p>الرئيسية</p>
                    </a>
                </li>
                <!-- الضبط العام -->
                <li class="nav-item has-treeview {{ request()->is('admin/setting*') || request()->is('admin/treasuries*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ request()->is('admin/setting*') || request()->is('admin/treasuries*') ? 'active' : '' }}">
                        <i class="nav-icon fab fa-whmcs"></i>
                        <p>
                            الضبط العام
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview bg-primary">
                        <li class="nav-item">
                            <a href="{{ route('admin.setting.general') }}" class="nav-link {{ request()->is('admin/setting*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>بيانات الشركة</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.treasuries') }}" class="nav-link {{ request()->is('admin/treasuries*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-archive"></i>
                                <p>
                                    الخزن
                                </p>
                            </a>
                        </li>
                    </ul>
                </li>
                <!-- ضبط المخازن -->
                <li class="nav-item has-treeview {{ request()->is('admin/sales_matrial_types*') ||
                    request()->is('admin/stores*') ||
                    request()->is('admin/uoms*') ||
                    request()->is('admin/item_cards*') ||
                    request()->is('admin/itemcard_categories*')
                        ? 'menu-open'
                        : '' }}">
                    <a href="#" class="nav-link {{ request()->is('admin/sales_matrial_types*') ||
                        request()->is('admin/stores*') ||
                        request()->is('admin/uoms*') ||
                        request()->is('admin/item_cards*') ||
                        request()->is('admin/itemcard_categories*')
                            ? 'active'
                            : '' }}">
                        <i class="nav-icon fas fa-hospital"></i>
                        <p>
                            الضبط المخازن
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview bg-primary">
                        <li class="nav-item">
                            <a href="{{ route('admin.stores') }}" class="nav-link {{ request()->is('admin/stores*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-hospital"></i>
                                <p>
                                    المخازن
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.uoms') }}" class="nav-link {{ request()->is('admin/uoms*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-hockey-puck"></i>
                                <p>
                                    الوحدات
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.sales_matrial_types') }}" class="nav-link {{ request()->is('admin/sales_matrial_types*') ? 'active' : '' }}">
                                <i class="nav-icon far fa-file-code"></i>
                                <p>
                                    فئات الفواتير
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('itemcard_categories.index') }}" class="nav-link {{ request()->is('admin/itemcard_categories*') ? 'active' : '' }}">
                                <i class="nav-icon fab fa-cloudsmith"></i>
                                <p>
                                    فئات الاصناف
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('item_cards.index') }}" class="nav-link {{ request()->is('admin/item_cards*') ? 'active' : '' }}">
                                <i class="nav-icon fab fa-cloudsmith"></i>
                                <p>
                                    الاصناف
                                </p>
                            </a>
                        </li>
                    </ul>
                </li>
                <!-- الحسابات المالية -->
                <li class="nav-item has-treeview {{ request()->is('admin/account_types*') ||
                    request()->is('admin/accounts*') ||
                    request()->is('admin/supplier_categories*') ||
                    request()->is('admin/suppliers*') ||
                    request()->is('admin/delegates*') ||
                    request()->is('admin/customers*')||
                    request()->is('admin/collect_transactions*')||
                    request()->is('admin/exchange_transactions*')
                        ? 'menu-open'
                        : '' }}">
                    <a href="#" class="nav-link {{ request()->is('admin/account_types*') ||
                        request()->is('admin/accounts*') ||
                        request()->is('admin/supplier_categories*') ||
                        request()->is('admin/suppliers*') ||
                        request()->is('admin/delegates*') ||
                        request()->is('admin/customers*')|| 
                        request()->is('admin/collect_transactions*')||
                        request()->is('admin/exchange_transactions*')
                            ? 'active'
                            : '' }}">
                        <i class="nav-icon fab fa-whmcs"></i>
                        <p>
                            الحسابات المالية
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview bg-primary">
                        <li class="nav-item">
                            <a href="{{ route('collect_transactions.index') }}" class="nav-link {{ request()->is('admin/collect_transactions*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p> شاشة تحصيل النقدية</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('exchange_transactions.index') }}" class="nav-link {{ request()->is('admin/exchange_transactions*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p> شاشة صرف النقدية</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('accounts.index') }}" class="nav-link {{ request()->is('admin/accounts*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>الحسابات المالية</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('customers.index') }}" class="nav-link {{ request()->is('admin/customers*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-users"></i>
                                <p>
                                    العملاء
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('suppliers.index') }}" class="nav-link {{ request()->is('admin/suppliers*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-users"></i>
                                <p>
                                    الموردين
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('delegates.index') }}" class="nav-link {{ request()->is('admin/delegates*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-users"></i>
                                <p>
                                    المناديب
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('account_types.index') }}" class="nav-link {{ request()->is('admin/account_types*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>انواع الحسابات المالية</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('supplier_categories.index') }}" class="nav-link {{ request()->is('admin/supplier_categories*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>فئات الموردين</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <!-- حركات مخزنية -->
                <li class="nav-item has-treeview {{ request()->is('admin/accuonts*') || request()->is('admin/supplier_orders*') ? 'menu-open bg-primary' : '' }}">
                    <a href="#" class="nav-link {{ request()->is('admin/accuonts*') || request()->is('admin/supplier_orders*') ? 'active' : '' }}">
                        <i class="nav-icon fab fa-whmcs"></i>
                        <p>
                            حركات مخزنية
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview bg-primary">
                        <li class="nav-item">
                            <a href="{{ route('supplier_orders.index') }}" class="nav-link {{ request()->is('admin/supplier_orders*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>فواتير المشتريات</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <!-- المبيعات -->
                <li class="nav-item has-treeview {{ request()->is('admin/sale_invoices*') || request()->is('admin/sale_invoices*') ? 'menu-open bg-primary' : '' }}">
                    <a href="#" class="nav-link {{ request()->is('admin/sale_invoices*') || request()->is('admin/sale_invoices*') ? 'active' : '' }}">
                        <i class="nav-icon fab fa-whmcs"></i>
                        <p>
                            المبيعات
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview bg-primary">
                        <li class="nav-item">
                            <a href="{{ route('sale_invoices.index') }}" class="nav-link {{ request()->is('admin/sale_invoices*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>فواتير المبيعات</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <!-- خدمات داخلية و خارجية -->
                <li class="nav-item has-treeview {{ request()->is('admin/accuonts*') || request()->is('admin/accuonts*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ request()->is('admin/accuonts*') || request()->is('admin/accuonts*') ? 'active' : '' }}">
                        <i class="nav-icon fab fa-whmcs"></i>
                        <p>
                            خدمات داخلية و خارجية
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview bg-primary">
                        <li class="nav-item">
                            <a href="{{ route('admin.setting.general') }}" class="nav-link {{ request()->is('admin/accuonts*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>بيانات الشركة</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <!-- حركة شفت الخزينة -->
                <li class="nav-item has-treeview {{ request()->is('admin/admin_shifts*') || request()->is('admin/admin_shifts*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ request()->is('admin/admin_shifts*') || request()->is('admin/admin_shifts*') ? 'active' : '' }}">
                        <i class="nav-icon fab fa-whmcs"></i>
                        <p>
                            حركات شفت الخزينة
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview bg-primary">
                        <li class="nav-item">
                            <a href="{{ route('admin_shifts.index') }}" class="nav-link {{ request()->is('admin/admin_shifts*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>شفتات خزن المستخدمين</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <!-- الصلاحيات و المستخدمين -->
                <li class="nav-item has-treeview {{ request()->is('admin/admin_accounts*') || request()->is('admin/admin_accounts*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ request()->is('admin/admin_accounts*') || request()->is('admin/admin_accounts*') ? 'active' : '' }}">
                        <i class="nav-icon fab fa-whmcs"></i>
                        <p>
                            الصلاحيات
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview bg-primary">
                        <li class="nav-item">
                            <a href="{{ route('admin_accounts.index') }}" class="nav-link {{ request()->is('admin/admin_accounts*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>المستخدمين</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <!-- التقارير -->
                <li class="nav-item has-treeview {{ request()->is('admin/accuonts*') || request()->is('admin/accuonts*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ request()->is('admin/accuonts*') || request()->is('admin/accuonts*') ? 'active' : '' }}">
                        <i class="nav-icon fab fa-whmcs"></i>
                        <p>
                            التقارير
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview bg-primary">
                        <li class="nav-item">
                            <a href="{{ route('admin.setting.general') }}" class="nav-link {{ request()->is('admin/accuonts*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>بيانات الشركة</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <!-- المراقبة و الدعم الفني -->
                <li class="nav-item has-treeview {{ request()->is('admin/accuonts*') || request()->is('admin/accuonts*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ request()->is('admin/accuonts*') || request()->is('admin/accuonts*') ? 'active' : '' }}">
                        <i class="nav-icon fab fa-whmcs"></i>
                        <p>
                            المراقبة والدعم الفني
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview bg-primary">
                        <li class="nav-item">
                            <a href="{{ route('admin.setting.general') }}" class="nav-link {{ request()->is('admin/accuonts*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>بيانات الشركة</p>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
