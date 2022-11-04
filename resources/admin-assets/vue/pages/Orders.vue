<template>
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            შეკვეთები
            <small>სამართავი პანელი</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> მთავარი</a></li>
        </ol>
    </section>
    <section class="content">

        <div class="row">
            <section class="col-lg-12 ">

                <!-- Activities -->
                <div class="box box-primary">
                    <div class="box-header">
                        <i class="ion ion-clipboard"></i>

                        <h3 class="box-title">შეკვეთები</h3>
                        <h3 class="box-title pull-right" style="margin: 0 5px;"><router-link :to="'/order/create'"><i class="fa fa-plus-circle"></i></router-link></h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body" :class="{'loading-box': loading}">
                        <spinner />

                        <div class="filters">
                            <form @submit.prevent="fetch(1, true)">
                                <div class="row">
                                    <div class="form-group col col-lg-4 col-md-6">
                                        <label for="reportrange">{{'dtrange'|translate}}</label>
                                        <input v-model="filters.dateRange" type="text" placeholder="Date range" class="form-control" id="reportrange">
                                    </div>
                                    <div class="form-group col col-lg-4 col-md-6">
                                        <label>{{'status'|translate}}</label>
                                        <select-2 class="form-control" v-model="filters.status" :options="{placeholder: lang('please_select'), width: '100%', minimumResultsForSearch: Infinity, allowClear: true}">
                                            <option value="" selected>Any</option>
                                            <option value="waiting">{{'waiting'|translate}}</option>
                                            <option value="warehouse">{{'warehouse'|translate}}</option>
                                            <option value="inTransit">{{'inTransit'|translate}}</option>
                                            <option value="arrived">{{'arrived'|translate}}</option>
                                            <option value="obtained">{{'obtained'|translate}}</option>
                                            <option value="stopped">{{'stopped'|translate}}</option>
                                        </select-2>
                                        <!--<input type="text" class="form-control" id="status" placeholder="MIN" style="margin-bottom: 5px;">-->
                                    </div>
                                    <div class="form-group col col-lg-4 col-md-6">
                                        <label>{{'country'|translate}}</label>
                                        <select-2 class="form-control" v-model="filters.to_country_id" :options="{placeholder: lang('please_select'), width: '100%', minimumResultsForSearch: Infinity, allowClear: true}">
                                            <option value="" selected>Any</option>
                                            <option :key="c.id" :value="c.id" v-for="c in countries">{{c.name}}</option>
                                        </select-2>
                                        <!--<input type="text" class="form-control" id="status" placeholder="MIN" style="margin-bottom: 5px;">-->
                                    </div>


                                    <div class="form-group col col-lg-4 col-md-6">
                                        <label for="fullname">{{'receiverName'|translate}}</label>
                                        <input type="text" v-model="filters.fullname" class="form-control" :placeholder="'fullnameOfReceiver'|translate" id="fullname">
                                    </div>

                                    <div class="form-group col col-lg-4 col-md-6">
                                        <label for="id_number">{{'userIdNumber'|translate}}</label>
                                        <input type="text" v-model="filters.personal_number" class="form-control" :placeholder="'userIdNumber'|translate" id="id_number">
                                    </div>

                                    <div class="form-group col col-lg-4 col-md-6">
                                        <label for="room_number">{{'userRoomNumber'|translate}}</label>
                                        <input type="text" v-model="filters.user_id" class="form-control" :placeholder="'userRoomNumber'|translate" id="room_number">
                                    </div>

                                </div>
                                <div class="row">

                                    <div class="form-group col col-lg-4 col-md-6">
                                        <label for="tracking_number">{{'tracking_id'|translate}}</label>
                                        <input type="text" v-model="filters.tracking_number" class="form-control" :placeholder="'tracking_id'|translate" id="tracking_number">
                                    </div>
                                    <div class="form-group col col-lg-4 col-md-6">
                                        <label>{{'homeDelivery'|translate}}</label>
                                        <select-2 v-model="filters.home_delivery" class="form-control" :options="{placeholder: lang('please_select'), minimumResultsForSearch: Infinity, allowClear: true}">
                                            <option value="">All</option>
                                            <option :value="1">{{'yes'|translate}}</option>
                                            <option :value="0">{{'no'|translate}}</option>
                                        </select-2>
                                    </div>

                                    <div class="form-group col col-lg-4 col-md-6">
                                        <label>{{'isPaid'|translate}}</label>
                                        <select-2 v-model="filters.isPaid" class="form-control" :options="{placeholder: lang('please_select'), minimumResultsForSearch: Infinity, allowClear: true}">
                                            <option value="">All</option>
                                            <option :value="1">{{'yes'|translate}}</option>
                                            <option :value="0">{{'no'|translate}}</option>
                                        </select-2>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <label>{{'isDeclared'|translate}}</label>
                                        <select-2 v-model="filters.isDeclared" class="form-control" :options="{placeholder: lang('please_select'), minimumResultsForSearch: Infinity, allowClear: true}">
                                            <option value="">All</option>
                                            <option :value="1">{{'yes'|translate}}</option>
                                            <option :value="0">{{'no'|translate}}</option>
                                        </select-2>
                                    </div>
                                    <div class="col-md-4"></div>
                                    <div class="col-md-6"></div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4"></div>
                                    <div class="col-md-4"></div>
                                    <div class="form-group col col-lg-4 col-md-6 pull-right">
                                        <div class="pull-right">
                                            <label>&nbsp;</label>
                                            <button class="btn btn-primary form-control">Filter</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <div class="operations" v-show="operations.selected.length">
                            <div class="row">
                                <div class="col col-md-6 col-sm-12">
                                    <div class="col col-md-3 col-sm-12">
                                        <div class="form-group">
                                            <div class="btn-group">
                                                <button class="btn btn-default">{{'ChangeStatus'|translate}}</button>
                                                <button class="btn btn-default dropdown-toggle" data-toggle="dropdown"><span class="caret"></span></button>
                                                <ul class="dropdown-menu" role="menu">
                                                    <li><a v-for="(status, key) in statuses" @click.prevent="changeStatus(key)" :key="key" href="#">{{status}}</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col col-md-3 col-sm-12">
                                        <div class="form-group">
                                            <div class="btn-group">
                                                <button class="btn btn-default">Online:</button>
                                                <button class="btn btn-default">{{ orderCalculations.onlineCount }}</button>
                                                <button class="btn btn-default">{{ orderCalculations.onlineWeightCount.toFixed(2) }}</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col col-md-3 col-sm-12">
                                        <div class="btn-group">
                                            <button class="btn btn-default">Pers:</button>
                                            <button class="btn btn-default">{{ orderCalculations.personalCount }}</button>
                                            <button class="btn btn-default">{{ orderCalculations.personalWeightCount.toFixed(2) }}</button>
                                        </div>
                                        {{ recheckSelectedOrders }}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <table id="Activities" class="table rangeDate actionioni table-striped table-bordered table-hover dataTables-example-activities " >
                            <thead>
                            <tr>
                                <th class="no-sort"><icheck @change="toggleAll" class="icheck example-select-all" /></th>
                                <th>#</th>
                                <th>თარიღი</th>
                                <th class="no-sort">{{'country'|translate}}</th>
                                <th>გზავნილის ნომერი</th>
                                <th>ოთახი</th>
                                <th>მფლობელი</th>
                                <th>პ.ნ/ს.კ</th>
                                <th>წონა</th>
                                <th>ფასი</th>
                                <th>ტრანსპორტირება</th>
                                <th>დეკლარირებული</th>
                                <th>გადახდილია</th>
                                <th>საკურიერო</th>
                                <th>სტატუსი</th>
                                <th>ოპერაციები</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr :key="order.id" v-if="!order.placeholder" role="row" v-for="order in list" class="odd"> 
                                <td><icheck class="onCheck" name="id[]" :value="order.id" @change="check($event, order.id)" /></td>
                                <td>{{order.id}}</td>
                                <td>{{moment(order.created_at).format('YYYY-MM-DD')}}</td>
                                <td style="text-align: center;">
                                    {{order.to_country.code}}
                                    <!--<img src="http://icons.iconarchive.com/icons/custom-icon-design/all-country-flag/24/Georgia-Flag-icon.png" alt="">-->
                                </td>
                                <td><a  href="#" @click.prevent="$refs.printOrder.show(order.id)" class="showDetailedInfoOnTracking cutOutOfSizeTracking" data-target="#orderInfo" data-requestid="1150"> {{order.tracking_number}}</a></td>
                                <td>KW{{order.user.id}}</td>
                                <td>{{order.user.name}} {{order.user.surname}}</td>
                                <td>{{order.user.personal_number}}</td>
                                <td>{{order.weight}}</td>
                                <td>{{order.obtain_cost||'0'}} {{order.obtain_currency}}</td>
                                <td>{{order.cost}} GBP</td>
                                <td><a href="#"  @click.prevent="$refs.viewDeclaration.show(order.id)">{{order.obtain_cost ? lang("yes") : lang("no")}}</a></td>
                                <td>{{order.is_paid ? "კი" : "არა"}}</td>
                                <td>{{order.home_delivery ? "კი" : "არა"}}</td>
                                <td>
                                    {{statuses[order.status]}}
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <button class="btn btn-default" @click.prevent="$refs.printOrder.show(order.id)">Print</button>
                                        <button class="btn btn-default dropdown-toggle" data-toggle="dropdown"><span class="caret"></span></button>
                                        <ul class="dropdown-menu" role="menu">
                                            <li v-if="!order.is_paid"><a href="#" @click.prevent="pay(order)">Pay</a></li>
                                            <li><a href="#" @click.prevent="$router.push('/order/'+order.id+'/edit')">Edit</a></li>
                                            <li><a href="#" @click.prevent="deleteOrder(order,list.indexOf(order))">Delete</a></li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                            </tbody>
                        </table>

                        <ul class="pagination pull-right" v-if="pagination.last_page!==1">
                            <li v-if="1 < pagination.current_page - pagination.radius"><a @click.prevent="fetch(1)" href="#">&laquo;</a></li>
                            <li :key="page" v-for="page in pagination.pages" :class="{active: pagination.current_page === page}"><a @click.prevent="fetch(page)" href="#">{{page}}</a></li>
                            <li v-if="pagination.last_page > pagination.current_page + pagination.radius"><a @click.prevent="fetch(pagination.last_page)" href="#">&raquo;</a></li>
                        </ul>

                    </div>
                </div>
                <print-order ref="printOrder" />
                <view-declaration ref="viewDeclaration" />
                <!-- /.box -->

            </section>
        </div>
    </section>
