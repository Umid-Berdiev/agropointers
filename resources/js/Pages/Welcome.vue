<script>
import LandingLayout from "@/Layouts/LandingLayout.vue";

export default {
    layout: LandingLayout,
};
</script>

<script setup>
import { computed, onMounted, reactive, ref, watch, watchEffect } from "vue";
import { useMainStore } from "@/stores/main";
import { Head, Link } from "@inertiajs/inertia-vue3";
import BaseBlock from "@/Components/BaseBlock.vue";
import L from "leaflet";
import "leaflet/dist/leaflet.css";
import SoilLayersControl from "@/Components/Maps/SoilLayersControl.vue";
import SoilDataTableControl from "../Components/Maps/SoilDataTableControl.vue";
import SoilDataChartControl from "@/Components/Maps/SoilDataChartControl.vue";

defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
    // laravelVersion: String,
    // phpVersion: String,
    gumusData: {
        type: Object,
        default: () => ({}),
    },
});

// Main store
const store = useMainStore();
const zoom = ref(12.5);
const center = ref([40.677694, 68.049889]);
const map = ref(null);
const tileProviders = reactive({
    ["Openstreet harita"]: L.tileLayer(
        "https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png",
        {
            visible: true,
            // attribution:
            //     '&copy; <a target="_blank" href="http://osm.org/copyright">OpenStreetMap</a> contributors',
        }
    ),
    ["Google harita"]: L.tileLayer(
        "http://www.google.com/maps/vt?ROADMAP=s@189&gl=uz&x={x}&y={y}&z={z}",
        {
            visible: false,
            // attribution: "GoogleMaps",
        }
    ),
    ["Google harita (sun'iy yo'ldosh)"]: L.tileLayer(
        "http://www.google.com/maps/vt?lyrs=s,h@189&gl=uz&x={x}&y={y}&z={z}",
        {
            visible: false,
            // attribution: "GoogleSatellite",
        }
    ),
});
const selectedLayers = ref([
    "aholi",
    "chegaralar",
    "boshqaYerlar",
    "yollar",
    "sugorishTarmoqlari",
    "kollektorlar",
    "kuzatuvQuduqlari",
]);
const aholi = ref(null);
const boshqaYerlar = ref(null);
const chegaralar = ref(null);
const kollektorlar = ref(null);
const kuzatuvQuduqlari = ref(null);
const sugorishTarmoqlari = ref(null);
const yollar = ref(null);

// layers
const chegaralarLayer = computed(() =>
    L.geoJSON(chegaralar.value, {
        style: function (geoJsonFeature) {
            return {
                stroke: true,
                fill: false,
                color: "purple",
                fillColor: "purple",
                fillOpacity: 1,
            };
        },
    })
);
const aholiLayer = computed(() =>
    L.geoJSON(aholi.value, {
        style: function (geoJsonFeature) {
            return {
                stroke: true,
                fill: true,
                color: "#beb297",
                fillColor: "#beb297",
                fillOpacity: 1,
            };
        },
    })
);
const boshqaYerlarLayer = computed(() =>
    L.geoJSON(boshqaYerlar.value, {
        style: (geoJsonFeature) => ({
            stroke: true,
            fill: true,
            color: "#c43c39",
            fillColor: "#c43c39",
            fillOpacity: 1,
        }),
    })
);
const yollarLayer = computed(() =>
    L.geoJSON(yollar.value, {
        style: function (geoJsonFeature) {
            return {
                stroke: true,
                fill: false,
                color: "gray",
                fillColor: "gray",
            };
        },
    })
);
const kollektorlarLayer = computed(() =>
    L.geoJSON(kollektorlar.value, {
        style: (geoJsonFeature) => ({
            stroke: true,
            fill: false,
            color: "#65a30d",
            fillColor: "#65a30d",
            fillOpacity: 1,
        }),
    })
);
const kuzatuvQuduqlariLayer = computed(() =>
    L.geoJSON(kuzatuvQuduqlari.value, {
        // pointToLayer: function (feature, latlng) {
        //     L.circleMarker(latlng, {
        //         radius: 5,
        //         color: "#111",
        //         fillColor: "orange",
        //         weight: 1,
        //         opacity: 1,
        //         fillOpacity: 1,
        //     })
        //         // .bindTooltip(() => {
        //         //     return `
        //         //     <div>quduq raqami: ${featureData.properties?.quduq_raqa}</div>
        //         //     <div>mgv_07_21: ${featureData.properties?.mgv_07_21}</div>
        //         //     `;
        //         // })
        //         .addTo(map.value);
        // },
        onEachFeature: function (feature, layer) {
            // console.log(layer);
            layer.setIcon(
                L.divIcon({
                    html: `<i class="fa fa-circle"></i>`,
                    className: "text-secondary",
                })
            );
            // .bindTooltip(() => {
            //     return `
            //     <div>quduq raqami: ${feature.properties?.quduq_raqa}</div>
            //     <div>mgv_07_21: ${feature.properties?.mgv_07_21}</div>
            //     `;
            // });
        },
    })
);
const sugorishTarmoqlariLayer = computed(() =>
    L.geoJSON(sugorishTarmoqlari.value)
);

