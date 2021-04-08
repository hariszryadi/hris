<div class="modal fade panelbox panelbox-left" id="sidebarPanel" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body p-0">

                <!-- profile box -->
                <div class="profileBox">
                    <div class="image-wrapper">
                        <img src="{{asset('storage/'.Auth::user()->empl->avatar)}}" alt="image" class="imaged rounded"
                        @if (Auth::user()->empl->gender == 'Pria')
                            onerror="this.src='{{asset('assets/admin/images/male.png')}}';"
                        @endif 
                            onerror="this.src='{{asset('assets/admin/images/female.png')}}';">
                    </div>
                    <div class="in">
                        <strong>{{Auth::user()->empl->empl_name}}</strong>
                        <div class="text-muted">
                            {{Auth::user()->empl->nip}}
                        </div>
                    </div>
                    <a href="javascript:;" class="close-sidebar-button" data-dismiss="modal">
                        <ion-icon name="close"></ion-icon>
                    </a>
                </div>
                <!-- * profile box -->

                <ul class="listview flush transparent no-line image-listview mt-2">
                    <li>
                        <a href="{{route('dashboard')}}" class="item">
                            <div class="icon-box bg-primary">
                                <ion-icon name="home-outline"></ion-icon>
                            </div>
                            <div class="in">
                                Dashboard
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="item">
                            <div class="icon-box bg-primary">
                                <ion-icon name="notifications-outline"></ion-icon>
                            </div>
                            <div class="in">
                                <div>Notifikasi</div>
                                <span class="badge badge-danger">5</span>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="{{route('leave')}}" class="item">
                            <div class="icon-box bg-primary">
                                <ion-icon name="calendar-outline"></ion-icon>
                            </div>
                            <div class="in">
                                Rencana Cuti
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="item">
                            <div class="icon-box bg-primary">
                                <ion-icon name="time-outline"></ion-icon>
                            </div>
                            <div class="in">
                                <div>Rencana Lembur</div>
                            </div>
                        </a>
                    </li>
                </ul>

            </div>

            <!-- sidebar buttons -->
            <div class="sidebar-buttons">
                <a href="{{route('profile')}}" class="button">
                    <ion-icon name="person-outline"></ion-icon>
                </a>
                <a href="#" class="button">
                    <ion-icon name="archive-outline"></ion-icon>
                </a>
                <a href="{{route('settings')}}" class="button">
                    <ion-icon name="settings-outline"></ion-icon>
                </a>
                <a href="{{route('logout')}}" class="button" id="logout">
                    <ion-icon name="log-out-outline"></ion-icon>
                </a>
            </div>
            <!-- * sidebar buttons -->
        </div>
    </div>
</div>