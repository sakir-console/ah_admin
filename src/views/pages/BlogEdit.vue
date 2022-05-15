<template>

  <div class="page-wrapper">
    <div class="content container-fluid">

      <div class="row">
        <div class="col-md-12">
          <h5 class="mb-3">Edit Blog</h5>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group form-focus">
                <input type="text" class="form-control floating" value="Doccure – Making your clinic painless visit?">
                <label class="focus-label">Blog Title <span class="text-danger">*</span></label>
              </div>
              <div class="form-group form-focus">
                <select class="select">
                  <option>Category</option>
                  <option selected>Dermotology</option>
                  <option>Neurology</option>
                </select>
              </div>
              <div class="form-group form-focus">
                <select class="select" id="selectval">
                  <option>Blog Type</option>
                  <option selected>Standard Blog</option>
                  <option value="video">Video Blog</option>
                </select>
              </div>
              <div class="form-group form-focus">
                <textarea rows="4" class="form-control floating">Topical medication, also known as topical chemotherapy, is a type of skin cancer treatment where medication in the form of a cream or ointment is applied directly to the skin. The goal is to kill the cancerous cells over a period of time.If you have a basal or squamous cell carcinoma that has not spread to the lymph nodes, your doctor may recommend topical chemotherapy for treatment.If you are a candidate for topical chemotherapy, your Mercy Health doctor will evaluate your case and recommend a treatment plan.</textarea>
                <label class="focus-label">Blog Title <span class="text-danger">*</span></label>
              </div>
              <div class="form-group">
                <div class="change-photo-btn  bg-grey">
                  <div>
                    <i class="feather-upload"></i>
                    <p>Upload File</p>
                  </div>
                  <input type="file" class="upload">
                </div>
              </div>
              <div class="upload-file">
                <h6>Uploaded files</h6>
                <div class="up-img">
                  <img class="avatar avatar-img" src="assets/img/profiles/avatar-05.jpg" alt="User Image">
                  <a href="javascript:void(0);" class="close-icon text-danger"><i class="feather-x-circle"></i></a>
                </div>
                <p>IMG_3892.jpg</p>
              </div>
              <div id="videoId" style="display: none">
                <div class="form-group form-focus">
                  <input type="text" class="form-control floating" value="AK6LS8NFI2">
                  <label class="focus-label">Video ID <span class="text-danger">*</span></label>
                </div>
              </div>
              <button type="submit" class="btn btn-primary save-btn">Save Changes</button>
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>

</template>

<script>
export default {
name: "BlogEdit",
  methods:{
    updateBlog() {
      // locations request - AH
      this.axios.post("blog/cat", this.pBody({
        "id": this.id,
        "title": this.title,
        "cat": this.cat,
        "text": this.text,
        "thumb": this.thumb,
      })).then(response => {
        console.log((response.data))
        this.viewBlogs()
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
  }
}
</script>

<style scoped>

</style>