<template>

  <div class="page-wrapper">
    <div class="content container-fluid">

      <div class="row">
        <div class="col-md-12">
          <h5 class="mb-3">Update Blog</h5>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group form-focus">
                <input v-model="title" type="text" class="form-control floating">
                <label class="focus-label">Blog Title <span class="text-danger">*</span></label>
              </div>
              <div class="form-group form-focus">
                <select v-model="cat_id" class="form-select">
                  <option v-for="(cat,index) in cats.data" :key="cat.id" :value="cat.id">{{cat.title}}</option>
                </select>
              </div>

              <div class="form-group form-focus">
                <textarea v-model="text" rows="4" class="form-control bg-grey floating"></textarea>
                <label class="focus-label">Blog Text <span class="text-danger">*</span></label>
              </div>

              <div v-if="errors.length!=0" class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Error!</strong>
                <li style="text-transform: capitalize;" v-for="(error,index) in errors.fields">{{ index }}: {{ error }} </li>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>


              <button @click.prevent="updateBlog()" type="submit" class="btn btn-primary save-btn">Save Changes</button>
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>

</template>

<script>
let urlParams = new URLSearchParams(window.location.search);

export default {
name: "BlogEdit",

  data() {
    return {
      errors:[],
      page: 1,
      id: '',
      cat_id: '',
      title: '',
      cat_opt: '',
      text: '',
      thumb: '',
      blogs: [],
      cats: [],
      uploadPercent: 0,
      showUploadProgress: false,
      processingUpload: false,
      profileUp:0
    }
  },
  methods:{
    updateBlog() {
      // locations request - AH
      this.axios.post("blog/save", this.pBody({
        "id": urlParams.get("id"),
        "title": this.title,
        "cat": this.cat_id,
        "text": this.text
      })).then(response => {
        console.log((response.data))

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
    viewBlog() {

      this.axios.get("blog/"+urlParams.get("id"))
          .then(response => {
            console.log((response.data))
            this.title = response.data.data.title
            this.text = response.data.data.text
            this.cat_id = response.data.data.cat

          }).catch(error => {
        this.errorMessage = error.message;
        console.error("There was an error!", error);
      });
    },
    // Blog cats FETCH request - AH
    viewCats() {
      this.axios.get("blog/cats")
          .then(response => {
            console.log((response.data))
            this.cats = response.data
          }).catch(error => {
        this.errorMessage = error.message;
        console.error("There was an error!", error);
      });
    },



  },
  mounted() {
    this.viewCats()
    this.viewBlog()
  }
}
</script>

<style scoped>

</style>