<script>
    import Listener from "../../mixins/Listener";
    import _ from "lodash";

    export default {
        mixins: [Listener],

        data() {
            return {
                dependsOnValue: null,
            };
        },

        methods: {
            // @override Listener
            broadcastHandler(response) {
                let dependsOnId = response.data.value.dependsOnId,
                    initialSelectId = response.data.value.initialSelectId;

                if (dependsOnId === this.dependsOnValue) {
                    return;
                }

                this.dependsOnValue = dependsOnId;
                this.selectedResourceId = initialSelectId;

                this.clearSelection();
                this.initializeComponent();
            },

            // @override BelongToField
            selectInitialResource() {
                if (this.selectedResourceId === true) {
                    this.selectedResourceId = this.availableResources[0].value;
                }

                this.selectedResource = _.find(
                    this.availableResources,
                    r => r.value === this.selectedResourceId
                );
            },
        },

        computed: {
            // @override BelongToField
            shouldSelectInitialResource() {
                return Boolean(
                    this.editingExistingResource || this.creatingViaRelatedResource || this.dependsOnValue
                )
            },

            // @override BelongToField
            queryParams() {
                return {
                    params: {
                        current: this.selectedResourceId,
                        first: this.initializingWithExistingResource,
                        search: this.search,
                        withTrashed: this.withTrashed,
                        dependsOnValue: this.dependsOnValue,
                    },
                }
            },
        },
    }
</script>
