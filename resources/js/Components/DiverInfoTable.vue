<script setup>
import { ref, watchEffect } from "vue";
import { useNotyf } from "../composable/useNotyf";
import moment from "moment";
import axios from "axios";

const props = defineProps({
    cadasterNumber: "",
});

const notyf = useNotyf();
const diverInfo = ref([]);
const isLoading = ref(false);
const diverStationId = ref("");
const fromDate = ref(moment().subtract(10, "days").format("DD-MM-YYYY"));
const toDate = ref(moment().subtract(1, "day").format("DD-MM-YYYY"));

watchEffect(() => {
    if (props.cadasterNumber) {
        onChange();
    }
});

async function onChange() {
    try {
        isLoading.value = true;
        const url = `http://89.236.195.198:3010/data/bwn`;
        const token = await getDiverToken();
        axios.defaults.headers.Authorization = "Bearer " + token;

        const res = await axios({
            url,
            method: "POST",
            data: {
                cadastr_number: props.cadasterNumber,
                from: fromDate.value,
                to: toDate.value,
            },
        });

        if (res.data.message) {
            notyf.error(res.data.message);
        } else {
            diverStationId.value = res.data[0]?.st_id || "";
            const resData = res.data ?? [];
            const reversedData = resData.slice(-31).reverse();
            diverInfo.value = reversedData;
        }
    } catch (error) {
        notyf.error(error.message);
    } finally {
        isLoading.value = false;
    }
}

async function getDiverToken() {
    let diverToken = localStorage.getItem("diver_token");
    let diverTokenExpired = moment(
        new Date(localStorage.getItem("diver_token_expired_at")),
        "DD/MM/YYYY HH:mm:ss"
    );

    const now = moment(new Date(), "DD/MM/YYYY HH:mm:ss");
    // console.log(diverTokenExpired.diff(now, "days") <= 0);

    if (
        !diverToken ||
        diverToken == "undefined" ||
        !diverTokenExpired ||
        diverTokenExpired.diff(now, "days") <= 0
    ) {
        try {
            const res = await axios.post("http://89.236.195.198:3010/login", {
                username: "mis",
                password: "samar",
            });
            diverToken = res.data.token;
            localStorage.setItem("diver_token", res.data.token);
            localStorage.setItem(
                "diver_token_expired_at",
                res.data["expired at"]
            );
        } catch (error) {
            alert("Diver token olishda xatolik: " + error);
        }
    }

    return diverToken;
}

function formatDate(dateString) {
    if (dateString && dateString.length === 8) {
        const year = dateString.substring(0, 4);
        const month = dateString.substring(4, 6);
        const date = dateString.substring(6);
        return `${year}-${month}-${date}`;
    }

    return dateString;
}
</script>

<template>
    <div>
        <h5>Diver station id: {{ diverStationId }}</h5>
        <table class="table table-sm table-hover table-bordered">
            <thead class="text-center">
                <tr>
                    <th v-text="'Date'" />
                    <th v-text="'Salinity'" />
                    <th v-text="'Level'" />
                    <th v-text="'Temperature'" />
                </tr>
            </thead>
            <tbody>
                <tr v-for="(item, index) in diverInfo" :key="index">
                    <td v-text="formatDate(item.vaqt)" />
                    <td class="text-right" v-text="item.mineral" />
                    <td class="text-right" v-text="item.level" />
                    <td class="text-right" v-text="item.temperatura" />
                </tr>
            </tbody>
        </table>
    </div>
</template>

<style lang="scss" scoped></style>
