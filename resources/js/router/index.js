import { createRouter, createWebHistory } from "vue-router";
import Home from "../components/Home.vue";
import LoginComponent from '../components/LoginComponent'

const routes = [
    {
        path: '/',
        name: 'welcome',
        component: Home
    },
    // Login 
    { 
        path: '/login', 
        name: 'login',
        component: LoginComponent,
    },
];

export default createRouter({
    history: createWebHistory(),
    routes
})