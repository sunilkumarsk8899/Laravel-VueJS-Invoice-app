<template>
    <div>
      <!-- <nav>
        <router-link to="/">Home</router-link>
        <router-link to="/add-product">Add Product</router-link>
      </nav> -->
      <router-view></router-view>
    </div>
  </template>

  <script>
  export default {
    name: 'App',
  };
  </script>

  <style>
  nav {
    margin-bottom: 1em;
  }
  nav a {
    margin-right: 1em;
    text-decoration: none;
    color: #3490dc;
  }
  nav a.router-link-exact-active {
    font-weight: bold;
    color: #ffed4a;
  }
  </style>
