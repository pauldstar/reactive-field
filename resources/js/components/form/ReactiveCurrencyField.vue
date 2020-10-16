<template>
    <default-field :field="field" :errors="errors">
        <template slot="field">
            <div class="flex flex-wrap items-stretch w-full relative">
                <div class="flex -mr-px">
                    <span class="flex items-center leading-normal rounded rounded-r-none border border-r-0 border-60 px-3 whitespace-no-wrap bg-30 text-80 text-sm font-bold">
                    {{ field.currency }}
                    </span>
                </div>

                <input
                    class="flex-shrink flex-grow flex-auto leading-normal w-px flex-1 rounded-l-none form-control form-input form-input-bordered text-right"
                    :id="field.attribute"
                    :dusk="field.attribute"
                    v-model="value"
                    v-bind="extraAttributes"
                    :disabled="isReadonly"
                />
            </div>
        </template>
    </default-field>
</template>

<script>
    import CurrencyField from '@nova/components/Form/CurrencyField';
    import ReactiveField from '../../mixins/ReactiveField';

    export default {
        extends: CurrencyField,
        mixins: [ReactiveField],

        mounted() {
            this.watches('value');
        },

        methods: {
            setValue(response) {
                this.value = response.data.value;
            }
        }
    }
</script>
