<script setup>
import BaseBlock from "../BaseBlock.vue";
import DiverInfoTable from "../DiverInfoTable.vue";
const props = defineProps({
    well: {
        type: Object,
        default: () => ({}),
    },
});
</script>

<template>
    <div
        class="modal fade"
        id="modal-wellinfo"
        tabindex="-1"
        role="dialog"
        aria-labelledby="modal-wellinfo"
        aria-hidden="true"
    >
        <div class="modal-dialog modal-dialog-popout" role="document">
            <div class="modal-content">
                <DiverInfoTable :cadaster-number="well.cadaster_num" />
            </div>
        </div>
    </div>
</template>
