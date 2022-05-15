<template>
  <div class="sidebar" id="sidebar">

    <div class="slimScrollDiv" style="position: relative; overflow: hidden; width: 100%; height: 662px;">
      <div class="sidebar-inner slimscroll" style="overflow: hidden; width: 100%; height: 662px;">
        <div id="sidebar-menu" class="sidebar-menu">
          <ul>
            <li class="menu-title"><span>Main</span></li>

 
            <li class="active">
              <a :href="`/`"><i class="feather-grid"></i> <span>Dashboard</span></a>
            </li>
            <li>

              <router-link :to="{name:'hospitals'}"><i class="fa fa-hospital-symbol"></i> <span>Hospitals</span></router-link>
            </li>
            <li>
              <router-link :to="{name:'specialities'}"><i class="feather-package"></i> <span>Dr. Specialities</span></router-link>
            </li>
            <li>
              <router-link :to="{name:'topDoctors'}"><i class="feather-star"></i> <span>Top Doctors</span></router-link>
            </li>
            <li>
              <router-link :to="{name:'doctors'}"><i class="feather-user-plus"></i> <span>Doctors</span></router-link>
            </li>

            <li>
              <router-link :to="{name:'patients'}"><i class="feather-users"></i> <span>Patients</span></router-link>
            </li>
            <li>
              <router-link :to="{name:'ambulance'}"><i class="fa fa-ambulance"></i> <span>Ambulance</span></router-link>
            </li>
            <li>
              <router-link :to="{name:'blog'}"><i class="feather-grid"></i> <span>Health Blog</span></router-link>
            </li>

            <li>
              <router-link :to="{name:'reports'}"><i class="feather-file-text"></i> <span> Reports</span></router-link>
            </li>
            <li>
              <router-link :to="{name:'locations'}"><i class="fa fa-search-location"></i> <span>Locations</span></router-link>
            </li>
            <li>
              <router-link :to="{name:'setting'}"><i class="feather-sliders"></i> <span> Settings</span></router-link>
            </li>
            <!--            <div class="dropdown">
                          <a href="#"><i class="feather-file-text"></i> <span> Reports</span></a>
                          <div class="dropdown-content">

                            <li><a href="appointment-report.html">Appointment Report</a></li>
                            <li><a href="income-report.html">Income Report</a></li>
                            <li><a href="invoice-report.html">Invoice Report</a></li>
                            <li><a href="user-reports.html">Users Report</a></li>

                          </div>
                        </div>
                     -->

          </ul>
        </div>

      </div>


    </div>
  </div>


</template>

<script>


export default {

  name: "Sidebar"

}
</script>

<style scoped>
.dropdown {
  position: relative;
  display: inline-block;
  margin-bottom: 5px;
  margin-left: 16px;
}

.dropdown-content {
  display: none;
  position: absolute;
  background-color: #f9f9f9;
  min-width: 160px;
  box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
  padding: 12px 16px;
  z-index: 1;
}

.dropdown:hover .dropdown-content {
  display: block;
}
</style>