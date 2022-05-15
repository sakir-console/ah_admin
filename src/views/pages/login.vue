<template>

</template>

<script>
export default {
name: "login",

  mounted(){
    const token = location.href.replace(location.origin+'/login-', '');
    localStorage.setItem('token',decodeURI(token))
    //http://localhost:8081/login-52%7C0.o878S7001165z380M626q7d5Uf65*affc.76w54585

    window.location = location.origin.replace('admin.','');
  }






}
</script>

<style scoped>

</style>