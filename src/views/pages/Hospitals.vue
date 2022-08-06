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
                    <h5 class="card-title">Hospitals</h5>
                  </div>


                  <div class="col-auto d-flex flex-wrap">



                    <div class="form-custom me-2">
                      <div id="district" class="dataTables_wrapper">

                        <select v-model="parent_dis" @change="getTha(parent_dis)" class="form-select">
                          <option value="" selected>Select District</option>
                          <option v-for="(district,index) in districts.data" :key="district.id"
                                  :value="district.id">{{ district.name }}
                          </option>
                        </select>

                      </div>
                    </div>

                    <div class="form-custom me-2">
                      <div id="thana" class="dataTables_wrapper">

                        <select v-model="parent_tha" @change="hospitalView()" class="form-select">
                          <option value="" selected>Select Thana</option>
                          <option v-for="(thana,index) in thanas.data" :key="thana.id" :value="thana.id">
                            {{ thana.name }}
                          </option>
                        </select>
                      </div>
                    </div>


                    <div class="form-custom me-2">
                      <div id="tableSearch" class="dataTables_wrapper">
                        <div id="data-table_filter" class="dataTables_filter"><label> <input  @input="searchHospital" type="text" v-model="hosname"
                                                                                             class="form-control form-control-sm"
                                                                                             placeholder="Search..."
                                                                                             aria-controls="data-table"></label>
                        </div>
                      </div>
                    </div>


                    <a href="#" data-bs-toggle="modal" data-bs-target="#addModal" class="btn btn-primary btn-add">
                      <i class="feather-plus-square me-1"></i> Add Hospital</a>


                  </div>



                </div>
              </div>
              <div class="card-body p-0">
                <div class="table-responsive">
                  <table class="datatable table table-borderless hover-table" id="data-table">
                    <thead class="thead-light">
                    <tr>
                      <th>No.</th>
                      <th style="text-transform: capitalize;">Hospital Name</th>
                      <th style="text-transform: capitalize;">Upazila</th>
                      <th style="text-transform: capitalize;">District</th>
                      <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="(hospital,index) in hospitals.data" :key="hospital.id">
                      <td>#{{ index + 1 }}</td>
                      <td>
                        <h2 class="table-avatar">
                          <a href="#" class="spl-img"><img :src="this.base_url+'assets/img/icon/hospi.jpg'"
                                                           class="img-fluid"
                                                           alt="Hospital"></a>
                          <a :href="hospital.id"><span>{{ hospital.name }}</span></a>
                        </h2>
                      </td>
                      <td>
                        {{hospital.thana_name}}

                      </td>
                      <td>
                        {{hospital.district_name}}

                      </td>
                      <td class="text-end">
                        <div class="actions">
                          <a @click.prevent="getUData(parseInt(hospital.id),hospital.name,parseInt(hospital.beds),parseInt(hospital.icu),parseInt(hospital.nicu),parseInt(hospital.ccu),parseInt(hospital.dialysis),hospital.addr,parseInt(hospital.district),parseInt(hospital.thana),parseFloat(hospital.lng),parseFloat(hospital.lat))"
                             class="text-black" href="" data-bs-toggle="modal" :data-bs-target="'#edtModal'+hospital.id">
                            <i class="feather-edit-3 me-1"></i> Edit
                          </a>
                          <a class="text-danger" href="" data-bs-toggle="modal" :data-bs-target="'#dltModal'+hospital.id">
                            <i class="feather-trash-2 me-1"></i> Delete
                          </a>
                        </div>
                      </td>

                      <div class="modal fade contentmodal" :id="'dltModal'+hospital.id" tabindex="-1" aria-hidden="true">
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
                                  <p>{{ hospital.name }}</p>
                                  <div class="submit-section">
                                    <a style="margin-right: 25px;" @click.prevent="dltHos(hospital.id)"
                                       class="btn btn-success" data-bs-dismiss="modal">Yes</a>
                                    <a href="#" class="btn btn-danger" data-bs-dismiss="modal">No</a>
                                  </div>
                                </div>
                              </form>
                            </div>
                          </div>
                        </div>
                      </div>

                      <div class="modal fade contentmodal" :id="'edtModal'+hospital.id" tabindex="-1" aria-hidden="true">

                        <div class="modal-dialog modal-dialog-centered" style="max-width: 50%">
                          <div class="modal-content doctor-profile">
                            <div class="modal-header">
                              <h3 class="mb-0">Edit Hospital</h3>
                              <button type="button" class="close-btn" data-bs-dismiss="modal" aria-label="Close"><i
                                  class="feather-x-circle"></i></button>
                            </div>
                            <div class="modal-body">


                              <div class="content container-fluid">

                                <div class="row">
                                  <div class=" d-flex">
                                    <div class="card flex-fill">
                                      <div class="card-header">
                                        <h4 class="card-title">Hospital Info</h4>
                                      </div>
                                      <div class="card-body">
                                        <form action="#">
                                          <div class="form-group row">
                                            <label class="col-lg-3 col-form-label">Hospital Name</label>
                                            <div class="col-lg-9">
                                              <input v-model="name" type="text" class="form-control">
                                            </div>
                                          </div>

                                          <div class="form-group row">
                                            <label class="col-lg-3 col-form-label">Total Beds</label>
                                            <div class="col-lg-9">
                                              <input v-model="beds" type="text" class="form-control">
                                            </div>
                                          </div>
                                          <div class="form-group row">
                                            <label class="col-lg-3 col-form-label">Total ICU</label>
                                            <div class="col-lg-9">
                                              <input v-model="icu" type="text" class="form-control">
                                            </div>
                                          </div>
                                          <div class="form-group row">
                                            <label class="col-lg-3 col-form-label">Total NICU</label>
                                            <div class="col-lg-9">
                                              <input v-model="nicu" type="text" class="form-control">
                                            </div>
                                          </div>
                                          <div class="form-group row">
                                            <label class="col-lg-3 col-form-label">Total CCU</label>
                                            <div class="col-lg-9">
                                              <input v-model="ccu" type="text" class="form-control">
                                            </div>
                                          </div>
                                          <div class="form-group row">
                                            <label class="col-lg-3 col-form-label">Dialysis</label>
                                            <div class="col-lg-9">
                                              <input v-model="dialysis" type="text" class="form-control">
                                            </div>
                                          </div>










                                          <div class="form-group row">
                                            <label class="col-lg-3 col-form-label">Hospital Address</label>
                                            <div class="col-lg-9">
                                              <input v-model="area" type="text" class="form-control">
                                            </div>
                                          </div>
                                          <div class="form-group row">
                                            <label class="col-lg-3 col-form-label">District</label>
                                            <div class="col-lg-9">
                                              <select v-model="parent_dis" @change="getTha(parent_dis)" class="form-select">
                                                <option v-for="(district,index) in districts.data" :key="district.id"
                                                        :value="district.id">{{ district.name }}
                                                </option>
                                              </select>
                                            </div>
                                          </div>
                                          <div class="form-group row">
                                            <label class="col-lg-3 col-form-label">Upazila</label>
                                            <div class="col-lg-9">
                                              <select v-model="parent_tha" class="form-select">
                                                <option v-for="(thana,index) in thanas.data" :key="thana.id" :value="thana.id">
                                                  {{ thana.name }}
                                                </option>
                                              </select>
                                            </div>
                                          </div>



                                          <div v-if="errors.length!=0" class="alert alert-danger alert-dismissible fade show" role="alert">
                                            <strong>Error!</strong>
                                            <li style="text-transform: capitalize;" v-for="(error,index) in errors.fields">{{ index }}: {{ error }} </li>
                                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                          </div>
                                          <div class="text-end">
                                            <button @click.prevent="updateHos" type="submit" class="btn btn-primary">
                                              Update
                                            </button>
                                          </div>
                                        </form>
                                      </div>
                                    </div>
                                  </div>

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
                <li v-for="index in hospitals['maxPage']" :key="index" :class="[(page == index) ? 'active':'']">
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
            <h3 class="mb-0">Add Hospital</h3>
            <button type="button" class="close-btn" data-bs-dismiss="modal" aria-label="Close"><i
                class="feather-x-circle"></i></button>
          </div>
          <div class="modal-body">

            <div class="content container-fluid">
              <div class="row">
                <div class="col-xl-6 d-flex">
                  <div class="card flex-fill">
                    <div class="card-header">
                      <h4 class="card-title">Hospital Info</h4>
                    </div>
                    <div class="card-body">
                      <form action="#">
                        <div class="form-group row">
                          <label class="col-lg-3 col-form-label">Hospital Name</label>
                          <div class="col-lg-9">
                            <input v-model="name" type="text" class="form-control">
                          </div>
                        </div>
                        <div class="form-group row">
                          <label class="col-lg-3 col-form-label">Hospital Address</label>
                          <div class="col-lg-9">
                            <input v-model="area" type="text" class="form-control">
                          </div>
                        </div>
                        <div class="form-group row">
                          <label class="col-lg-3 col-form-label">Total Beds</label>
                          <div class="col-lg-9">
                            <input v-model="beds" type="text" class="form-control">
                          </div>
                        </div>
                        <div class="form-group row">
                          <label class="col-lg-3 col-form-label">Total ICU</label>
                          <div class="col-lg-9">
                            <input v-model="icu" type="text" class="form-control">
                          </div>
                        </div>
                        <div class="form-group row">
                          <label class="col-lg-3 col-form-label">Total NICU</label>
                          <div class="col-lg-9">
                            <input v-model="nicu" type="text" class="form-control">
                          </div>
                        </div>
                        <div class="form-group row">
                          <label class="col-lg-3 col-form-label">Total CCU</label>
                          <div class="col-lg-9">
                            <input v-model="ccu" type="text" class="form-control">
                          </div>
                        </div>
                        <div class="form-group row">
                          <label class="col-lg-3 col-form-label">Dialysis</label>
                          <div class="col-lg-9">
                            <input v-model="dialysis" type="text" class="form-control">
                          </div>
                        </div>




                        <div class="form-group row">
                          <label class="col-lg-3 col-form-label">District</label>
                          <div class="col-lg-9">
                            <select v-model="parent_dis" @change="getTha(parent_dis)" class="form-select">
                              <option v-for="(district,index) in districts.data" :key="district.id"
                                      :value="district.id">{{ district.name }}
                              </option>
                            </select>
                          </div>
                        </div>
                        <div class="form-group row">
                          <label class="col-lg-3 col-form-label">Upazila</label>
                          <div class="col-lg-9">
                            <select v-model="parent_tha" class="form-select">
                              <option v-for="(thana,index) in thanas.data" :key="thana.id" :value="thana.id">
                                {{ thana.name }}
                              </option>
                            </select>
                          </div>
                        </div>




                        <div v-if="errors.length!=0" class="alert alert-danger alert-dismissible fade show" role="alert">
                          <strong>Error!</strong>
                          <li style="text-transform: capitalize;" v-for="(error,index) in errors.fields">{{ index }}: {{ error }} </li>
                          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        <div class="text-end">
                          <button @click.prevent="addHos" type="submit" class="btn btn-primary">Submit</button>
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
                          <div ref="mapDiv" style="width: 100%; height: 65vh"/>
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


    <div v-if="loading" class="row ">
      <div class="col-md-12">
        <div class="pagination-tab mt-md-5 d-flex justify-content-center">
          <div>
            <div class="circle-loader">
              <div></div>
              <div></div>
              <div></div>
              <div></div>
              <div></div>
              <div></div>
              <div></div>
              <div></div>
            </div>

          </div>
        </div>
      </div>
    </div>


  </div>
