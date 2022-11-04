<template>
    <transition name="fade" @before-enter="beforeEnter" @after-enter="afterEnter" @before-leave="beforeLeave" @after-leave="afterLeave">
    <section v-show="notifications.length" class="single geo lower" id="notification">
        <div class="slider">
            <notification-item v-for="(notification, index) in notifications" :key="index" :index="index" :notification="notification"></notification-item>
        </div>
    </section>
    </transition>
</template>
<script>
let interval;
export default {
    data() {
        return {
            notifications: [],
            currentSlide: 0
        }
    },

    beforeCreate() {
    },
    mounted() {
        axios.post("/json/notifications")
            .then(res => {
                this.notifications = res.data.result;
                if(this.notifications.length) {
                    let slider = $(this.$el).find(".slider");
                    setTimeout(() => {
                        slider.slick({
                            slidesToShow: 1,
                            initialSlide: this.currentSlide,
                            touchMove: false,
                            arrows: true,
                            dots: false,
                            infinite: false
                        });

                        slider.on('beforeChange', (event, slick, currentSlide, nextSlide) => {
                            this.currentSlide = nextSlide;
                        });
                        $(window).resize(e => {
                            slider.slick('slickGoTo', slider.slick("slickCurrentSlide"));
                        });
                    });
                }
            })
            .then(function(err) {

            })
    },
    components: {
        NotificationItem: require("./NotificationItem.vue")
    },
    methods: {
        remove(key) {
            $(this.$el).find(".slider").slick('unslick');
            this.notifications.splice(key, 1);
            setTimeout(() => {
                $(this.$el).find(".slider").slick();
                $(window).trigger("resize");
            });
        },
        beforeEnter() {
            if(interval) clearInterval(interval);
            interval = setInterval(function() {
                $(window).trigger("resize");
            },1);
        },
        afterEnter() {
            clearInterval(interval);
        },
        beforeLeave() {
            this.beforeEnter();
        },
        afterLeave() {
            this.afterEnter();
        }
    }
}
</script>