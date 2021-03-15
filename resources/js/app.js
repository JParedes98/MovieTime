import VueRouter from "vue-router";
import { BootstrapVue, IconsPlugin } from "bootstrap-vue";
import VueSweetalert2 from "vue-sweetalert2";

window.Vue = require("vue").default;
window._ = require("lodash");
window.axios = require("axios");
window.axios.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";

// CONFIGURATION
const moment = require("moment");
require("moment/locale/es");

// INITIALIZATIONS
Vue.use(VueRouter);
Vue.use(BootstrapVue);
Vue.use(IconsPlugin);
Vue.use(VueSweetalert2);
Vue.use(require("vue-moment"), {
    moment
});

const routes = [
    { path: "/", component: require("./pages/Index.vue").default },

    { path: "/login", component: require("./pages/auth/Login.vue").default },
    { path: "/register", component: require("./pages/auth/Register.vue").default },
];

const router = new VueRouter({
    routes
});

// PARTIALS
Vue.component("navbar", require("./components/Navbar.vue").default);

// RUN APP
const app = new Vue({
    router
}).$mount("#app");
