<template>
    <section id="content">
        <div class="c-contentWrapper">
            <div id="c-map">
                <gmap :ready="ready" style="height: 100%;"></gmap>
            </div>
            <div class="c-location-message">
                <div class="c-location-title">
                    <span>{{'ge_city'|translate}}</span>
                    {{'ge_country'|translate}}
                </div>
                <hr>
                <div class="c-location-content">
                    <div class="c-line"><span>{{'conts_city_title'|translate}}:</span> {{'ge_city'|translate}}</div>
                    <div class="c-line"><span>{{'conts_address_title'|translate}}:</span> {{'ge_address'|translate}}</div>
                    <div class="c-line"><span>{{'conts_address_2_title'|translate}}:</span> {{'ge_address_2'|translate}}</div>
                    <div class="c-line"><span>{{'conts_zip_title'|translate}}:</span> {{'ge_zip'|translate}}</div>
                    <div class="c-line"><span>{{'conts_phone_title'|translate}}:</span> {{'ge_phone'|translate}}</div>
                    <div class="c-line"><span>{{'conts_mail_title'|translate}}:</span> <a href="mailto:info@kiwipost.ge">{{'ge_mail'|translate}}</a></div>
                    <div class="c-line"><span>{{'conts_web_title'|translate}}:</span> {{'ge_web'|translate}}</div>
                    <div class="c-line"><span>{{'conts_monday_friday_title'|translate}}:</span> {{'ge_monday_friday'|translate}}</div>
                    <div class="c-line"><span>{{'conts_saturday_title'|translate}}:</span> {{'ge_saturday'|translate}}</div>
                    <div class="c-line"><span>{{'conts_sunday_title'|translate}}:</span> {{'ge_sunday'|translate}}</div>
                </div>
                <div class="c-action-buttons">
                    <a href="#" class="c-button" @click.prevent="contact('GE')">
                        <img src="/images/c-action-button.png" alt=""> Message
                    </a>
                </div>
            </div>
            <div class="c-location-message-2">
                <div class="c-location-title">
                    <span>{{'uk_city'|translate}}</span>
                    {{'uk_country'|translate}}
                </div>
                <hr>
                <div class="c-location-content">
                    <div class="c-line"><span>{{'conts_city_title'|translate}}:</span> {{'uk_city'|translate}}</div>
                    <div class="c-line"><span>{{'conts_address_title'|translate}}:</span> {{'uk_address'|translate}}</div>
                    <div class="c-line"><span>{{'conts_address_2_title'|translate}}:</span> {{'uk_address_2'|translate}}</div>
                    <div class="c-line"><span>{{'conts_zip_title'|translate}}:</span> {{'uk_zip'|translate}}</div>
                    <div class="c-line"><span>{{'conts_phone_title'|translate}}:</span> {{'uk_phone'|translate}}</div>
                    <div class="c-line"><span>{{'conts_mail_title'|translate}}:</span> <a href="mailto:info@kiwipost.co.uk">{{'uk_mail'|translate}}</a></div>
                    <div class="c-line"><span>{{'conts_web_title'|translate}}:</span> {{'uk_web'|translate}}</div>
                    <div class="c-line"><span>{{'uk_tue_thu_fri'|translate}}:</span> {{'uk_twf_hours'|translate}}</div>
                    <div class="c-line"><span>{{'conts_saturday_title'|translate}}-{{'conts_sunday_title'|translate}}:</span> {{'uk_saturday_sunday'|translate}}</div>
                    <div class="c-line"><span>{{'uk_free_days'|translate}}:</span> {{'uk_rest_days'|translate}}</div>
                </div>
                <div class="c-action-buttons">
                    <a href="#" class="c-button" @click.prevent="contact('UK')">
                        <img src="/images/c-action-button.png" alt=""> Message
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
            center: {lat: 48.369263, lng: 20.603286},
            pos: {lat: 41.723514, lng: 44.763843}, //41.723504,44.7633008,19z
            pos2: {lat: 51.5455205, lng: -0.1777839},
            zoom: 5
        }
    },
    methods: {
        ready(Map) {
            let map = Map({
                center: this.center,
                zoom: this.zoom
            });

            let marker = new google.maps.Marker({
                position: this.pos,
                map: null,
                title: "Kiwipost",
                animation: google.maps.Animation.DROP
            }),
                marker2 = new google.maps.Marker({
                    position: this.pos2,
                    map: null,
                    title: "Kiwipost",
                    animation: google.maps.Animation.DROP
                });


            let infoWindow = new google.maps.InfoWindow({
                content: this.$el.querySelector('.c-location-message'),
                shown: true
            }),
                infoWindow2 = new google.maps.InfoWindow({
                content: this.$el.querySelector('.c-location-message-2'),
                shown: true
            });

            marker.addListener('click', () => {
                infoWindow.open(map, marker);
            });
            marker2.addListener('click', () => {
                infoWindow.open(map2, marker2);
            });


            setTimeout(()=>{
                marker.setMap(map);
                marker2.setMap(map);
                setTimeout( ()=>{
                    infoWindow.open(map, marker);
                    infoWindow2.open(map, marker2);
                },500);
            },1000);

        },
        contact(country) {
            this.$parent.showContactWindow(country);
        }
    }
}
</script>

<style scoped>
    .c-contentWrapper > .c-location-message, .c-contentWrapper > .c-location-message-2{
        display: none;
    }
</style>