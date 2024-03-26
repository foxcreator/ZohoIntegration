import './bootstrap';
import { createApp } from 'vue';
import routes from "./routes.js";
import { createRouter, createWebHistory } from 'vue-router';
import { createPinia } from "pinia";
import App from "./components/App.vue";

/**
 * Next, we will create a fresh Vue application instance. You may then begin
 * registering components with the application instance so they are ready
 * to use in your application's views. An example is included for you.
 */

const app = createApp({});

const router = createRouter({
    history: createWebHistory(),
    routes,
});

const pinia = createPinia();
// const toast = toast();

app.use(router);
app.use(pinia);
app.component('app', App)
app.mount('#app');
