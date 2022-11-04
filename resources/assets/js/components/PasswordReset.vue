<template>
    <form action="" @submit.prevent="recover" :class="{'loading-box': loading}">
        <spinner></spinner>
        <div class="input-group" :class="{'error': errorFields.email}">
            <label for="email">{{'email'|translate}}</label>
            <input v-model="mdl.email" @blur="errorFields.email = ''" id="email" :placeholder="'email'|translate">
        </div>
        <div class="error" v-if="error">{{ error }}</div>
        <div class="popup-footer">
            <div class="btn-group length-2">
                <button type="button" class="btn btn-half white-bg login-btn">{{'login' | translate}}</button>
                <button class="btn btn-half">{{'reset'|translate}}</button>
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
            },
            error: false,
            errorFields: {},
            loading: false
        }
    },

    methods: {
        recover() {
            this.errorFields = {};
            this.error = "";
            this.loading = true;
            axios.post("/password/recovery", this.mdl)
                .then((res) => {
                    if(res.data.success) {
                        this.error = false;
                        alert(res.data.result, "Kiwipost", true, () => {
                            location.reload();
                        });
                    } else {
                        this.loading = false;
                        this.errorFields = res.data.error;
                        if(res.data.error.alert) {
                            alert(res.data.error.alert, "Kiwipost");
                        }
                    }
                })
                .catch((err) => {
                    this.loading = false;
                    console.log("Error", err);
                })
        }
    }
}
</script>