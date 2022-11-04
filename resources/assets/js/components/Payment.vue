<template>
    <form action="/payment" @submit="payment" method="post" class="payment-form" :class="{'loading-box': loading}">
        <spinner></spinner>
        <div class="warning-text">
            Please note that our wallet supports only GBP currency.<br>
            You can pay with your currency, we will convert it to GBP.
        </div>
        <input type="hidden" name="_token" v-model="mdl.csrf">

        <div class="input-group">
            <label for="amount_to">Amount (GBP)</label>
            <div class="group-wrapper">
                <input v-model.number="mdl.amount_to" @keyup="toChanged" type="number" autocomplete="off" min="0.01" step="0.01" class="with-addon" name="amount" style="padding-right: 60px !important;" id="amount_to" placeholder="Type amount">
                <label class="input-addon vertical-align-wrapper" style="width: 60px; padding-left: 10px;">
                    <span class="vertical-align">{{'GBP_symbol' | translate('en')}} (GBP)</span>
                </label>
            </div>
        </div>


        <div class="input-group">
            <label for="amount">Your amount</label>
            <div class="group-wrapper">
                <input v-model.number="mdl.amount_from" disabled type="number" min="0.01" step="0.01" class="with-addon" id="amount" style="padding-right: 60px !important; background-color: #F0F0F0">
                <div class="dropdown addon-dropdown autoclose" style="width: 60px; background-color: #FFF;">
                    <label class="dropdown-handle vertical-align-wrapper">
                        <span class="vertical-align" style="padding-left: 10px;">{{mdl.currency}}</span> <span class="caret"></span>
                    </label>
                    <div class="dropdown-content">
                        <ul class="dropdown-list">
                            <li class="dropdown-list-item" v-for="currency in currencies" @click="setCurrency(currency)">{{currency}}</li>
                        </ul>
                    </div>
                </div>
                <input type="hidden" name="currency" v-model="mdl.currency">
            </div>
        </div>

        <div class="popup-footer">
            <!--<a href="#" class="btn btn-half white-bg">Forgot Password?</a>-->
            <button class="btn full">Make payment</button>
        </div>
    </form>
</template>

<script>
export default {
    data() {
        return {
            mdl: {
                csrf: "",
                amount_from: 0,
                amount_to: 0,
                currency: ''
            },
            currencies: ['USD','GEL'],
            rates: [],
            loading: true
        }
    },
    mounted() {
        axios.post("/json/currencies")
            .then(res => {
                this.loading = false;
                if(res.data.success) {
                    this.rates = res.data.result;
                    this.rates.GELGBP = this.rates['GELGBP'];


                    this.mdl.csrf = $("meta[name=csrf-token]").attr("content");
                    this.setCurrency(this.currencies[1]);
                    $(this.$el).find(".dropdown").dropdown({autoclose: true});
                }else{
                    alert(res.data.error, "Kiwipost", true, () => {
                         location.reload();
                    });
                }
            });
    },
    methods: {
        setCurrency(currency) {
            let fire = false;
            if(this.mdl.currency) {
                fire = true;
            }
            this.mdl.currency = currency;
            fire&&this.toChanged();
        },
        fromChanged() {
            this.mdl.amount_to = this.round((this.mdl.amount_from * this.rates[this.mdl.currency+'GBP']));
        },
        toChanged() {
            this.mdl.amount_from = this.round((this.mdl.amount_to * this.rates['GBP'+this.mdl.currency]));
        },
        round(num) {
            return Math.round(num*100)/100
        },
        payment() {
            this.loading = true;
        }
    }
}
</script>