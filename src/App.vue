<template>

  <layout></layout>

</template>



<script>
import Layout from "@/views/Layout";
export default {
  components: {Layout},
  beforeMount() {
    if(!localStorage.getItem('token')&& !location.pathname.match(/^\/login-/)){
      //window.location='http://localhost:8080/login'
      window.location=location.origin.replace('admin.','')+'/login';
    }
  }
}
</script>