<script setup>
import { computed, reactive, ref } from "vue";
import { Dataset, DatasetItem, DatasetInfo, DatasetPager } from "vue-dataset";

const props = defineProps({
    data: {
        type: Array,
        default: () => [],
    },
    labelType: "",
});
const columns = reactive([
    {
        name: "Gumus amount (%)",
        field: "gumus_amount",
    },
    {
        name: "Area",
        field: "area",
    },
]);

const soilDataAreaTotal = computed(
    () =>
        props.data.length &&
        props.data.reduce((acc, cur) => acc + Number(cur.area), 0)
);

function areaInPercent(rowAreaValue) {
    console.log({ soilDataAreaTotal });
    return ((rowAreaValue / soilDataAreaTotal.value) * 100).toFixed(2);
}
</script>

<template>
    <div id="soil_data_control" class="bg-white p-3 rounded-1">
        <!-- <div class="table-responsive">
            <table class="table table-border">
                <thead></thead>
            </table>
        </div> -->
        <Dataset v-slot="{ ds }" :ds-data="data">
            <div class="row">
                <div class="col-md-12">
                    <div class="table-responsive">
                        <table
                            class="table table-sm table-bordered mb-0 text-secondary"
                        >
                            <thead>
                                <tr>
                                    <th scope="col">№</th>
                                    <th
                                        v-for="(th, index) in columns"
                                        :key="th.field"
                                    >
                                        {{ th.name }}
                                    </th>
                                    <th>%</th>
                                </tr>
                            </thead>
                            <DatasetItem tag="tbody" class="fs-sm">
                                <template #default="{ row, rowIndex }">
                                    <tr>
                                        <th scope="row">
                                            {{ rowIndex + 1 }}
                                        </th>
                                        <!-- <td>{{ row.value }}</td> -->
                                        <td>{{ row[labelType] }}</td>
                                        <td>{{ row.area }}</td>
                                        <td>
                                            {{ areaInPercent(row.area) }}
                                        </td>
                                    </tr>
                                </template>
                            </DatasetItem>
                        </table>
                    </div>
                </div>
            </div>
            <!-- <div
                class="d-flex flex-md-row flex-column justify-content-between align-items-center"
            >
                <DatasetInfo class="py-3 fs-sm" />
                <DatasetPager class="flex-wrap py-3 fs-sm" />
            </div> -->
        </Dataset>
    </div>
</template>

<style lang="scss" scoped>
#soil_data_control {
    border: 2px solid lightgray;
    position: absolute;
    top: 4.25rem;
    right: 0.6rem;
    z-index: 800;
}
</style>
