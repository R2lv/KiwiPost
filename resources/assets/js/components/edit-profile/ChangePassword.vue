<template>
    <div>
        <div :class="{'loading-box': loading}">
            <spinner />
            <div class="input-group" :class="{'error': errorFields.password}">
                <label for="password4">{{'new_password'|translate}}</label>
                <input type="password" v-model="mdl.password" @blur="errorFields.password = false" id="password4" :placeholder="'new_password'|translate">
            </div>
            <div class="input-group" :class="{'error': errorFields.password_confirmation}">
                <label for="password_confirmation">{{'repeat_new_password'|translate}}</label>
                <input type="password" v-model="mdl.password_confirmation" @blur="errorFields.password_confirmation = false" id="password_confirmation" :placeholder="'repeat_new_password'|translate">
            </div>
            <div class="input-group" :class="{'error': errorFields.current_password}">
                <label for="current_password">{{'your_current_password'|translate}} <span class="red">*</span></label>
                <input type="password" v-model="mdl.current_password" @blur="errorFields.current_password = false" id="current_password" :placeholder="'your_current_password'|translate">
            </div>

            <div class="popup-footer">
                <div class="btn-group length-2">
                    <a href="#" class="btn white-bg" @click.prevent="$parent.setStep('main')">{{'back'|translate}}</a>
                    <a href="#" @click.prevent="save" class="btn">{{'change_password'|translate}}</a>
                </div>
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
            axios.post("/json/user/update/password", _(this.mdl).pick(['password','password_confirmation','current_password']).value())
                .then(res => {
                    this.loading = false;
                    if(res.data.success) {
                        alert(res.data.result, false, true, () => {
                            this.mdl = {};
                            this.$parent.setStep('main');
                        });
                    } else {
                        this.errorFields = res.data.error;
                    }
                })
                .catch(err => {
                    this.loading = false;
                    console.log("Error",err);
                })
        }
    }
}
</script>