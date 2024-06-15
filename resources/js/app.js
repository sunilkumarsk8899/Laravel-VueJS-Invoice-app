import { createApp } from 'vue';
import App from './App.vue';
import router from './router';

// Import your bootstrap file if needed
import './bootstrap';

createApp(App)
    .use(router)
    .mount('#app');
