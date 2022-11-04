module.exports = {
    install(Vue, options) {
        let MapComp = Vue.extend(_.extend(require("../components/Map.vue"),{
            props: {
                apiKey: {
                    type: String,
                    default() {
                        return options.key
                    }
                },
                ready: {
                    type: Function,
                    default() {
                        return ()=>{};
                    }
                }
            }
        }));

        Vue.component('gmap', MapComp);
    }
};