<template>
  <div class="page-wrapper">
    <div class="content container-fluid">

      <div class="row">
        <div class="col-md-9">
          <ul class="list-links mb-4">
            <li class="active"><a href="#">Blog List</a></li>
            <li>
              <router-link :to="{name:'blogCats'}"><span>Categories</span></router-link>
            </li>
          </ul>
        </div>
        <div class="col-md-3 text-md-end">
          <router-link :to="{name:'blogAdd'}" class="btn btn-primary btn-blog mb-3"><span>Add Blog</span></router-link>
        </div>
      </div>
      <div class="row">

        <div v-for="(blog,index) in blogs.data" :key="blog.id" class="col-md-6 col-xl-4 col-sm-12 d-flex">
          <div class="blog grid-blog flex-fill">
            <div class="blog-image">
              <a href=""><img class="img-fluid" :src="`https://amaderhospital.com`+blog.thumb" alt="Blog Image"></a>

            </div>
            <div class="blog-content">
              <ul class="entry-meta meta-item">
                <li>
                  <div class="post-author">
                    <a href="">
                      <img :src="blog.photo==''?this.base_url+'assets/img/profiles/avatar-02.jpg':`https://amaderhospital.com`+blog.photo" alt="Post Author">
                      <span>
<span class="post-title">{{ blog.name }}</span>
<span class="post-date">@ {{ blog.username }}</span>
</span>
                    </a>
                  </div>
                </li>
              </ul>
              <h3 class="blog-title"><a href="blog-details.html">{{ blog.title }}</a></h3>
              <p> {{ blog.text }}</p>
            </div>
            <div class="row">
              <div class="col"><a :href=purl+blog.id class="text-success"><i class="feather-edit-3 me-1"></i>
                Edit</a></div>

              <div class="col text-end">
                <a class="text-danger" href="" data-bs-toggle="modal"
                   :data-bs-target="'#dltModal'+blog.id">
                  <i class="feather-trash-2 me-1"></i> Delete
                </a>
              </div>
            </div>
          </div>
          <div class="modal fade contentmodal" :id="'dltModal'+blog.id" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
              <div class="modal-content doctor-profile">
                <div class="modal-header border-bottom-0 justify-content-end">
                  <button type="button" class="close-btn" data-bs-dismiss="modal" aria-label="Close"><i
                      class="feather-x-circle"></i></button>
                </div>
                <div class="modal-body">
                  <div class="delete-wrap text-center">
                    <div class="del-icon"><i class="feather-x-circle"></i></div>
                    <h2>Sure you Want to delete</h2>
                    <p>{{ blog.title }}</p>
                    <div class="submit-section">
                      <a style="margin-right: 25px;" @click.prevent="dltBlg(blog.id)"
                         class="btn btn-success" data-bs-dismiss="modal">Yes</a>
                      <a href="#" class="btn btn-danger" data-bs-dismiss="modal">No</a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

        </div>


      </div>

      <div class="row ">
        <div class="col-md-12">
          <div class="pagination-tab mt-md-5 d-flex justify-content-center">
            <div>
              <ul class="pagination mb-4">
                <li class="page-item disabled">
                  <a class="page-link" href="#" tabindex="-1">Pages:</a>
                </li>
                <li v-for="index in blogs['maxPage']" :key="index" :class="[(page == index) ? 'active':'']">
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
  name: "Blog",
  data() {
    return {
      errors:[],
      purl: '/blog-edit?id=',
      page: 1,
      id: '',
      title: '',
      cat: '',
      text: '',
      thumb: '',
      blogs: []
    }
  },
  methods: {
    // Blog cats FETCH request - AH
    viewBlogs() {
      this.axios.get("blog?uid&cat&page="+this.page+"&order")
          .then(response => {
            console.log((response.data))
            this.blogs = response.data
          }).catch(error => {
        this.errorMessage = error.message;
        console.error("There was an error!", error);
      });
    },
    addBlog() {
      this.axios.post("blog/add", this.pBody({
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
          this.errors=response.data
          this.toast(response.data.error, "", "danger")
        }

      }).catch(error => {
        this.errorMessage = error.message;
        console.error("There was an error!", error);
      });
    },
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
    // // Cat DELETE request - AH
    dltBlg(id) {
      this.axios.post("blog/remove", this.pBody({
        "id": id
      })).then(response => {
        console.log((response.data))
        this.viewBlogs()

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
      this.viewBlogs()
    },
  },
  mounted() {
    this.viewBlogs()
  }
}
</script>

<style scoped>

</style>