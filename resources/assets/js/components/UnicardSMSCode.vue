<template>
    <form @submit.prevent="submit" class="step">
        <div class="input-group">
            <label for="code">{{'sms_code'|translate}}</label>
            <input type="text" :placeholder="'sms_code'|translate" required id="code" autocomplete="off" v-model="mdl.sms_code">
        </div>

        <div class="popup-footer">
            <div class="btn-group length-3">
                <button type="button" class="btn white-bg" @click.prevent="back">{{'back'|translate}}</button>
                <button type="button" class="btn white-bg" @click.prevent="resend">{{'resend'|translate}}</button>
                <button class="btn">{{'pay'|translate}}</button>
            </div>
        </div>
    </form>
</template>
<script>
export default {

    data() {
        return {
            mdl: {
                sms_code: "",
                order_id: "",
            }
        }
    },

    methods: {
        submit() {

            axios.get("/json/orders/payment/PayByUnicard/"+this.mdl.orderId+"/"+this.mdl.sms_code)
                .then(res => {
                    if(res.data.success){
                        alert(res.data.result, "Kiwi Post", true, () => {
                            location.reload();                 
                        });
                    }else{
                        alert(res.data.error,"Kiwi post error", false);
                        this.mdl.sms_code = '';
                        this.loading = false;
                    }
                })
        }, 
        show(order_id) {
            this.$parent.step = 'payment-sms-code';
            // this.resend();
            this.mdl.orderId = order_id;
        },
        resend() {
            axios.get("/json/orders/payment/resendSms/"+this.mdl.orderId)
                .then(res => {
                    if(res.data.success){
                        alert(res.data.result, "Kiwi Post", true);
                        this.mdl.sms_code = '';
                    }else{
                        alert(res.data.error,"Kiwi post error", false);
                        this.mdl.sms_code = '';
                        this.loading = false;
                    }
                })

        },
        back() {
            this.$parent.step='payment';
            this.$parent.loading = false;
        }
    }
}
</script>