<template>
    <form action="" @submit.prevent="login" :class="{'loading-box': loading}">
        <spinner></spinner>
        <div class="input-group" :class="{'error': errorFields.email}">
            <label for="email">{{'email' | translate}}</label>
            <input v-model="mdl.email" @blur="errorFields.email = false" id="email" :placeholder="'email'|translate">
        </div>
        <div class="input-group" :class="{'error': errorFields.password}">
            <label for="password">{{'password'|translate}}</label>
            <input type="password" v-model="mdl.password" @blur="errorFields.password = false" id="password" :placeholder="'password'|translate">
        </div>
        <div class="error" v-if="error">{{ error }}</div>
        <div class="popup-footer">
            <div class="btn-group length-2">
                <a href="#" class="btn btn-half white-bg recover-password" @click.prevent="showPasswordRecoveryWindow">{{'forgot_password'|translate}}?</a>
                <button class="btn btn-half">{{'login'|translate}}</button>
            </div>
            <div class="btn-group length-1" v-if="showRegButton">
                <a href="#" class="btn white-bg full" @click.prevent="showRegistrationWindow">{{'register'|translate}}</a>
            </div>
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
            },
            showRegButton: true,
            loading: false
        }
    },

    methods: {
        login() {
            this.errorFields = {};
            this.error = "";
            this.loading = true;
            axios.post("/login", this.mdl)
                .then(res => {
                    if(res.data.success) {
                        this.error = false;
                        location.href = '/';
                    } else {
                        this.loading = false;
                        this.error = res.data.error;
                        this.errorFields = {
                            email: true,
                            password: true
                        }
                    }
                })
                .catch((err) => {
                    this.loading = false;
                    console.log("Error", err);
                })
        },
        showRegistrationWindow() {
            if(this.$parent) {
                this.$parent.showRegistrationWindow();
            }
        },
        showPasswordRecoveryWindow() {
            if(this.$parent) {
                this.$parent.showPasswordRecoveryWindow();
            }
        }
    },
    mounted() {

    }
}
</script>