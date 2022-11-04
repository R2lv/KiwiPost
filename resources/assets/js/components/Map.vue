<template>
<div id="v-map"></div>
</template>
<script>
export default {
    created() {
        window._initMap = () => {
            if(this.ready)
                this.ready(options => {
                    return new google.maps.Map(this.$el, options);
                })
        };
        let script = document.createElement("script");
        script.src = `https://maps.googleapis.com/maps/api/js?key=${this.apiKey}&callback=_initMap`;
        script.async = true;
        document.body.appendChild(script);
    }
}
</script>