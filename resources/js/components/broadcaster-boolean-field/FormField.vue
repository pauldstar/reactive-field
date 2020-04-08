<script>
export default {
    methods: {
        toggle() {
            this.value = !this.value;

            Nova.$emit(this.field.broadcastTo, {
                'field_name': this.field.attribute,
                'value': this.value
            });
        },
    },
}
</script>
