<script>
    import BooleanField from '@nova/components/Form/BooleanField';
    import ReactiveField from '../../mixins/ReactiveField';

    export default {
        extends: BooleanField,
        mixins: [ReactiveField],
        props: ['resourceId'],

        mounted() {
            this.watches('value');
        },

        methods: {
            toggle() {
                this.value = !this.value;
            },

            setValue(response) {
                this.value = response.value;
            }
        },
    }
</script>
