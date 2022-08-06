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
                    <h5 class="card-title">Top Doctors list</h5>
                  </div>


                  <div class="col-auto d-flex flex-wrap">

                    <div class="col-md-3 text-md-end">
                      <router-link :to="{name:'TDAdd'}" class="btn btn-primary btn-blog mb-3"><span>Add Top Doctor</span></router-link>
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

                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="(doctor,index) in doctors.data" :key="doctor.id">
                      <td>#{{ index + 1 }}</td>
                      <td>
                        <h2 class="table-avatar">
                          <a href="#" class="spl-img"><img :src="this.getPP(doctor)" class="img-fluid"
                                                           alt="User Image"></a>
                          <a :href="doctor.id"><span> {{ doctor.title }}
                          <br>
                            @{{ doctor.username }}
                          </span></a>
                        </h2>
                      </td>
                      <td>{{ doctor.sect }}</td>
                      <td>{{ doctor.qualification }}</td>
                      <td>{{ doctor.fee }}</td>
                      <td>{{ doctor.follow_up_fee }}</td>

                      <div class="modal fade contentmodal" :id="'dltModal'+doctor.id" tabindex="-1"
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
      page: 1,
      hos:'',
      sec:'',
      id: '',
      name: '',
      doctors: []
    }
  },
  methods: {
    // Specialities FETCH request - AH
    viewDocs() {
      this.axios.get("sitedata/top")
          .then(response => {
            console.log((response.data))
            this.doctors = response.data
          }).catch(error => {
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
  }
}
</script>

<style scoped>

</style>