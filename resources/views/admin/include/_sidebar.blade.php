<aside class="main-sidebar sidebar-dark-primary elevation-4 sidebar_style">
    <!-- Brand Logo -->
    <a href="{{ route('admin.setting.general') }}" class="brand-link">
        <img src="{{ URL::asset('assets/admin/uploads/admin_sttings_imgs/' . auth()->user()->generalSetting->photo) }}"
            alt="صورة" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">ammar.com</span>
    </a>
    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{ URL::asset('assets/admin/dist/img/avatar04.png') }}" class="img-circle elevation-2"
                    alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">{{ auth()->user()->name }}</a>
            </div>
        </div>
        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">
                <li class="nav-item">
                    <a href="{{ route('dashboard') }}"
                        class="nav-link @if (url()->current() == route('dashboard')) active @else '' @endif ">
                        <i class="nav-icon fas fa-home"></i>
                        <p>
                            الرئيسية
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.treasuries') }}"
                        class="nav-link @if (url()->current() == route('admin.treasuries')) active @else '' @endif">
                        <i class="nav-icon fas fa-archive"></i>
                        <p>
                            الخزن
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.sales_matrial_types') }}"
                        class="nav-link @if (url()->current() == route('admin.sales_matrial_types')) active @else '' @endif">
                        <i class="nav-icon far fa-file-code"></i>
                        <p>
                            فئات الفواتير
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.stores') }}"
                        class="nav-link @if (url()->current() == route('admin.stores')) active @else '' @endif">
                        <i class="nav-icon fas fa-hospital"></i>
                        <p>
                            المخازن
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.uoms') }}"
                        class="nav-link @if (url()->current() == route('admin.uoms')) active @else '' @endif">
                        <i class="nav-icon fas fa-hockey-puck"></i>
                        <p>
                            الوحدات
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('itemcard_categories.index') }}"
                        class="nav-link @if (url()->current() == route('itemcard_categories.index')) active @else '' @endif">
                        <i class="nav-icon fab fa-cloudsmith"></i>
                        <p>
                            فئات الاصناف
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('item_cards.index') }}"
                        class="nav-link @if (url()->current() == route('item_cards.index')) active @else '' @endif">
                        <i class="nav-icon fab fa-cloudsmith"></i>
                        <p>
                            الاصناف
                        </p>
                    </a>
                </li>
                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link  @if (url()->current() == route('admin.setting.general')) active @else '' @endif">
                        <i class="nav-icon fab fa-whmcs"></i>
                        <p>
                            الضبط
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admin.setting.general') }}"
                                class="nav-link @if (url()->current() == route('admin.setting.general')) active @else '' @endif">
                                <i class="far fa-circle nav-icon"></i>
                                <p>الضبط العام</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="" class="nav-link @if (url()->current() == route('admin.setting.general')) active @else '' @endif">
                                <i class="far fa-circle nav-icon"></i>
                                <p>ضبط الحسابات</p>
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
