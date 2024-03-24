import Deals from "./components/pages/Deals.vue";
import Accounts from "./components/pages/Accounts.vue";
import Homepage from "./components/pages/Homepage.vue";


const routes = [
    {path: '/', name: 'home', component: Homepage},
    {path: '/deals', name: 'deals', component: Deals},
    {path: '/accounts', name: 'accounts', component: Accounts},
    { path: '/:pathMatch(.*)*', redirect: '/' },
];

export default routes;
