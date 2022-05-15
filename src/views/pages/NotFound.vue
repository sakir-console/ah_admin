<template>
  <div class="main-wrapper" style="align-items: center; color: #1f1f1f; display: flex;">
    <div class="header d-none">

      <ul class="nav nav-tabs user-menu">

        <li class="nav-item">
          <a href="#" id="dark-mode-toggle" class="dark-mode-toggle">
            <i class="feather-sun light-mode"></i><i class="feather-moon dark-mode"></i>
          </a>
        </li>

      </ul>

    </div>

    <div class="error-box">
      <img :src="this.base_url+'assets/img/404.png'" class="img-fluid" alt="404"/>
      <h2>Oops! This Page is Not Found.</h2>
      <p>The requested page dose not exist.</p>
      <a :href="`/`" class="btn btn-primary"><i class="feather-home me-2"></i>Back to Home</a>
    </div>

  </div>
</template>

<script>
export default {
  name: "NotFound"
}
</script>

<style scoped>

</style>