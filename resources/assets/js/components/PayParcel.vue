<template>
    <div class="profile-steps" :class="[step]">
        <transition name="trans-slide">
            <div class="step" v-show="step=='payment'">
                <form @submit.prevent="payment" method="post" class="payment-form" :class="{'loading-box': loading}">
                    <spinner></spinner>
                    <input type="hidden" name="_token" v-model="mdl.csrf">

                    <div class="input-group">
                        <label for="price">{{'price' | translate}}</label>
                        <input type="text" id="price" :value="parcel.cost" disabled class="with-addon">
                        <span class="input-addon vertical-align-wrapper" style="padding-top: 25px;">
                            <span class="vertical-align">GBP</span>
                        </span>
                    </div>

                    <div class="input-group">
                        <label for="price">{{'payment_method' | translate}}</label> 
                        <div class="dropdown">
                            <label class="input-dropdown dropdown-handle vertical-align-wrapper">
                                <span class="vertical-align">{{mdl.payment_method | translate}}</span> <span class="caret"></span>
                            </label>
                            <div class="dropdown-content">
                                <ul class="dropdown-list">
                                    <li class="dropdown-list-item" v-for="(balance, method) in payment_methods" :key="method" @click="setPaymentMethod(method)">{{method|translate}} <span v-if="balance" class="pull-right">{{balance}}</span></li>
                                </ul>
                            </div>
                        </div>

                    </div>

                    <div style="height: 50px;"></div>

                    <div class="popup-footer">
                        <!--<a href="#" class="btn btn-half white-bg">Forgot Password?</a>-->
                        <button class="btn full">{{'pay'|translate}}</button>
                    </div>
                </form>
            </div>
        </transition>
        <transition name="trans-slide-2">
            <unicard-sms-code v-show="step=='payment-sms-code'" ref="unicardSmsCode" class="step"></unicard-sms-code>
        </transition>
    </div>
</template>

<script>
let UnicardSmsCode = require("./UnicardSMSCode.vue");
export default {
    data() {
        return {
            mdl: {
                payment_method: 'with_balance'
            },
            payment_methods: {
                'with_balance':'',
                'with_xero':'',
                'with_unicard':''
            },
            step: 'payment',
            loading: false
        }
    },
    methods: {
        setPaymentMethod(m) {
            this.mdl.payment_method = m;
        },
        payment() {
            this.loading = true;
            if(this.mdl.payment_method === 'with_xero') {
                let w = window.open(this.parcel.xero_payment_url);
                this.watchForClose(w, () => {
                    this.loading = false;
                });
            } else if(this.mdl.payment_method === 'with_balance') {
                axios.get("/json/orders/payment/"+this.parcel.id)
                    .then(res => {
                        if(res.data.success) {
                            alert(res.data.result, "Kiwi Post", true, () => {
                                location.reload();
                            });
                        } else {
                            alert(res.data.error, "Kiwi post error", false);
                        }
                        this.loading = false;
                    });
            } else if(this.mdl.payment_method==='with_unicard') {
                axios.get("/json/orders/payment/byUnicard/"+this.parcel.id)
                    .then(res => {
                        if(res.data.success){
                            alert(res.data.result, "Kiwi Post", true, () => {
                                this.unicard();
                            });
                        }else{
                            alert(res.data.error,"Kiwi post error", false);
                            this.loading = false;
                        }
                    })
                
            } else {
                this.loading = false;
            }
        },
        unicard() {
            this.$refs.unicardSmsCode.show(this.parcel.id); 
        },
        watchForClose(w, cb) {
            if(window._winInterval) clearInterval(window._winInterval);
            window._winInterval = setInterval(() => {
                if(w.closed) {
                    clearInterval(window._winInterval);
                    cb();
                }
            },100);
        }
    },
    mounted() {
        axios.get("/json/user/balances/")
        .then(res => {
            if(res.data.success) {
                this.payment_methods.with_balance = res.data.result.balance.toString();
                this.payment_methods.with_unicard = res.data.result.unicard;
            }
        })

        $(this.$el).find(".dropdown").dropdown({autoclose: true});
    },
    props: {
        parcel: {
            'default'() {return {};}
        }
    },

    components: {
        UnicardSmsCode
    }
}
</script>