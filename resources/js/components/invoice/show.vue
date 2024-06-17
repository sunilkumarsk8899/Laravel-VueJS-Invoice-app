<script setup>
import axios from 'axios';
import { onMounted, ref } from 'vue';
import router from '../../router';

// Define props
const props = defineProps({
  id: {
    type: String,
    default: ''
  }
});

// Reactive state for form
let form = ref({});

// Function to fetch invoice data
const getInvoice = async () => {
  try {
    let resp = await axios.get(`/api/show_invoice/${props.id}`);
    form.value = resp.data.invoice;
    console.log(resp);
  } catch (error) {
    console.error("Error fetching invoice data:", error);
  }
}

// Fetch invoice data on component mount
onMounted(() => {
  getInvoice();
});

const print = () =>{
    window.print();
    router.push('/').catch(()=>{});
}

</script>

<template>

    <div class="container">
        <div class="invoices">

<div class="card__header">
    <div>
        <h2 class="invoice__title">Invoice</h2>
    </div>
    <div>

    </div>
</div>
<div>
    <div class="card__header--title ">
        <h1 class="mr-2">#{{ form.id }}</h1>
        <p>{{ form.created_at }} </p>
    </div>

    <div>
        <ul  class="card__header-list">
            <li>
                <!-- Select Btn Option -->
                <button class="selectBtnFlat" @click="print()">
                    <i class="fas fa-print"></i>
                    Print
                </button>
                <!-- End Select Btn Option -->
            </li>
            <li>
                <!-- Select Btn Option -->
                <button class="selectBtnFlat">
                    <i class=" fas fa-reply"></i>
                    Edit
                </button>
                <!-- End Select Btn Option -->
            </li>
            <li>
                <!-- Select Btn Option -->
                <button class="selectBtnFlat ">
                    <i class=" fas fa-pencil-alt"></i>
                    Delete
                </button>
                <!-- End Select Btn Option -->
            </li>

        </ul>
    </div>
</div>

<div class="table invoice">
    <div class="logo">
        <!-- <img src="assets/img/logo.png" alt="" style="width: 200px;"> -->
    </div>
    <div class="invoice__header--title">
        <p></p>
        <p class="invoice__header--title-1">Invoice</p>
        <p></p>
    </div>


    <div class="invoice__header--item">
        <div>
            <h2>Invoice To:</h2>
            <p>
                {{ form.customer?.firstname }} {{ form.customer?.lastname }}
            </p>
        </div>
        <div>
                <div class="invoice__header--item1">
                    <p>Invoice#</p>
                    <span>#{{ form.number }}</span>
                </div>
                <div class="invoice__header--item2">
                    <p>Date</p>
                    <span>{{ form.date }}</span>
                </div>
                <div class="invoice__header--item2">
                    <p>Due Date</p>
                    <span>{{ form.due_date }}</span>
                </div>
                <div class="invoice__header--item2">
                    <p>Reference</p>
                    <span>{{ form.reference }}</span>
                </div>

        </div>
    </div>

    <div class="table py1">

        <div class="table--heading3">
            <p>#</p>
            <p>Item Description</p>
            <p>Unit Price</p>
            <p>Qty</p>
            <p>Total</p>
        </div>

        <!-- item 1 -->
        <div class="table--items3" v-for="(item,i) in form.invoice_items">
            <p class="table--items--col2">
                {{ i+1 }}
            </p>
            <p  class="table--items--col1 table--items--transactionId3">
                {{ item.product.description }}
            </p>
            <p class="table--items--col2">
                $ {{ item.unit_price }}
            </p>
            <p class="table--items--col3">
                {{ item.quantity }}
            </p>
            <p class="table--items--col5">
                $ {{ item.unit_price * item.quantity }}
            </p>
        </div>
    </div>

    <div  class="invoice__subtotal">
        <div>
            <h2>Thank you for your business</h2>
        </div>
        <div>
            <div class="invoice__subtotal--item1">
                <p>Sub Total</p>
                <span> $ {{ form.sub_total }}</span>
            </div>
            <div class="invoice__subtotal--item2">
                <p>Discount</p>
                <span>$ {{ form.discount }}</span>
            </div>

        </div>
    </div>

    <div class="invoice__total">
        <div>
            <h2>Terms and Conditions</h2>
            <p> {{ form.terms_and_conditions }} </p>
        </div>
        <div>
            <div class="grand__total" >
                <div class="grand__total--items">
                    <p>Grand Total</p>
                    <span>$ {{ form.total }}</span>
                </div>
            </div>
        </div>
    </div>

</div>

</div>
<br>
    </div>

</template>
