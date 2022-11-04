<template>
    <div :class="{'loading-box': loading}">
        <spinner></spinner>
        <div class="input-group" :class="{'error': errorFields.mobile_token}">
            <label for="mobile_token">{{'sms_code_sent_to_your_number'|translate}}</label>
            <input v-model="mdl.mobile_token" @blur="errorFields.mobile_token = false" maxlength="6" minlength="6" id="mobile_token" :placeholder="'enter_sms_code' | translate">
        </div>

        <div class="popup-footer" style="margin-top: 105px;">
            <div class="btn-group length-3">
                <a href="#" class="btn white-bg" @click.prevent="$parent.prompt=false">{{'edit_number'|translate}}</a>
                <a href="#" class="btn white-bg" @click.prevent="resend">{{'resend_code'|translate}}</a>
                <a href="#" @click.prevent="save" class="btn">{{'change_number'|translate}}</a>
            </div>
        </div>

    </div>
</template>
<script>
export default {
    data() {
        return {
            mdl: {
                mobile_token: ""
            },
            errorFields: {},
            loading: false
        }
    },
    methods: {
        resend() {
            if(this.loading) return;

            this.loading = true;

            this.mdl.errorFields = {};
            axios.post("/json/user/newsms")
                .then(res => {
                    if(res.data.success)
                        alert(res.data.result, "Kiwipost");
                    else {
                        alert(res.data.error, "Kiwipost", true);
                    }
                    this.loading = false;
                })
        },
        save() {
            if(this.loading) return;

            this.loading = true;
            axios.post('/json/user/smstoken', _(this.mdl).pick(['mobile_token']).value())
                .then(res => {
                    if(res.data.success) {
                        this.$parent.success();
                    } else {
                        this.errorFields = res.data.error;
                    }
                    this.loading = false;
                })
                .catch(err => {
                    console.log("Error", err);
                })
        }
    }
}
</script>