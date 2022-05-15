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
                    <h5 class="card-title">Ambulance list</h5>
                  </div>


                  <div class="col-auto d-flex flex-wrap">

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
              <div class="card-body p-0">
                <div class="table-responsive">
                  <table class="datatable table table-borderless hover-table" id="data-table">
                    <thead class="thead-light">
                    <tr>
                      <th>No.</th>
                      <th style="text-transform: capitalize;">Driver Name</th>
                      <th>Phone</th>
                      <th>Area</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="(ambulance,index) in ambulances.data" :key="ambulance.id">
                      <td>#{{ index + 1 }}</td>
                      <td>
                        <h2 class="table-avatar">
                          <a href="#" class="spl-img"><img :src="this.base_url+'/assets/img/icon/spec.png'" class="img-fluid"
                                                           alt="User Image"></a>
                          <a :href="ambulance.id"><span> ambulance.name </span></a>
                        </h2>
                      </td>
                      <td>Phone</td>
                      <td>Thana</td>
                      <td class="text-end">
                        <div class="actions">

                          <a class="text-danger" href="" data-bs-toggle="modal"
                             :data-bs-target="'#dltModal'+ambulance.id">
                            <i class="feather-trash-2 me-1"></i> Verify
                          </a>
                        </div>
                      </td>

                      <div class="modal fade contentmodal" :id="'dltModal'+ambulance.id" tabindex="-1"
                           aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">

                          <div class="modal-content doctor-profile">
                            <div class="modal-header border-bottom-0 justify-content-end">
                              <button type="button" class="close-btn" data-bs-dismiss="modal" aria-label="Close"><i
                                  class="feather-x-circle"></i></button>
                            </div>
                            <div class="modal-body">
                              <form>
                                <div class="delete-wrap text-center">
                                  <div class="del-icon"><i class="feather-x-circle"></i></div>
                                  <h2>Sure you Want to Verify</h2>
                                  <p> ambulance.name </p>
                                  <div class="submit-section">
                                    <a style="margin-right: 25px;" @click.prevent="verifyAmb(ambulance.id)"
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
                <li v-for="index in ambulances['maxPage']" :key="index" :class="[(page == index) ? 'active':'']">
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
  name: "Ambulance",
  data() {
    return {
      page: 1,
      hos:'',
      sec:'',
      id: '',
      name: '',
      ambulances: []
    }
  },
  methods: {
    // Specialities FETCH request - AH
    viewAmbs() {
      this.axios.get("ambulance/list/"+this.page)
          .then(response => {
            console.log((response.data))
            this.ambulances = response.data
          }).catch(error => {
        this.errorMessage = error.message;
        console.error("There was an error!", error);
      });
    },

    verifyAmb(id) {
      // locations request - AH
      this.axios.post("doctor/verify", this.pBody({
        "id": id
      })).then(response => {
        console.log((response.data))
        this.viewAmbs()
        $('.close-btn').click();
        if (response.data.success == true) {
          this.toast(response.data.message, "", "success")
        } else {
          this.toast(response.data.error, "", "danger")
        }

      }).catch(error => {
        this.errorMessage = error.message;
        console.error("There was an error!", error);
      });
    },
    // // specialities DELETE request - AH


    nextPage(pg) {
      this.page = pg
      this.viewAmbs()
    },
  },
  mounted() {
    this.viewAmbs()
  }
}
</script>

<style scoped>

</style>