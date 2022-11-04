<template>
    <div :class="{'loading-box': loading}">
        <spinner />
        <div class="input-group" :class="{'error': errorFields.email}">
            <label for="email">{{'email_address' | translate}}</label>
            <input type="email" v-model="$parent.mdl.email.email" @blur="errorFields.email = false" id="email" :placeholder="'email_address'|translate">
        </div>
        <div class="input-group" :class="{'error': errorFields.password}">
            <label for="password2">{{'your_password' | translate}} <span class="red">*</span></label>
            <input type="password" v-model="$parent.mdl.email.password" @blur="errorFields.password = false" id="password2" :placeholder="'your_password' | translate">
        </div>
        <div class="popup-footer">
            <div class="btn-group length-2">
                <a href="#" class="btn white-bg" @click.prevent="$parent.setStep('main')">{{'back' | translate}}</a>
                <a href="#" @click.prevent="save" class="btn">{{'change_email' | translate}}</a>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            errorFields: {},
            mdl: {},
            loading: false
        }
    },
    methods: {
        save() {
            this.loading = true;
            axios.post("/json/user/update/email", _(this.$parent.mdl.email).pick(['email','password']).value())
                .then(res => {
                    if(res.data.success) {
                        alert("Email changed successfully", false, true, ()=>{
                            this.$parent.setStep('main');
                            this.loading = false;
                        });
                    } else {
                        this.errorFields = res.data.error;
                        this.loading = false;
                    }
                });
        }
    }
}
</script>