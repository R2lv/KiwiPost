<template>
    <input :type="type">
</template>

<script>
export default {
    mounted() {
        let vm = this;
        $(this.$el).iCheck({
            checkboxClass: 'icheckbox_minimal-blue',
            radioClass   : 'iradio_minimal-blue'
        });
        
        setTimeout(()=>{
            $(this.$el).on('ifChanged', function(e) {
                vm.$emit("input", vm.type.toLowerCase()==='checkbox' ? (this.checked ? vm.trueValue : vm.falseValue) : this.value);
                vm.$emit("change", e);
            });
        });

    },
    props: {
        type: {
            default: 'checkbox'
        },
        trueValue: {
            default: true
        },
        falseValue: {
            default: false
        }
    },
    watch: {
        value (value) {
            console.log("Val", value);
            $(this.$el).trigger("change");
        }
    }
}
</script>