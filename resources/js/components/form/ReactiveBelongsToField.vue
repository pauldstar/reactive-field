<script>
    import ReactiveField from '../../mixins/ReactiveField';
    import _ from 'lodash';
    import CustomBelongsToField from '../CustomBelongsToField';

    export default {
        extends: CustomBelongsToField,
        mixins: [ReactiveField],

        data() {
            return {
                dependsOnValue: null,
            };
        },

        mounted() {
            this.watches('selectedResourceId');
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

        methods: {
            // @override BelongsToField
            selectResource(resource) {
                this.selectedResource = resource;
                this.broadcast(resource.value);
            },

            // @override BelongsToField
            clearSelection() {
                this.selectedResource = '';
                this.availableResources = [];
                this.broadcast('');
            },

            // @override Reactive
            setValue(response) {
                let val = response.data.value,
                    dependsOnId = val.dependsOnId,
                    initialSelectId = val.initialSelectId;

                if (dependsOnId === this.dependsOnValue) {
                    return;
                }

                this.dependsOnValue = dependsOnId;
                this.selectedResourceId = initialSelectId;

                this.clearSelection();

                if (this.shouldSelectInitialResource) {
                    if (!this.isSearchable) {
                        this.initializingWithExistingResource = false
                    }
                    this.getAvailableResources().then(() => this.selectInitialResource())
                }
            },

            // @override BelongToField
            selectInitialResource() {
                if (this.selectedResourceId === true) {
                    this.selectedResourceId = this.availableResources[0].value;
                }
                this.selectedResource = _.find(
                    this.availableResources,
                    // don't use ===
                    r => r.value == this.selectedResourceId
                )
            },
        },
    }
</script>
