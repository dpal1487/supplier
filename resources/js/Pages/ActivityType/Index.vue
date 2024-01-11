<script>
import { defineComponent } from "vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import { Head, Link } from "@inertiajs/inertia-vue3";
import axios from "axios";
import Pagination from "../../Jetstream/Pagination.vue";
import { Inertia } from "@inertiajs/inertia";
import ActivityTypeForm from "./Components/ActivityTypeForm.vue";
import SectionLoader from "../../Components/SectionLoader.vue";
import utils from "../../utils.js";

export default defineComponent({
    props: ["activity_types"],
    data() {
        return {
            form: {},
            activity_type: {},
            title: "Activity Type",
            isLoading: false,
            tbody: [
                "Sr. Number",
                "Text",
                "Action",
            ],
        };
    },
    components: {
        AppLayout,
        Link,
        Head,
        Pagination,
        ActivityTypeForm,
        SectionLoader
    },
    methods: {
        async confirmDelete(id, index) {
            console.log(id)
            this.isLoading = true;
            await utils.deleteIndexDialog(route('activity_type.destroy', id), this.activity_types.data, index);
            this.isLoading = false;
        },
        search() {
            Inertia.get("/activity_types", this.form);
        },
        activityForm(id) {
            this.isLoading = true;
            axios.get("/activity_type/edit", { params: { "id": id } })
                .then((response) => {
                    if (response?.data?.success) {
                        this.activity_type = response?.data?.activity_type
                    }
                }).finally(() => {
                    this.isLoading = false
                })
        }
    },
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
                <span class="text-muted text-hover-primary">{{ title }}</span>
            </li>
        </template>
        <div class="row gy-0">
            <div class="col-md-6 gap-5">
                <div class="card" v-if="isLoading == true">
                    <div class="card-header">
                        <div class="card-title">
                            <h2>General Form</h2>
                        </div>
                    </div>
                    <div class="card-body my-10">
                        <div class="row col-md-12">
                            <div class="fv-row my-10">
                                <SectionLoader :width="50" :height="50" />
                            </div>
                        </div>
                    </div>
                </div>
                <div v-else>
                    <ActivityTypeForm :activity_type="activity_type" />
                </div>

            </div>
            <div class="col-md-6">
                <div class="card card-md-stretch me-xl-3 mb-md-0 mb-6">
                    <div>
                        <form class="card-header justify-content-start p-5 gap-3" @submit.prevent="search()">
                            <div class="d-flex align-items-center position-relative">
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
                                    <tr class="text-gray-400 fw-bold fs-7 text-uppercase">
                                        <th v-for="(th, index) in tbody" :key="index">
                                            {{ th }}
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="fw-semibold text-gray-600">
                                    <tr v-for="(activity_type, index) in activity_types.data" :key="index">
                                        <td>{{ index + 1 }}</td>
                                        <td>{{ activity_type?.text }}</td>
                                        <td>
                                            <div class="d-flex">
                                                <li class="menu-item">
                                                    <button class="btn btn-sm" @click="activityForm(activity_type?.id)">
                                                        <i class="bi bi-pencil"></i>
                                                    </button>
                                                </li>
                                                <li class="menu-item">
                                                    <button @click="confirmDelete(activity_type?.id, index)"
                                                        class="btn btn-sm">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </li>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="d-flex align-items-center justify-content-center justify-content-md-end"
                            v-if="activity_types.meta">
                            <Pagination :links="activity_types.meta.links" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </app-layout>
</template>
