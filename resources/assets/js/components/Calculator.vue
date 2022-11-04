<template>
    <div class="calculator-block upper">
        <div class="calculator-title">
            <img src="images/calculator-icon.png" alt=""> {{'calculate_price' | translate}}
        </div>
        <div v-show="!result">
            <form action="#" class="calc-form" @submit.prevent="calculatePrice">
                <div class="input-group">
                    <input class="input with-addon" v-model.number="mdl.weight" :placeholder="'weight' | translate">
                    <div class="dropdown addon-dropdown autoclose">
                        <label class="input dropdown-handle">
                            {{ mdl.weight_unit | translate }}
                            <span class="caret"></span>
                        </label>
                        <div class="dropdown-content">
                            <ul class="dropdown-list">
                                <li class="dropdown-list-item" @click.prevent="mdl.weight_unit = 'kg'">{{'kg' | translate}}</li>
                                <li class="dropdown-list-item" @click.prevent="mdl.weight_unit = 'lb'">lb</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="input-group">
                    <div class="dropdown autoclose">
                        <label class="input dropdown-handle">
                            {{'parcel_type' | translate}}{{ mdl.parcel_type && ': ' + lang(mdl.parcel_type)}}
                            <span class="caret"></span>
                        </label>
                        <div class="dropdown-content">
                            <ul class="dropdown-list">
                                <li class="dropdown-list-item" @click.prevent="mdl.parcel_type='online'">{{'online' | translate}}</li>
                                <li class="dropdown-list-item" @click.prevent="mdl.parcel_type='personal'">{{'personal' | translate}}</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="input-group">
                    <div class="dropdown autoclose">
                        <label class="input dropdown-handle">
                            {{ fromCountry.name ? lang('from') + ': '+fromCountry.name : lang('choose_country') + ' ('+lang('from')+')' }}
                            <span class="caret"></span>
                        </label>
                        <div class="dropdown-content">
                            <ul class="dropdown-list">
                                <li class="dropdown-list-item" @click.prevent="setFromCountry(c)" v-for="c in countries">{{ c.name }}</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="input-group">
                    <div class="dropdown autoclose">
                        <label class="input dropdown-handle">
                            {{ toCountry.name ? lang('to') + ': '+toCountry.name : lang('choose_country') + ' ('+lang('to')+')' }}
                            <span class="caret"></span>
                        </label>
                        <div class="dropdown-content">
                            <ul class="dropdown-list">
                                <li class="dropdown-list-item" @click.prevent="setToCountry(c)" v-for="c in toCountries">{{ c.name }}</li>
                            </ul>
                        </div>
                    </div>
                </div>


                <div v-if="country_prices.from_home_per_kg" class="input-group">
                    <label class="input with-addon" for="take_from">{{'take_from_home'|translate}}</label>
                    <div class="addon simple"><input id="take_from" v-model="mdl.take_from" type="checkbox"></div>
                </div>

                <div v-if="country_prices.home_delivery || country_prices.home_delivery_per_kg" class="input-group">
                    <label class="input with-addon" for="home_delivery">{{'home_delivery'|translate}}</label>
                    <div class="addon simple"><input id="home_delivery" v-model="mdl.home_delivery" type="checkbox"></div>
                </div>

                <div class="input-group centered calc-button-wrapper">
                    <button style="cursor: pointer" class="btn">{{'calculate'|translate}}!</button>
                </div>
            </form>
        </div>
        <div v-show="result">
            <div class="calc-result-image">
                <img src="/images/box.png">
            </div>
            <div class="info-list">
                <div><strong>{{mdl.weight}} {{lang(mdl.weight_unit)}}</strong>, {{'from' | translate}} <strong>{{fromCountry.name}}</strong>, {{'to' | translate}} <strong>{{toCountry.name}}</strong></div>
                <!--<div class="weight"></div>-->
            </div>
            <div class="result-text">
                {{resultText}}
            </div>
            <div class="back" @click.prevent="reset">back</div>
        </div>
    </div>
</template>

<script>
let calculate = require("../mixins/calculate");
export default {
    data() {
        return {
            mdl: {
                quantity: 1,
                weight: '',
                weight_unit: 'kg',
                parcel_type: '',
                from_country_id: '',
                to_country_id: '',
                take_from: false,
                home_delivery: false
            },
            price_list: require("../prices.json"),
            countries: [],
            result: false,
            resultText: ''
        }
    },

    beforeCreate() {
        let countries = _(axios.get).partial('/json/countries').value(),
            parameters = _(axios.get).partial('/master/ajax/parameter').value();

        axios.all([countries(),parameters()])
            .then(axios.spread((c,p) => {
                if(c.data.success) {
                    this.countries = c.data.result;
                }
                if(p.data.success) {
//                    this.parameters = p.data.result;
                    this.price_list = p.data.result;
                }
            }))
            .catch(function(err) {
                console.log("Error",err);
            })
    },

    methods: {
        setFromCountry(c) {
            this.mdl.from_country_id = c.id;
            _(this.toCountries).some({id: this.mdl.to_country_id}) || (this.mdl.to_country_id = null);
        },
        setToCountry(c) {
            this.mdl.to_country_id = c.id;
        },
        kg2lb(val) {
            return parseInt(val * 2.20462262 * 10) / 10;
        },
        lb2kg(val) {
            return parseInt(val * 0.45359237 * 10) / 10;
        },
        calculatePrice() {
            let weight = this.mdl.weight_unit === 'lb' ? this.lb2kg(this.mdl.weight) : this.mdl.weight;

            if(!(this.mdl.parcel_type || this.mdl.from_country_id || this.mdl.to_country_id)) {
                alert(this.lang("_please_fill_all_fields"));
                return;
            }


            let price = this.calculate(weight*this.mdl.quantity, this.fromCountry.code, this.toCountry.code, this.prices);

            if(this.mdl.home_delivery) {
                price += this.home_delivery_price;
            }

            if(this.mdl.take_from) {
                price += this.from_home_price;
            }

            this.resultText = price + ' GBP';
            this.result = true;
        },
        reset() {
            this.resultText = '';
            this.result = false;
        }
    },
    computed: {
        prices() {
            return this.price_list[this.mdl.parcel_type] || [];
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
        toCountries() {
            let fromCountry = null;
            if(this.mdl.from_country_id) {
                fromCountry = _(this.countries).find((c)=>{
                    return c.id === this.mdl.from_country_id;
                });
            }

            if(fromCountry && fromCountry.code !== 'UK') {
                return [_(this.countries).find((c)=>{return c.code==='UK'})];
            } else if(!fromCountry) {
                return this.countries;
            }

            return _(this.countries).filter((c)=>{return c.code !== 'UK'}).value();
        },
        fromCountry() {
            return _(this.countries).find((c)=>{return c.id === this.mdl.from_country_id}) || {};
        },
        toCountry() {
            return _(this.countries).find((c)=>{return c.id === this.mdl.to_country_id}) || {};
        }
    },
    mixins: [calculate]
}
</script>