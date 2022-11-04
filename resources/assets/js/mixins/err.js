module.exports = {
    methods: {
        err(name) {
            return this.errorFields[name] && this.errorFields[name].join("<br>");
        },
    }
};