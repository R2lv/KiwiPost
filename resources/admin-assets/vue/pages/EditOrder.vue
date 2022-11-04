<template>
    <div class="content-wrapper">
        <section class="content">
            <div class="row">
                <section class="col-lg-12" :class="{'loading-box': loading}">
                    <spinner></spinner>
                    <div class="nav-tabs-custom" id="configuration">
                        <ul class="nav nav-tabs pull-right">
                            <li class="pull-left header"><i class="fa fa-inbox"></i> ამანათის დამატება</li>
                            <li :class="{'active': hasType('personal'), 'disabled': !hasType('personal')}"><a href="#" @click.prevent="setType('personal')">პირადი</a></li>
                            <li :class="{'active': hasType('online'), 'disabled': !hasType('online')}"><a href="#" @click.prevent="setType('online')">ონლაინი</a></li>
                        </ul>
                        <div class="tab-content no-padding" id="configuration-forms">
                            <!-- Morris chart - Sales -->
                            <div class="clearfix" v-if="hasType('personal')" data-customid="#personalmodal" id="personal" style="position: relative;">

                                <div class="col-xs-12">

                                    <form class="form-horizontal" @submit.prevent="save" action="#" method="POST" style="margin: 20px 0">



                                        <div class="form-group row">
                                            <label class="col-md-2">გზავნილის ნომერი</label>
                                            <div class="col-md-10">
                                                <input v-model="mdl.tracking_number" class="form-control" placeholder="">
                                            </div>
                                        </div>


                                        <div class="form-group row">
                                            <label class="col-md-2">გამგზავნი</label>
                                            <div class="col-md-4">
                                                <select-2 @change="senderChanged" ref="sender_select" class="form-control" :options="select2.search_options">
                                                    <option value="">Clear</option>
                                                </select-2>
                                                <!--<input v-model="mdl.sender_name" class="form-control" placeholder="სახელი">-->

                                            </div>
                                            <div class="col-md-4">
                                                <input v-model="mdl.sender.surname" :readonly="senderExists"  class="form-control" placeholder="გვარი">
                                            </div>

                                            <div class="col-md-2">
                                                <label>გადამხდელი&nbsp;&nbsp;&nbsp; <icheck type="radio" name="xero_invoice_for" :checked="mdl.xero_invoice_for == 'sender'" v-model="mdl.xero_invoice_for" value="sender"></icheck></label>
                                            </div>

                                        </div>

                                        <div class="form-group row">
                                            <div class="col-md-2"></div>
                                            <div class="col-md-4">
                                                <select-2 @change="fromChanged" style="width: 100% !important;" :options="{placeholder: 'Select country', minimumResultsForSearch: Infinity}" :disabled="senderExists" class="form-control" v-model.number="mdl.from_country_id" ref="from_country">
                                                    <option value="">Clear</option>
                                                    <option v-for="c in countries" :value="c.id">{{c.name}}</option>
                                                </select-2>
                                            </div>
                                            <div class="col-md-3">
                                                <input v-model="mdl.sender.email" :readonly="senderExists" class="form-control" placeholder="ელ. ფოსტა">
                                            </div>
                                            <div class="col-md-3">
                                                <input v-model="mdl.sender.mobile" :readonly="senderExists" class="form-control" placeholder="ტელეფონის ნომერი">
                                            </div>
                                        </div>


                                        <br><br>
                                        <div class="form-group row">
                                            <label class="col-md-2">მიმღები</label>
                                            <div></div>
                                            <div class="col-md-4">
                                                <select-2 @change="receiverChanged" ref="receiver_select" class="form-control" :options="select2.search_options">
                                                    <option value="">Clear</option>
                                                </select-2>
                                            </div>
                                            <div class="col-md-4">
                                                <input v-model="mdl.receiver.surname" :readonly="receiverExists" class="form-control" placeholder="გვარი">
                                            </div>

                                            <div class="col-md-2">
                                                <label>გადამხდელი&nbsp;&nbsp;&nbsp; <icheck type="radio" name="xero_invoice_for" :checked="mdl.xero_invoice_for=='received'" v-model="mdl.xero_invoice_for" value="receiver"></icheck></label>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-2"></label>
                                            <div class="col-md-4">
                                                <select-2 @change="toChanged" v-model.number="mdl.to_country_id" ref="to_country"  :options="{placeholder: 'Select country', minimumResultsForSearch: Infinity}" :disabled="receiverExists" class="form-control">
                                                    <option value="">Clear</option>
                                                    <option v-for="c in toCountries" :value="c.id">{{c.name}}</option>
                                                </select-2>
                                            </div>

                                            <div class="col-md-3">
                                                <input v-model="mdl.receiver.email" :readonly="receiverExists" class="form-control" placeholder="ელ. ფოსტა">
                                            </div>
                                            <div class="col-md-3">
                                                <input v-model="mdl.receiver.mobile" :readonly="receiverExists" class="form-control" placeholder="ნომერი">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-2"></label>
                                            <div class="col-md-5">
                                                <input v-model="mdl.receiver.city_town" :readonly="receiverExists" class="form-control" placeholder="City / Town">
                                            </div>
                                            <div class="col-md-5">
                                                <input v-model="mdl.receiver.address_1" :readonly="receiverExists" class="form-control" placeholder="Address">
                                            </div>
                                        </div>

                                        <br><br>



                                        <div class="form-group">
                                            <label class="col-md-2">პროდუქცია</label>
                                            <div class="col-md-10">
                                                <select-2 class="form-control" multiple @change="catsChanged" ref="cats">
                                                    <option v-for="cat in categories" :value="cat.id">{{cat.name}}</option>
                                                </select-2>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-2"></label>
                                            <div class="col-md-5">
                                                <input v-model="mdl.comment" class="form-control" placeholder="აღწერა">
                                            </div>
                                            <div class="col-md-3">
                                                <input v-model="mdl.obtain_cost" class="form-control" placeholder="ღირებულება">
                                            </div>
                                            <div class="col-md-2">
                                                <select-2 name="" v-model="mdl.obtain_currency" :options="{placeholder: 'Currency', minimumResultsForSearch: Infinity}" class="form-control">
                                                    <option v-for="currency in currencies" :value="currency">{{currency}}</option>
                                                </select-2>
                                            </div>
                                        </div>
                                        <br><br>
                                        <div class="form-group">
                                            <label class="col-md-2">წონა</label>
                                            <div class="col-md-2">
                                                <input v-model.number="mdl.weight" class="form-control" placeholder="რეალური წონა">
                                            </div>
                                            <div class="col-sm-2"></div>
                                            <div class="col-sm-3" v-if="country_prices.from_home_per_kg">
                                                <!--<input type="text" class="form-control" placeholder="სიგრძე" disabled>-->
                                                <label>სახლიდან წაღება &nbsp;&nbsp;<icheck :checked="mdl.from_delivery_cost > 0     " @change="calcPrice" v-model="mdl.from_home_delivery"></icheck></label>
                                            </div>
                                            <div class="col-sm-3" v-if="country_prices.home_delivery || country_prices.home_delivery_per_kg">
                                                <!--<input type="text" class="form-control" placeholder="სიგანე" disabled>-->
                                                <label>სახლში მიტანა &nbsp;&nbsp;<icheck :checked="mdl.home_delivery" @change="calcPrice" v-model="mdl.home_delivery"></icheck></label>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-2">ღირებულება</label>
                                            <div class="col-sm-10">
                                                <input v-model="mdl.price" class="form-control" readonly="" placeholder="">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-lg-12 ">
                                                <button @click.prevent="saveAndPrint" class="btn btn-danger pull-right"><i class="fa fa-print"></i> შენახვა და ბეჭდვა</button>
                                                <button class="btn btn-primary pull-right" style="margin-right: 5px"><i class="fa fa-save"></i> შენახვა</button>
                                            </div>
                                        </div>
                                    </form>

                                </div>

                            </div>


                            <div v-if="hasType('online')" data-customid="#online"  id="online" style="position: relative;" class="clearfix">

                                <div class="col-xs-12">

                                    <form @submit.prevent="save" class="form-horizontal" action="#" method="POST" style="margin: 20px 0;">

                                        <div class="form-group">
                                            <label class="col-sm-2">გზავნილის ნომერი</label>
                                            <div class="col-sm-10">
                                                <input v-model="mdl.tracking_number" class="form-control" placeholder="">
                                            </div>
                                        </div>


                                        <div class="form-group">
                                            <label class="col-sm-2">ოთახის ნომერი</label>
                                            <div class="col-sm-10">
                                                <input v-model="mdl.room_number" class="form-control" placeholder="">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-2">გამგზავნის ქვეყანა</label>
                                            <div class="col-sm-10">
                                                <select-2 @change="fromChanged" class="form-control" :options="{placeholder: 'Select country', minimumResultsForSearch: Infinity}" v-model.number="mdl.from_country_id" ref="from_country">
                                                    <option value="">Clear</option>
                                                    <option v-for="c in countries" :value="c.id">{{c.name}}</option>
                                                </select-2>
                                            </div>
                                        </div>


                                        <div class="form-group">
                                            <label class="col-sm-2">მიმღების ქვეყანა</label>
                                            <div class="col-sm-10">
                                                <select-2 @change="calcPrice" :options="{placeholder: 'Select country', minimumResultsForSearch: Infinity}" v-model.number="mdl.to_country_id" class="form-control" ref="to_country">
                                                    <option value="">Clear</option>
                                                    <option v-for="c in toCountries" :value="c.id">{{c.name}}</option>
                                                </select-2>
                                            </div>
                                        </div>



                                        <div class="form-group">
                                            <label class="col-sm-2">წონა</label>
                                            <div class="col-sm-2">
                                                <input v-model.number="mdl.weight" class="form-control" placeholder="რეალური წონა">
                                            </div>
                                            <div class="col-sm-2"></div>
                                            <div class="col-sm-2">
                                                <input disabled class="form-control" placeholder="სიგრძე">
                                            </div>
                                            <div class="col-sm-2">
                                                <input disabled class="form-control" placeholder="სიგანე">
                                            </div>
                                            <div class="col-sm-2">
                                                <input disabled class="form-control" placeholder="სიმაღლე">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-2">ღირებულება</label>
                                            <div class="col-sm-10">
                                                <input v-model="mdl.price" class="form-control" readonly placeholder="">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-lg-12 ">
                                                <button @click.prevent="saveAndPrint" class="btn btn-danger pull-right"><i class="fa fa-print"></i> შენახვა და ბეჭდვა</button>
                                                <button class="btn btn-primary pull-right" style="margin-right: 5px"><i class="fa fa-save"></i> შენახვა</button>
                                            </div>
                                        </div>
                                    </form>

                                </div>

                            </div>


                        </div>
                    </div>
                </section>

                <section class="col-lg-12">
                    <div class="box box-primary">
                        <div class="box-header">
                            <i class="ion ion-clipboard"></i>

                            <h3 class="box-title">ბოლო ჩანაწერები</h3>
                            <h3 class="box-title pull-right" style="margin: 0 5px;"><a href="#" data-toggle="modal" id="addCustomer" data-target="#CustomerModal"><i class="fa fa-pencil"></i></a></h3>

                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">

                            <form class="form-horizontal" action="#" method="POST">
                                <table id="Activities" class="table rangeDate actionioni table-striped table-bordered table-hover dataTables-example-activities " >
                                    <thead>
                                    <tr>
                                        <th class="no-sort"><input type="checkbox" class="example-select-all" name="id[]"></th>
                                        <th>#</th>
                                        <th>თარიღი</th>
                                        <th class="no-sort">
                                            <select name="" class="nostyleSelectBox native">
                                                <option value="1">GER</option>
                                                <option value="1">USA</option>
                                            </select>
                                        </th>
                                        <th>გზავნილის ნომერი</th>
                                        <th>ოთახი</th>
                                        <th>მფლობელი</th>
                                        <th>პ.ნ/ს.კ</th>
                                        <th>წონა</th>
                                        <th>ფასი</th>
                                        <th>რეისი</th>
                                        <th>საკურიერო</th>
                                        <th>შეჩერება</th>
                                        <th>სტატუსი</th>
                                    </tr>
                                    </thead>
                                    <tbody>


                                    </tbody>
                                </table>
                            </form>

                        </div>


                    </div>
                    <!-- /.box -->
                    <print-order ref="printOrder"></print-order>
                </section>
            </div>
            <!-- /.row (main row) -->
        </section>
        <!-- /.content -->
    </div>

