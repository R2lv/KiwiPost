<template>
    <div class="notificationItem" :class="[notification.type]">
        <div class="lengthText">{{index+1}} {{'out_of'|translate}} {{$parent.notifications.length}} {{'notifications'|translate}}</div>
        <div class="contentWrapper centered">
            <div class="vAlign">
                <div class="box clearfix">
                    <div class="icon">
                        <img src="images/warning-icon.png" alt="">
                    </div>
                    <div class="content">
                        <div class="title upper">{{ notification.title }}</div>
                        <div class="text" v-html="notification.text"></div>
                        <div class="buttons">
                            <a href="" class="btn" data-style="expand-left" data-spinner-size="20" v-if="notification.button_text" @click.prevent="action($event, notification.button_action)">{{ notification.button_text }}</a>
                            <a href="" class="btn" v-if="notification.button_2_text" @click.prevent="action($event, notification.button_2_action)">{{ notification.button_2_text }}</a>
                            <a href="" class="btn" v-if="notification.button_close" @click.prevent="close">Got it</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    props: ['notification', 'index'],
    mounted() {
        $(this.$el).find(".btn").ladda();
    },
    methods: {
        close() {
            axios.post("/json/notifications/"+this.notification.id)
                .then(function(res) {
                    if(res.data.success)
                        this.$parent.remove(this.index);
                    else
                        console.log("Error", res.data.error);
                }.bind(this))
                .catch(function(err) {
                    console.log("Error", err);
                });
        },
        action(e, act) {
            if(act)
                this[act](e);
        },

        resend_verification_email(e) {
            let btn = $(e.currentTarget);

            btn.ladda("start");
            axios.post("/json/email/resend")
                .then(function(res)  {
                    btn.ladda("stop");
                }.bind(this))
                .catch(function(err) {
                    btn.ladda("stop");
                }.bind(this));
        },
        verify_mobile_number() {
            this.$parent.$parent.showProfileEditWindow(null, 'verify_number');
        },
        edit_email_address() {
            this.$parent.$parent.showProfileEditWindow(null, 'email');
        }
    }
}
</script>