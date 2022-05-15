import { createRouter, createWebHistory } from 'vue-router'
import Home from "@/views/pages/Home";
import Specialities from "@/views/pages/Specialities";
import Doctors from "@/views/pages/Doctors";
import Patients from "@/views/pages/Patients";
import Map from "@/components/Map";
import locations from "@/views/pages/locations";
import Hospitals from "@/views/pages/Hospitals";
import TopDoctors from "@/views/pages/TopDoctors";
import Ambulance from "@/views/pages/Ambulance";
import Blog from "@/views/pages/Blog";
import Reports from "@/views/pages/Reports";
import Settings from "@/views/pages/Settings";
import NotFound from "@/views/pages/NotFound";
import BlogCats from "@/views/pages/BlogCats";
import BlogAdd from "@/views/pages/BlogAdd";
import BlogEdit from "@/views/pages/BlogEdit";
import login from "@/views/pages/login";

const routes = [
  {
    path: '/:pathMatch(.*)*',
    redirect: '/404'
  },
  {
    path: '/404',
    name: 'error',
    component: NotFound
  },
  {
    path: '/',
    name: 'home',
    component: Home
  },
  {
    path: '/hospitals',
    name: 'hospitals',
    component: Hospitals
  },
  {
    path: '/specialities',
    name: 'specialities',
    component: Specialities
  },
  {
    path: '/top-doctors',
    name: 'topDoctors',
    component: TopDoctors
  },
  {
    path: '/doctor-list',
    name: 'doctors',
    component: Doctors
  },
  {
    path: '/patient-list',
    name: 'patients',
    component: Patients
  },
  {
    path: '/ambulance',
    name: 'ambulance',
    component: Ambulance
  },
  {
    path: '/health-blog',
    name: 'blog',
    component: Blog
  },
  {
    path: '/blog-cats',
    name: 'blogCats',
    component: BlogCats
  },
  {
    path: '/blog-add',
    name: 'blogAdd',
    component: BlogAdd
  },
  {
    path: '/health-edit',
    name: 'blogEdit',
    component: BlogEdit
  },
  {
    path: '/reports',
    name: 'reports',
    component: Reports
  },
  {
    path: '/setting',
    name: 'setting',
    component: Settings
  },
  {
    path: '/locations',
    name: 'locations',
    component: locations
  },
  {
    path: '/map',
    name: 'map',
    component: Map
  },
  {
    path: '/login-:pathMatch(.*)*',
    name: 'login',
    component: login
  }

]

const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes
})

export default router