</template>

<script>
import {computed, ref, onMounted, onUnmounted, watch} from 'vue'
import {useGeolocation} from '@/useGeolocation'
import {Loader} from '@googlemaps/js-api-loader'

const GOOGLE_MAPS_API_KEY = 'AIzaSyCLU6EjlJGFYQja_P4uOnP7o9vrKKDSqog'
export default {
  name: "Hospitals",
  components: {Map},
  data() {
    return {
      errors:[],
      loading: false,
      id: null,
      label: 'all',
      page: 1,
      area: '',
      hospitals: [],

      beds:'',
      icu:'',
      nicu:'',
      ccu:'',
      dialysis:'',

      add_label: 'thana',
      name: '',
      hosname: '',
      place_lng: '',
      place_lat: '',
      sC: false,
      sD: false,
      sT: false,

      parent: '',
      parent_con: '',
      parent_dis: '',
      parent_tha: '0',
      countries: [],
      districts: [],
      thanas: []


    }
  },
  methods: {
    hospitalView() {
      this.loading = true
      // locations request - AH
      this.axios.get("hospital/"+this.parent_tha+"/" + this.page)
          .then(response => {
            this.loading = false;
            console.log((response.data))
            this.hospitals = response.data
          })
          .catch(error => {
            this.errorMessage = error.message;
            console.error("There was an error!", error);
          });
    },


    searchHospital() {
      if (this.hosname == '') {
        this.hospitalView()
      } else {
        this.loading = true;

        //request - AH
        this.axios.get("hospital/search?q=" + this.hosname)
            .then(response => {
              this.loading = false;
              if (response.data.data.length !== 0) {
                this.NoData = false
              } else {
                this.NoData = true
              }
              console.log((response.data))
              this.hospitals = response.data
            })
            .catch(error => {
              this.errorMessage = error.message;
              console.error("There was an error!", error);
            });
      }

    },


    dltHos(id) {
      // locations request - AH
      this.axios.post("hospital/remove", this.pBody({
        "id": id
      })).then(response => {
        console.log((response.data))
        this.hospitalView()

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



    getDis() {
      // locations request - AH
      this.axios.get("location/get/" + 1 + "/district/0")
          .then(response => {
            console.log((response.data))
            this.districts = response.data
            this.getTha(this.parent)
            this.hospitalView()
          })
          .catch(error => {
            this.errorMessage = error.message;
            console.error("There was an error!", error);
          });


    },
    getTha(dis) {
      // locations request - AH
      this.axios.get("location/get/" + dis + "/thana/0")
          .then(response => {
            console.log((response.data))
            this.thanas = response.data

          }).catch(error => {
        this.errorMessage = error.message;
        console.error("There was an error!", error);
      });


    },

    addHos() {

      this.axios.post("/hospital/save", this.pBody({
        "name": this.name,
        "icu": this.icu,
        "nicu": this.nicu,
        "beds": this.beds,
        "ccu": this.ccu,
        "dialysis": this.dialysis,
        "addr": this.area,




        "thana": this.parent_tha,
        "lat": this.otherPos.lat?.toFixed(4),
        "lng": this.otherPos.lng?.toFixed(4)
      })).then(response => {
        console.log((response.data))
        this.hospitalView()


        if (response.data.success == true) {
          $('.close-btn').click();
          this.toast(response.data.message, "", "success")
        } else {
          this.errors=response.data
          this.toast(response.data.error, "", "danger")
        }

      })
          .catch(error => {
            this.errorMessage = error.message;
            this.toast(error.message, "", "danger")
            console.error("There was an error!", error.message);
          });
    },
    getUData(id, nam,beds,icu,nicu,ccu,dialysis, addr,dis, tha, lg, lt) {
       console.log(id)
      this.id = id
      this.name = nam
      this.beds = beds
      this.icu = icu
      this.nicu = nicu
      this.ccu = ccu
      this.dialysis = dialysis
      this.area = addr

     // this.parent_dis = dis
      this.parent_tha = tha
      this.place_lng = lg
      this.place_lat = lt

    },
    updateHos() {

      this.axios.post("/hospital/save", this.pBody({
        "id": this.id,
        "name": this.name,
        "icu": this.icu,
        "nicu": this.nicu,
        "beds": this.beds,
        "ccu": this.ccu,
        "dialysis": this.dialysis,
        "addr": this.area,


        "thana": this.parent_tha,
        "lat": this.place_lat,
        "lng": this.place_lng
      })).then(response => {
        console.log((response.data))
        this.parent_con= '',
        this.parent_dis= '',
        this.hospitalView()

        if (response.data.success == true) {
          $('.close-btn').click();
          this.toast(response.data.message, "", "success")
        } else {
          this.errors=response.data
          this.toast(response.data.error, "", "danger")
        }

      })
          .catch(error => {
            this.errorMessage = error.message;
            console.error("There was an error!", error);
          });
    },
    nextPage(pg) {
      this.page = pg
      this.hospitalView()
    },
    changeLabel() {
      this.page = 1
      this.hospitalView()
    }

  },
  setup() {
    const {coords} = useGeolocation()
    const currPos = computed(() => ({
      lat: coords.value.latitude,
      lng: coords.value.longitude
    }))
    const otherPos = ref(null)
    const loader = new Loader({apiKey: GOOGLE_MAPS_API_KEY})
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

             latLng: {lat, lng}
           }) =>
              (otherPos.value = {lat: lat(), lng: lng()})
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
          icon: 'https://img.icons8.com/fluent/48/000000/marker-storm.png',
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
    return {currPos, otherPos, distance, mapDiv}
  },
  mounted() {
    this.getDis()
    this.hospitalView()

  }
}
</script>

<style scoped>
.circle-loader {
  position: relative;

}

.circle-loader div {
  height: 10px;
  width: 10px;
  background-color: #03A9F4;
  border-radius: 50%;
  position: absolute;
  -webkit-animation: 1.3s opaque ease-in-out infinite both;
  animation: 1.3s opaque ease-in-out infinite both;
}

.circle-loader > div:nth-child(1) {
  top: -25px;
  left: 0;
}

.circle-loader > div:nth-child(2) {
  top: -17px;
  left: 17px;
  -webkit-animation-delay: .15s;
  animation-delay: .15s;
}

.circle-loader > div:nth-child(3) {
  top: 0;
  left: 25px;
  -webkit-animation-delay: 0.3s;
  animation-delay: 0.3s;
}

.circle-loader > div:nth-child(4) {
  top: 17px;
  left: 17px;
  -webkit-animation-delay: 0.45s;
  animation-delay: 0.45s;
}

.circle-loader > div:nth-child(5) {
  top: 25px;
  left: 0;
  -webkit-animation-delay: 0.6s;
  animation-delay: 0.6s;
}

.circle-loader > div:nth-child(6) {
  top: 17px;
  left: -17px;
  -webkit-animation-delay: 0.75s;
  animation-delay: 0.75s;
}

.circle-loader > div:nth-child(7) {
  top: 0;
  left: -25px;
  -webkit-animation-delay: .9s;
  animation-delay: .9s;
}

.circle-loader > div:nth-child(8) {
  top: -17px;
  left: -17px;
  -webkit-animation-delay: 1.05s;
  animation-delay: 1.05s;
}

@-webkit-keyframes opaque {
  0%, 40%, 100% {
    opacity: 0.1;
  }
  40% {
    opacity: 1;
  }
}

@keyframes opaque {
  0%, 40%, 100% {
    opacity: 0.1;
  }
  40% {
    opacity: 1;
  }
}

</style>