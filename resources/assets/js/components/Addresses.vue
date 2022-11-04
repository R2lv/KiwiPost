<template>
    <section id="address" class="dropdown address-dropdown geo lower">
        <div class="contentWrapper pad">
            <div class="info-section address-section dropdown-handle">
                <a href="#">
                    <div class="title">{{'my_address' | translate}} <img src="images/arr-down-tiny-grey.png" alt=""></div>
                    <span class="address">{{selectedAddress.country.name}}</span>
                </a>
            </div>

            <div class="show-xs info-section wallet clearfix">
                <div class="wallet-icon"> </div>
                <div class="wallet-info">
                    <div class="amount">{{user.balance}} {{'GBP_symbol' | translate('en')}}</div>
                </div>
                <div class="pay-icon" @click.prevent="$parent.showPaymentWindow">+</div>
            </div>
            <div class="hide-xs">
                <div class="info-section">
                    <div class="title">{{'first_name' | translate}}</div>
                    <div class="value">{{user.name}}</div>
                </div>
                <div class="info-section">
                    <div class="title">{{'lastname' | translate}}</div>
                    <div class="value">{{user.lastname}}</div>
                </div>
                <div class="info-section">
                    <div class="title">{{'address_1' | translate}}</div>
                    <div class="value">{{selectedAddress.address}}</div>
                </div>
                <div class="info-section">
                    <div class="title">{{'address_2' | translate}}</div>
                    <div class="value">{{selectedAddress.address_second}} {{user.id}}</div>
                </div>
                <div class="info-section">
                    <div class="title">{{'post_code' | translate}}</div>
                    <div class="value">{{selectedAddress.zip}}</div>
                </div>
                <div class="info-section">
                    <div class="title">{{'city' | translate}}</div>
                    <div class="value">{{selectedAddress.city}}</div>
                </div>
                <div class="info-section">
                    <div class="title">{{'state/province' | translate}}</div>
                    <div class="value">{{selectedAddress.state}}</div>
                </div>
                <div class="info-section">
                    <div class="title">{{'phone' | translate}}</div>
                    <div class="value">{{selectedAddress.phone}}</div>
                </div>

                <div class="info-section wallet">
                    <div class="wallet-icon"> </div>
                    <div class="wallet-info">
                        <div class="title">{{'balance' | translate}}</div>
                        <div class="amount">{{user.balance}} {{'GBP_symbol' | translate('en')}}</div>
                    </div>
                    <div class="pay-icon" @click.prevent="$parent.showPaymentWindow">+</div>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>

        <div class="dropdown-content">
            <div class="contentWrapper">

                <div v-for="address in addresses" @click.prevent="selectAddress(address)" :class="{'selected': address.id == selectedAddress.id}" class="address-select">
                    <div class="">
                        <div class="info-section address-section only">
                            <a href="#">
                                <span class="address">{{address.country.name}}</span>
                            </a>
                        </div>
                        <div class="info-section">
                            <div class="title">{{'first_name' | translate}}</div>
                            <div class="value">{{user.name}}</div>
                        </div>
                        <div class="info-section">
                            <div class="title">{{'lastname' | translate}}</div>
                            <div class="value">{{user.lastname}}</div>
                        </div>
                        <div class="info-section">
                            <div class="title">{{'address_1' | translate}}</div>
                            <div class="value">{{address.address}}</div>
                        </div>
                        <div class="info-section">
                            <div class="title">{{'address_2' | translate}}</div>
                            <div class="value">{{address.address_second}} {{user.id}}</div>
                        </div>
                        <div class="info-section">
                            <div class="title">{{'postcode' | translate}}</div>
                            <div class="value">{{address.zip}}</div>
                        </div>
                        <div class="info-section">
                            <div class="title">{{'city' | translate}}</div>
                            <div class="value">{{address.city}}</div>
                        </div>
                        <div class="info-section">
                            <div class="title">{{'state/province' | translate}}</div>
                            <div class="value">{{address.state}}</div>
                        </div>
                        <div class="info-section">
                            <div class="title">{{'phone' | translate}}</div>
                            <div class="value">{{address.phone}}</div>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>

            </div>
        </div>
    </section>
</template>

<script>
export default {
    data() {
        return {
            addresses: [],
            selectedAddress: {country:{name: ""}},
            user: {
                balance: "...",
                name: "...",
                lastname: "...",
                id: "..."
            }
        }
    },

    beforeCreate() {
        console.log('before');
        axios.post("/json/addresses")
            .then(function(res) {
                console.log(res.data);
                if(res.data.success) {
                    this.addresses = res.data.result.addresses;
                    this.balance = res.data.result.balance;
                    this.user = res.data.result.user;
                    this.selectAddress(this.addresses[0]);
                }
            }.bind(this));
    },

    mounted() {
        console.log(this.$el, $.fn.dropdown);
        $(this.$el).dropdown();
    },

    methods: {
        selectAddress(address) {
            this.selectedAddress = address;
            if($(window).width()>1300) {
                $(this.$el).removeClass("open");
            }
        }
    }
}
</script>