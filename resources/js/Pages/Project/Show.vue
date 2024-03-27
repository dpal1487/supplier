<script>
import { defineComponent } from "vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import { Link } from "@inertiajs/inertia-vue3";
import CopyLinkButton from "../../Components/CopyLinkButton.vue";
export default defineComponent({
    props: ["project"],
    components: {
        AppLayout,
        Link,
        CopyLinkButton
    },
    validations() {
        return {};
    },
    data() {
        return {
            series: [this.project?.data?.reports?.total_clicks, this.project?.data?.reports?.complete, this.project?.data?.reports?.terminate, this.project?.data?.reports?.quotafull, this.project?.data?.reports?.incomplete, this.project?.data?.reports?.security_terminate],
            chartOptions: {
                chart: {
                    width: 380,
                    type: 'pie',
                },
                labels: ["Total Click", "Total Completed", "Total Terminate", "Total Quotafull", "Total Incomplete", "Total Security Terminate"],
                legend: {
                    position: 'bottom'
                },
                responsive: [{
                    breakpoint: 380,
                    options: {
                        chart: {
                            width: 250
                        },
                        legend: {
                            position: 'bottom'
                        }
                    }
                }]
            },
            title: 'Project View',
        };
    },
});
</script>
<template>
    <app-layout :title="title">
        <template #breadcrumb>
            <li class="breadcrumb-item">
                <span class="bullet bg-gray-400 w-5px h-2px"></span>
            </li>
            <li class="breadcrumb-item text-muted">
                <span class="text-muted text-hover-primary">Projects</span>
            </li>
        </template>
        <div class="mb-5">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">
                        <h2>#{{ project?.data?.project_id }}</h2>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="row justify-content-center g-5">
                        <div class="col-md-8">
                            <div class="d-flex flex-row px-5 my-5">
                                <div class="flex-shrink-0" style="width: 200px;">Project ID</div>
                                <div class="flex-root fs-6 fw-bold text-gray-800 mw-100" style="width: 120px;">
                                    {{ project?.data?.project_id }}</div>
                            </div>

                            <div class="d-flex flex-row  px-5 my-5">
                                <div class="flex-shrink-0" style="width: 200px;">Project Link</div>
                                <div class="flex-root fs-6 fw-bold text-gray-800 mw-100" style="width: 120px;">
                                    <CopyLinkButton :link="project?.data?.project_link" tooltip="Copy project link" />
                                </div>
                            </div>
                            <div class="d-flex flex-row  px-5 my-5">
                                <div class="flex-shrink-0" style="width: 200px;">Project Country</div>
                                <div class="flex-root fs-6 fw-bold text-gray-800 mw-100" style="width: 120px;">
                                    {{ project?.data?.country?.display_name }}
                                </div>
                            </div>
                            <div class="d-flex flex-row  px-5 my-5">
                                <div class="flex-shrink-0" style="width: 200px;">Client Name</div>
                                <div class="flex-root fs-6 fw-bold text-gray-800 mw-100" style="width: 120px;">
                                    {{ project?.data?.client?.name }}
                                </div>
                            </div>
                            <div class="d-flex flex-row  px-5 my-5">
                                <div class="flex-shrink-0" style="width: 200px;">Sample Size</div>
                                <div class="flex-root fs-6 fw-bold text-gray-800 mw-100" style="width: 120px;">
                                    {{ project?.data?.sample_size }}N
                                </div>
                            </div>
                            <div class="d-flex flex-row  px-5 my-5">
                                <div class="" style="width: 200px;">Project CPI</div>
                                <div class="flex-root fs-6 fw-bold text-gray-800">
                                    ${{ project.data.cpi }}
                                </div>
                            </div>
                            <div class="d-flex flex-row  px-5 my-5">
                                <div class="" style="width: 200px;">Project LOI</div>
                                <div class="flex-root fs-6 fw-bold text-gray-800">
                                    {{ project.data?.loi }} Min
                                </div>
                            </div>
                            <div class="d-flex flex-row  px-5 my-5">
                                <div class="" style="width: 200px;">Incidence Ratio</div>
                                <div class="flex-root fs-6 fw-bold text-gray-800">
                                    {{ project.data?.ir }}%
                                </div>
                            </div>
                            <div class="d-flex flex-row  px-5 my-5">
                                <div class="" style="width: 200px;">Project Status</div>
                                <div class="flex-root fs-6 fw-bold text-gray-800">
                                    <span class="badge badge-success" v-if="project.data?.status">Active</span>
                                    <span class="badge badge-danger" v-else>Inactive</span>
                                </div>
                            </div>
                            <div class="d-flex flex-row  px-5 my-5">
                                <div class="" style="width: 200px;">Target </div>
                                <div class="flex-root fs-6 fw-bold text-gray-800">
                                    {{ project?.data?.project?.target }}

                                </div>
                            </div>
                        </div>
                        <div class="col-md-4  d-flex align-items-center">
                            <div class="text-center">
                                <apexchart type="pie" height="300" width="300" :options="chartOptions" :series="series">
                                </apexchart>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </app-layout>
</template>