onMounted(async () => {
    // fetch geojson data
    await fetchStaticLayers();

    // init map
    initMap();
});

watchEffect(() => {
    map.value?.removeLayer(aholiLayer.value);
    map.value?.removeLayer(chegaralarLayer.value);
    map.value?.removeLayer(boshqaYerlarLayer.value);
    map.value?.removeLayer(yollarLayer.value);
    map.value?.removeLayer(sugorishTarmoqlariLayer.value);
    map.value?.removeLayer(kollektorlarLayer.value);
    map.value?.removeLayer(kuzatuvQuduqlariLayer.value);

    if (selectedLayers.value.includes("aholi"))
        map.value?.addLayer(aholiLayer.value);

    if (selectedLayers.value.includes("chegaralar"))
        map.value?.addLayer(chegaralarLayer.value);

    if (selectedLayers.value.includes("boshqaYerlar"))
        map.value?.addLayer(boshqaYerlarLayer.value);

    if (selectedLayers.value.includes("yollar"))
        map.value?.addLayer(yollarLayer.value);

    if (selectedLayers.value.includes("sugorishTarmoqlari"))
        map.value?.addLayer(sugorishTarmoqlariLayer.value);

    if (selectedLayers.value.includes("kollektorlar"))
        map.value?.addLayer(kollektorlarLayer.value);

    if (selectedLayers.value.includes("kuzatuvQuduqlari"))
        map.value?.addLayer(kuzatuvQuduqlariLayer.value);
});

async function fetchStaticLayers() {
    const res_aholi = await fetch("/aholi.geojson");
    const res_boshqa_yerlar = await fetch("/boshqa_yerlar.geojson");
    const res_chegaralar = await fetch("/chegaralar.geojson");
    const res_kollektorlar = await fetch("/kollektorlar.geojson");
    const res_kuzatuv_quduqlari = await fetch("/kuzatuv_quduqlari.geojson");
    const res_sugorish_tarmoqlari = await fetch(
        "/sug'orish_tarmoqlari.geojson"
    );
    const res_yollar = await fetch("/yo'llar.geojson");
    aholi.value = await res_aholi.json();
    boshqaYerlar.value = await res_boshqa_yerlar.json();
    chegaralar.value = await res_chegaralar.json();
    kollektorlar.value = await res_kollektorlar.json();
    kuzatuvQuduqlari.value = await res_kuzatuv_quduqlari.json();
    sugorishTarmoqlari.value = await res_sugorish_tarmoqlari.json();
    yollar.value = await res_yollar.json();
}

function initMap() {
    map.value = L.map("map", {
        // zoomControl: true,
        // zoomAnimation: false,
        // fadeAnimation: true,
        // markerZoomAnimation: true,
        zoom: zoom.value,
        center: center.value,
        zoomDelta: 0.5,
        // zoomSnap: 0.5,
        // layers: Object.values(tileProviders),
    })
        .on("zoomend", function (e) {
            zoom.value = map.value.getZoom();
        })
        .on("moveend", function (e) {
            center.value = Object.values(map.value.getBounds().getCenter());
        });
    tileProviders["Openstreet harita"].addTo(map.value);

    // add layers to map
    L.control
        .layers(
            tileProviders,
            {
                //
            },
            {
                position: "topright",
            }
        )
        .addTo(map.value);
    L.control
        .scale({
            imperial: false,
        })
        .setPosition("bottomleft")
        .addTo(map.value);

    /*Legend specific*/
    // let soilLayersControl = L.control({ position: "topleft" });
    // let soilDataControl = L.control({ position: "topright" });

    // soilLayersControl.onAdd = function (map) {
    //     let div = L.DomUtil.get("soil_layers_control");
    //     return div;
    // };

    // soilDataControl.onAdd = function (map) {
    //     let div = L.DomUtil.get("soil_data_control");
    //     return div;
    // };

    // soilLayersControl.addTo(map.value);
    // soilDataControl.addTo(map.value);

    map.value.attributionControl.setPrefix(""); // Don't show the 'Powered by Leaflet' text.
}
</script>

<template>
    <div class="position-relative">
        <div id="map" style="height: 85vh"></div>
        <SoilLayersControl v-model:selected-layers="selectedLayers" />
        <SoilDataTableControl :soil-data="gumusData" />
        <SoilDataChartControl :soil-data="gumusData" />
        <p>Center is at {{ center }} and the zoom is: {{ zoom }}</p>
    </div>
</template>

<style scoped lang="scss">
//
</style>
