<template>
	<section id="content" class="news" :class="{'loading-box': loading_shops && loading_cats}">
		<spinner></spinner>
		<div class="contentWrapper pad">
			<div class="shops-nav geo upper">
				<ul class="shops-cat-list">
					<li  :class="{'active':activeCat==-10}" @click="updateCategory('all')"><a href="#">{{'all'|translate}}</a></li>
					<li class="" v-for="category in categories" :class="{'active':activeCat == categories.indexOf(category)}">
						<a href="#" @click="updateCategory(categories.indexOf(category))" >{{ category.title }}</a>
					</li>

				</ul>
			</div>
			<div class="shops-container">
				<div class="shop-list">
					<a v-for="(shop, $index) in shops" v-on:mouseover="animateMe($index)" @mouseout="cancelAnimation" class="shop vertical-align-wrapper" :class="{backstep: hoverIndex!==-1 && hoverIndex !== $index}" target="_blank" :href="shop.url">
						{{shop.title}}
					</a>
				</div>
			</div>
		</div>
	</section>
</template>
<script>
export default {
	data() {
		return {
			shops: [],
			shopsList:[],
			categories:[],
			hoverIndex: -1,
			loading_shops: true,
			loading_cats: true,
			activeCat: -10,
		}
	},
	methods: {
		animateMe(i) {
			console.log("Over");
			this.hoverIndex = i;
		},
		cancelAnimation() {
			this.hoverIndex = -1;
		},
        updateCategory(index){
		    if(index=='all'){
		        this.shops = this.shopsList;
                this.activeCat = -10;
			}else {
                this.shops = this.categories[index].shops;
                this.activeCat = index;
            }
		}
	},
	mounted(){
        axios.get("/json/shops")
            .then(res => {
                if(res.data.success) {
                    this.shopsList = res.data.result;
                    this.shops = this.shopsList;
                    this.loading_shops = false;
                }
            });

        axios.get("/json/categories")
            .then(res => {
                if(res.data.success) {
                    this.categories = res.data.result;
                    this.loading_shops = false;
                }
            });

    }

}
</script>