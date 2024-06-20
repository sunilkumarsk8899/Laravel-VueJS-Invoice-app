import { createRouter, createWebHistory } from 'vue-router';
import Home from '../components/Home.vue';
import AddProduct from '../components/AddProduct.vue';
import invoiceIndex from '../components/invoice/index.vue';
import NotFound from '../NotFound.vue';
import invoiceNew from '../components/invoice/new.vue';
import invoiceShow from '../components/invoice/show.vue';
// import invoiceShow form '../components/invoice/show.vue';
import invoiceEdit from '../components/invoice/edit.vue';

const routes = [
    {   path: '/',
        component: invoiceIndex
    },
    {
        path: '/:pathMatch(.*)*',
        component: NotFound
    },
    {   path: '/add-product',
        name: 'AddProduct',
        component: AddProduct
    },
    {
        path: '/invoice/show/:id',
        component: invoiceShow,
        props:true
    },
    {
        path: '/invoice/edit/:id',
        component: invoiceEdit,
        props:true
    },
    {
        path: '/invoice/new',
        component: invoiceNew
    }
];

const router = createRouter({
    history: createWebHistory(),
    routes
});

export default router;
