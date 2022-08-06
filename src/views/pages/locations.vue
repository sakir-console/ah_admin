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
                    <h5 class="card-title">Locations</h5>
                  </div>


                  <div class="col-auto d-flex flex-wrap">
                    <div class="form-custom me-2">
                      <div id="level" class="dataTables_wrapper">

                        <select @change="changeLabel" v-model="label" class="form-select">
                          <option value="all" selected>Select Label</option>
                          <option value="country">Country</option>
                          <option value="district">District</option>
                          <option value="thana">Thana</option>
                        </select>
                      </div>
                    </div>
                    <div class="form-custom me-2">
                      <div id="tableSearch" class="dataTables_wrapper">
                        <div id="data-table_filter" class="dataTables_filter"><label> <input type="search"
                                                                                             class="form-control form-control-sm"
                                                                                             placeholder="Search..."
                                                                                             aria-controls="data-table"></label>
                        </div>
                      </div>
                    </div>


                    <a href="#" data-bs-toggle="modal" data-bs-target="#addModal" class="btn btn-primary btn-add">
                      <i class="feather-plus-square me-1"></i> Add Location</a>


                  </div>
                </div>
              </div>
              <div class="card-body p-0">
                <div class="table-responsive">
                  <table class="datatable table table-borderless hover-table" id="data-table">
                    <thead class="thead-light">
                    <tr>
                      <th>No.</th>
                      <th style="text-transform: capitalize;">{{label}}</th>
                      <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="(place,index) in places.data" :key="place.id">
                      <td>#{{index+1}}</td>
                      <td>
                        <h2 class="table-avatar">
                          <a href="#" class="spl-img"><img :src="this.base_url+'assets/img/icon/marker.png'" class="img-fluid"
                                                           alt="User Image"></a>
                          <a :href="place.id"><span>{{ place.name }}</span></a>
                        </h2>
                      </td>
                      <td class="text-end">
                        <div class="actions">
                          <a @click.prevent="getUData(place.id,place.name,place.label,place.of,place.lng,place.lat)" class="text-black" href="" data-bs-toggle="modal" :data-bs-target="'#edtModal'+place.id">
                            <i class="feather-edit-3 me-1"></i> Edit
                          </a>
                          <a class="text-danger" href="" data-bs-toggle="modal" :data-bs-target="'#dltModal'+place.id">
                            <i class="feather-trash-2 me-1"></i> Delete
                          </a>
                        </div>
                      </td>

                      <div class="modal fade contentmodal" :id="'dltModal'+place.id" tabindex="-1" aria-hidden="true">
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
                                  <p>{{place.name}}</p>
                                  <div class="submit-section">
                                    <a style="margin-right: 25px;" @click.prevent="dltLoc(place.id)" class="btn btn-success" data-bs-dismiss="modal">Yes</a>
                                    <a href="#" class="btn btn-danger" data-bs-dismiss="modal">No</a>
                                  </div>
                                </div>
                              </form>
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
                <li v-for="index in places['maxPage']" :key="index" :class="[(page == index) ? 'active':'']">
                  <a class="page-link" href="#" @click="nextPage(index)">{{ index }}</a>
                </li>

              </ul>
            </div>

          </div>
        </div>

      </div>
    </div>


    <div class="modal fade contentmodal" id="addModal" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" style="max-width: 85%">
        <div class="modal-content doctor-profile">
          <div class="modal-header">
            <h3 class="mb-0">Add Location</h3>
            <button type="button" class="close-btn" data-bs-dismiss="modal" aria-label="Close"><i
                class="feather-x-circle"></i></button>
          </div>
          <div class="modal-body">

              <div class="content container-fluid">
                  <div class="row">
                    <div class="col-xl-6 d-flex">
                      <div class="card flex-fill">
                        <div class="card-header">
                          <h4 class="card-title">Location Info</h4>
                        </div>
                        <div class="card-body">
                          <form action="#">
                            <div class="form-group row">
                              <label class="col-lg-3 col-form-label">Place Name</label>
                              <div class="col-lg-9">
                                <input v-model="name" type="text" class="form-control">
                              </div>
                            </div>

                            <div class="form-group row">
                              <label class="col-lg-3 col-form-label">Place TYPE</label>
                              <div class="col-lg-9">
                                <select v-model="add_label" @change="selectedLabel" class="form-select">
                                  <option selected>Location Type</option>
                                  <option value="country">Country</option>
                                  <option value="district">District</option>
                                  <option value="thana">Thana</option>
                                </select>
                              </div>
                            </div>

                            <div v-if="sD || sT" class="form-group row">
                              <label class="col-lg-3 col-form-label">Country</label>
                              <div class="col-lg-9">
                                <select v-model="parent_con" @change="getDis(parent_con)" class="form-select">

                                  <option v-for="(country,index) in countries.data" :key="country.id" :value="country.id">{{country.name}}</option>
                                </select>
                              </div>
                            </div>

                            <div v-if="sT" class="form-group row">
                              <label class="col-lg-3 col-form-label">District</label>
                              <div class="col-lg-9">
                                <select v-model="parent_dis" class="form-select">
                                  <option v-for="(district,index) in districts.data" :key="district.id" :value="district.id">{{district.name}}</option>
                                </select>
                              </div>
                            </div>
                            <div v-if="errors.length!=0" class="alert alert-danger alert-dismissible fade show" role="alert">
                              <strong>Error!</strong>
                              <li style="text-transform: capitalize;" v-for="(error,index) in errors.fields">{{ index }}: {{ error }} </li>
                              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                            <div class="text-end">
                              <button @click.prevent="addLoc" type="submit" class="btn btn-primary">Submit</button>
                            </div>
                          </form>
                        </div>
                      </div>
                    </div>
                    <div class="col-xl-6 d-flex">
                      <div class="card flex-fill">
                        <div class="card-header">
                          <h4 class="card-title">Map location</h4>
                        </div>
                        <div class="card-body">

                          <div class="row">
                            <div class="col-sm-12">
                              <div class="d-flex text-center" style="height: 10vh">
                                <div class="m-auto">
                                  <h4>Your Position</h4>
                                  Latitude: {{ currPos.lat.toFixed(2) }}, Longitude:
                                  {{ currPos.lng.toFixed(2) }}
                                </div>

                                <div class="m-auto">
                                  <h4>Select Position</h4>
                                  <span v-if="otherPos">
        Latitude: {{ otherPos.lat.toFixed(2) }}, Longitude:
        {{ otherPos.lng.toFixed(2) }}
      </span>
                                  <span v-else>Click the map to select a position</span>
                                </div>
                              </div>
                              <div ref="mapDiv" style="width: 100%; height: 65vh" />
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
    </div>






  </div>
