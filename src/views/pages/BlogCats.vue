<template>
<div>



  <div class="page-wrapper">
    <div class="content container-fluid">

      <div class="row">
        <div class="col-md-9">
          <ul class="list-links mb-4">
            <li>
              <router-link :to="{name:'blog'}">  Blog List</router-link></li>
            <li class="active">  <router-link :to="{name:'blogCats'}">Categories</router-link></li>
          </ul>
        </div>
        <div class="col-md-3 text-md-end">
          <a href="#" class="btn btn-primary btn-add" data-bs-toggle="modal" data-bs-target="#addModal"><i class="feather-plus-square me-1"></i> Add Category</a>

        </div>
      </div>


      <div class="row">
        <div class="col-sm-12">
          <div class="card">
            <div class="card-header border-bottom-0">
              <div class="row align-items-center">
                <div class="col">
                  <h5 class="card-title">Categories</h5>
                </div>
                <div class="col-auto custom-list d-flex">
                  <div class="form-custom me-2">
                    <div id="tableSearch" class="dataTables_wrapper"></div>
                  </div>

                </div>
              </div>
            </div>
            <div class="card-body p-0">
              <div class="table-responsive">
                <table class="datatable table table-borderless hover-table" id="data-table">
                  <thead class="thead-light">
                  <tr>
                    <th>Sl</th>
                    <th>Category</th>

                    <th></th>
                  </tr>
                  </thead>
                  <tbody>
                  <tr v-for="(category,index) in categories.data" :key="category.id">
                    <td>#{{ index + 1 }}</td>
                    <td>
                      <h2 class="table-avatar">
                        <a href="#" data-bs-toggle="modal" data-bs-target="#editModal"><img class="avatar avatar-img" src="assets/img/products/product1.jpg" alt="User Image"></a>
                        <a href="#" data-bs-toggle="modal" data-bs-target="#editModal"><span>{{category.title}}</span></a>
                      </h2>
                    </td>

                    <td class="text-end">
                      <div class="actions">
                        <a @click.prevent="getUData(categories.id,categories.title)" class="text-black" href=""
                           data-bs-toggle="modal" :data-bs-target="'#edtModal'+categories.id">
                          <i class="feather-edit-3 me-1"></i> Edit
                        </a>
                        <a class="text-danger" href="" data-bs-toggle="modal"
                           :data-bs-target="'#dltModal'+categories.id">
                          <i class="feather-trash-2 me-1"></i> Delete
                        </a>
                      </div>
                    </td>

                    <div class="modal fade contentmodal" :id="'edtModal'+categories.id" tabindex="-1" aria-hidden="true">
                      <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content doctor-profile">
                          <div class="modal-header">
                            <h3 class="mb-0">Edit Category</h3>
                            <button type="button" class="close-btn" data-bs-dismiss="modal" aria-label="Close"><i class="feather-x-circle"></i></button>
                          </div>
                          <div class="modal-body">
                            <form>
                              <div class="add-wrap">
                                <div class="form-group form-focus">
                                  <input v-model="title" type="text" class="form-control floating">
                                  <label class="focus-label">Category Name<span class="text-danger">*</span></label>
                                </div>

                                <div class="submit-section">
                                  <button @click.prevent="updateCat" type="submit" class="btn btn-primary">
                                    Update
                                  </button>
                                </div>
                              </div>
                            </form>
                          </div>
                        </div>
                      </div>
                    </div>


                    <div class="modal fade contentmodal" :id="'dltModal'+categories.id" tabindex="-1" aria-hidden="true">
                      <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content doctor-profile">
                          <div class="modal-header border-bottom-0 justify-content-end">
                            <button type="button" class="close-btn" data-bs-dismiss="modal" aria-label="Close"><i class="feather-x-circle"></i></button>
                          </div>
                          <div class="modal-body">
                            <div class="delete-wrap text-center">
                              <div class="del-icon"><i class="feather-x-circle"></i></div>
                              <h2>Sure you Want to delete</h2>
                              <p>{{categories.title}}</p>
                              <div class="submit-section">
                                <a style="margin-right: 25px;" @click.prevent="dltCat(categories.id)"
                                   class="btn btn-success" data-bs-dismiss="modal">Yes</a>
                                <a href="#" class="btn btn-danger" data-bs-dismiss="modal">No</a>
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
            <li v-for="index in categories['maxPage']" :key="index" :class="[(page == index) ? 'active':'']">
              <a class="page-link" href="#" @click="nextPage(index)">{{ index }}</a>
            </li>

          </ul>
        </div>

        </div>
      </div>

    </div>
  </div>


  <div class="modal fade contentmodal" id="addModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content doctor-profile">
        <div class="modal-header">
          <h3 class="mb-0">Add Category</h3>
          <button type="button" class="close-btn" data-bs-dismiss="modal" aria-label="Close"><i class="feather-x-circle"></i></button>
        </div>
        <div class="modal-body">
          <form>
            <div class="add-wrap">
              <div class="form-group form-focus">
                <input v-model="title" type="text" class="form-control floating">
                <label class="focus-label">Category Name<span class="text-danger">*</span></label>
              </div>

              <div v-if="errors.length!=0" class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Error!</strong>
                <li style="text-transform: capitalize;" v-for="(error,index) in errors.fields">{{ index }}: {{ error }} </li>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>
              <div class="submit-section">
                <button @click.prevent="addCat()" type="submit" class="btn btn-primary btn-save">Save Changes</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>



</div>
</template>

<script>
export default {
name: "BlogCats",
  data() {

    return {
      errors:[],
      page: 1,
      id: '',
      title: '',
      categories: []
    }
  },
  methods: {
    // Blog cats FETCH request - AH
    viewCats() {
      this.axios.get("blog/cats")
          .then(response => {
            console.log((response.data))
            this.categories = response.data
          }).catch(error => {
        this.errorMessage = error.message;
        console.error("There was an error!", error);
      });
    },
    addCat() {
      this.axios.post("blog/cat", this.pBody({
        "title": this.title,
      })).then(response => {
        console.log((response.data))
        this.viewCats()
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
    updateCat() {
      // locations request - AH
      this.axios.post("blog/cat", this.pBody({
        "id": this.id,
        "title": this.name
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
    // // Cat DELETE request - AH
    dltCat(id) {
      this.axios.post("blog/cat", this.pBody({
        "id": id
      })).then(response => {
        console.log((response.data))
        this.viewCats()

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
      this.title = nam
    },
    nextPage(pg) {
      this.page = pg
      this.viewCats()
    },
  },
  mounted() {
    this.viewCats()
  }
}
</script>

<style scoped>

</style>