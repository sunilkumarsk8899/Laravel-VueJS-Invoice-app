<template>
    <div>
      <h1>Add Product</h1>
      <form @submit.prevent="addProduct">
        <div>
          <label for="name">Product Name:</label>
          <input type="text" v-model="name" id="name" required>
        </div>
        <div>
          <label for="price">Price:</label>
          <input type="number" v-model="price" id="price" required>
        </div>
        <button type="submit">Add Product</button>
      </form>
    </div>
  </template>

  <script>
  export default {
    name: 'AddProduct',
    data() {
      return {
        name: '',
        price: 0
      };
    },
    methods: {
      addProduct() {
        console.log('Product added:', { name: this.name, price: this.price });
      }
    }
  };
  </script>

  <style scoped>
  h1 {
    color: #ffed4a;
  }
  form {
    display: flex;
    flex-direction: column;
  }
  div {
    margin-bottom: 1rem;
  }
  button {
    background-color: #3490dc;
    color: white;
    padding: 0.5rem;
    border: none;
    cursor: pointer;
  }
  </style>
