import './bootstrap';
import { createApp } from 'vue';
import App from './App.vue';
import router from './router';
import axios from 'axios';

import Investments from './components/Index.vue';

const app = createApp(App);
app.use(router);
app.mount('#app'); 

axios.defaults.withCredentials = true
axios.defaults.withXSRFToken = true