<script setup>

    import { onMounted, ref } from 'vue';
    import axios from "axios";
    import router from '@/router';

    let form = ref([]);
    let getAllCustomer = ref([]);
    let customer_id = ref([]);
    let item = ref([]);
    let listCart = ref([]);
    let showModel = ref(false);
    let hideModel = ref(true);
    let listProducts = ref([]);

    onMounted( async () =>{
        allCustomer();
        getProduct();
    });


    const indexForm = async () =>{
        let resp = await axios.get('api/create_invoice');
        form.value = resp.data;
    }

    const allCustomer = async () =>{
        const resp = await axios.get('/api/get_all_customer');
        // console.log('resp ',resp);
        getAllCustomer.value = resp.data.customers;
    }

    const addCart = (item) =>{
        // console.log(item);
        const itemCart = {
            id : item.id,
            item_code : item.item_code,
            description : item.description,
            unit_price : item.unit_price,
            quantity : item.quantity
        };
        listCart.value.push(itemCart);
        closeModel();
    }

    const openModel = () =>{
        showModel.value = !showModel.value;
    }

    const closeModel = () =>{
        showModel.value = !hideModel.value;
    }

    const getProduct = async () =>{
        let resp = await axios.get('/api/products');
        // console.log(resp);
        listProducts.value = resp.data.products;
    }

    // remove Item
    const removeItem = (i) =>{
        listCart.value.splice(i,1);
    }

    // sub total
    const subTotal = () =>{
        let subtotal = 0;
            listCart.value.map((data)=>{
                subtotal = subtotal + (data.quantity*data.unit_price);
            });
        return subtotal;
    }

    // total
    const grandTotal = () =>{
        let total = subTotal();
        if(form.value.discount){
            total = subTotal() - form.value.discount;
        }
        return total;
    }

    // onSave
    const onSave = async () =>{
        let sub_Total = 0;
        sub_Total = subTotal();

        let total = 0;
        total = grandTotal();

      const formData = new FormData();
      formData.append('invoice_item', JSON.stringify(listCart.value));
      formData.append('customer_id', customer_id.value);
      formData.append('date', form.value.date);
      formData.append('due_date', form.value.due_date);
      formData.append('numero', form.value.numero);
      formData.append('reference', form.value.reference);
      formData.append('discount', form.value.discount);
      formData.append('sub_total', sub_Total);
      formData.append('total', total);
      formData.append('terms_conditions', form.value.terms_conditions);

      let res = await axios.post('/api/add_invoice',formData);
      console.log(res);
      listCart.value = [];
      router.push('/');

    }


</script>
<template>
    <div class="container">
        <!--==================== NEW INVOICE ====================-->
        <div class="invoices">

            <div class="card__header">
                <div>
                    <h2 class="invoice__title">New Invoice</h2>
                </div>
                <div>

                </div>
            </div>

            <div class="card__content">
                <div class="card__content--header">
                    <div>
                        <p class="my-1">Customer</p>
                        <select name="" id="" class="input" v-model="customer_id">
                            <option value="" disabled>Select Customer</option>
                            <option :value="customer.id" v-for="customer in getAllCustomer" :key="customer.id">
                                {{ customer.firstname }}
                                {{ customer.lastname }}
                            </option>
                        </select>
                    </div>
                    <div>
                        <p class="my-1">Date</p>
                        <input id="date" placeholder="dd-mm-yyyy" type="date" class="input" v-model="form.date"> <!---->
                        <p class="my-1">Due Date</p>
                        <input id="due_date" type="date" class="input" v-model="form.due_date">
                    </div>
                    <div>
                        <p class="my-1">Numero</p>
                        <input type="text" class="input" v-model="form.numero">
                        <p class="my-1">Reference(Optional)</p>
                        <input type="text" class="input" v-model="form.reference">
                    </div>
                </div>
                <br><br>
                <div class="table">

                    <div class="table--heading2">
                        <p>Item Description</p>
                        <p>Unit Price</p>
                        <p>Qty</p>
                        <p>Total</p>
                        <p></p>
                    </div>

                    <!-- item 1 -->
                    <div class="table--items2" v-for="(itemcart,i) in listCart" :key="itemcart.id" >
                        <p>#{{ itemcart.item_code }} {{ itemcart.description }} </p>
                        <p>
                            <input type="text" class="input" v-model="itemcart.unit_price">
                        </p>
                        <p>
                            <input type="text" class="input" v-model="itemcart.quantity">
                        </p>
                        <p v-if="itemcart.quantity">
                            $ {{ itemcart.quantity*itemcart.unit_price }}
                        </p>
                        <p v-else></p>
                        <p style="color: red; font-size: 24px;cursor: pointer;" @click="removeItem(i)">
                            &times;
                        </p>
                    </div>
                    <div style="padding: 10px 30px !important;">
                        <button class="btn btn-sm btn__open--modal" @click="openModel()" >Add New Line</button>
                    </div>
                </div>

                <div class="table__footer">
                    <div class="document-footer" >
                        <p>Terms and Conditions</p>
                        <textarea cols="50" rows="7" class="textarea" v-model="form.terms_conditions"></textarea>
                    </div>
                    <div>
                        <div class="table__footer--subtotal">
                            <p>Sub Total</p>
                            <span>$ {{ subTotal() }}</span>
                        </div>
                        <div class="table__footer--discount">
                            <p>Discount</p>
                            <input type="text" class="input" v-model="form.discount">
                        </div>
                        <div class="table__footer--total">
                            <p>Grand Total</p>
                            <span>$ {{ grandTotal() }}</span>
                        </div>
                    </div>
                </div>


            </div>
            <div class="card__header" style="margin-top: 40px;">
                <div>

                </div>
                <div>
                    <a class="btn btn-secondary" @click="onSave()" >
                        Save
                    </a>
                </div>
            </div>

        </div>


        <!--==================== add modal items ====================-->
        <div class="modal main__modal " :class="{ show: showModel }" >
            <div class="modal__content">
                <span class="modal__close btn__close--modal" @click="closeModel()">×</span>
                <h3 class="modal__title">Add Item</h3>
                <hr><br>
                <div class="modal__items">
                    <ul style="list-style: none;">
                        <li v-for="(item,i) in listProducts" :key="item.id" style="display: grid;grid-template-columns: 30px 350px 15px;align-items: center;padding-bottom: 5px;">
                            <p>{{ i+1 }}</p>
                            <a href="#">
                                {{ item.item_code }} {{ item.description }}
                            </a>
                            <button @click="addCart(item)" style="border: 1px solid #e0e0e0;">
                                +
                            </button>
                        </li>
                    </ul>
                </div>
                <br><hr>
                <div class="model__footer">
                    <button class="btn btn-light mr-2 btn__close--modal" @click="closeModel()">
                        Cancel
                    </button>
                    <button class="btn btn-light btn__close--modal ">Save</button>
                </div>
            </div>
        </div>
    </div>
    <br>
    <br>
    <br>
    <br>
</template>
