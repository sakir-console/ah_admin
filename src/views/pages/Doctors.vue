<template>
  <div>

    <div class="page-wrapper">
      <div class="content container-fluid">

        <div class="row">
          <div class="col-sm-12">
            <div class="card">
              <div class="card-header border-bottom-0">
                <div class="row align-items-center">
                  <div class="col">
                    <h5 class="card-title">Doctors list</h5>
                  </div>


                  <div class="col-auto d-flex flex-wrap">


                    <div class="col-auto d-flex flex-wrap">
                      <div v-if="errors.length!=0" class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Error!</strong>
                        <li style="text-transform: capitalize;" v-for="(error,index) in errors.fields">{{ index }}: {{ error }} </li>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                      </div>
                      <div class="form-custom me-2">
                        <div class="dataTables_wrapper">

                          <select v-model="hos" @change="viewDocs" class="form-select">
                            <option value="" selected>Hospital wise</option>
                            <option v-for="(hospital,index) in hospitals.data" :key="hospital.id" :value="hospital.id">
                              {{ hospital.name }}
                            </option>
                          </select>


                        </div>
                      </div>

                      <div class="form-custom me-2">
                        <div class="dataTables_wrapper">

                          <select v-model="spec" @change="viewDocs" class="form-select">
                            <option value="" selected>Select Specialist</option>
                            <option v-for="(speciality,index) in specialities.data" :key="speciality.id"
                                    :value="speciality.id">
                              {{ speciality.name }}
                            </option>
                          </select>


                        </div>
                      </div>

                      <div class="form-custom me-2">
                        <div class="dataTables_wrapper">

                          <select v-model="verified" @change="viewDocs" class="form-select">
                            <option value="" selected>Verification wise</option>
                            <option value="1">
                              Verified
                            </option>
                            <option value="0">
                             Not Verified
                            </option>
                          </select>


                        </div>
                      </div>


                      <div class="form-custom me-2">
                        <div id="tableSearch" class="dataTables_wrapper">
                          <div id="data-table_filter" class="dataTables_filter">
                            <label>
                              <input type="search" class="form-control form-control-sm" placeholder="Search..."
                                     aria-controls="data-table">
                            </label>
                          </div>
                        </div>
                      </div>



                    </div>


                  </div>
                </div>
              </div>
              <div class="card-body p-0">
                <div class="table-responsive">
                  <table class="datatable table table-borderless hover-table" id="data-table">
                    <thead class="thead-light">
                    <tr>
                      <th>No.</th>
                      <th style="text-transform: capitalize;">Dr Name</th>
                      <th>Specialist</th>
                      <th>Qualification</th>
                      <th>Fee</th>
                      <th>F-up Fee</th>
                      <th>Verification</th>

                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="(doctor,index) in doctors.data" :key="doctor.id">
                      <td>#{{ index + 1 }}</td>
                      <td>
                        <h2 class="table-avatar">
                          <a href="#" class="spl-img"><img :src="this.getPP(doctor)" class="img-fluid"
                                                           alt="User Image"></a>
                          <a :href="doctor.id"><span> {{ doctor.name }}
                          <br>
                            @{{ doctor.username }}
                          </span></a>
                        </h2>
                      </td>
                      <td>{{ doctor.sect_name }}</td>
                      <td>{{ doctor.qualification }}</td>
                      <td>{{ doctor.fee }}</td>
                      <td>{{ doctor.follow_up_fee }}</td>
                      <td>{{ doctor.verified == '0' ? '❌' : ' ✓' }}</td>
                      <td class="text-end" style="width: 10px;">
                        <div class="actions">

                          <a v-if="doctor.verified == '0'" class="text-danger btn" href="" data-bs-toggle="modal"
                             :data-bs-target="'#dltModal'+doctor.uid">
                            ✓ Verify
                          </a>
                          <a v-if="doctor.verified == '1'" class="text-danger btn" href="" data-bs-toggle="modal"
                             :data-bs-target="'#edtModal'+doctor.uid">
                            ❌ Disprove
                          </a>
                        </div>
                      </td>

                      <div class="modal fade contentmodal" :id="'dltModal'+doctor.uid" tabindex="-1"
                           aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">

                          <div class="modal-content doctor-profile">
                            <div class="modal-header border-bottom-0 justify-content-end">
                              <button type="button" class="close-btn" data-bs-dismiss="modal" aria-label="Close"><i
                                  class="feather-x-circle"></i></button>
                            </div>
                            <div  v-if="doctor.verified == '0'" class="modal-body">
                              <form>
                                <div class="delete-wrap text-center">
                                  <div class="del-icon"><i class="feather-x-circle"></i></div>
                                  <h2>Sure you Want to Verify</h2>
                                  <p>{{ doctor.name }} </p>
                                  <div class="submit-section">
                                    <a style="margin-right: 25px;" @click.prevent="verifyDoc(doctor.uid,'1','')"
                                       class="btn btn-success" data-bs-dismiss="modal">Yes</a>
                                    <a href="#" class="btn btn-danger" data-bs-dismiss="modal">No</a>
                                  </div>
                                </div>
                              </form>
                            </div>





                          </div>
                        </div>
                      </div>


                      <div class="modal fade contentmodal" :id="'edtModal'+doctor.uid" tabindex="-1"
                           aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">

                          <div class="modal-content doctor-profile">
                            <div class="modal-header border-bottom-0 justify-content-end">
                              <button type="button" class="close-btn" data-bs-dismiss="modal" aria-label="Close"><i
                                  class="feather-x-circle"></i></button>
                            </div>

                            <div  v-if="doctor.verified == '1'" class="modal-body">
                              <form>
                                <div class="delete-wrap text-center">
                                  <div class="del-icon"><i class="feather-x-circle"></i></div>
                                  <h2>Sure you Want to Disprove</h2>
                                  <p>{{ doctor.name }} </p>
                                  <div class="submit-section">
                                    <a style="margin-right: 25px;" @click.prevent="verifyDoc(doctor.uid,'0','')"
                                       class="btn btn-success" data-bs-dismiss="modal">Yes</a>
                                    <a href="#" class="btn btn-danger" data-bs-dismiss="modal">No</a>
                                  </div>
                                </div>
                              </form>
                            </div>





                          </div>
                        </div>
                      </div>

                    </tr>

                    </tbody>
                  </table>
                </div>
              </div>
            </div>
            <div>
              <ul class="pagination mb-4">
                <li class="page-item disabled">
                  <a class="page-link" href="#" tabindex="-1">Pages:</a>
                </li>
                <li v-for="index in doctors['maxPage']" :key="index" :class="[(page == index) ? 'active':'']">
                  <a class="page-link" href="#" @click="nextPage(index)">{{ index }}</a>
                </li>

              </ul>
            </div>

          </div>
        </div>

      </div>
    </div>

  </div>
