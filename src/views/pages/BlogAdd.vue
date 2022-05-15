<template>
  <div class="page-wrapper">
    <div class="content container-fluid">

      <div class="row">
        <div class="col-md-12">
          <h5 class="mb-3">Add Blog</h5>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group form-focus">
                <input v-model="title" type="text" class="form-control floating">
                <label class="focus-label">Blog Title <span class="text-danger">*</span></label>
              </div>
              <div class="form-group form-focus">
                <select v-model="cat_opt" class="form-select">
                  <option v-for="(cat,index) in cats.data" :key="cat.id" :value="cat.id">{{cat.title}}</option>
                </select>
              </div>

              <div class="form-group form-focus">
                <textarea v-model="text" rows="4" class="form-control bg-grey floating"></textarea>
                <label class="focus-label">Blog Text <span class="text-danger">*</span></label>
              </div>
              <div class="form-group">
                <div v-if="showUploadProgress">
                  Uploading: {{ uploadPercent }} %
                </div>
                <div class="change-photo-btn  bg-grey">
                  <div>
                    <i class="feather-upload"></i>
                    <p>Upload File</p>
                  </div>
                  <input type="file" ref="photo" name="thumb" accept=".png, .jpg, .jpeg" @change="onAvatarChange"/>

                </div>
              </div>

              <button @click.prevent="addBlog()" type="submit" class="btn btn-primary save-btn">Save Changes</button>
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>

</template>

<script>
export default {
  name: "BlogAdd",

  data() {
    return {
      purl: '/blog-edit?id=',
      page: 1,
      id: '',
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
  methods: {


    addBlog(){
      if(this.$refs.photo){
        this.showUploadProgress = true
        this.processingUpload = true
        this.uploadPercent = 0
        let formData = new FormData()
        formData.append('thumb', this.thumb)
        formData.append('title', this.title)
        formData.append('cat', '2')
        formData.append('text', this.text)

        this.axios.post("blog/add", formData, {
          onUploadProgress: (progressEvent) => {
            this.uploadPercent = progressEvent.lengthComputable ? Math.round( (progressEvent.loaded * 100) / progressEvent.total ) : 0 ;
          }
        }).then( (response) => {
          this.err=false;
          this.errMsg='',
              this.msg=response.data.message;
          this.showUploadProgress = false
          this.processingUpload = false
          this.$emit('imageUrl', response.data.secure_url )
          this.profileUp += 1;
          if (response.data.success == true) {
            this.toast(response.data.message, "", "success")
          } else {
            this.toast(response.data.error, "", "danger")
          }
        })
            .catch( (error) => {
              if(error.response){
                this.err=true;
                this.errMsg=error.response.data.data;
                console.log(error.message)
                this.msg=error.response.data.message;
              }else{
                console.log(error)
              }
              this.showUploadProgress = false
              this.processingUpload = false
            })
      }
    },
    onAvatarChange(e) {
      this.thumb = e.target.files[0]

    },
    // Blog cats FETCH request - AH
    viewCats() {
      this.axios.get("blog/cat")
          .then(response => {
            console.log((response.data))
            this.categories = response.data
          }).catch(error => {
        this.errorMessage = error.message;
        console.error("There was an error!", error);
      });
    },

  },
  mounted() {
    this.viewCats()
  }
}
</script>

<style scoped>

</style>