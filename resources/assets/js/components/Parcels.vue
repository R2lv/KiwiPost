<template>
    <section id="parcels">
        <ul class="filters geo lower">
            <li :class="{active: isFilter('')}" @click.prevent="setFilter('')"><a class="geo lower" href="#">{{'all' | translate}}</a></li>
            <li :class="{active: isFilter('waiting')}"><a class="geo lower" href="#" @click.prevent="setFilter('waiting')">{{'waiting' | translate}}</a></li>
            <li :class="{active: isFilter('warehouse')}"><a class="geo lower" href="#" @click.prevent="setFilter('warehouse')">{{'warehouse' | translate}}</a></li>
            <li :class="{active: isFilter('shipped')}"><a class="geo lower" href="#" @click.prevent="setFilter('shipped')">{{'shipped' | translate}}</a></li>
            <li :class="{active: isFilter('received')}"><a class="geo lower" href="#" @click.prevent="setFilter('received')">{{'received' | translate}}</a></li>
        </ul>
        <div class="parcel-list contentWrapper pad">
            <transition-group name="zoomOut" class="parcelsWrapper geo lower" tag="div">
                <div class="item add" key="0" @click.prevent="showAddParcelWindow">
                    <a href="">
                        <div class="vAlign">
                            <div class="plus-icon"></div>
                            <label>{{'add_package' | translate}}</label>
                        </div>
                    </a>
                </div>

                <div class="item" v-for="parcel in parcelList" :key="parcel.id" v-if="isFilter(parcel.status) || !filter">
                    <div class="top-panel">
                        <div class="icon state-2"></div>
                        <div class="tracking-info">
                            <span class="title geo lower">{{'tracking_id' | translate}}</span>
                            <span class="tracking">{{ parcel.tracking_number || "-" }}</span>
                        </div>
                        <div class="clearfix"></div>
                        <div class="parcel-info">
                            <div class="info-pair info-price">
                                <div class="title geo lower">{{'price' | translate}}</div>
                                <div class="value">{{parcel.obtain_cost}} {{(parcel.obtain_currency+"_symbol") | translate('en')}}</div>
                            </div>
                            <div class="info-pair info-weight">
                                <div class="title geo lower">{{'weight' | translate}}</div>
                                <div class="value geo lower">{{parcel.weight ? parcel.weight + lang('kg'): '-'}}</div>
                            </div>
                            <div class="info-pair info-website">
                                <div class="title geo lower">{{'website' | translate}}</div>
                                <div class="value">{{parcel.obtain_webstore||'-'}}</div>
                            </div>
                            <div class="status error"> </div>
                            <div class="edit-parcel material-icons" @click.prevent="showEditParcelWindow(parcel)">mode_edit</div>
                            <div class="delete-parcel material-icons">delete_forever</div>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                    <div class="bottom-panel">
                        <div class="additional-info">
                            <div class="type">
                                <span class="title geo lower">{{'type' | translate}}: </span> {{lang('_parcel_type_'+parcel.type)}}
                            </div>
                            <div class="from-to">
                                <span class="country">{{parcel.from_country.code}}</span> <img src="images/arrow-right-tiny.png" alt=""> <span class="country">{{parcel.to_country.code}}</span>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <div class="price-location">
                            <div class="price" :class="{red: !parcel.is_paid}" @click.prevent="pay(parcel)">
                                <div>{{(parcel.cost).toFixed(3)}} GBP</div>
                                <div class="pay" v-if="!parcel.is_paid">{{'pay' | translate}}</div>
                            </div>
                            <div class="location">
                                <div class="location-path" :class="['state-'+getParcelState(parcel)]"></div>
                                <div class="parcel-status">
                                    <img src="images/transit-car-icon.png" alt=""> {{ parcel.arrive_date || lang(parcel.status) }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </transition-group>
        </div>
    </section>
</template>

<script>
    let AddParcelComponent = Vue.extend(require("./AddParcel.vue")),
        EditParcelComponent = Vue.extend(require("./EditParcel.vue"));

    export default {

        data() {
            return {
                parcelList: [],
                filter: ""
            }
        },

        beforeCreate() {
            axios.get("/json/orders")
                .then(function(res) {
                    if(res.data.success)
                        this.parcelList = res.data.result;
                }.bind(this))
                .catch((err) => {})
        },

        methods: {
            pay(parcel) {
                if(parcel.paid || !parcel.cost) return;
                this.$parent.showPayParcelWindow(parcel)
            },
            showAddParcelWindow() {
                this.$parent.showAddParcelWindow();
            },
            showEditParcelWindow(parcel) {
                let p = showPopup(false, "<div id='add-parcel-container'></div>",false,'declaration-popup');

                let reg = new EditParcelComponent({
                    el: $(p.root).find("#add-parcel-container").get(0),
                    mounted() {
                        p.show();
//                        $(window).trigger("resize");
                    },
                    data() {
                        return {
                            parcel: parcel
                        };
                    }
                });
            },
            setFilter(filter) {
                this.filter = filter;
            },
            isFilter(f) {
                return (this.filter.trim() === f.trim());
            },
            getParcelState(parcel) {
                switch(parcel.status) {
                    case 'waiting':
                        return '0';
                    case 'warehouse':
                        return '1';
                    case 'inTransit': case 'terminal':
                        return '2';
                    case 'arrived': case 'obtained':
                        return '3';
                    default:
                        return '0'
                }
            }
        },
    }
</script>