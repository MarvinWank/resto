import Vue from 'vue'
import VueRouter from 'vue-router'

import Home from "../views/Home";
import Login from "../views/Login";

Vue.use(VueRouter)


const routes = [

    {
        path: '/',
        name: 'Home',
        component: Home
    },
    {
        path: '/login',
        name: 'Login',
        component: Login
    },

]

const router = new VueRouter({
    mode: 'history',
    routes
})
export default router;
