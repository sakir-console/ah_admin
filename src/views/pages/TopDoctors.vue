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
                      <th style="text-transform: capitalize;">Dr Name</th>
                      <th>Specialist</th>
                      <th>Hospital</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="(doctor,index) in doctors.data" :key="doctor.id">
                      <td>#{{ index + 1 }}</td>
                      <td>
                        <h2 class="table-avatar">
                          <a href="#" class="spl-img"><img :src="this.base_url+'/assets/img/icon/spec.png'" class="img-fluid"
                                                           alt="User Image"></a>
                          <a :href="doctor.id"><span> doctor.name </span></a>
                        </h2>
                      </td>
                      <td>Specialist</td>
                      <td>Hos</td>

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