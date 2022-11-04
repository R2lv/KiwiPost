<template>
    <form action="" @submit.prevent="register" :class="{'loading-box': loading}">
        <spinner />
        <div class="step" :class="{'hidden': step!==1}">

            <div class="input-group" :class="{'error': errorFields.email}">
                <label for="email">{{'email' | translate}}</label>
                <input type="text" v-model="mdl.email" @blur="errorFields.email = false" :title="errorFields.email" id="email" :placeholder="'email' | translate">
                <i class="addon material-icons" v-if="errorFields.email">
                    info_outline
                    <span class="error-text" v-html="err('email')"></span>
                </i>
            </div>

            <div class="input-group" :class="{'error': errorFields.password}">
                <label for="password">{{'password' | translate}}</label>
                <input type="password" v-model="mdl.password" @blur="errorFields.password = false" :title="errorFields.password" id="password" :placeholder="'password' | translate">
                <i class="addon material-icons" v-if="errorFields.password">
                    info_outline
                    <span class="error-text" v-html="err('password')"></span>
                </i>
            </div>

            <div class="input-group" :class="{'error': errorFields.password_confirmation}">
                <label for="password-repeat">{{'confirm_password' | translate}}</label>
                <input type="password" v-model="mdl.password_confirmation" @blur="errorFields.password_confirmation = false" :title="errorFields.password_confirmation" id="password-repeat" :placeholder="'confirm_password' | translate">
                <i class="addon material-icons" v-if="errorFields.password_confirmation">
                    info_outline
                    <span class="error-text" v-html="err('password_confirmation')"></span>
                </i>
            </div>

            <div class="input-group" :class="{'error': errorFields.country_id}">
                <label>{{'choose_country' | translate}}</label>

                <div class="dropdown">
                    <div class="input-dropdown dropdown-handle">{{ country.name ? country.name : 'choose_country' | translate }}<span class="caret"></span></div>
                    <div class="dropdown-content">
                        <ul class="dropdown-list">
                            <li v-for="c in countries" :key="c.id" class="dropdown-list-item" @click="setCountry(c)">{{c.name}}</li>
                        </ul>
                    </div>
                </div>
                <i class="addon material-icons" v-if="errorFields.country_id">
                    info_outline
                    <span class="error-text" v-html="err('country_id')"></span>
                </i>
            </div>

            <div class="input-group inline" style="margin-bottom: 0;">
                <label class="checkbox-wrapper" title="Get offers and updates. You can opt out at any time." style="padding-bottom: 0">
                    {{"subscribe_newsletter" | translate}}
                    <input v-model="mdl.newsletter" value="newsletter" type="checkbox">
                </label><br>
            </div>

            <div class="input-group inline" style="margin-bottom: 0;">
                <label class="checkbox-wrapper" title="Get offers and updates. You can opt out at any time.">
                    <a target="_blank" style="text-decoration: none; color: inherit;" href="/Terms.pdf">{{"accept_terms" | translate}}</a>
                    <input v-model="mdl.terms" value="terms" type="checkbox">
                </label>
            </div>
 
            <div class="error" v-if="errorFields.terms">{{err('terms')}}</div>
        </div>

        <div class="step" :class="{'hidden': step!==2}">
            <div class="input-group" :class="{'error': errorFields.name}">
                <label for="name">{{'name' | translate}}</label>
                <input v-model="mdl.name" @blur="errorFields.name = false" :title="errorFields.name" id="name" :placeholder="'name' | translate">
                <i class="addon material-icons" v-if="errorFields.name">
                    info_outline
                    <span class="error-text" v-html="err('name')"></span>
                </i>
            </div>
            <div class="input-group" :class="{'error': errorFields.surname}">
                <label for="lastname">{{'lastname' | translate}}</label>
                <input v-model="mdl.surname" @blur="errorFields.surname = false" :title="errorFields.surname" id="lastname" :placeholder="'lastname' | translate">
                <i class="addon material-icons" v-if="errorFields.surname">
                    info_outline
                    <span class="error-text" v-html="err('surname')"></span>
                </i>
            </div>
            <div class="input-group" :class="{'error': errorFields.personal_number}">
                <label for="personal_number">{{'personal_number' | translate}}</label>
                <input v-model="mdl.personal_number" @blur="errorFields.personal_number = false" :title="errorFields.personal_number" id="personal_number" :placeholder="'personal_number' | translate">
                <i class="addon material-icons" v-if="errorFields.personal_number">
                    info_outline
                    <span class="error-text" v-html="err('personal_number')"></span>
                </i>
            </div>
            <div class="input-group" :class="{'error': errorFields.mobile}">
                <label for="number">{{'phone_number' | translate}}</label>
                <masked-input v-if="mobile_mask" v-model="mdl.mobile" @blur="errorFields.mobile = false" :mask="mobile_mask" placeholder-char=" " :title="errorFields.mobile" id="number" :placeholder="'phone_number' | translate" />
                <input v-else v-model="mdl.mobile" @blur="errorFields.mobile = false" :title="errorFields.mobile" id="number" :placeholder="'phone_number' | translate" />
                <i class="addon material-icons" v-if="errorFields.mobile">
                    info_outline
                    <span class="error-text" v-html="err('mobile')"></span>
                </i>
            </div>
            <div class="input-group" :class="{'error': errorFields.city_town}">
                <label for="city_town">{{'city_town' | translate}}</label>
                <input v-model="mdl.city_town" @blur="errorFields.city_town = false" :title="errorFields.city_town" id="city_town" :placeholder="'city_town' | translate">
                <i class="addon material-icons" v-if="errorFields.city_town">
                    info_outline
                    <span class="error-text" v-html="err('city_town')"></span>
                </i>
            </div>
            <div class="input-group" :class="{'error': errorFields.postcode}">
                <label for="postcode">{{'post_code' | translate }}</label>
                <a v-if="country.id == 1" :href="'n_post_index'|translate" target="_blank" class="pull-right unicardN">{{'no_post_index'|translate}}</a>
                <input v-model="mdl.postcode" @blur="errorFields.postcode = false" :title="errorFields.postcode" id="postcode" :placeholder="'post_code' | translate">
                <i class="addon material-icons" v-if="errorFields.postcode">
                    info_outline
                    <span class="error-text" v-html="err('postcode')"></span>
                </i>
            </div>
            <div class="input-group" :class="{'error': errorFields.address_1}">
                <label for="address_1">{{'address_1' | translate}}</label>
                <input v-model="mdl.address_1" @blur="errorFields.address_1 = false" :title="errorFields.address_1" id="address_1" :placeholder="'address_1' | translate">
                <i class="addon material-icons" v-if="errorFields.address_1">
                    info_outline
                    <span class="error-text" v-html="err('address_1')"></span>
                </i>
            </div>

            <div class="input-group" :class="{'error': errorFields.address_2}">
                <label for="address_2">{{'address_2' | translate}}</label>
                <input v-model="mdl.address_2" @blur="errorFields.address_2 = false" :title="errorFields.address_2" id="address_2" :placeholder="'address_2' | translate">
                <i class="addon material-icons" v-if="errorFields.address_2">
                    info_outline
                    <span class="error-text" v-html="err('address_2')"></span>
                </i>
            </div>


            <div class="input-group" :class="{'error': errorFields.unicard}">
                <label for="unicard">{{'unicard' | translate}}</label>
                <a :href="'no_unicard_url'|translate" target="_blank" class="pull-right unicardN">{{'no_unicard'|translate}}</a> 
                <masked-input v-model="mdl.unicard" @blur="errorFields.unicard = false" :title="errorFields.unicard" mask="\1\111 1111 1111 1111" id="unicard" placeholder-char="-" :placeholder="'unicard' | translate" />
                <i class="addon material-icons" v-if="errorFields.unicard">
                    info_outline
                    <span class="error-text" v-html="err('unicard')"></span>
                </i>
            </div> 

            <div id="recaptcha"></div>

            <div class="error" v-if="errorFields['g-recaptcha-response']" v-html="errorFields['g-recaptcha-response'].join('<br>')"></div>

        </div>
        <div class="popup-footer">
            <div class="btn-group length-2">
                <div :class="{'hidden': step!==1}">
                    <a href="#" class="btn white-bg login-btn" @click.prevent="showLoginWindow">{{'already_member?' | translate}}</a>
                    <a href="#" @click.prevent="validate" class="btn">{{'next' | translate}}</a>
                </div>
                <div :class="{'hidden': step!==2}">
                    <a href="#" class="btn white-bg" @click.prevent="goToStep(1)">{{'back' | translate}}</a>
                    <button class="btn">{{'register' | translate}}</button>
                </div>
            </div>
        </div>
    </form>
