<template>
    <form action="" @submit.prevent="save" :class="{'loading-box': loading}">
        <spinner></spinner>
        <div class="input-group" :class="{'error': errorFields.tracking_number}">
            <label for="tracking_number">{{'tracking_number' | translate}}</label>
            <input :disabled="!editable || added_by_operator" v-model="mdl.tracking_number" @blur="errorFields.tracking_number = false" :title="errorFields.tracking_number" id="tracking_number" :placeholder="lang('ex.')+': 42000000123456789'">
            <i class="addon material-icons" v-if="errorFields.tracking_number">
                info_outline
                <span class="error-text" v-html="err('tracking_number')"></span>
            </i>
        </div>
        <div class="input-group" :class="{'error': errorFields.obtain_cost}">
            <label for="obtain_cost">{{'price' | translate}}</label>
            <input :disabled="!editable" v-model="mdl.obtain_cost" @blur="errorFields.obtain_cost = false" :title="errorFields.obtain_cost" id="obtain_cost" :placeholder="'price'|translate">
            <i class="addon material-icons" v-if="errorFields.obtain_cost">
                info_outline
                <span class="error-text" v-html="err('obtain_cost')"></span>
            </i>
        </div>

        <div class="input-group" :class="{'error': errorFields.obtain_currency}">
            <label>{{'currency' | translate}}</label>
            <div :disabled="!editable" class="dropdown autoclose">
                <div class="input-dropdown dropdown-handle">{{ mdl.obtain_currency || lang('please_select') }} <span class="caret"></span></div>
                <div class="dropdown-content">
                    <ul class="dropdown-list">
                        <li class="dropdown-list-item" :key="currency" @click.prevent="mdl.obtain_currency = currency" v-for="currency in currencies">{{ currency }}</li>
                    </ul>
                </div>
            </div>
            <i class="addon material-icons" v-if="errorFields.obtain_currency">
                info_outline
                <span class="error-text" v-html="err('obtain_currency')"></span>
            </i>
        </div>


        <div class="input-group" :class="{'error': errorFields.from_country_id}">
            <label>{{'country' | translate}} ({{'from' | translate}})</label>
            <div :disabled="!editable || added_by_operator" class="dropdown autoclose">
                <div class="input-dropdown dropdown-handle">{{ fromCountry.name ? fromCountry.name : lang('please_select') }} <span class="caret"></span></div>
                <div class="dropdown-content">
                    <ul class="dropdown-list">
                        <li class="dropdown-list-item" :key="c.id" @click.prevent="setFromCountry(c)" v-for="c in countries">{{ c.name }}</li>
                    </ul>
                </div>
            </div>
            <i class="addon material-icons" v-if="errorFields.from_country_id">
                info_outline
                <span class="error-text" v-html="err('from_country_id')"></span>
            </i>
        </div>

        <div class="input-group" :class="{'error': errorFields.to_country_id}">
            <label>{{'country' | translate}} ({{'to' | translate}})</label>
            <div :disabled="!editable || added_by_operator" class="dropdown autoclose">
                <div class="input-dropdown dropdown-handle">{{ toCountry.name ? toCountry.name : lang('please_select') }} <span class="caret"></span></div>
                <div class="dropdown-content">
                    <ul class="dropdown-list">
                        <li class="dropdown-list-item" :key="c.id" @click.prevent="setToCountry(c)" v-for="c in toCountries">{{ c.name }}</li>
                    </ul>
                </div>
            </div>

            <i class="addon material-icons" v-if="errorFields.to_country_id">
                info_outline
                <span class="error-text" v-html="err('to_country_id')"></span>
            </i>
        </div>

        <div class="input-group" :class="{'error': errorFields.obtain_webstore}">
            <label for="obtain_webstore">Webpage</label>
            <input :disabled="!editable" v-model="mdl.obtain_webstore" @blur="errorFields.obtain_webstore = false" :title="errorFields.obtain_webstore" id="obtain_webstore" :placeholder="lang('ex.') + ': www.amazon.com'">
        </div>

        <div class="input-group">
            <label>{{'categories' | translate}}</label>
            <div :disabled="!editable" class="dropdown">
                <div class="input-dropdown dropdown-handle">{{ _cats }} <span class="caret"></span></div>
                <div class="dropdown-content">
                    <ul class="dropdown-list">
                        <li class="dropdown-list-item" :key="category.id" v-for="category in categories">
                            <label>
                                <input type="checkbox" v-model="mdl.order_category_ids" :value="category.id"> {{ category.name }}
                            </label>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="input-group">
            <label for="comment">{{'comment' | translate}}</label>
            <textarea :disabled="!editable" v-model="mdl.comment" @blur="errorFields.comment = false" :title="errorFields.comment" id="comment" rows="4"></textarea>
        </div>

        <div class="input-group inline" v-if="!mdl.paid && mdl.status === 'waiting'">
            <label class="green-text">{{'additional_services' | translate}}: </label>
            <label class="checkbox-wrapper" v-if="toCountry.code === 'GE'">{{'home_delivery' | translate}} <input v-model="mdl.home_delivery" :disabled="!editable" type="checkbox"></label>
        </div>

        <div class="error" v-if="errorFields.invoice">{{errorFields.invoice}}</div>
        <div class="popup-footer">
            <div v-if="mdl.obtain_invoice" class="view-invoice">
                <a :href="'/json/orders/'+mdl.order_id" target="_blank">{{'view_invoice'|translate}}</a>
            </div>
            <div class="btn-group length-2">
                <a href="#" class="btn white-bg">
                    <label style="display: block;"><input type="file" :disabled="!editable" @change="fileChange($event, 'invoice')" accept="image/*|pdf" style="display: none;">
                        <img src="images/upload-invoice-icon.png" class="icon-left" alt="">
                        <span class="popup-btn-text" style="width: 40px;">{{'upload_invoice' | translate}}</span>
                    </label>
                </a><!--
                <div class="btn white-bg dropdown dropup autoclose trusted-person">
                    <span class="dropdown-handle">
                        <span class="popup-btn-text">{{ trustedPersonName ? trustedPersonName : lang('trusted_person') }}</span> <img style="transform: rotate(180deg)" src="/images/arr-down-tiny-grey.png" class="icon-right" alt="">
                    </span>
                    <div class="dropdown-content">
                        <ul class="dropdown-list">
                            <li class="dropdown-list-item" v-for="t in trustedPersons" @click.prevent="mdl.trusted_id=t.id">{{ t.name+ ' ' + t.surname}}</li>
                        </ul>
                    </div>
                </div>-->
                <button class="btn">{{'save' | translate}}</button>
            </div>
        </div>
    </form>
