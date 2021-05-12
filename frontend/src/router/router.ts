import Vue from 'vue'
import VueRouter from 'vue-router'

import Home from "../views/home/Home.vue";
import Login from "../views/Login.vue";
import AddRecipe from "../views/addRecipe/AddRecipe.vue";
import ViewRecipe from "@/views/viewRecipe/ViewRecipe.vue";
import EditRecipe from "@/views/editRecipe/EditRecipe.vue";
import Register from "@/views/register/Register.vue";

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
        path: '/register',
        name: 'Register',
        component: Register
    },
    {
        path: '/recipe/add',
        name: 'AddRecipe',
        component: AddRecipe
    },
    {
        path: "/recipe/view/:id",
        name: "ViewRecipe",
        component: ViewRecipe
    },
    {
        path: "/recipe/edit/:id",
        name: "EditRecipe",
        component: EditRecipe
    }

]

const router: VueRouter = new VueRouter({
    mode: 'history',
    routes
})
export default router;
