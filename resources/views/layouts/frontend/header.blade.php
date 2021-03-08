<div class="appHeader bg-primary scrolled">
    <div class="left">
        <a href="#" class="headerButton" data-toggle="modal" data-target="#sidebarPanel">
            <ion-icon name="menu-outline"></ion-icon>
        </a>
    </div>
    <div class="pageTitle">
        @yield('pageTitle')
    </div>
</div>

<!-- Search Component -->
@include('layouts.frontend.searchbar')
<!-- * Search Component -->