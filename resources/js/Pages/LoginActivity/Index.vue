<script>
import { defineComponent, ref } from "vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import { Head, Link } from "@inertiajs/inertia-vue3";
import { Inertia } from "@inertiajs/inertia";
import Multiselect from "@vueform/multiselect";
import Pagination from "../../Jetstream/Pagination.vue";
import NoRecordMessage from "../../Components/NoRecordMessage.vue";
import VueDatePicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css';

export default defineComponent({
    props: ["login_activities"],
    data() {
        return {
            form: {},
            title: "Login Activities",
            tbody: [
                "Name",
                "Login Date",
                "Login Time",
                "Logout Time",
                "Work Time",
                "Time ",
            ],
        };
    },
    components: {
        AppLayout,
        Link,
        Head,
        Pagination,
        Multiselect,
        NoRecordMessage,
        VueDatePicker,

    },
    methods: {
        search() {
            if (this.form.start_date) {
                let jsDateString = this.form.start_date;
                // Convert the JavaScript date string to a Date object
                let jsDateObject = new Date(jsDateString);
                // Format the Date object using toISOString and then replace 'T' with a space
                let formattedDate = jsDateObject.toISOString();
                this.form.start_date = formattedDate;
                // Now, formattedDate contains the date in the 'Y-m-d H:i:s'
            }
            Inertia.get("/login_activities", this.form);
        },
    },
});
</script>
<template>
    <app-layout :title="title">
        <template #breadcrumb>
            <li class="breadcrumb-item">
                <span class="bullet bg-gray-400 w-5px h-2px"></span>
            </li>
            <li class="breadcrumb-item">
                <Link href="/login_activities" class="text-muted text-hover-primary">{{ title }}</Link>
            </li>
        </template>

        <Head :title="title" />
        <div class="card">
            <div>
                <form class="card-header justify-content-start p-5 gap-3" @submit.prevent="search()">
                    <div class="d-flex align-items-center position-relative gap-5">
                        <span class="svg-icon svg-icon-1 position-absolute ms-4"><svg width="24" height="24"
                                viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2" rx="1"
                                    transform="rotate(45 17.0365 15.1223)" fill="currentColor"></rect>
                                <path
                                    d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z"
                                    fill="currentColor"></path>
                            </svg>
                        </span>
                        <input type="text" v-model="form.q" class="form-control form-control-solid w-250px ps-14"
                            placeholder="Search " />
                        <VueDatePicker v-model="form.start_date" :clearable="false" auto-apply
                            input-class-name="form-control form-control-lg form-control-solid fw-normal"
                            placeholder="Select Date">
                        </VueDatePicker>
                    </div>

                    <button type="submit" class="btn btn-primary">
                        Search
                    </button>
                </form>
            </div>
            <div class="card-body pt-0">
                <div class="table-responsive">
                    <table class="table align-middle table-row-dashed fs-6 gy-5 text-left">
                        <thead>
                            <tr class="text-gray-700 fw-bold fs-7 text-uppercase">
                                <th v-for="(th, index) in tbody" :key="index">
                                    {{ th }}
                                </th>
                            </tr>
                        </thead>
                        <tbody class="fw-semibold text-gray-500" v-if="login_activities.data.length > 0">
                            <tr v-for="(login_activity, index) in login_activities.data" :key="index">
                                <td class="text-gray-800 fs-5 fw-bold mb-1">
                                    {{ login_activity?.name }}
                                </td>
                                <td>{{ login_activity?.login_date }}</td>
                                <td>{{ login_activity?.login_time }}</td>
                                <td>{{ login_activity?.logout_time }}</td>
                                <td>{{ login_activity?.total_time }}</td>
                                <td>{{ login_activity?.day_time }}</td>

                            </tr>
                        </tbody>

                        <tbody class="fw-semibold text-gray-600" v-else>
                            <tr class="text-gray-600 fw-bold fs-7 align-middle text-uppercase h-100px">
                                <td colspan="6" class="text-center h-full">
                                    <NoRecordMessage />
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="d-flex align-items-center justify-content-center justify-content-md-end"
                    v-if="login_activities.meta">
                    <Pagination :links="login_activities.meta.links" />
                </div>
            </div>
        </div>
    </app-layout>
</template>
