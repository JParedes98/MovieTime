import VueRouter from "vue-router";
import { BootstrapVue, IconsPlugin } from "bootstrap-vue";
import VueSweetalert2 from "vue-sweetalert2";

window.Vue = require("vue").default;
window._ = require("lodash");
window.axios = require("axios");
window.axios.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";
window.axios.defaults.headers.common["Authorization"] = 'Bearer ' + localStorage.getItem('mt_token');

// CONFIGURATION
const moment = require("moment");

// INITIALIZATIONS
Vue.use(VueRouter);
Vue.use(BootstrapVue);
Vue.use(IconsPlugin);
Vue.use(VueSweetalert2);
Vue.use(require("vue-moment"), {
    moment
});

const routes = [
    { path: "/", component: require("./pages/Movies.vue").default, },
    { path: "/users", component: require("./pages/Users.vue").default, },

    { path: "/login", component: require("./pages/auth/Login.vue").default },
    { path: "/register", component: require("./pages/auth/Register.vue").default },
    { path: "/forgot-password", component: require("./pages/auth/ForgotPassword.vue").default },
    { path: "/reset-password/:token", component: require("./pages/auth/ResetPassword.vue").default },

    { path: "/email-verification/:token", component: require("./pages/auth/EmailVerification.vue").default },
];

const router = new VueRouter({
    routes
});

// PARTIALS
Vue.component("Navbar", require("./components/Navbar.vue").default);

// RUN APP
const app = new Vue({
    router
}).$mount("#app");
