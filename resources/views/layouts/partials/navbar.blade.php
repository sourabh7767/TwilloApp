<!-- BEGIN: Header-->
@php
    $userObj = auth()->user();
@endphp
<nav class="header-navbar navbar navbar-expand-lg align-items-center floating-nav navbar-light navbar-shadow container-xxl">
    <div class="navbar-container d-flex content">
        <ul class="nav navbar-nav align-items-center ms-auto">
            <li class="nav-item dropdown dropdown-user">
                <a class="nav-link dropdown-toggle dropdown-user-link" id="dropdown-user" href="#" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <div class="user-nav d-sm-flex d-none">
                        <span class="user-name fw-bolder">{{$userObj->full_name ? $userObj->full_name : $userObj->first_name}}</span>
                        <span class="user-status">Admin</span>
                    </div>
                    <span class="avatar">
                        <img class="round" src="{{$userObj->profile_image ? $userObj->profile_image : asset('images/theme/portrait/small/avatar-s-11.jpg')}}" alt="avatar" height="40" width="40">
                        <span class="avatar-status-online"></span>
                    </span>
                </a>
                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdown-user">
                    <a class="dropdown-item" href="{{route('user.profile')}}"><i class="me-50" data-feather="user"></i> Profile</a>
                    <a class="dropdown-item" href="{{route('user.updateProfile')}}"><i class="me-50" data-feather="edit"></i> Update Profile</a>
                    <a class="dropdown-item" href="{{route('user.changePassword')}}"><i class="me-50" data-feather="key"></i> Change Password</a>
                    
                    <a class="dropdown-item" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="me-50" data-feather="power"></i> Logout</a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </div>
            </li>
        </ul>
    </div>
</nav>
<!-- END: Header-->