window._ = require('lodash');
window.toastr = require('toastr');
window.jQuery = window.$ = require("jquery");
require ('./components/jquery/dist/jquery.min.js');
require ('./components/jquery-ui/jquery-ui.min.js');
window.$.widget.bridge('uibutton', window.$.ui.button);

require ('./components/bootstrap/dist/js/bootstrap.min.js');

window.Raphael = require ('./components/raphael/raphael.min.js');
require ('./components/morris.js/morris.min.js');
require ('./components/jquery-sparkline/dist/jquery.sparkline.min.js');
require ('./plugins/jvectormap/jquery-jvectormap-1.2.2.min.js');
require ('./plugins/jvectormap/jquery-jvectormap-world-mill-en.js');
require ('./plugins/iCheck/icheck');
require ('./components/jquery-knob/dist/jquery.knob.min.js');
window.moment = require ('moment');
require ('./components/bootstrap-daterangepicker/daterangepicker.js');
require ('./components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js');
require ('./components/datatables.net/js/jquery.dataTables.min.js');
require ('./components/datatables.net-bs/js/dataTables.bootstrap.min.js');
// require ('./plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js');
require ('./components/jquery-slimscroll/jquery.slimscroll.min.js');
require ('./components/fastclick/lib/fastclick.js');
require ('./dist/js/adminlte.min.js');
require ('select2/dist/js/select2.full.js');

require("jquery.cookie");
// require ('./dist/js/demo.js');
// require ('./dist/js/pages/dashboard.js');
require ('./js/app');

{
    let axios = require("axios");


    let headers = {'X-Requested-With': 'XMLHttpRequest'};
    let token = document.head.querySelector('meta[name="csrf-token"]');
    if (token) {
        headers['X-CSRF-TOKEN'] = token.content;
    } else {
        console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
    }
    window.axios = axios.create({
        baseURL: '/master/ajax/',
        headers: headers
    });

    window.$http = axios.create({
        headers: headers
    });

    window.Axios = axios;
}