</template>

<script>
import MaskedInput from "vue-masked-input";

let err = require("../mixins/err");
export default {
	components: {MaskedInput},
	data() {
        return {
            mdl: {
                name: "",
                surname: "",
                email: "",
                address_1: "",
                address_2: "",
                personal_number: "",
                country_id: "",
                postcode: "",
                city_town: "",
                mobile: "",
                password: "",
                password_confirmation: "",
                newsletter: true,
                terms: false,
                unicard: ''
            },
            errorFields: {},
            countries: [],
            country: {}, 
            step: 1,
            recaptcha_id: "",
            loading: true
        }
    },
    beforeCreate() {
        axios.post("/json/countries")
            .then(res => {
                if(res.data.success)
                    this.countries = res.data.result;

                this.loading = false;
            })
            .catch(err => {
                console.log("Axios error:", err);
                this.loading = false;
            })
    },

    mounted: function(){
        $(this.$el).find(".dropdown").dropdown({autoclose: true});
        $(this.$el).find("[data-mask]").each((i,e)=>{
            $(e).inputmask({mask: $(e).data("mask")});
        });
        this.recaptcha_id = grecaptcha.render($(this.$el).find('#recaptcha').get(0), {
            "sitekey": "6LeRFToUAAAAAOiWBvVm1u4nz5OVsPHcG3VVD8Du",
            "size": "invisible",
            "callback": this.recaptcha
        });
    },

    methods: {
        validate() {
            this.errorFields = {};
            this.loading = true;
            axios.post("/register/validate", _.pick(this.mdl, ['country_id', 'email', 'password', 'password_confirmation', 'terms'])).then(res => {
                if(res.data.success) {
                    this.goToStep(2);
                } else {
                    this.errorFields = res.data.error;
                }
                this.loading = false;
            })
            .catch(err => {
                console.log("Error", err);
                this.loading = false;
            });
        },
        recaptcha(response) {
            this.mdl['g-recaptcha-response'] = response;
            axios.post("/register", this.mdl)
                .then(res => {
                    if(res.data.success) {
                        location.href = '/';
                    } else {
                        this.errorFields = res.data.error;
                        grecaptcha.reset(this.recaptcha_id);
                    }
                    this.loading = false;
                })
                .catch(err => {
                    console.log("Error", err);
                    grecaptcha.reset(this.recaptcha_id);
                    this.loading = false;
                })
        },
        register() {
            if(this.loading) return;

            if(this.step===1) {
                this.validate(); 
                return;
            }

            this.errorFields = {};

            this.loading = true;
            grecaptcha.execute(this.recaptcha_id);
        },
        goToStep(step) {
            this.step = step;
        },
        setCountry(country) {
            this.country = country;
            this.mdl.country_id = country.id;
        },
        showLoginWindow() {
            if(this.$parent) {
                this.$parent.showLoginWindow();
            }
        }
    },
    computed: {
	    mobile_mask() {
	    	return this.country.code === 'GE' ? "\\9\\9\\5 \\511 11 11 11" : false;
        }
    },
    mixins: [err]
}
</script>