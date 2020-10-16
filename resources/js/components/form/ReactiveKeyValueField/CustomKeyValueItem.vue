<template>
    <div v-if="isNotObject" class="flex items-center key-value-item">
        <div class="flex flex-grow border-b border-50 key-value-fields">
            <div
                class="w-1/3 cursor-text"
                :class="{ 'bg-30': readOnlyKeys || !isEditable }"
            >
                <textarea
                    :dusk="`key-value-key-${index}`"
                    v-model="item.key"
                    @focus="handleKeyFieldFocus"
                    ref="keyField"
                    type="text"
                    class="font-mono text-sm resize-none block w-full form-control form-input form-input-row py-2 text-90"
                    :disabled="!isEditable || readOnlyKeys"
                    style="background-clip: border-box;"
                    :class="{
                        'bg-white': !isEditable || readOnlyKeys,
                        'hover:bg-20 focus:bg-white': isEditable && !readOnlyKeys,
                    }"
                />
            </div>

            <div @click="handleValueFieldFocus" class="flex-grow border-l border-50">
                <textarea
                    :dusk="`key-value-value-${index}`"
                    v-model="item.value"
                    @focus="handleValueFieldFocus"
                    ref="valueField"
                    type="text"
                    class="font-mono text-sm text-right block w-full form-control form-input form-input-row py-2 text-90"
                    :disabled="!isEditable"
                    :class="{
                        'bg-white': !isEditable,
                        'hover:bg-20 focus:bg-white': isEditable,
                    }"
                />
            </div>
        </div>

        <div
            v-if="isEditable && canDeleteRow"
            class="flex justify-center h-11 w-11 absolute"
            style="right: -50px;"
        >
            <button
                @click="$emit('remove-row', item.id)"
                type="button"
                tabindex="-1"
                class="flex appearance-none cursor-pointer text-70 hover:text-primary active:outline-none active:shadow-outline focus:outline-none focus:shadow-outline"
                title="Delete"
            >
                <icon/>
            </button>
        </div>
    </div>
</template>

<script>
    import KeyValueItem from '@nova/components/Form/KeyValueField/KeyValueItem';

    export default {
        extends: KeyValueItem
    }
</script>

<style>
    .key-value-items:first-child {
        border-top-right-radius: .5rem;
        border-top-left-radius: .5rem;
        background-clip: border-box;
        border-top-width: 0;
    }

    .key-value-fields .form-input-row {
        height: 33px;
    }
</style>
