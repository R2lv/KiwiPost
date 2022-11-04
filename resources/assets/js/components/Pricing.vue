<template>

<section id="content" class="geo upper">
    <div class="content-wrapper">
        <div class="pricing-tabs">
            <a href="#" v-for="title in pricingData.titles" class="pricing-tab" :class="{active: isPrices(title.id)}" @click.prevent="setPrices(title)">{{title.title}}</a>
        <!-- -&ndash;&gt;<a href="#" class="pricing-tab" :class="{active: isPrices('geo2uk')}" @click.prevent="setPrices('geo2uk')">Georgia To Great Britain</a>-->
        </div>


        <div class="pricing-blocks " v-for="title in pricingData.titles" v-if="isPrices(title.id)">
            <div class="pricing-block" :class="{highlight: p.highlight}" v-for="p in pricing">
                <div class="image">
                    <img :src="p.image_url" alt="">
                </div>
                <div class="pricing-title">{{p.title}}</div>
                <div v-for="item in p.list">
                    <div class="separator" v-if="item.description"></div>
                    <div class="separator-margin" v-else></div>
                    <div class="price-text">
                        <div class="text" v-html="item.description"></div>
                        <div class="text-highlight" v-html="item.value"></div>
                    </div>
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
            currentId: null,
            pricingData: pricing
        }
    },
    mounted() {
        this.currentId = this.pricingData.titles[0].id;
    },
    methods: {
        setPrices(pricing) {
            this.currentId = pricing.id;
        },
        isPrices(id) {
            return this.currentId === id;
        }
    },
    computed: {
        pricing() {
            return this.pricingData[this.currentId];
        }
    }
}
</script>