</template>

<script>

    let calculate = require("../../../assets/js/mixins/calculate");

    let search_options = {
        placeholder: "Search for user or enter First name",
        minimumInputLength: 2,
        ajax: {

            url: "/user/search",
            data(params) {
                return {
                    s: params.term
                }
            },
            delay: 250,
            transport(params,success,failure) {
                axios.post(params.url, params.data).then(success).catch(failure);
            },
            processResults(res) {
                return {
                    results: res.data.result.map(item => {
                        return {
                            id: item.id,
                            text: item.name + " " + item.surname,
                            additional: item.mobile,
                            item: item
                        }
                    }),

                }
            }
        },
        templateResult(item) {
            let res = "<div>" + item.text + "<span class='pull-right'>";
            if(item.additional)
                res+="("+item.additional+")</span></div>";
            return res;
        },
        templateSelection(item) {
            return item.item ? item.item.name : item.text;
        },
        escapeMarkup(markup) { return markup; },
        createTag(params) {
            let data = $(this.$element).select2("data").length ? $(this.$element).select2("data")[0] : {id: -1};
            return {
                id: data.id == -2 ? -1 : -2,
                text: params.term,
                additional: "+"
            };
        },
        tags: true
    };
export default {
    data() {
        return {
            mdl: {
                tracking_number: "",
                weight: "",
                price: "",
                order_category_ids: [],

                sender_id: '',
                room_number: '',

                receiver: {},
                sender: {},

                comment: "",
                obtain_currency: "",
                obtain_cost: "",
                home_delivery: 0,
                from_home_delivery: 0
            },
            currencies: ['USD','EUR','GEL','GBP'],
            countries: [],
            categories: [],
            priceList: [],
            type: 'personal',
            loading: true,
            select2: {
                search_options
            }
        }
    },/*
    beforeCreate() {
    },*/
    methods: {
        saveAndPrint() {
            this.save(data => {
                this.$refs.printOrder.show(data.result.id);
            });
        },
        save(cb) {
            this.loading = true;
            if(this.type==='online') {
                this.loading = true;
                axios.post("/order", _(this.mdl).pick(['tracking_number', 'room_number', 'weight', 'from_country_id', 'to_country_id']).omitBy(_(_.eq).partial('').value()).assign({parcel_type: this.type}))
                    .then(res => {
                        if (res.data.success) {
                            if (typeof cb === 'function') cb(res.data);
                            else {
                                toastr.success("Order saved successfully", "Success");
                            }
                            this.loading = false;
                        } else {
                            toastr.error(Object.values(res.data.error).join("<br>"));
                            this.loading = false;
                        }
                    });

            } else {
                // this.loading = false;
                let data = _(this.mdl).omit(['sender','receiver']).omitBy(_(_.eq).partial('').value()).assign({'parcel_type': this.type});
                if(!this.senderExists) {
                    data = data.assign({
                        'sender': _(this.mdl.sender).pick('name','surname','email','mobile').omitBy(_(_.eq).partial('').value()).value()
                    });
                }
                if(!this.receiverExists) {
                    data = data.assign({
                        'receiver': _(this.mdl.receiver).pick('name','surname','email','mobile', 'city_town', 'address_1').omitBy(_(_.eq).partial('').value()).value()
                    });
                }

                // axios.post("/order", data.value())
                //     .then(res => {
                //         if(res.data.success) {
                //             if (typeof cb === 'function') cb(res.data);
                //             else {
                //                 toastr.success("Order saved successfully", "Success");
                //             }
                //         } else {
                //             toastr.error(Object.values(res.data.error).join("<br>"));
                //         }
                //     })

            }

        },

        senderChanged(e) {
            let id = $(e.currentTarget).val();
            let data = $(e.currentTarget).select2("data");
            let item = data[0];

            if(!id || parseInt(id)<1) {
                this.mdl.sender = {
                    name: item.text
                };
            } else {
                this.mdl.sender = item.item;
                this.mdl.from_country_id = item.item.country_id;
            }
            this.mdl.sender_id = parseInt(id) > 0 ? parseInt(id) : 0;
        },

        receiverChanged(e) {
            let id = $(e.currentTarget).val();
            let data = $(e.currentTarget).select2("data");
            let item = data[0];

            if(!id || parseInt(id)<1) {
                this.mdl.receiver = {
                    name: item.text
                };
            } else {
                if(!_(this.toCountries).some({id: item.item.country_id})) {
                    toastr.error("Can not send package to the selected country");
                    this.$refs.receiver_select&&$(this.$refs.receiver_select.$el).val(null).trigger("change");
                    id = '';
                } else {
                    this.mdl.receiver = item.item;
                    this.mdl.to_country_id = item.item.country_id;
                }
            }
            this.mdl.room_number = parseInt(id) > 0 ? parseInt(id) : 0;
        },
        catsChanged(e) {
            this.mdl.order_category_ids = $(e.currentTarget).val();
        },
        setType(type) {},
        hasType(type) {
            return this.type===type;
        },
        weightChanged() {
            this.calcPrice();
        },
        fromChanged() {
            if(!_(this.toCountries).some({id: this.mdl.to_country_id}) && !!this.mdl.to_country_id) {
                console.log("From: ", this.fromCountry.name, this.toCountry.name);
                toastr.error("Can not send package to the selected country");
                this.mdl.to_country_id = '';
                $(this.$refs.receiver_select.$el).val(null).trigger("change");
            }
            this.calcPrice();
        },
        toChanged() {
            this.calcPrice();
        },
        calcPrice() {
            if (this.mdl.from_country_id && this.mdl.to_country_id && this.mdl.weight) {

                if (this.hasType('online')) {
                    this.mdl.price = this.calculate(this.mdl.weight, this.fromCountry.code, this.toCountry.code, this.priceList[this.type]);
                } else {
                    let price = this.calculate(this.mdl.weight, this.fromCountry.code, this.toCountry.code, this.priceList[this.type]);

                    console.log(this.mdl.home_delivery);

                    if (this.mdl.home_delivery) {
                        price += this.home_delivery_price;
                    }

                    if (this.mdl.take_from) {
                        price += this.from_home_price;
                    }

                    this.mdl.price = price;

                }
            }
            else this.mdl.price = '';
        },
        setOrder(order) {
            this.mdl = order;
            if(this.type==='online') {
                    order.room_number = order.user_id;
                    $(this.$refs.from_country.$el).val(this.mdl.from_country_id).trigger("change");

                    setTimeout(() => {
                        $(this.$refs.to_country.$el).val(this.mdl.to_country_id).trigger("change");
                    });
            } else {
                $(this.$refs.sender_select.$el).select2("trigger", "select", {
                    data: {
                        id: order.sender_id,
                        text: order.sender.name + ' ' + order.sender.lastname,
                        item: order.sender
                    }
                });
                $(this.$refs.receiver_select.$el).select2("trigger", "select", {
                    data: {
                        id: order.user_id,
                        text: order.user.name + ' ' + order.user.lastname,
                        item: order.user
                    }
                });
                /*
                $(this.$refs.sender_select.$el).select2('data', {
                    id: order.sender_id,
                    text: order.sender.name + ' ' + order.sender.lastname,
                    item: order.sender
                });

                setTimeout(()=> {
                    $(this.$refs.sender_select.$el).val({
                        id: order.sender_id,
                        text: order.sender.name + ' ' + order.sender.lastname,
                        item: order.sender
                    }).trigger("change");
                });*/
                this.mdl.sender = order.sender;
                this.mdl.sender_id = order.sender.id;
                this.mdl.user = order.user;
                this.mdl.user_id = order.user_id;


                $(this.$refs.cats.$el).val(this.mdl.order_category_ids).trigger("change");


                setTimeout(()=>{
                    $(this.$el).find("input[type=radio]").iCheck("update");
                    this.calcPrice();
                });
            }

            this.loading = false;
        }
    },
    computed: {
        prices() {
            return this.priceList[this.type] || [];
        },
        country_prices() {
            return _(this.prices).find({
                from: this.fromCountry.code,
                to: this.toCountry.code
            }) || {};
        },
        from_home_price() {
            if(this.country_prices.from_home_per_kg) {
                return this.mdl.weight * this.country_prices.from_home_per_kg;
            }
            return 0;
        },
        home_delivery_price() {
            if(this.country_prices.home_delivery_per_kg) {
                return this.mdl.weight * this.country_prices.home_delivery_per_kg;
            } else if(this.country_prices.home_delivery) {
                return this.calcDelivery(this.mdl.weight, this.country_prices.home_delivery)
            }
            return 0;
        },

        senderExists() {
            return !!this.mdl.sender_id && parseInt(this.mdl.sender_id) > 0;
        },
        receiverExists() {
            return !!this.mdl.room_number && parseInt(this.mdl.room_number) > 0;
        },
        toCountries() {
            let fromCountry = null;
            if(this.mdl.from_country_id) {
                fromCountry = this.countries.find((c)=>{
                    return c.id === this.mdl.from_country_id;
                }, this)
            }

            if(fromCountry && fromCountry.code !== 'UK') {
                return [this.countries.find((c)=>{return c.code==='UK'})];
            } else if(!fromCountry) {
                return this.countries;
            }

            return this.countries.filter((c)=>{return c.code !== 'UK'});
        },
        fromCountry() {
            return this.countries.find((c)=>{return c.id === this.mdl.from_country_id}, this) || {};
        },
        toCountry() {
            return this.countries.find((c)=>{return c.id === this.mdl.to_country_id}, this) || {};
        },
    },
    watch: {
        'mdl.weight'() {
            this.weightChanged();
        }
    },
    mounted() {
        setTimeout(() => {
            $(this.$el).find("input[type=checkbox]:not(.native)").iCheck({
                checkboxClass: 'icheckbox_minimal-blue',
                radioClass   : 'iradio_minimal-blue'
            });
        });


        let countries = _(axios.get).partial('/country').value(),
            parameters = _(axios.get).partial('/parameter').value(),
            categories = _(axios.get).partial('/category').value(),
            order = _(axios.get).partial('/order/'+this.$route.params.id).value();

        Axios.all([countries(),parameters(),categories(), order()])
            .then(Axios.spread((c, p, categories, _order)=>{
                if(c.data.success) {
                    this.countries = c.data.result;
                }

                if(p.data.success) {
                    this.priceList = p.data.result;
                }

                if(categories.data.success) {
                    this.categories = categories.data.result;
                }

                if(_order.data.success) {

                    this.type = _order.data.result.type === 1 ? 'personal' : 'online';
                    setTimeout(()=>{
                        this.setOrder(_order.data.result);
                    });
                }
            }));
    },
    mixins: [calculate]
}
</script>