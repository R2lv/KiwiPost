module.exports = {
    install(Vue, options) {

        Vue.setLanguage = function(language) {
            Vue.__lang = language;
        };

        Vue.mixin({
            filters: {
                translate(key, customLang) {
                    return (Vue.__lang && (options[customLang || Vue.__lang][key] || key)) || key;
                }
            },
            methods: {
                lang(key, customLang) {
                    return (Vue.__lang && (options[customLang || Vue.__lang][key] || key)) || key;
                },
                showLangs() {
                    return [Vue.__lang,options];
                }
            }
        })
    }
};