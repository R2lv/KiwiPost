<template>
    <form @submit.prevent="send" :class="{'loading-box': loading}">
        <spinner></spinner>
        <div class="input-group" :class="{'error': errorFields.title}">
            <label for="title">{{'title'|translate}}</label>
            <input v-model="mdl.title" @blur="errorFields.title = false" id="title" :placeholder="'title'|translate">
        </div>
        <div class="input-group" :class="{'error': errorFields.name}">
            <label for="name">{{'name'|translate}}</label>
            <input v-model="mdl.name" @blur="errorFields.name = false" id="name" :placeholder="'name'|translate">
        </div>
        <div class="input-group" :class="{'error': errorFields.email}">
            <label for="email">{{'email'|translate}}</label>
            <input v-model="mdl.email" @blur="errorFields.name = false" id="email" :placeholder="'email'|translate">
        </div>
        <div class="input-group" :class="{'error': errorFields.message}">
            <label for="message">{{'message'|translate}}</label>
            <textarea v-model="mdl.message" @blur="errorFields.title = false" id="message" :placeholder="'message'|translate"></textarea>
        </div>
        <div class="error" v-if="error">{{ error }}</div>
        <div class="popup-footer">
            <div class="btn-group length-1">
                <!--<a href="#" class="btn btn-half white-bg">Forgot Password?</a>-->
                <button class="btn full">{{'send'|translate}}</button>
            </div>
        </div>
    </form>
</template>

<script>
export default {
    data() {
        return {
            mdl: {
                name: "",
                email: "",
                title: "",
                message: ""
            },
            error: false,
            errorFields: {},
            loading: false
        }
    },

    methods: {
        send() {
            if(this.loading) return;

            this.loading = true;
            axios.post('/json/contact/mail', _(this.mdl).pick(['name','title','message','email']).assign({country: this.customData}).value())
                .then(res => {
                    this.loading = false;
                    if(res.data.success) {
                        alert("Mail sent successfully", "Success", false, () => {
                            this.mdl = {
                                name: "",
                                email: "",
                                title: "",
                                message: ""
                            };
                            console.log("P", this.p);
                            if(this.p) this.p.exit();
                            else location.href = '/contacts';
                        });
                    } else {
                        this.errorFields = res.data.error;
                    }
                })
        }
    },
    props: {
        customData: {
            required: true
        },
        p: {
            'default': false
        }
    }
}
</script>