</template>

<script>

export default {
  name: "Doctors",
  data() {

    return {
      appointmentUrl: '/appointment?doc=',
      loading: false,
      page: 1,
      NoData: false,

      verified: '1',
      spec: '',
      hos: '',
      doctors: [],
      hospitals: [],
      specialities: [],
      errors:[]

    }
  },
  methods: {
    // Specialities FETCH request - AH
    viewDocs() {
      this.loading = true
      this.axios.get("doctor?page=" + this.page + "&hospital=" + this.hos + "&sector=" + this.spec + "&verified=" + this.verified)
          .then(response => {
            this.loading = false
            if (response.data.data.length !== 0) {
              this.NoData = false
            } else {
              this.NoData = true
            }
            console.log((response.data))
            this.doctors = response.data
          }).catch(error => {
        this.errorMessage = error.message;
        console.error("There was an error!", error);
      });
    },

    verifyDoc(id, isVerify, rsn) {
      // locations request - AH
      this.axios.post("doctor/verify", this.pBody({
        "id": id,
        "verified": isVerify,
        "reason": rsn
      })).then(response => {
        console.log((response.data))
        this.viewDocs()
        $('.close-btn').click();
        if (response.data.success == true) {
          this.toast(response.data.message, "", "success")
        } else {
          this.errors=response.data
          this.toast(response.data.error, "", "danger")
        }

      }).catch(error => {
        this.errorMessage = error.message;
        console.error("There was an error!", error);
      });
    },
    // // specialities DELETE request - AH
    viewSpec() {
      this.axios.get("doctor/sectors")
          .then(response => {
            console.log((response.data))
            this.specialities = response.data
          }).catch(error => {
        this.errorMessage = error.message;
        console.error("There was an error!", error);
      });
    },

    hospitalView() {

      // locations request - AH
      this.axios.get("hospital/0/0")
          .then(response => {
            this.loading = false;
            console.log((response.data))
            this.hospitals = response.data
          })
          .catch(error => {
            this.errorMessage = error.message;
            console.error("There was an error!", error);
          });
    },
    nextPage(pg) {
      this.page = pg
      this.viewDocs()

    },
  },
  mounted() {
    this.viewDocs()
    this.viewSpec()
    this.hospitalView()
  }
}
</script>

<style scoped>

</style>