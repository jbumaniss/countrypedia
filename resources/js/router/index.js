import { createRouter, createWebHistory } from '@ionic/vue-router';
import Index from '../Pages/Country/Index.vue';
import Detail from '../Pages/Country/Detail.vue';

const routes = [
    {
        path: '/',
        name: 'Home',
        component: Index
    },
    {
        path: '/country/:id',
        name: 'CountryDetails',
        component: Detail,
        props: true
    }
];

const router = createRouter({
    history: createWebHistory(import.meta.env.BASE_URL),
    routes
});

export default router;
