import Vue from 'vue'
import VueRouter from 'vue-router'

import Home from "../views/home/Home";
import Login from "../views/Login";
import AddRecipe from "../views/addRecipe/AddRecipe.vue";

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
    {
        path: '/recipe/add',
        name: 'AddRecipe',
        component: AddRecipe
    }

]

const router = new VueRouter({
    mode: 'history',
    routes
})
export default router;
