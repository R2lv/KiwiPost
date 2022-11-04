<template>
    <div :class="{'loading-box': loading}">
        <spinner></spinner>
        <div class="input-group" :class="{'error': errorFields.unicard}">
            <label for="unicard">{{'unicard' | translate}}</label>
            <a :href="'no_unicard_url'|translate" target="_blank" class="pull-right unicardN">{{'no_unicard'|translate}}</a>
            <input type="text" v-model="$parent.mdl.unicard.unicard" @blur="errorFields.unicard = false" id="unicard" :placeholder="'unicard'|translate">
        </div>
        <div class="input-group" :class="{'error': errorFields.password}">
            <label for="password3">{{'your_password' | translate}} <span class="red">*</span></label>
            <input type="password" v-model="$parent.mdl.unicard.password" @blur="errorFields.password = false" id="password3" :placeholder="'your_password' | translate">
        </div>
        <div class="popup-footer">
            <div class="btn-group length-2">
                <a href="#" class="btn white-bg" @click.prevent="$parent.setStep('main')">{{'back' | translate}}</a>
                <a href="#" @click.prevent="save" class="btn">{{'change_unicard' | translate}}</a>
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
            axios.post("/json/user/update/unicard", _(this.$parent.mdl.unicard).pick(['unicard','password']).value())
                .then(res => {
                    if(res.data.success) {
                        alert(res.data.result, false, true, ()=>{
                            this.$parent.setStep('main');
                            this.loading = false;
                        });
                    } else {
                        var message = res.data.error.message;
                        if(message != undefined) {
                            alert(res.data.error.message,false,false);
                        }
                        this.errorFields = res.data.error;
                        this.loading = false;
                    }
                });
        }
    }
}
</script>