</template>

<script>
let err = require("../mixins/err");
export default {
    data() {
        return {
            mdl: {
                _method: "PUT",
                order_id: "",
                tracking_number: "",
                obtain_cost: "",
                obtain_currency: "",
                obtain_webstore: "",
                from_country_id: "",
                to_country_id: "",
                comment: "",
                additional_services: [],
                home_delivery: false,
                order_category_ids: [],
                trusted_id: "",
                status: "",
                type: "",
                operator_id: "",
                paid: "",
                obtain_invoice: ""
            },
            errorText: '',
            categories: [],
            currencies: ['GBP','GEL','USD','EUR'],
            countries: [],
            parcel: {},
            trustedPersons: [],
            errorFields: {},
            result: false,
            loading: true
        }
    },

    beforeCreate() {
        axios.get('/json/parceldata')
            .then(function(res) {
                if(res.data.success) {
                    this.countries = res.data.result.countries;
                    this.categories = res.data.result.categories;
                    this.trustedPersons = res.data.result.trusted;
                }
                this.loading = false;
            }.bind(this))
            .catch(function(err) {
                console.log("Error", err);
            });
    },

    mounted() {
        $(this.$el).find(".dropdown:not(.autoclose)").dropdown();
        $(this.$el).find(".dropdown.autoclose").dropdown({autoclose: true});

        this.mdl = _(this.parcel).pick(Object.keys(this.mdl)).assign({order_id: this.parcel.id, _method: this.mdl._method}).value();
    },

    computed: {
        added_by_operator() {
            return !!this.mdl.operator_id;
        },
        editable() {
            return this.mdl.type===0 && _(['waiting','warehouse']).includes(this.mdl.status) && !this.mdl.paid;
        },
        _cats() {
            return this.mdl.order_category_ids.length && this.categories.length ? this.mdl.order_category_ids.map((c) => {return _(this.categories).find({id: c}).name;}).join(", ") : this.lang("select_categories");
        },
        toCountries() {
            let fromCountry = null;
            if(this.mdl.from_country_id) {
                fromCountry = this.countries.find((c)=>{
                    return c.id === this.mdl.from_country_id;
                }, this);
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
        trustedPersonName() {
            let trusted = _(this.trustedPersons).find({id: this.mdl.trusted_id});
            return trusted ? trusted.name + ' ' + trusted.surname : null;
        }
    },

    methods: {
        setFromCountry(c) {
            this.mdl.from_country_id = c.id;
            _(this.toCountries).some({id: this.mdl.to_country_id}) || (this.mdl.to_country_id = null);
        },
        setToCountry(c) {
            this.mdl.to_country_id = c.id;
        },
        save() {
            if(this.loading) return;
            this.errorFields = {};

            let formData = new FormData();
            for(let [key,val] of Object.entries(this.mdl)) {
                if(Array.isArray(val)) {
                    val.forEach(function(e) {
                        formData.append(key+"[]", e);
                    });
                } else
                    formData.append(key, val);
            }

            this.loading = true;
            axios.post("/json/orders", formData)
                .then(res => {
                    this.loading = false;
                    if(res.data.success) {
                        alert(res.data.result, "Kiwipost", true, () => {
                            location.href = '/';
                        });
                    } else {
                        this.errorFields = res.data.error;
                    }
                })
                .catch(function(err) {
                    console.log("Error", err);
                })
        },
        fileChange(e, f) {
            console.log(e);
            this.mdl[f] = e.currentTarget.files.length ? e.currentTarget.files[0] : undefined;
        }
    },
    mixins: [err]
}
</script>