<template>
  <div class="page-wrapper">
    <div class="content container-fluid pb-0">
      <h4 class="mb-3">Overview</h4>
      <div class="row">
        <div class="col-xl-3 col-sm-6 col-12">
          <div class="card">
            <div class="card-body">
              <div class="dash-widget-header">
<span class="dash-widget-icon bg-primary">
<i class="feather-user-plus"></i>
</span>
                <div class="dash-count">
                  <h5 class="dash-title">Doctors</h5>
                  <div class="dash-counts">
                    <p>{{vdr}}</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-xl-3 col-sm-6 col-12">
          <div class="card">
            <div class="card-body">
              <div class="dash-widget-header">
<span class="dash-widget-icon bg-blue">
<i class="feather-users"></i>
</span>
                <div class="dash-count">
                  <h5 class="dash-title">Patients</h5>
                  <div class="dash-counts">
                    <p>{{stat.users}}</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-xl-3 col-sm-6 col-12">
          <div class="card">
            <div class="card-body">
              <div class="dash-widget-header">
<span class="dash-widget-icon bg-warning">
<img :src="this.base_url+'assets/img/icon/calendar.png'" alt="User Image">
</span>
                <div class="dash-count">
                  <h5 class="dash-title">Appointment</h5>
                  <div class="dash-counts">
                    <p>{{stat.appointments}}</p>
                  </div>
                </div>
              </div>


            </div>
          </div>
        </div>
        <div class="col-xl-3 col-sm-6 col-12">
          <div class="card">
            <div class="card-body">
              <div class="dash-widget-header">
