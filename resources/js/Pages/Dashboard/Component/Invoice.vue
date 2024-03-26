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
            series: [this.invoice.report.total_projects, this.invoice.report.total_clicks, this.invoice.report.completes, this.invoice.report.quotafull, this.invoice.report.terminates,],
            chartOptions: {
                chart: {
                    width: 380,
                    type: "pie",
                },
                labels: ["Total Project", "Total Click", "Total Completed", "Total Quotafull", "Total Terminate"],
                responsive: [{
                    breakpoint: 480,
                    options: {
                        chart: {
                            width: 300
                        },
                        legend: {
                            position: 'bottom'
                        }
                    }
                }]
            },
        };
    },

});
</script>

<template>
    <div class="card my-5">
        <div class="card-body pt-2">
            <div class="row justify-content-center">
                <div class="col-md-6 d-flex align-items-center">
                    <apexchart type="pie" height="450" width="450" :options="chartOptions" :series="series">
                    </apexchart>
                </div>
                <div class="col-md-6 p-2">
                    <div class="row">
                        <div class=" mb-5">
                            <div class="card card-flush bgi-no-repeat bgi-size-contain bgi-position-x-end" style="
                                    background-color: #298356;
                                ">
                                <div class="card-header p-5">
                                    <div class="card-title d-flex flex-column">
                                        <span class="fs-2hx fw-bold text-white me-2 lh-1 ls-n2">{{ invoice?.live
                                            }}</span>
                                        <span class="text-white opacity-75 pt-1 fw-semibold fs-6">Live Project</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class=" mb-5">
                            <div class="card card-flush bgi-no-repeat bgi-size-contain bgi-position-x-end" style="
                                    background-color: #7f41f1;
                                ">
                                <div class="card-header p-5">
                                    <div class="card-title d-flex flex-column">
                                        <span class="fs-2hx fw-bold text-white me-2 lh-1 ls-n2">{{ invoice?.pause
                                            }}</span>
                                        <span class="text-white opacity-75 pt-1 fw-semibold fs-6">Pause Project</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class=" mb-5">
                            <div class="card card-flush bgi-no-repeat bgi-size-contain bgi-position-x-end" style="
                                    background-color: #f1416c;
                                ">
                                <div class="card-header p-5">
                                    <div class="card-title d-flex flex-column">
                                        <span class="fs-2hx fw-bold text-white me-2 lh-1 ls-n2">{{ invoice?.close
                                            }}</span>
                                        <span class="text-white opacity-75 pt-1 fw-semibold fs-6">Close Project</span>
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
