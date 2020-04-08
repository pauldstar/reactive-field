<script>
    export default {
        created() {
            Nova.$on(this.field.listensTo, this.messageReceived);
        },

        data: () => ({
            calculating: false,
            fieldValues: {}
        }),

        methods: {
            // override this method to handle broadcast responses
            broadcastHandler(response) {
            },

            messageReceived(message) {
                this.fieldValues[message.field_name] = message.value;
                this.calculateValue();
            },

            calculateValue: function () {
                this.calculating = true;

                Nova.request()
                    .post(
                        `/fusion/calculated-field/calculate/${this.resourceName}/${this.field.attribute}`,
                        this.fieldValues
                    )
                    .then(response => {
                        this.broadcastHandler(response);
                        this.calculating = false;
                    })
                    .catch(() => {
                        this.calculating = false;
                    });
            },
        }
    }
</script>
