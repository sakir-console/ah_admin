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
                    <h5 class="card-title">Dr. Specialities</h5>
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


                    <a href="#" data-bs-toggle="modal" data-bs-target="#addModal" class="btn btn-primary btn-add">
                      <i class="feather-plus-square me-1"></i> Add Speciality</a>


                  </div>
                </div>
              </div>
              <div class="card-body p-0">
                <div class="table-responsive">
                  <table class="datatable table table-borderless hover-table" id="data-table">
                    <thead class="thead-light">
                    <tr>
                      <th>No.</th>
                      <th style="text-transform: capitalize;">{{ label }}</th>
                      <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="(speciality,index) in specialities.data" :key="speciality.id">
                      <td>#{{ index + 1 }}</td>
                      <td>
                        <h2 class="table-avatar">
                          <a href="#" class="spl-img"><img :src="this.base_url+'/assets/img/icon/spec.png'" class="img-fluid"
                                                           alt="User Image"></a>
                          <a :href="speciality.id"><span>{{ speciality.name }}</span></a>
                        </h2>
                      </td>
                      <td class="text-end">
                        <div class="actions">
                          <a @click.prevent="getUData(speciality.id,speciality.name)" class="text-black" href=""
                             data-bs-toggle="modal" :data-bs-target="'#edtModal'+speciality.id">
                            <i class="feather-edit-3 me-1"></i> Edit
                          </a>
                          <a class="text-danger" href="" data-bs-toggle="modal"
                             :data-bs-target="'#dltModal'+speciality.id">
                            <i class="feather-trash-2 me-1"></i> Delete
                          </a>
                        </div>
                      </td>

                      <div class="modal fade contentmodal" :id="'dltModal'+speciality.id" tabindex="-1"
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
                                  <h2>Sure you Want to delete</h2>
                                  <p>{{ speciality.name }}</p>
                                  <div class="submit-section">
                                    <a style="margin-right: 25px;" @click.prevent="dltSpec(speciality.id)"
                                       class="btn btn-success" data-bs-dismiss="modal">Yes</a>
                                    <a href="#" class="btn btn-danger" data-bs-dismiss="modal">No</a>
                                  </div>
                                </div>
                              </form>
                            </div>
                          </div>
                        </div>
                      </div>

                      <div class="modal fade contentmodal" :id="'edtModal'+speciality.id" tabindex="-1"
                           aria-hidden="true">

                        <div class="modal-dialog modal-dialog-centered" style="max-width: 50%">
                          <div class="modal-content doctor-profile">
                            <div class="modal-header">
                              <h3 class="mb-0">Edit Speciality</h3>
                              <button type="button" class="close-btn" data-bs-dismiss="modal" aria-label="Close"><i
                                  class="feather-x-circle"></i></button>
                            </div>
                            <div class="modal-body">


                              <div class="content container-fluid">

                                <div class="row">
                                  <div class=" d-flex">
                                    <div class="card flex-fill">
                                      <div class="card-header">
                                        <h4 class="card-title">Speciality Info</h4>
                                      </div>
                                      <div class="card-body">
                                        <form action="#">
                                          <div class="form-group row">
                                            <label class="col-lg-3 col-form-label">Speciality Name</label>
                                            <div class="col-lg-9">
                                              <input v-model="name" type="text" class="form-control">
                                            </div>
                                          </div>
                                          <div class="text-end">
                                            <button @click.prevent="updateSpec" type="submit" class="btn btn-primary">
                                              Update
                                            </button>
                                          </div>
                                        </form>
                                      </div>
                                    </div>
                                  </div>

                                </div>


                              </div>
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
                <li v-for="index in specialities['maxPage']" :key="index" :class="[(page == index) ? 'active':'']">
                  <a class="page-link" href="#" @click="nextPage(index)">{{ index }}</a>
                </li>

              </ul>
            </div>

          </div>
        </div>

      </div>
    </div>

    <div class="modal fade contentmodal" id="addModal" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" style="max-width: 45%">
        <div class="modal-content doctor-profile">
          <div class="modal-header">
            <h3 class="mb-0">Add Speciality</h3>
            <button type="button" class="close-btn" data-bs-dismiss="modal" aria-label="Close"><i
                class="feather-x-circle"></i></button>
          </div>
          <div class="modal-body">

            <div class="content container-fluid">
              <div class="row">
                <div class="d-flex">
                  <div class="card flex-fill">
                    <div class="card-header">
                      <h4 class="card-title">Speciality Info</h4>
                    </div>
                    <div class="card-body">
                      <form action="#">
                        <div class="form-group row">
                          <label class="col-lg-3 col-form-label">Speciality Name</label>
                          <div class="col-lg-9">
                            <input v-model="name" type="text" class="form-control">
                          </div>
                        </div>

                        <div class="text-end">
                          <button @click.prevent="addSpec" type="submit" class="btn btn-primary">Submit</button>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>

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
  name: "Specialities",
  data() {
    return {
      page: 1,
      id: '',
      name: '',
      specialities: []
    }
  },
  methods: {
    // Specialities FETCH request - AH
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
    addSpec() {
      this.axios.post("doctor/sector", this.pBody({
        "name": this.name
      })).then(response => {
        console.log((response.data))
        this.viewSpec()
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
    updateSpec() {
      // locations request - AH
      this.axios.post("doctor/sector", this.pBody({
        "sector_id": this.id,
        "name": this.name
      })).then(response => {
        console.log((response.data))
        this.viewSpec()
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
    dltSpec(id) {
      this.axios.post("doctor/remove", this.pBody({
        "sector_id": id
      })).then(response => {
        console.log((response.data))
        this.viewSpec()

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
    getUData(id, nam) {
      this.id = id;
      this.name = nam
    },
    nextPage(pg) {
      this.page = pg
      this.locations()
    },
  },
  mounted() {
    this.viewSpec()
  }
}
</script>

<style scoped>

</style>