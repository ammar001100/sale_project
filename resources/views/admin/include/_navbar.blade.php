<!--<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <div class="col-12">
        <a href="{{ route('admin.setting.general') }}" class="btn">
            <img src="{{ URL::asset('assets/admin/uploads/admin_sttings_imgs/' . auth()->user()->generalSetting->photo) }}"
                alt="صورة" class="brand-image img-circle elevation-3" style="opacity: .8">
            <span class="brand-text font-weight-light">{{ auth()->user()->generalSetting->system_name }}</span>
        </a>
    </div>
</nav>-->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="{{ route('dashboard') }}" class="nav-link">الرئيسية</a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="{{ route('admin.logout') }}" class="nav-link">تسجيل الخروج</a>
        </li>
    </ul>

    <!-- SEARCH FORM -->
    <form class="form-inline ml-3">
        <div class="input-group input-group-sm">
            <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
            <div class="input-group-append">
                <button class="btn btn-navbar" type="submit">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </div>
    </form>
    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
    <div id="loading-wrapper">
  <span class="spinner-grow text-success"></span>
  </div>
  <span id="timer-countdown"></span>
  <a href="{{ route('admin.setting.general') }}" class="btn">
            <img src="{{ URL::asset('assets/admin/uploads/admin_sttings_imgs/' . auth()->user()->generalSetting->photo) }}"
                alt="صورة" class="brand-image img-circle elevation-3" style="opacity: .8">
            <span class="brand-text font-weight-light"><b>{{ auth()->user()->generalSetting->system_name }}</b></span>
        </a>  
    </ul>
</nav>
