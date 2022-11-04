<template>
    <div :class="{'loading-box': loading}">
        <spinner></spinner>
        <div class="input-group" :class="{'error': errorFields.country_id}">
            <label>{{'country' | translate}}</label>

            <div class="dropdown">
                <div class="input-dropdown dropdown-handle">{{ $parent.mdl.address.country.name || lang("choose_country")}}<span class="caret"></span></div>
                <div class="dropdown-content">
                    <ul class="dropdown-list">
                        <li v-for="c in countries" class="dropdown-list-item" @click="setCountry(c)">{{c.name}}</li>
                    </ul>
                </div>
            </div>
            <i class="addon material-icons" v-if="errorFields.country_id">
                info_outline
                <span class="error-text" v-html="err('country_id')"></span>
            </i>
        </div>


        <div class="input-group" :class="{'error': errorFields.city_town}">
            <label for="city_town">{{'city_town' | translate}}</label>
            <input v-model="$parent.mdl.address.city_town" @blur="errorFields.city_town = false" id="city_town" :placeholder="'city_town' | translate">
        </div>
        <div class="input-group" :class="{'error': errorFields.postcode}">
            <label for="postcode">{{'post_code' | translate}}</label>
            <input v-model="$parent.mdl.address.postcode" @blur="errorFields.postcode = false" id="postcode" :placeholder="'post_code' | translate">
        </div>
        <div class="input-group" :class="{'error': errorFields.address_1}">
            <label for="address_1">{{'address_1' | translate}}</label>
            <input v-model="$parent.mdl.address.address_1" @blur="errorFields.address_1 = false" id="address_1" :placeholder="'address_1' | translate">
        </div>
        <div class="input-group" :class="{'error': errorFields.address_2}">
            <label for="address_2">{{'address_2' | translate}}</label>
            <input v-model="$parent.mdl.address.address_2" @blur="errorFields.address_2 = false" id="address_2" :placeholder="'address_2' | translate">
        </div>
        <div class="input-group" :class="{'error': errorFields.password}">
            <label for="password1">{{'your_password' | translate}} <span class="red">*</span></label>
            <input type="password" v-model="$parent.mdl.address.password" @blur="errorFields.password = false" id="password1" :placeholder="'your_current_password'|translate">
        </div>

        <div class="popup-footer">
            <div class="btn-group length-2">
                <a href="#" class="btn white-bg" @click.prevent="$parent.setStep('main')">{{'back' | translate}}</a>
                <a href="#" @click.prevent="save" class="btn">{{'save' | translate}}</a>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            errorFields: {},
            countries: [],
            country: {},
            loading: false
        }
    },
    beforeCreate() {
        this.loading = true;
        axios.post("/json/countries")
            .then(res => {
                if(res.data.success)
                    this.countries = res.data.result;
                this.loading = false;
            })
            .catch(err => {
                console.log("Axios error:", err);
                this.loading = false;
            });

    },
    mounted() {
        $(this.$el).find(".dropdown").dropdown({autoclose: true});
    },
    methods: {
        setCountry(country) {
            this.$parent.mdl.address.country = country;
            this.$parent.mdl.address.country_id = country.id;
        },
        save() {
            this.loading = true;
            axios.post("/json/user/update/address", _(this.$parent.mdl.address).omit(['country']).value())
                .then(res => {
                    if(res.data.success) {
                        alert("Address changed successfully", false, true, () => {
                            this.$parent.setStep('main');
                            this.loading = false;
                        });
                    } else {
                        this.errorFields = res.data.error;
                        this.loading = false;
                    }
                })
        }
    }
}
</script>