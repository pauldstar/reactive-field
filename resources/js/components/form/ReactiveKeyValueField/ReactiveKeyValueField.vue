<template>
    <default-field :field="field" :errors="errors" :full-width-content="true">
        <template slot="field">
            <KeyValueTable
                :edit-mode="!field.readonly"
                :delete-row-enabled="field.canDeleteRow"
            >
                <CustomKeyValueHeader
                    v-if="!field.hideHeader"
                    :key-label="field.keyLabel"
                    :value-label="field.valueLabel"
                />

                <div class="bg-white overflow-hidden key-value-items">
                    <CustomKeyValueItem
                        v-for="(item, index) in theData"
                        :index="index"
                        @remove-row="removeRow"
                        :item.sync="item"
                        :key="item.id"
                        :ref="item.id"
                        :read-only="field.readonly"
                        :read-only-keys="field.readonlyKeys"
                        :can-delete-row="field.canDeleteRow"
                    />
                </div>
            </KeyValueTable>

            <div
                class="mr-11"
                v-if="!field.readonly && !field.readonlyKeys && field.canAddRow"
            >
                <button
                    @click="addRowAndSelect"
                    type="button"
                    class="btn btn-link dim cursor-pointer rounded-lg mx-auto text-primary mt-3 px-3 rounded-b-lg flex items-center"
                >
                    <icon type="add" width="24" height="24" view-box="0 0 24 24"/>
                    <span class="ml-1">{{ field.actionText }}</span>
                </button>
            </div>
        </template>
    </default-field>
</template>

<script>
    import KeyValueField from '@nova/components/Form/KeyValueField/KeyValueField';
    import CustomKeyValueHeader from './CustomKeyValueHeader';
    import CustomKeyValueItem from './CustomKeyValueItem';
    import ReactiveField from "../../../mixins/ReactiveField";

    export default {
        extends: KeyValueField,
        mixins: [ReactiveField],
        components: {CustomKeyValueHeader, CustomKeyValueItem},
        props: ['resourceId', 'field'],

        methods: {
            // @override Reactive
            setValue(r) {
                this.theData = _.map(r.data.value || {}, (value, key) => ({
                    id: guid(),
                    key,
                    value,
                }))

                if (this.theData.length == 0) {
                    this.addRow()
                }
            },
        }
    }

    function guid() {
        let S4 = function () {
            return (((1 + Math.random()) * 0x10000) | 0)
                .toString(16).substring(1)
        }

        return (
            S4() + S4() + '-' + S4() +
            '-' + S4() + '-' + S4() +
            '-' + S4() + S4() + S4()
        )
    }
</script>
