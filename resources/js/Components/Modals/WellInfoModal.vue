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
        <div class="modal-dialog modal-dialog-popout modal-dialog-scrollable" role="document">
            <div class="modal-content p-3">
                <nav>
                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                        <button
                            class="nav-link active"
                            id="nav-well-tab"
                            data-bs-toggle="tab"
                            data-bs-target="#nav-well"
                            type="button"
                            role="tab"
                            aria-controls="nav-well"
                            aria-selected="true"
                        >
                            Well info
                        </button>
                        <button
                            class="nav-link"
                            id="nav-diver-tab"
                            data-bs-toggle="tab"
                            data-bs-target="#nav-diver"
                            type="button"
                            role="tab"
                            aria-controls="nav-diver"
                            aria-selected="false"
                        >
                            Diver info
                        </button>
                    </div>
                </nav>
                <div class="tab-content p-3" id="nav-tabContent">
                    <div
                        class="tab-pane fade show active"
                        id="nav-well"
                        role="tabpanel"
                        aria-labelledby="nav-well-tab"
                        tabindex="0"
                    >
                        <ul class="list-group">
                            <li class="list-group-item d-flex">
                                <span>Well number</span>
                                <span class="ms-auto">{{
                                    well.quduq_raqa
                                }}</span>
                            </li>
                            <li class="list-group-item d-flex">
                                <span>District name</span>
                                <span class="ms-auto">{{
                                    well.Tuman_nomi
                                }}</span>
                            </li>
                            <li class="list-group-item d-flex">
                                <span>СИУ_н</span>
                                <span class="ms-auto">{{ well.СИУ_н }}</span>
                            </li>
                            <li class="list-group-item d-flex">
                                <span>UGV_04_21</span>
                                <span class="ms-auto">{{
                                    well.UGV_04_21
                                }}</span>
                            </li>
                            <li class="list-group-item d-flex">
                                <span>MGV_04_21</span>
                                <span class="ms-auto">{{
                                    well.MGV_04_21
                                }}</span>
                            </li>
                            <li class="list-group-item d-flex">
                                <span>Veg_21</span>
                                <span class="ms-auto">{{ well.Veg_21 }}</span>
                            </li>
                            <li class="list-group-item d-flex">
                                <span>mgv_07_21</span>
                                <span class="ms-auto">{{ well.mgv_07_21 }}</span>
                            </li>
                        </ul>
                    </div>
                    <div
                        class="tab-pane fade"
                        id="nav-diver"
                        role="tabpanel"
                        aria-labelledby="nav-diver-tab"
                        tabindex="0"
                    >
                        <DiverInfoTable :cadaster-number="well.cadaster_num" />
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
