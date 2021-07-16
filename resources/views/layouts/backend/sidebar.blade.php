<div class="sidebar sidebar-main">
    <div class="sidebar-content">

        <!-- User menu -->
        <div class="sidebar-user">
            <div class="category-content">
                <div class="media">
                    <a href="#" class="media-left"><img src="{{asset('assets/admin/images/placeholder.jpg')}}" class="img-circle img-sm" alt=""></a>
                    <div class="media-body">
                        <span class="media-heading text-semibold">{{Auth::user()->name}}</span>
                        <div class="text-size-mini text-muted">
                            {{Auth::user()->email}}
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
        <!-- /user menu -->
        
        <!-- Main navigation -->
        <div class="sidebar-category sidebar-category-visible">
            <div class="category-content no-padding">
                <ul class="navigation navigation-main navigation-accordion">

                    <!-- Main -->
                    <li class="navigation-header"><span></span> <i class="icon-menu" title="Main pages"></i></li>
                    <li class="nav-item">
                        <a href="{{route('admin.dashboard')}}" class="nav-link"><i class="icon-home4"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>
                
                    <li class="nav-item nav-item-submenu">
                        <a href="#" class="nav-link"><i class="icon-cube3"></i>
                            <span>Master</span></a>
                        <ul>
                            <li class="nav-item {{request()->is('admin/division/*') ? 'active' : ''}}">
                                <a href="{{route('admin.division.index')}}">Divisi</a>
                            </li>
                
                            <li class="nav-item {{request()->is('admin/employee/*') ? 'active' : ''}}">
                                <a href="{{route('admin.employee.index')}}">Pegawai</a>
                            </li>

                            <li class="nav-item {{request()->is('admin/category-leave/*') ? 'active' : ''}}">
                                <a href="{{route('admin.categoryLeave.index')}}">Kategori Cuti/Izin</a>
                            </li>
                
                        </ul>
                    </li>
                
                    <li class="nav-item nav-item-submenu">
                        <a href="#" class="nav-link"><i class="icon-transmission"></i>
                            <span>Transaction</span></a>
                        <ul>
                            <li class="nav-item {{request()->is('admin/transaction-leave/*') ? 'active' : ''}}">
                                <a href="{{route('admin.transactionLeave.index')}}">Transaksi Cuti/Izin</a>
                            </li>

                            <li class="nav-item {{request()->is('admin/transaction-overtime/*') ? 'active' : ''}}">
                                <a href="{{route('admin.transactionOvertime.index')}}">Transaksi Lembur</a>
                            </li>

                        </ul>
                    </li>

                    <li class="nav-item nav-item-submenu">
                        <a href="#" class="nav-link"><i class="icon-file-upload"></i>
                            <span>Import</span></a>
                        <ul>
                            <li class="nav-item {{request()->is('admin/import/*') ? 'active' : ''}}">
                                <a href="{{route('admin.import.index')}}">Import Absensi</a>
                            </li>

                        </ul>
                    </li>

                    <li class="nav-item nav-item-submenu">
                        <a href="#" class="nav-link"><i class="icon-stack"></i>
                            <span>CMS</span></a>
                        <ul>
                            <li class="nav-item {{request()->is('admin/slider/*') ? 'active' : ''}}">
                                <a href="{{route('admin.slider.index')}}">Slider</a>
                            </li>

                        </ul>
                    </li>
                
                    <li class="nav-item nav-item-submenu">
                        <a href="#" class="nav-link"><i class="icon-user-lock"></i>
                            <span>User Config</span></a>
                        <ul>
            
                            <li class="nav-item {{request()->is('admin/account/*') ? 'active' : ''}}">
                                <a href="{{route('admin.account.index')}}">Account Pegawai</a>
                            </li>

                            <li class="nav-item {{request()->is('admin/role/*') ? 'active' : ''}}">
                                <a href="{{route('admin.role.index')}}">Role</a>
                            </li>

                            <li class="nav-item {{request()->is('admin/user-admin/*') ? 'active' : ''}}">
                                <a href="{{route('admin.userAdmin.index')}}">User Admin</a>
                            </li>
            
                        </ul>
                    </li>

                    <li class="nav-item nav-item-submenu">
                        <a href="#" class="nav-link"><i class="icon-download4"></i>
                            <span>Report</span></a>
                        <ul>
            
                            <li class="nav-item {{request()->is('admin/report/leave') ? 'active' : ''}}">
                                <a href="{{route('admin.report.leave')}}">Report Cuti/Izin</a>
                            </li>

                            <li class="nav-item {{request()->is('admin/report/overtime') ? 'active' : ''}}">
                                <a href="{{route('admin.report.overtime')}}">Report Lembur</a>
                            </li>
            
                        </ul>
                    </li>
                
                </ul>
            </div>
        </div>
        <!-- /main navigation -->

    </div>
</div>