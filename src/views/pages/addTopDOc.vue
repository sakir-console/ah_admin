<template>
  <div class="page-wrapper">
    <div class="content container-fluid">

      <div class="row">
        <div class="col-md-12">
          <h5 class="mb-3">Add Top Doctors</h5>
          <div class="row">


            <div class="form-group"><label>Doctor Name</label>
              <input  @blur="()=>{this.searchingHos=false}" @click="searchHospitals" @input="searchHospitals" type="text" v-model="searchHos" class="form-control" placeholder="Enter Doctor Name"></div>

            <div class="filter-widget">
              <h4>Doctor</h4>
              <div>
                <div class="form-group">



                  <div v-if="searchingHos" class="lds-ellipsis">
                    <div></div>
                    <div></div>
                    <div></div>
                    <div></div>
                  </div>


                  <div v-for="(hospital,index) in hospitals.data" :key="hospital.id"
                       :value="hospital.id" class="form-check-inlinex visits">
                    <label class="visit-btns">
                      <input v-model="hosNum" :value="hospital.uid" type="checkbox"
                             class="form-check-input">
                      <span class="visit-rsn" data-bs-toggle="tooltip"
                            title="Select Symptom">
                                                    {{ hospital.name }} # @{{hospital.username}}

                        - {{ hospital.sect_name }}


                      </span>


                    </label>
                  </div>





                </div>
              </div>

            </div>

            <button @click.prevent="updateTD()" type="submit" class="btn btn-primary save-btn">Save Changes</button>




          </div>
        </div>
      </div>

    </div>
  </div>

</template>

<script>
export default {
name: "addTopDOc",
  data() {
    return {
      loading: false,

      hosNum: [],
      searchHos:'',
      searchingHos:false,
      hos:'',

      page: 1,
      NoData:false,

      spec:'',
      doctors: [],
      hospitals:[],
      specialities:[],


    }
  },
  methods: {


    hospitalList() {
      // searchHos request - AH
      this.axios.get("doctor/search?q="+this.searchHos)
          .then(response => {
            this.loading = false;
            console.log((response.data))
            if (response.data.success == true) {
              this.hospitals = response.data
              if (response.data.data.length !== 0) {
                this.searchingHos=false
              }

            }
          })
          .catch(error => {
            this.errorMessage = error.message;
            console.error("There was an error!", error);
          });
    },
    updateTD() {
      // locations request - AH
      this.axios.post("sitedata/top_doctor", this.pBody({
        "ids": this.hosNum,

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
    searchHospitals(){
      this.searchingHos=true
      if(this.searchHos!=''){
        this.hospitalList()
      }

    },


  }

}
</script>



<style scoped>

.lds-ellipsis {
  display: inline-block;
  position: relative;
  width: 80px;

  height: 80px;
  margin-left: 35%;
}
.lds-ellipsis div {
  position: absolute;
  top: 33px;
  width: 13px;
  height: 13px;
  border-radius: 50%;
  background: #2cb09b;
  animation-timing-function: cubic-bezier(0, 1, 1, 0);
}
.lds-ellipsis div:nth-child(1) {
  left: 8px;
  animation: lds-ellipsis1 0.6s infinite;
}
.lds-ellipsis div:nth-child(2) {
  left: 8px;
  animation: lds-ellipsis2 0.6s infinite;
}
.lds-ellipsis div:nth-child(3) {
  left: 32px;
  animation: lds-ellipsis2 0.6s infinite;
}
.lds-ellipsis div:nth-child(4) {
  left: 56px;
  animation: lds-ellipsis3 0.6s infinite;
}
@keyframes lds-ellipsis1 {
  0% {
    transform: scale(0);
  }
  100% {
    transform: scale(1);
  }
}
@keyframes lds-ellipsis3 {
  0% {
    transform: scale(1);
  }
  100% {
    transform: scale(0);
  }
}
@keyframes lds-ellipsis2 {
  0% {
    transform: translate(0, 0);
  }
  100% {
    transform: translate(24px, 0);
  }
}








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