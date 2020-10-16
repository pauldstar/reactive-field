<script>
import SelectField from '@nova/components/Form/SelectField';
import ReactiveField from '../../mixins/ReactiveField';

export default {
    extends: SelectField,
    mixins: [ReactiveField],

    mounted() {
        this.watches('value');
    },

    methods: {
        setValue(response) {
            if (this.isSearchable) {
                this.selectedOption = _.find(
                    this.filteredOptions, ['value', response.data.value]
                );
            } else this.value = response.data.value;
        }
    }
}
</script>
