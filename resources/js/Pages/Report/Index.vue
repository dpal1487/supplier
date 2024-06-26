<script>
import { defineComponent, ref } from "vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import { Head, Link } from "@inertiajs/inertia-vue3";
import Multiselect from "@vueform/multiselect";
import Pagination from "../../Jetstream/Pagination.vue";
import { Inertia } from "@inertiajs/inertia";
import NoRecordMessage from "../../Components/NoRecordMessage.vue";
export default defineComponent({
    props: ["surveys", "users"],
    data() {
        return {
            title: "Reports",
            first_name: '',
            label: '',
            form: {},
            tbody: [
                "S.No",
                "Project ID",
                "Vender Name",
                "Start Date",
                "End Date",
                "LOI",
                "CPI",
                "IP",
                "Status",
            ],
            status: [
                { value: "complete", label: "Completed" },
                { value: "terminate", label: "Terminated" },
                { value: "quotafull", label: "Quotafull" },
            ],
        };
    },
    components: {
        AppLayout,
        Link,
        Head,
        Pagination,
        Multiselect,
        NoRecordMessage
    },
    methods: {
        search() {
            Inertia.get(
                "/project-reports", this.form,
            );
        },
        $queryParams(...args) {
            let queryString = this.$page.url;
            if (queryString.indexOf("?") === -1) {
                return {};
            }
            queryString = queryString.substring(queryString.indexOf("?") + 1);
            return Object.assign(Object.fromEntries(new URLSearchParams(queryString)), ...args);
        },

    },
    created() {
        const queryString = window.location.search;
        const urlParams = new URLSearchParams(queryString);
        this.form.status = urlParams.get('status')
        this.form.q = urlParams.get('q')
    }

});
</script>
<template>
    <Head :title="title" />
    <app-layout :title="title">
        <template #breadcrumb>
            <li class="breadcrumb-item">
                <span class="bullet bg-gray-400 w-5px h-2px"></span>
            </li>
            <li class="breadcrumb-item">
                <span class="text-muted text-hover-primary">Project Reports </span>
            </li>

        </template>
        <div class="card">
            <form class="card-header justify-content-start p-5 gap-2 gap-md-5" @submit.prevent="search()">
                <div class="d-flex align-items-center position-relative w-100 mw-150px">
                    <span class="svg-icon svg-icon-1 position-absolute ms-4"><svg width="24" height="24"
                            viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2" rx="1"
                                transform="rotate(45 17.0365 15.1223)" fill="currentColor"></rect>
                            <path
                                d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z"
                                fill="currentColor"></path>
                        </svg>
                    </span>
                    <input type="text" v-model="form.q" class="form-control form-control-solid ps-14"
                        placeholder="Search " />
                </div>
                <div class="w-100 mw-150px">
                    <Multiselect :options="status" label="label" :can-clear="false" valueProp="value" :searchable="true"
                        :track-by="label" class="form-control form-control-solid" placeholder="Select "
                        v-model="form.status" />
                </div>
                <div class="w-100 mw-150px">
                    <input type="date" class="form-control form-control-solid" id="date" placeholder="Select Date"
                        v-model="form.from_date" />
                </div>
                <div class="w-100 mw-150px">
                    <input type="date" class="form-control form-control-solid" placeholder="Select Date"
                        v-model="form.to_date" />
                </div>
                <div class="d-flex w-400px gap-5">
                    <button type="submit" class="btn btn-primary w-100">
                        Search
                    </button>
                    <a target="_blank" :href="route('project-reports.report', { ...$queryParams() })"
                        class="btn btn-primary w-100"><i class="bi bi-graph-down-arrow"></i>Export
                        Report</a>
                </div>
            </form>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table align-middle table-row-dashed fs-6 gy-5">
                        <thead>
                            <tr class="text-gray-700 fw-bold fs-7 w-100 text-uppercase">
                                <th class="min-w-120px" v-for="(th, index) in tbody" :key="index">
                                    {{ th }}
                                </th>
                            </tr>
                        </thead>
                        <tbody class="fw-semibold text-gray-500" v-if="surveys?.data?.length > 0">
                            <tr v-for="(survey, index) in surveys.data" :key="index">
                                <td>{{ index + 1 }}</td>
                                <td>{{ survey.project_id }} </td>
                                <td>{{ survey?.vender?.name }}</td>
                                <td>{{ survey.created_at }}</td>
                                <td>{{ survey.end_date }}</td>
                                <td>{{ survey.loi }}</td>
                                <td>{{ survey?.cpi }}</td>
                                <td>{{ survey?.starting_ip }}</td>
                                <td>
                                    <div v-if="(survey.status == 'terminate')"
                                        class="mx-1 text-capitalize badge badge-light-danger">Terminate</div>
                                    <div v-else-if="(survey.status == 'complete')"
                                        class="mx-1 text-capitalize badge badge-light-success">Complete
                                    </div>
                                    <div v-else-if="(survey.status == 'quotafull')"
                                        class="mx-1 text-capitalize badge badge-light-info">Quotafull</div>
                                    <div v-else-if="(survey.status == 'security-terminate')"
                                        class="mx-1 text-capitalize badge badge-light-danger">
                                        Security Terminate</div>
                                    <div v-else class="mx-1 text-capitalize badge badge-light">Incomplete</div>
                                </td>

                            </tr>
                        </tbody>

                        <tbody class="fw-semibold text-gray-600" v-else>
                            <tr class="text-gray-600 fw-bold fs-7 align-middle text-uppercase h-100px">
                                <td colspan="10" class="text-center h-full">
                                    <NoRecordMessage />
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer">
                <Pagination :links="surveys" />
            </div>
        </div>
    </app-layout>
</template>
