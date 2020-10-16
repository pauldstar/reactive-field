<script>
    import ReactiveField from '../../mixins/ReactiveField';
    import TextField from '@nova/components/Form/TextField';

    export default {
        extends: TextField,
        mixins: [ReactiveField],
        props: ['resourceId'],

        mounted() {
            this.watches('value');
        },

        methods: {
            setValue(response) {
                this.value = response.data.value;
            }
        }
    };
</script>
