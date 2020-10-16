<template>
    <div class="bg-30 rounded-t-lg flex border-b border-50">
        <div
            class="bg-clip w-1/3 uppercase font-bold text-xs text-80 tracking-wide px-3 py-2"
        >
            {{ keyLabel }}
        </div>

        <div
            class="bg-clip flex-grow uppercase font-bold text-xs text-right text-80 tracking-wide px-3 py-2 border-l border-50"
        >
            {{ valueLabel }}
        </div>
    </div>
</template>

<script>
    import KeyValueHeader from '@nova/components/Form/KeyValueField/KeyValueHeader';

    export default {
        extends: KeyValueHeader
    }
</script>