</div>
</template>

<script>

let calculate = require("../../../assets/js/mixins/calculate");
export default {
    data() {
        return {
            list: [{status: '', is_paid: '', placeholder: true}],
            page: 1,
            length: 20,
            mdl: {},
            filters: {},
            operations: {
                selected: []
            },
            pagination: {
                radius: 3
            },
            loading: true,
            countries: [],
            statuses: {},
            orderCalculations: {
                personalCount:0,
                onlineCount:0,
                personalWeightCount:0,
                onlineWeightCount:0
            }
        }
    },
    methods: {
        calculateOrders(){
            if(this.selected_orders) {
                this.orderCalculations.personalCount = 0;
                this.orderCalculations.personalWeightCount = 0;
                this.orderCalculations.onlineCount = 0;
                this.orderCalculations.onlineWeightCount = 0;
                for (var i = 0; i < this.selected_orders.length; i++) {
                    if (this.selected_orders[i].type == 1) {
                        this.orderCalculations.personalCount += 1;
                        if(parseFloat(this.selected_orders[i].weight) > 0)
                        this.orderCalculations.personalWeightCount += this.selected_orders[i].weight;
                    } else {
                        this.orderCalculations.onlineCount += 1;
                        if(parseFloat(this.selected_orders[i].weight) > 0)
                        this.orderCalculations.onlineWeightCount += parseFloat(this.selected_orders[i].weight);

                    }
                }
            }
        },
        toggleAll(e) {
            // console.log("Toggle all", $(e.target).attr("checked"));

            if($(e.target).prop("checked")) {
                $(".onCheck").iCheck("check");
            } else {
                $(".onCheck").iCheck("uncheck");
            }
        },
        pay(order) {
            axios.get("/orders/admin/pay/"+order.id)
            .then(res => {
                if(res.data.success) {
                    toastr.success(res.data.result);
                    _(this.list).filter({id: order.id}).each(item => {
                        item.is_paid = 1;
                    });
                } else {
                    toastr.error(res.data.error);
                }
            });
        },
        deleteOrder(order, index) {
            console.log(index);
            axios.get("/orders/admin/delete/"+order.id)
            .then(res => {
                if(res.data.success) {
                    toastr.success(res.data.result);
                    this.list.splice(index,1);
                } else {
                    toastr.error(res.data.error);
                }
            });
        },
        changeStatus(status) {

            this.loading = true;
            if(this.operations.selected.length) {
                axios.post("/orders/status", {
                    status: status,
                    ids: this.operations.selected
                }).then(res => {
                    this.loading = false;
                    if(res.data.success) {
                        _(this.list).each(item => {
                            if(_(this.operations.selected).includes(item.id))
                                item.status = this.statuses[status];
                        });
                        toastr.success(res.data.result);
                        $(this.$el).find(".onCheck").iCheck("uncheck");
                    }
                });
            }

        },
        check(e, id) {
            if($(e.target).prop("checked")) {
                this.operations.selected.push(id);
            } else {
                this.operations.selected.splice(this.operations.selected.indexOf(id),1);
            }
        },
        fetch(page, force = false) {
            if(this.pagination.current_page === page && !force) return;
            this.loading = true;

            let params = _(this.filters).pick(['tracking_number','dateRange','status','to_country_id','fullname','personal_number','user_id','home_delivery','isPaid','isDeclared']).omitBy(_(_.eq).partial("").value()).assign({page: page}).value();

            window.axios.get("/order", {
                params: params
            }).then(res=>{
                    if(res.data.success) {
                        this.list = res.data.result.data;

                        this.pagination.pages = [];
                        this.pagination.current_page = res.data.result.current_page;

                        for(let i = res.data.result.current_page - this.pagination.radius; i <= res.data.result.current_page+this.pagination.radius; i++) {
                            if(i>0 && i <= res.data.result.last_page) {
                                this.pagination.pages.push(i);
                            }
                        }

                        this.pagination.last_page = res.data.result.last_page;
                        this.pagination.first_page = res.data.result.first_page;

                    }
                    this.loading = false;
                    this.calculateOrders();

                    // setTimeout(()=>{
                    //     console.log("iCheck");
                    //     $(this.$el).find("input[type=checkbox]:not(.native)").iCheck({
                    //         checkboxClass: 'icheckbox_minimal-blue',
                    //         radioClass   : 'iradio_minimal-blue'
                    //     });
                    // });

                })
        }
    },
    mounted() {
        axios.get("/country")
            .then(res => {
                if(res.data.success) {
                    this.countries = res.data.result;
                }
            });

        axios.get("/orders/statuses")
        .then(res => {
            if(res.data.success) {
                this.statuses = res.data.result;
            }
        });
        
        $(this.$el).find('#reportrange').daterangepicker(null, (start,end) => {
            this.filters.dateRange = start.format("MM/DD/YYYY") + " - " + end.format("MM/DD/YYYY");
        });

        this.fetch(1);
    },
    mixins: [calculate],
    computed: {
        selected_orders() {
            let keys = _(this.operations.selected);
            return _(this.list).filter(order => keys.includes(order.id)).value();
        },
        recheckSelectedOrders(){
            return this.calculateOrders();
        }
    }
}
</script>