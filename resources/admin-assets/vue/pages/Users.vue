<template>
    <div class="content-wrapper">
        <section class="content-header">
            <h1>
                მომხმარებლები
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

                            <h3 class="box-title">ძებნა</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body" :class="{'loading-box': loading}">
                            <spinner />

                            <div class="filters">
                                <form @submit.prevent="fetch(1, true)">
                                    <div class="row" style="text-align: center;">
                                        <div class="col col-lg-2 col-md-2"></div>
                                        <div class="col col-lg-2 col-md-2">
                                            <label for="room"></label>
                                            <input type="text" v-model="filters.room" class="form-control" :placeholder="'userRoomNumber'|translate" id="room">
                                        </div>
                                        <div class="form-group col col-lg-5 col-md-5">
                                            <label for="fullname"></label> <!--{{'customer'|translate}}-->
                                            <input type="text" v-model="filters.search" class="form-control" :placeholder="'searchableFields'|translate" id="fullname">
                                        </div>
                                        <div class="col col-lg-1 col-md-1">
                                            <label for=""></label>
                                            <button class="btn btn-primary form-control">ძებნა</button>
                                        </div>
                                        <div class="col col-lg-2 col-md-2"></div>
                                    </div>
                                </form>
                            </div>

                            <table id="Activities" class="table rangeDate actionioni table-striped table-bordered table-hover dataTables-example-activities " >
                                <thead>
                                <tr>
                                    <!--<th>#</th>-->
                                    <th>ოთახი</th>
                                    <th>რეგ. თარიღი</th>
                                    <th class="no-sort">{{'country'|translate}}</th>
                                    <th>სახელი, გვარი</th>
                                    <th>პ.ნ/ს.კ</th>
                                    <th>მობ.ნომერი-1</th>
                                    <th>მობ.ნომერი-2</th>
                                    <th>ელ-ფოსტა</th>
                                    <th>მისამართი-1</th>
                                    <th>მისამართი-2</th>
                                    <th>ფოსტა</th>
                                    <th>ქალაქი</th>
                                    <th>უნიქარდი</th>
                                    <th>ბალანსი</th>
                                    <th>TEMP</th>
                                    <!--<th></th>-->
                                </tr>
                                </thead>
                                <tbody>
                                <tr :key="user.id" v-if="!user.placeholder" role="row" v-for="user in list" class="odd">
                                    <!--<td>{{user.id}}</td>-->
                                    <td>KW{{user.id}}</td>
                                    <td>{{moment(user.created_at).format('YYYY-MM-DD')}}</td>
                                    <td>
                                        {{user.country_id === 1 ? "საქართველო" : "ლონდონი"}}
                                        <!--<img src="http://icons.iconarchive.com/icons/custom-icon-design/all-country-flag/24/Georgia-Flag-icon.png" alt="">-->
                                    </td>
                                    <td> {{user.name}}  {{ user.surname}}</td>
                                    <td>{{user.personal_number}}</td>
                                    <td>{{user.mobile}}</td>
                                    <td>{{user.mobile_2}}</td>
                                    <td>{{user.email}}</td>
                                    <td>{{user.address_1}}</td>
                                    <td>{{user.address_2}}</td>
                                    <td>{{user.postcode}}</td>
                                    <td>{{user.city_town}}</td>
                                    <td>{{user.unicard}}</td>
                                    <td>{{user.balance}} GBP</td>
                                    <td>{{user.temp ? "+" : "-"}}</td>
                                    <!--<td>-->
                                        <!--<div class="btn-group">-->
                                            <!--<button class="btn btn-default" @click.prevent="$refs.printOrder.show(user.id)">Print</button>-->
                                            <!--<button class="btn btn-default dropdown-toggle" data-toggle="dropdown"><span class="caret"></span></button>-->
                                            <!--<ul class="dropdown-menu" role="menu">-->
                                                <!--<li v-if="!user.is_paid"><a href="#" @click.prevent="pay(order)">Pay</a></li>-->
                                                <!--<li><a href="#" @click.prevent="$router.push('/order/'+order.id+'/edit')">Edit</a></li>-->
                                                <!--<li><a href="#">Delete</a></li>-->
                                            <!--</ul>-->
                                        <!--</div>-->
                                    <!--</td>-->
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
                statuses: {}
            }
        },
        methods: {
            fetch(page, force = false) {
                if(this.pagination.current_page === page && !force) return;
                this.loading = true;

                let params = _(this.filters).pick(['search','room']).omitBy(_(_.eq).partial("").value()).assign({page: page}).value();

                window.axios.get("/user", {
                    params: params
                }).then(res=>{
                    console.log(res.data);
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

                })
                // this.loading = false;
            }
        },
        mounted() {
            axios.get("/country")
                .then(res => {
                    if(res.data.success) {
                        this.countries = res.data.result;
                    }
                });


            $(this.$el).find('#reportrange').daterangepicker(null, (start,end) => {
                this.filters.dateRange = start.format("MM/DD/YYYY") + " - " + end.format("MM/DD/YYYY");
            });

            this.fetch(1);
        }
    }
</script>