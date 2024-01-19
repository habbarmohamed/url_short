import { createRouter, createWebHistory } from "vue-router";
import Home from "../components/Home.vue";

const routes = [
    {
        path: '/',
        name: 'welcome',
        component: Home
    },
];

export default createRouter({
    history: createWebHistory(),
    routes
})