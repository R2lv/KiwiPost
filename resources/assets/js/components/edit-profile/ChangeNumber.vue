<template>
    <div>
    <transition name="trans-slide">
    <div v-if="!prompt" class="step" style="width: 100%" :class="{'loading-box': loading}">
        <spinner />
        <div class="input-group" :class="{'error': errorFields.mobile}">
            <label for="phone_number">{{'new_phone_number'|translate}}</label>
            <masked-input v-if="mobile_mask" :mask="mobile_mask" placeholder-char=" " v-model="$parent.mdl.mobile.mobile" @blur="errorFields.mobile = false" id="phone_number" :placeholder="'new_phone_number'|translate" />
            <input v-else v-model="$parent.mdl.mobile.mobile" @blur="errorFields.mobile = false" id="phone_number" :placeholder="'new_phone_number'|translate">
        </div>
        <div class="input-group" :class="{'error': errorFields.current_password}">
            <label for="current_password2">{{'your_password'|translate}} <span class="red">*</span></label>
            <input type="password" v-model="$parent.mdl.mobile.current_password" @blur="errorFields.current_password = false" id="current_password2" :placeholder="'your_password'|translate">
        </div>

        <div class="popup-footer">
            <div class="btn-group length-2">
                <a href="#" class="btn white-bg" @click.prevent="$parent.setStep('main')">{{'back'|translate}}</a>
                <a href="#" @click.prevent="save" class="btn">{{'send_me_code'|translate}}</a>
            </div>
        </div>
    </div>
    </transition>
    <transition name="trans-slide-2">
    <div v-if="prompt" class="step" style="width: 100%;">
        <prompt />
    </div>
    </transition>
    </div>
</template>

<script>
import MaskedInput from "vue-masked-input";

let ChangeNumberPrompt = Vue.extend(require("./ChangeNumberPrompt.vue"));
export default {
    data() {
        return {
            errorFields: {},
            p: null,
            prompt: false,
            loading: false
        }
    },
    props: ['verify_phone'],
    methods: {
        save() {
            this.loading = true;
            axios.post('/json/user/sms', _(this.$parent.mdl.mobile).pick(['mobile','current_password']).value())
                .then(res => {
                    if(res.data.success) {
                        this.prompt = true;
                        this.loading = false;
                    } else {
                        this.loading = false;
                        this.errorFields = res.data.error;
                    }
                })
                .catch(err => {
                    console.log("Error", err);
                })
        },
        success() {
            this.prompt = false;
            this.loading = true;
            alert(this.lang("number_changed_successfully"), false, true, () => {
                location.reload();
            })
        }
    },
    computed: {
    	mobile_mask() {
    		return this.$parent.mdl.address.country.code === 'GE' ? "\\9\\9\\5 \\511 11 11 11" : false;
	    }
    },
    watch: {
        verify_phone(val) {
            this.prompt = val;
        }
    },
    components: {
	    MaskedInput,
	    Prompt: ChangeNumberPrompt
    }
}
</script>