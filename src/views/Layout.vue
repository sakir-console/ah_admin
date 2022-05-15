<template>

    <Header></Header>
    <Sidebar></Sidebar>
    <router-view/>


</template>

<script>
import Header from "@/views/Header";
import Sidebar from "@/views/Sidebar";


export default {
  name: "Layout",
  components: { Header,Sidebar}
}
</script>

<style scoped>

</style>