</template>

<script>
import { computed, ref, onMounted, onUnmounted, watch } from 'vue'
import { useGeolocation } from '@/useGeolocation'
import { Loader } from '@googlemaps/js-api-loader'

const GOOGLE_MAPS_API_KEY = 'AIzaSyCLU6EjlJGFYQja_P4uOnP7o9vrKKDSqog'
export default {
  name: "locations",
  components: {Map},
  data() {
    return {
      errors:[],
      id:'',
      label: 'all',
      page: 1,
      area: '',
      places: [],
      parent:'',
      parent_con:'',
      parent_dis:'',
      parent_tha:'',
      add_label:'',
      name:'',
      place_lng:'',
      place_lat:'',
      sC:false,
      sD:false,
      sT:false,
      countries: [],
      districts: [],
      thanas: [],


    }
  },
  methods: {
    locations() {

      // locations request - AH
      this.axios.get("location/get/all/"+this.label+"/"+this.page)
          .then(response => {
            console.log((response.data))
            this.places = response.data
          })
          .catch(error => {
            this.errorMessage = error.message;
            console.error("There was an error!", error);
          });
    },
    dltLoc(id) {
      // locations request - AH
      this.axios.post("/location/remove",this.pBody({
        "id":id
      })).then(response => {
            console.log((response.data))
            this.locations()

            if(response.data.success==true)
            {this.toast(response.data.message,"","success")
            }else{this.toast(response.data.error,"","danger")}

          })
          .catch(error => {
            this.errorMessage = error.message;
            console.error("There was an error!", error);
          });
    },
    selectedLabel(){
      switch(this.add_label) {
        case 'country':
          this.parent=0
          this.sC=true
          this.sT=false
          this.sD=false
          break;
        case 'district':
         this.getCon()
          this.sD=true
          this.sC=false
          this.sT=false
          break;
        case 'thana':
          this.getCon()
          this.sT=true
          this.sC=false
          this.sD=false
          break;
        default:
          // code block
      }
    },
    getCon(){
      // locations request - AH
      this.axios.get("location/get/all/country/0")
          .then(response => {
            console.log((response.data))
            this.countries = response.data
            this.getDis(this.parent)
          })
          .catch(error => {
            this.errorMessage = error.message;
            console.error("There was an error!", error);
          });


    },
    getDis(con){
      // locations request - AH
      this.axios.get("location/get/"+con+"/district/0")
          .then(response => {
            console.log((response.data))
            this.districts = response.data
            this.getTha(this.parent)
          })
          .catch(error => {
            this.errorMessage = error.message;
            console.error("There was an error!", error);
          });


    },
    getTha(dis){
      // locations request - AH
      this.axios.get("location/get/"+dis+"/thana/0")
          .then(response => {
            console.log((response.data))
            this.thanas = response.data
          })
          .catch(error => {
            this.errorMessage = error.message;
            console.error("There was an error!", error);
          });


    },
    getParent(){
      if(this.add_label=='country'){
        return 0
      }
      if(this.add_label=='district'){
        return this.parent_con
      }
      if(this.add_label=='thana'){
        return this.parent_dis
      }
      return this.parent_tha
    },
    addLoc() {

      this.axios.post("/location/save",this.pBody({
        "name":this.name,
        "label":this.add_label,
        "parent":this.getParent(),
        "lat":this.otherPos.lat?.toFixed(4),
        "lng":this.otherPos.lng?.toFixed(4)
      })).then(response => {
            console.log((response.data))
            this.locations()


            if(response.data.success==true)
            {   $('.close-btn').click();
              this.toast(response.data.message,"","success")
            }else
              {

                this.errors=response.data
                this.toast(response.data.error,"","danger")}

          })
          .catch(error => {
            this.errorMessage = error.message;
            this.toast(error.message,"","danger")
            console.error("There was an error!", error.message);
          });
    },
    getUData(id,nam,lab,par,lg,lt) {
      console.log(lab)
      this.id = id;
      this.name=nam
      this.add_label=lab
      this.parent=par
      this.place_lng=lg
      this.place_lat=lt

    },
    updateLoc() {
      // locations request - AH
      this.axios.post("/location/save",this.pBody({
        "id":this.id,
        "name":this.name,
        "label":this.add_label,
        "parent":this.parent,
        "lat":this.place_lat,
        "lng":this.place_lng
      })).then(response => {
            console.log((response.data))
            this.locations()

            if(response.data.success==true)
            {  $('.close-btn').click();
              this.toast(response.data.message,"","success")
            }else{
              this.errors=response.data
              this.toast(response.data.error,"","danger")}

          })
          .catch(error => {
            this.errorMessage = error.message;
            console.error("There was an error!", error);
          });
    },
    nextPage(pg){
      this.page=pg
      this.locations()
    },
    changeLabel(){
      this.page=1
      this.locations()
    }

  },
  setup() {
    const { coords } = useGeolocation()
    const currPos = computed(() => ({
      lat: coords.value.latitude,
      lng: coords.value.longitude
    }))
    const otherPos = ref(null)
    const loader = new Loader({ apiKey: GOOGLE_MAPS_API_KEY })
    const mapDiv = ref(null)
    let map = ref(null)
    let clickListener = null
    onMounted(async () => {
      await loader.load()
      map.value = new google.maps.Map(mapDiv.value, {
        center: currPos.value,
        zoom: 7
      })
      clickListener = map.value.addListener(
          'click',
          ({

             latLng: { lat, lng } }) =>
              (otherPos.value = { lat: lat(), lng: lng() })
      )
    })
    onUnmounted(async () => {
      if (clickListener) clickListener.remove()
    })
    let line = null
    watch([map, currPos, otherPos], () => {
      if (line) line.setMap(null)
      if (map.value && otherPos.value != null)
        line = new google.maps.Marker({
          position: otherPos.value,
          icon:'https://img.icons8.com/fluent/48/000000/marker-storm.png',
          map: map.value
        })
    })
    const haversineDistance = (pos1, pos2) => {
      const R = 3958.8 // Radius of the Earth in miles
      const rlat1 = pos1.lat * (Math.PI / 180) // Convert degrees to radians
      const rlat2 = pos2.lat * (Math.PI / 180) // Convert degrees to radians
      const difflat = rlat2 - rlat1 // Radian difference (latitudes)
      const difflon = (pos2.lng - pos1.lng) * (Math.PI / 180) // Radian difference (longitudes)
      const d =
          2 *
          R *
          Math.asin(
              Math.sqrt(
                  Math.sin(difflat / 2) * Math.sin(difflat / 2) +
                  Math.cos(rlat1) *
                  Math.cos(rlat2) *
                  Math.sin(difflon / 2) *
                  Math.sin(difflon / 2)
              )
          )
      return d
    }
    const distance = computed(() =>
        otherPos.value === null
            ? 0
            : haversineDistance(currPos.value, otherPos.value)
    )
    return { currPos, otherPos, distance, mapDiv }
  },
  mounted() {
    this.locations()

  }
}
</script>

<style scoped>

</style>