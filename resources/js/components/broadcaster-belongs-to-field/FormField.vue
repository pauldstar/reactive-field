<script>
export default {
    methods: {
        /**
         * Select a resource using the <select> control
         */
        selectResourceFromSelectControl(e) {
            this.selectedResourceId = e.target.value;
            this.selectInitialResource();

            Nova.$emit(this.field.broadcastTo, {
                'field_name': this.field.attribute,
                'value': this.selectedResourceId
            });
        },

        /*
         * Set the initial, internal value for the field.
         */
        setInitialValue() {
            this.value = this.field.value || ''
        },
    },
}
</script>
