require("./bootstrap");

toastr.options = {
    "closeButton": false,
    "debug": false,
    "newestOnTop": false,
    "progressBar": true,
    "positionClass": "toast-bottom-right",
    "preventDuplicates": true,
    "onclick": null,
    "showDuration": "300",
    "hideDuration": "1000",
    "timeOut": "5000",
    "extendedTimeOut": "1000",
    "showEasing": "swing",
    "hideEasing": "linear",
    "showMethod": "fadeIn",
    "hideMethod": "fadeOut"
};

require("./js/app");

let TranslatePlugin = require("../assets/js/vue-plugins/Translation");
let VueRouter = require("vue-router").default;
let routes = require("./vue/res/routes").default;
let components = require("./vue/res/components").default;
let Permissions = require("./vue/res/permissions").default;
let Vue = require("vue");

Vue.use(VueRouter);
Vue.use(Permissions);

Vue.use(TranslatePlugin, {
    'ka': require('../assets/js/locales/ka.json'),
    'en': require('../assets/js/locales/en.json')
});

Vue.mixin({
    methods: {
        moment: window.moment
    }
});

Vue.setLanguage($.cookie("lang") || 'ka');
let router = new VueRouter({
    routes,
    mode: 'history',
    base: '/master'
});
/*
router.afterEach((to, from) => {
    setTimeout(()=>{
        // console.log($(".icheck"));
    },1);
});
*/
Vue.component('statistics', Vue.extend(components.Statistics));
Vue.component('spinner', Vue.extend(components.Spinner));
Vue.component('select-2', Vue.extend(components.Select2));
Vue.component('icheck', Vue.extend(components.Checkbox));
Vue.component('PrintOrder', Vue.extend(components.PrintOrder));
Vue.component('ViewDeclaration', Vue.extend(components.ViewDeclaration));
Vue.component('barcode', Vue.extend(components.Barcode));


window.init();
let app = new Vue({
    el: '#app',
    router
});