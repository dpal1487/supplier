<script>
import { defineComponent } from "vue";
import { Link } from "@inertiajs/inertia-vue3";
export default defineComponent({
    props: ["invoice"],
    components: {
        Link,
    },
    data() {
        return {
            series: [this.invoice],
            chartOptions: {
                chart: {
                    width: 380,
                    type: "pie",
                },
                labels: ["Sample size", "Total IR", "total completed"],
            },
        };
    },
});
</script>

<template>
    <div class="card my-5">
        <div class="card-header pt-7">
            <h3 class="card-title align-items-start flex-column">
                <span class="card-label fw-bold text-gray-800 align-middle mb-4"
                    >Invoice Dashboard</span
                >
            </h3>
        </div>
        <div class="card-body pt-2">
            <div class="row">
                <div class="col-md-6">
                    <apexchart
                        type="pie"
                        height="350"
                        width="350"
                        :options="chartOptions"
                        :series="series"
                    >
                    </apexchart>
                </div>
                <div class="col-md-6 p-2">
                    <div class="row">
                        <div class="col-md-6 mb-5">
                            <div
                                class="card card-flush bgi-no-repeat bgi-size-contain bgi-position-x-end"
                                style="
                                    background-color: #298356;
                                    background-image: url('/assets/media/patterns/vector-1.png');
                                    height: 150px;
                                "
                            >
                                <div class="card-header p-5">
                                    <div class="card-title d-flex flex-column">
                                        <span
                                            class="fs-2hx fw-bold text-white me-2 lh-1 ls-n2"
                                            >{{ invoice?.live_invoice }}</span
                                        >
                                        <span
                                            class="text-white opacity-75 pt-1 fw-semibold fs-6"
                                            >Pending Approval</span
                                        >
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-5">
                            <div
                                class="card card-flush bgi-no-repeat bgi-size-contain bgi-position-x-end"
                                style="
                                    background-color: #7f41f1;
                                    background-image: url('/assets/media/patterns/vector-1.png');
                                    height: 150px;
                                "
                            >
                                <div class="card-header p-5">
                                    <div class="card-title d-flex flex-column">
                                        <span
                                            class="fs-2hx fw-bold text-white me-2 lh-1 ls-n2"
                                            >{{
                                                invoice?.inactive_invoice
                                            }}</span
                                        >
                                        <span
                                            class="text-white opacity-75 pt-1 fw-semibold fs-6"
                                            >Approved Invoice</span
                                        >
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-5">
                            <div
                                class="card card-flush bgi-no-repeat bgi-size-contain bgi-position-x-end"
                                style="
                                    background-color: #f1416c;
                                    background-image: url('/assets/media/patterns/vector-1.png');
                                    height: 150px;
                                "
                            >
                                <div class="card-header p-5">
                                    <div class="card-title d-flex flex-column">
                                        <span
                                            class="fs-2hx fw-bold text-white me-2 lh-1 ls-n2"
                                            >{{
                                                invoice?.cancelled_invoice
                                            }}</span
                                        >
                                        <span
                                            class="text-white opacity-75 pt-1 fw-semibold fs-6"
                                            >Rejected Invoice</span
                                        >
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-5">
                            <div
                                class="card card-flush bgi-no-repeat bgi-size-contain bgi-position-x-end"
                                style="
                                    background-color: #f18741;
                                    background-image: url('/assets/media/patterns/vector-1.png');
                                    height: 150px;
                                "
                            >
                                <div class="card-header p-5">
                                    <div class="card-title d-flex flex-column">
                                        <span
                                            class="fs-2hx fw-bold text-white me-2 lh-1 ls-n2"
                                            >{{ invoice?.closed_invoice }}</span
                                        >
                                        <span
                                            class="text-white opacity-75 pt-1 fw-semibold fs-6"
                                            >Paid Invoice</span
                                        >
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
