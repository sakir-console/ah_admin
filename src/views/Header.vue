<template>
  <div class="header">

    <div class="header-left">
      <a href="/" class="logo">
        <img :src="this.base_url+'assets/img/icon/logo2.png'" alt="Logo">
      </a>
      <a href="/" class="logo logo-small">
        <img :src="this.base_url+'assets/img/icon/favicon.png'" alt="Logo" width="30" height="30">
      </a>
      <a href=" " id="toggle_btn">
        <i class="feather-chevrons-left"></i>
      </a>
    </div>


    <div class="top-nav-search">
      <div class="main">
        <form class="search" method="post" action=" ">
          <div class="s-icon"><i class="fas fa-search"></i></div>
          <input type="text" class="form-control" placeholder="Start typing your Search..."/>

        </form>
      </div>
    </div>


    <a class="mobile_btn" id="mobile_btn">
      <i class="fas fa-bars"></i>
    </a>


    <ul class="nav nav-tabs user-menu">


      <li class="nav-item dropdown noti-nav">
        <a href="#" class="dropdown-toggle nav-link" data-bs-toggle="dropdown">
          <i class="feather-bell"></i> <span class="badge"></span>
        </a>
        <div class="dropdown-menu notifications">
          <div class="topnav-dropdown-header">
            <span class="notification-title">Notifications</span>
            <a href="" class="clear-noti"><i class="feather-more-vertical"></i></a>
          </div>

        </div>
      </li>


      <li class="nav-item dropdown main-drop">
        <a href="#" class="dropdown-toggle nav-link" data-bs-toggle="dropdown">
<span class="user-img">
<img :src="this.base_url+'assets/img/profiles/avatar-01.jpg'" alt="">
<span class="status online"></span>
</span>
        </a>
        <div class="dropdown-menu">
          <div class="user-header">
            <div class="avatar avatar-sm">
              <img :src="this.base_url+'assets/img/profiles/avatar-01.jpg'" alt="User Image" class="avatar-img rounded-circle">
            </div>
            <div class="user-text">
              <h6>Robert Haddin</h6>
              <p class="text-muted mb-0">Administrator</p>
            </div>
          </div>
          <a class="dropdown-item" href="profile.html"><i class="feather-user me-1"></i> My Profile</a>
          <a class="dropdown-item" href="profile.html"><i class="feather-edit me-1"></i> Edit Profile</a>
          <a class="dropdown-item" href="account-settings.html"><i class="feather-sliders me-1"></i> Account
            Settings</a>
          <hr class="my-0 ms-2 me-2">
          <a class="dropdown-item" href="login.html"><i class="feather-log-out me-1"></i> Logout</a>
        </div>
      </li>

    </ul>

  </div>

</template>

<script>


export default {
  name: "Header"
}
</script>

<style scoped>

</style>