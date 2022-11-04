<template>
<div class="profile-steps" :class="[step, loading&&'loading-box']">
    <spinner />
    <transition name="trans-slide">
        <div class="step" v-show="isStep('main')">
            <div class="profile-edit-inputs">
                <div class="input-group">
                    <div class="p-input" @click="setStep('address')">{{'change_address' | translate}} <div class="caret-right"></div></div>
                </div>
                <div class="input-group">
                    <div class="p-input" @click="setStep('email')">{{'change_email_address' | translate}} <div class="caret-right"></div></div>
                </div>
                <div class="input-group">
                    <div class="p-input" @click="setStep('number')">{{'change_phone_number' | translate}} <div class="caret-right"></div></div>
                </div>
                <div class="input-group">
                    <div class="p-input" @click="setStep('password')">{{'change_password' | translate}} <div class="caret-right"></div></div>
                </div>
                <div class="input-group">
                    <div class="p-input" @click="setStep('unicard')">{{'change_unicard' | translate}} <div class="caret-right"></div></div>
                </div>

            </div>
        </div>
    </transition>

    <transition name="trans-slide-2">
        <edit-address class="step" v-show="isStep('address')" />
    </transition>
    <transition name="trans-slide-2">
        <change-email class="step" v-show="isStep('email')" />
    </transition>
    <transition name="trans-slide-2">
        <change-number class="step" :verify_phone="verify_phone" v-show="isStep('number')" />
    </transition>
    <transition name="trans-slide-2">
        <change-password class="step" v-show="isStep('password')" />
    </transition>
    <transition name="trans-slide-2">
        <edit-unicard class="step" v-show="isStep('unicard')" />
    </transition>

</div>
</template>

<script>
const EditAddress = require("./edit-profile/EditAddress.vue"),
    ChangeEmail = require("./edit-profile/ChangeEmail.vue"),
    ChangeNumber = require("./edit-profile/ChangeNumber.vue"),
    EditUnicard = require("./edit-profile/EditUnicard.vue"),
    ChangePassword = require("./edit-profile/ChangePassword.vue");
export default {
    data() {
        return {
            mdl: {
                address: {country:{}},
                email: {},
                mobile: {},
                unicard: {unicard: ""}
            },
            errorFields: {},
            step: 'main',
            autoStep: false,
            verify_phone: false,
            loading: true
        }
    },
    created() {
        this.reload();
    },

    mounted: function(){
        !!this.popup&&this.popup.show();
        let goTo;
        if(this.autoStep) {
            goTo = this.autoStep;
        }


        if(this.customData) {
            goTo = this.customData;
        }


        if(goTo) {
            if(goTo === 'verify_number') {
//                console.log("Changing");
                this.verify_phone = true;
                goTo = 'number';
//                return;
            }
            setTimeout(()=>{
                this.setStep(goTo);
            },500);
        }
    },

    methods: {
        reload() {
            this.loading = true;
            axios.post("/json/user/get/address")
                .then(res => {
                    if(res.data.success) {
                        this.mdl.address = _(res.data.result).pick([
                            'country','country_id','city_town','postcode','address_1','address_2'
                        ]).value();
                        this.mdl.email = {email: res.data.result.email, password: ""};
                        this.mdl.mobile = {mobile: res.data.result.mobile, password: ""};
                        this.mdl.unicard = {unicard: res.data.result.unicard};
                    }
                    this.loading = false;
                })
                .catch(err => {
                    console.log("Error",err);
                    this.loading = false;
                });
        },
        setStep(step) {
            if(step==='main') this.reload();
            this.step = step;
        },
        isStep: function(step) {
            return this.step === step;
        }
    },

    components: {
        EditAddress,
        ChangePassword,
        ChangeEmail,
        ChangeNumber,
        EditUnicard
    },
    props: ['customData']
}
</script>