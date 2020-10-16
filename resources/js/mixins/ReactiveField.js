export default {
    data: () => ({
        fieldsWithValues: {}
    }),

    created() {
        if (this.field.listensTo) {
            Nova.$on(this.field.listensTo, this.calculateValue);
        }
    },

    destroyed() {
        if (this.field.listensTo) {
            Nova.$off(this.field.listensTo, this.calculateValue);
        }
    },

    methods: {
        // name of value to broadcast after a change
        watches(value) {
            this.$watch(value, _.debounce(function () {
                this.broadcast(this.$data[value]);
            }, 500));
        },

        // broadcast value to listening components
        broadcast(value) {
            if (this.field.broadcastFrom) {
                Nova.$emit(this.field.broadcastFrom, {
                    'field_name': this.field.attribute,
                    'value': value
                });
            }
        },

        // override this method to handle broadcast responses
        setValue(response) {
        },

        calculateValue: function (e) {
            this.fieldsWithValues.resourceId = this.resourceId;
            this.fieldsWithValues[e.field_name] = e.value;

            let urlPrefix = '/fifteen-group/nova-compact-reactive-ui/calculate';

            Nova.request().post(
                `${urlPrefix}/${this.resourceName}/${this.field.attribute}`,
                this.fieldsWithValues
            ).then(response => {
                this.setValue(response);
            });
        }
    }
}
