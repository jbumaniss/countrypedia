import { createRouter, createWebHistory } from '@ionic/vue-router';
import CountryIndex from '../Pages/Country/Index.vue';
import CountryDetail from '../Pages/Country/Detail.vue';
import LanguageDetail from '../Pages/Language/Detail.vue';

const routes = [
    {
        path: route('countries.index'),
        name: 'Home',
        component: CountryIndex
    },
    {
        path: route('countries.show', { id: ':id' }),
        name: 'CountryDetails',
        component: CountryDetail,
        props: true
    },
    {
        path: route('languages.show', { id: ':id' }),
        name: 'LanguageDetails',
        component: LanguageDetail,
        props: true
    }
];

const router = createRouter({
    history: createWebHistory(import.meta.env.BASE_URL),
    routes
});

export default router;
