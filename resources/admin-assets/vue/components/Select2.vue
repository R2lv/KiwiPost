<template>
    <input v-if="tag=='input'" type="text">
    <select v-else>
        <slot></slot>
    </select>
</template>
<script>
export default {
        props: ['options', 'selectdata', 'value', 'tag'],
        mounted: function () {
            const vm = this;
            $(this.$el)
            // init select2
                .select2(this.options)
                .val(this.value)
                .trigger('change')
                // emit event on change.
                .on('change', function (e) {
                    vm.$emit('input', this.value);
                    vm.$emit('change', e);
                });
        },
        watch: {
            value: function (value) {
                $(this.$el).val(value).trigger('change');
                $(this.$el).select2('destroy').select2(this.options);
//                this.$emit("change", value);
            },
            options: function (options) {
                $(this.$el).select2(options)
            }
        },
        destroyed: function () {
            $(this.$el).off().select2('destroy');
        }
}
</script>