<span class="dash-widget-icon bg-danger">
<img :src="this.base_url+'assets/img/icon/chart.png'" alt="User Image">
</span>
                <div class="dash-count">
                  <h5 class="dash-title">Hospitals</h5>
                  <div class="dash-counts">
                    <p>{{stat.hospital}}</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="row">

        <div class="col-xl-7 d-flex">
          <div class="card flex-fill">
            <div class="card-header">
              <div class="row align-items-center">
                <div class="col">
                  <h5 class="card-title">Appointments</h5>
                </div>

              </div>
            </div>
            <div class="card-body">
              <div id="sales_chart"></div>
            </div>
          </div>
        </div>


        <div class="col-xl-5 d-flex">
          <div class="card flex-fill">
            <div class="card-header">
              <div class="row align-items-center">
                <div class="col">
                  <h5 class="card-title">Income Report</h5>
                </div>

              </div>
            </div>
            <div class="card-body">
              <div class="text-end w-100">
                <div class="income-rev">Total Revenue : <span>৳451254K</span></div>
              </div>
              <div id="income-report"></div>
            </div>
          </div>
        </div>

      </div>



      <div class="row">

        <div class="col-xl-4 col-md-6">
          <div class="card">
            <div class="card-header">
              <div class="row align-items-center">
                <div class="col">
                  <h5 class="card-title">Popular by Speciality </h5>
                </div>
                <div class="col-auto">
                  <select class="select">
                    <option>This Week</option>
                    <option>This Month</option>
                  </select>
                </div>
              </div>
            </div>
            <div class="card-body p-0">
              <div class="table-responsive">
                <table class="table table-borderless">
                  <tbody>
                  <tr class="speciality-item">
                    <td class="spl-name">
                      <div class="spl-box">
                        <img :src="this.base_url+'assets/img/icon/urology.png'" alt="User Image">
                      </div>
                      <div class="spl-count">
                        <h6>Urology</h6>
                        <p>Patients : 400</p>
                      </div>
                    </td>
                    <td class="con-revenue">
                      <p class="text-muted">Revenue</p>
                      <h6>৳6000K</h6>
                    </td>
                    <td class="spl-consult">
                      <p class="text-muted">Consultations</p>
                      <h6>200</h6>
                    </td>
                  </tr>
                  <tr class="speciality-item">
                    <td class="spl-name">
                      <div class="spl-box">
                        <img :src="this.base_url+'assets/img/icon/neurology.png'" alt="User Image">
                      </div>
                      <div class="spl-count">
                        <h6>Neurology</h6>
                        <p>Patients : 980 </p>
                      </div>
                    </td>
                    <td class="con-revenue">
                      <p class="text-muted">Revenue</p>
                      <h6>৳6000K</h6>
                    </td>
                    <td class="spl-consult">
                      <p class="text-muted">Consultations</p>
                      <h6>98</h6>
                    </td>
                  </tr>
                  <tr class="speciality-item">
                    <td class="spl-name">
                      <div class="spl-box">
                        <img :src="this.base_url+'assets/img/icon/ortho.png'" alt="User Image">
                      </div>
                      <div class="spl-count">
                        <h6>Orthopedic</h6>
                        <p>Patients : 600</p>
                      </div>
                    </td>
                    <td class="con-revenue">
                      <p class="text-muted">Revenue</p>
                      <h6>৳6000K</h6>
                    </td>
                    <td class="spl-consult">
                      <p class="text-muted">Consultations</p>
                      <h6>78</h6>
                    </td>
                  </tr>
                  <tr class="speciality-item">
                    <td class="spl-name">
                      <div class="spl-box">
                        <img :src="this.base_url+'assets/img/icon/cardio.png'" alt="User Image">
                      </div>
                      <div class="spl-count">
                        <h6>Urology</h6>
                        <p>Patients : 400</p>
                      </div>
                    </td>
                    <td class="con-revenue">
                      <p class="text-muted">Revenue</p>
                      <h6>৳6000K</h6>
                    </td>
                    <td class="spl-consult">
                      <p class="text-muted">Consultations</p>
                      <h6>65</h6>
                    </td>
                  </tr>
                  <tr class="speciality-item">
                    <td class="spl-name">
                      <div class="spl-box">
                        <img :src="this.base_url+'assets/img/icon/dental.png'" alt="User Image">
                      </div>
                      <div class="spl-count">
                        <h6>Urology</h6>
                        <p>Patients : 400</p>
                      </div>
                    </td>
                    <td class="con-revenue">
                      <p class="text-muted">Revenue</p>
                      <h6>৳6000K</h6>
                    </td>
                    <td class="spl-consult">
                      <p class="text-muted">Consultations</p>
                      <h6>59</h6>
                    </td>
                  </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>


        <div class="col-xl-4 col-md-6">
          <div class="row">
            <div class="col-md-6 pe-md-0">
              <div class="card cons-card mb-3">
                <h6>Consultaion Today</h6>
                <div id="income-month"></div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="card pat-card mb-1">
                <div class="card-body">
                  <p>New Patients</p>
                  <h3>45</h3>
                </div>
              </div>
              <div class="card pat-card mb-3">
                <div class="card-body">
                  <p>Old Patients</p>
                  <h3>45</h3>

                </div>
              </div>
            </div>
            <div class="col-md-12">
              <div class="card">
                <div class="card-header">
                  <div class="row align-items-center">
                    <div class="col">
                      <h5 class="card-title">Appointment Status</h5>
                    </div>
                    <div class="col-auto">
                      <select class="select">
                        <option>This Week</option>
                        <option>This Month</option>
                      </select>
                    </div>
                  </div>
                </div>
                <div class="card-body">
                  <div class="row">
                    <div class="col-md-6">
                      <div id="status_chart"></div>
                    </div>
                    <div class="col-md-6">
                      <div class="app-status">
                        <p>Completed Appointment</p>
                        <h6 class="text-primary">650</h6>
                        <p>Cancelled Appointment</p>
                        <h6>250</h6>
                        <p>Today's Appointment</p>
                        <h6>50</h6>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="col-lg-4">
          <div class="card">
            <div class="card-header">
              <div class="row">
                <div class="col">
                  <h5 class="card-title">Top Doctors</h5>
                </div>
              </div>
            </div>
            <div class="card-body p-0">
              <div class="table-responsive">
                <table class="table doc-table">
                  <tbody>
                  <tr>
                    <td>
                      <h2 class="table-avatar">
                        <a class="avatar-pos avatar-online" href="profile.html"><img class="avatar avatar-img" src="assets/img/profiles/avatar-05.jpg" alt="User Image"></a>
                        <a href="#" class="user-name"><span class="text-muted">Dr. Rayan</span> <span class="tab-subtext">Gyanoclogist</span></a>
                      </h2>
                    </td>
                    <td><span class="table-rating"><i class="fas fa-star me-2"></i> 4.5</span></td>
                    <td class="text-right"><span class="text-muted">200 Patients</span></td>
                  </tr>    <tr>
                    <td>
                      <h2 class="table-avatar">
                        <a class="avatar-pos avatar-online" href="profile.html"><img class="avatar avatar-img" src="assets/img/profiles/avatar-05.jpg" alt="User Image"></a>
                        <a href="#" class="user-name"><span class="text-muted">Dr. Rayan</span> <span class="tab-subtext">Gyanoclogist</span></a>
                      </h2>
                    </td>
                    <td><span class="table-rating"><i class="fas fa-star me-2"></i> 4.5</span></td>
                    <td class="text-right"><span class="text-muted">200 Patients</span></td>
                  </tr>
                  <tr>
                    <td>
                      <h2 class="table-avatar">
                        <a class="avatar-pos avatar-online" href="profile.html"><img class="avatar avatar-img" src="assets/img/profiles/avatar-10.jpg" alt="User Image"></a>
                        <a href="#" class="user-name"><span class="text-muted">Dr. Bea</span> <span class="tab-subtext">Dentist</span></a>
                      </h2>
                    </td>
                    <td><span class="table-rating"><i class="fas fa-star me-2"></i> 4.9</span></td>
                    <td class="text-right"><span class="text-muted">180 Patients</span></td>
                  </tr>
                  <tr>
                    <td>
                      <h2 class="table-avatar">
                        <a class="avatar-pos avatar-offline" href="profile.html"><img class="avatar avatar-img" src="assets/img/profiles/avatar-11.jpg" alt="User Image"></a>
                        <a href="#" class="user-name"><span class="text-muted">Dr. Monroe</span> <span class="tab-subtext">Hair Specialities</span></a>
                      </h2>
                    </td>
                    <td><span class="table-rating"><i class="fas fa-star me-2"></i> 4.8</span></td>
                    <td class="text-right"><span class="text-muted">160 Patients</span></td>
                  </tr>
                  <tr>
                    <td>
                      <h2 class="table-avatar">
                        <a class="avatar-pos avatar-offline" href="profile.html"><img class="avatar avatar-img" src="assets/img/profiles/avatar-13.jpg" alt="User Image"></a>
                        <a href="#" class="user-name"><span class="text-muted">Dr. Lester</span> <span class="tab-subtext">Orthopaedics</span></a>
                      </h2>
                    </td>
                    <td><span class="table-rating"><i class="fas fa-star me-2"></i> 4.7</span></td>
                    <td class="text-right"><span class="text-muted">140 Patients</span></td>
                  </tr>
                  <tr>
                    <td>
                      <h2 class="table-avatar">
                        <a class="empty-user" href="profile.html"><i class="feather-user"></i> </a>
                        <a href="#" class="user-name"><span class="text-muted">Dr. Clint</span> <span class="tab-subtext">Neurology</span></a>
                      </h2>
                    </td>
                    <td><span class="table-rating"><i class="fas fa-star me-2"></i> 4.6</span></td>
                    <td class="text-right"><span class="text-muted">120 Patients</span></td>
                  </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>

      </div>


    </div>
  </div>


</template>

<script>
export default {
name: "Home",
  data() {
    return {

      page: 1,
      id: '',
      stat: [],
      vdr:''
    }
  },
  methods: {
    // Blog cats FETCH request - AH
    viewStat() {
      this.axios.get("sitedata/stat")
          .then(response => {
            console.log((response.data))
            this.stat = response.data.data
            this.vdr=this.stat.doctor.verified
          }).catch(error => {
        this.errorMessage = error.message;
        console.error("There was an error!", error);
      });
    },




  },
  mounted() {
    this.viewStat()
  }
}
</script>

<style scoped>

</style>