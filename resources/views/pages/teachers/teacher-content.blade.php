<x-private-layout>
    <!-- Navbar -->
    <x-navbar role="{{ auth()->user()->role->name }}">
        <div class="nav">
            <a class="nav-link" href="/teacher/dashboard">
                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                Dashboard
            </a>

            <x-nav-link idNumber="1" link_name="Students" icon_class="fa-solid fa-user-graduate">
                <x-sub-nav-link href="/teacher/students/add">View</x-sub-nav-link>
                <x-sub-nav-link href="/teacher/students/view">Add</x-sub-nav-link>
            </x-nav-link>

            <div class="sb-sidenav-menu-heading">Addons</div>
            <a class="nav-link" href="./teacher-profile.php">
                <div class="sb-nav-link-icon"><i class="fa fa-user" aria-hidden="true"></i></div>
                Profile
            </a>
            <a class="nav-link getPopup" href="./settings.php">
                <div class="sb-nav-link-icon"><i class="fa-solid fa-gear"></i></div>
                Settings
            </a>
            <a class="nav-link getPopup" href="/logout">
                <div class="sb-nav-link-icon"><i class="fa-solid fa-arrow-right-from-bracket"></i></div>
                Logout
            </a>
        </div>
    </x-navbar>
    <x-nav-top></x-nav-top>
    <div id="layoutSidenav_content">
        <div class="container-fluid">
            <!-- Slotted content -->
            @yield('content')
            <!--  -->
        </div>
    </div>
    <!--  -->

</x-private-layout>