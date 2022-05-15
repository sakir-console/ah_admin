import { createApp } from 'vue'
import App from './App.vue'
import router from './router'
import axios from "axios";
// import the library
import { createToast } from 'mosha-vue-toastify';
// import the styling for the toast
import 'mosha-vue-toastify/dist/style.css'

const app = createApp(App);


const toastBar = (title,des,type) => {
    createToast({
        title: title,
        description: des
    },{
        type: type, // 'info', 'danger', 'warning', 'success', 'default'
        timeout: 5000,
        showCloseButton: true,
        showIcon: true,
        position: 'top-right', // 'top-left', 'top-right', 'bottom-left', 'bottom-right', 'top-center', 'bottom-center'
        transition: 'bounce', //'bounce', 'zoom', 'slide'
        hideProgressBar: false,
        swipeClose: true,
        //toastBackgroundColor: '#fafafa',
        onClose: null
    })
    return { toastBar }
}
const formHelper= (data)=>{
    const FD=new FormData();
    for(let k in data){
        FD.append(k,data[k])
    }
    return FD;
}

const token = localStorage.getItem('token');
const headers ={}
if (token) {
    headers['Authorization'] = `Bearer ${token}`;
    console.log(headers);
}
const instance = axios.create({
    baseURL: 'https://amaderhospital.com/api/',headers
});

app.config.globalProperties.axios=instance
app.config.globalProperties.pBody=formHelper
app.config.globalProperties.base_url=''
app.config.globalProperties.toast=toastBar

app.use(router).mount('#app')