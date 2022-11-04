<template>
    <form action="" @submit.prevent="change">
        <div class="input-group" :class="{'error': errorFields.email}">
            <label for="email">{{'new_email_address' | translate}}</label>
            <input v-model="mdl.email" @blur="errorFields.email = false" id="email" :placeholder="'new_email_address' | translate">
        </div>
        <div class="input-group" :class="{'error': errorFields.password}">
            <label for="password">{{'your_password' | translate}}</label>
            <input type="password" v-model="mdl.password" @blur="errorFields.password = false" id="password" :placeholder="'your_password'|translate">
        </div>
        <div class="error" v-if="error">{{ error }}</div>
        <div class="popup-footer">
                <!--<a href="#" class="btn btn-half white-bg">Forgot Password?</a>-->
                <button class="btn full">{{'save' | translate}}</button>
        </div>
    </form>
</template>

<script>
export default {
    data() {
        return {
            mdl: {
                email: "",
                password: ""
            },
            error: false,
            errorFields: {
                email: false,
                password: false
            }
        }
    },

    methods: {
        change() {
            this.errorFields = {};
            this.error = "";

            axios.post("/email/edit", this.mdl)
                .then(function(res) {
                    if(res.data.success) {
                        this.error = false;
                        location.href = '/home';
                    } else {
                        this.error = res.data.error;
                        this.errorFields = {
                            email: true,
                            password: true
                        }
                    }
                }.bind(this))
                .catch(function(err) {
                    console.log("Error", err);
                })
        }
    }
}
</script>