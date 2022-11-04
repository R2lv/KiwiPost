<header class="main-header">
    <!-- Logo -->
    <a href="{{ route('cms', ['all'=>'/']) }}" class="logo">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span class="logo-mini"><b>KI</b>WI</span>
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg"><b>KIWI</b>POST</span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </a>

        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <!-- Messages: style can be found in dropdown.less-->
                <li>
                    <a href="/">
                        <i class="fa fa-home"></i>
                    </a>
                </li>
                <li>
                    <a v-if="hasPermission('PARCEL_ADD')" @click.prevent="$router.push('/order/create')" href="#">
                        <i class="fa fa-plus"></i>
                    </a>
                </li>
                <!-- User Account: style can be found in dropdown.less -->
                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <img src="/dist/img/user2-160x160.jpg" class="user-image" alt="User Image">
                        <span class="hidden-xs">{{ auth()->user()->name }} {{ auth()->user()->surname }}</span>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- User image -->
                        <li class="user-header">
                            <img src="/dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">

                            <p>
                                {{ auth()->user()->name }} {{ auth()->user()->surname }}
                                <small>{{ trans('defaults.admin.member', ['date'=>Carbon\carbon::parse(auth()->user()->created_at)->format('d-m-Y')]) }}</small>
                            </p>
                        </li>
                        <!-- Menu Body -->
                        <li class="user-body">
                            <div class="row">
                                <div class="col-xs-6 text-center">
                                    <a href="#">{{ trans('defaults.admin.parcels') }} 0</a>
                                </div>
                                <div class="col-xs-6 text-center">
                                    <a href="#">{{ trans('defaults.admin.fails') }} 0</a>
                                </div>
                            </div>
                            <!-- /.row -->
                        </li>
                        <!-- Menu Footer-->
                        <li class="user-footer">
                            <div class="pull-left">
                                <a href="#" class="btn btn-default btn-flat">Profile</a>
                            </div>
                            <div class="pull-right">
                                <a href="#" class="btn btn-default btn-flat">{{ trans('defaults.logOut') }}</a>
                            </div>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
</header>