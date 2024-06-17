<script setup>
import { onMounted, ref } from "vue";
import axios from "axios";
import router from '@/router';

const invoice = ref([]);
let searchInputInvoice = ref([]);

const getInvoices = async () => {
    try {
        const response = await axios.get('/api/get_all_invoices');
        invoice.value = response.data.invoices;
        // console.log('response', response);
    } catch (error) {
        console.error('Error fetching invoices:', error);
    }
};

onMounted(async () => {
    getInvoices();
    invoiceSearch();
});

const invoiceSearch = async () =>{
    if(searchInputInvoice.value.length > 0){
        try {
            const searchResponse = await axios.get('/api/get_all_invoices_by_search?s='+searchInputInvoice.value);
            invoice.value = searchResponse.data.invoices;
            console.log('response', searchResponse);
        } catch (error) {
            console.error('Error fetching invoices:', error);
        }
    }else{
        getInvoices();
    }
}

// show
const onShow = (id) =>{
    router.push(`/invoice/show/${id}`);
}

</script>

<template>

    <div class="container">
        <div class="invoices">

            <div class="card__header">
                <div>
                    <h2 class="invoice__title">Invoices</h2>
                </div>
                <div>
                    <a class="btn btn-secondary">
                        <router-link to="/invoice/new">New Invoice</router-link>
                    </a>
                </div>
            </div>

            <div class="table card__content">
                <div class="table--filter">
                    <span class="table--filter--collapseBtn ">
                        <i class="fas fa-ellipsis-h"></i>
                    </span>
                    <div class="table--filter--listWrapper">
                        <ul class="table--filter--list">
                            <li>
                                <p class="table--filter--link table--filter--link--active">
                                    All
                                </p>
                            </li>
                            <li>
                                <p class="table--filter--link ">
                                    Paid
                                </p>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="table--search">
                    <div class="table--search--wrapper">
                        <select class="table--search--select" name="" id="">
                            <option value="">Filter</option>
                        </select>
                    </div>
                    <div class="relative">
                        <i class="table--search--input--icon fas fa-search "></i>
                        <input class="table--search--input" v-model="searchInputInvoice" @keyup="invoiceSearch()" type="text" placeholder="Search invoice">
                    </div>
                </div>

                <div class="table--heading">
                    <p>ID</p>
                    <p>Date</p>
                    <p>Number</p>
                    <p>Customer</p>
                    <p>Due Date</p>
                    <p>Total</p>
                </div>

                <!-- item 1 -->
                <div class="table--items" v-if="invoice.length > 0" v-for="item in invoice" :key="item.id">
                    <a href="#" @click="onShow(item.id)" class="table--items--transactionId">#{{ item.id }}</a>
                    <p>{{ item.date }}</p>
                    <p>#{{ item.number }}</p>
                    <p v-if="item.customer.firstname">{{ item.customer.firstname }}</p>
                    <p v-else> --------------------- </p>
                    <p>{{ item.due_date }}</p>
                    <p> $ {{ item.total }}</p>
                </div>

                <div class="table--items" v-else>
                    <p>Data Not Found</p>
                </div>
            </div>

        </div>
    </div>

</template>
