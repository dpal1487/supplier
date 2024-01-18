<script>
import { defineComponent, ref } from "vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import { Head, Link } from "@inertiajs/inertia-vue3";
import Pagination from "../../Jetstream/Pagination.vue";
import axios from "axios";
import Loading from "vue-loading-overlay";
import "vue-loading-overlay/dist/css/index.css";
import { toast } from "vue3-toastify";
import { Inertia } from "@inertiajs/inertia";
export default defineComponent({
    props: ["filanids"],
    data() {
        return {
            form: {},
            isLoading: false,
            title: "Final Id",
            tbody: [
                "Project Name",
                "Complete",
                "Count",
                "ACTION",
            ],
        };
    },
    components: {
        AppLayout,
        Link,
        Head,
        Pagination,
        Loading
    },
    methods: {

        search() {
            Inertia.get(
                "/final-id", this.form,
            );
        },
        showFinalIds(id) {
            this.isModalOpen = true;
            this.activeId = id;
        },
        hideFinalIds() {
            this.isModalOpen = false;
        },

        formSubmit(e, id) {
            const file = e.currentTarget.files[0];
            this.$data.form.image = file;
            this.selectedFilename = file?.name;
            this.url = URL.createObjectURL(file);
            const config = {
                headers: { "content-type": "multipart/form-data" },
            };
            const formData = new FormData();
            formData.append("file", file);
            this.isLoading = true;
            axios
                .post(`/project/${id}/importid`, formData, config)
                .then(function (response) {
                    if (response.data.success) {
                        toast.success(response.data.message);
                    } else {
                        toast.error(response.data.message);
                    }
                })
                .catch(function (error) {
                    toast.error(error.message);
                })
                .finally(() => {
                    this.isLoading = false;
                });
        },

    },

});
</script>
<template>
    <loading v-model:active="isLoading" :can-cancel="false" :is-full-page="true" />

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

        <div class="card">
            <form @submit.prevent="search" class="card-header justify-content-start p-5 gap-2 gap-md-5">
                <div class="d-flex align-items-center position-relative">
                    <span class="svg-icon svg-icon-1 position-absolute ms-4"><svg width="24" height="24" viewBox="0 0 24 24"
                            fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2" rx="1"
                                transform="rotate(45 17.0365 15.1223)" fill="currentColor"></rect>
                            <path
                                d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z"
                                fill="currentColor"></path>
                        </svg>
                    </span>
                    <input type="text" v-model="form.q" class="form-control form-control-solid w-250px ps-14"
                        placeholder="Search ..." />
                </div>

                <button type="submit" class="btn btn-primary">
                    Search
                </button>
            </form>

            <div class="card-body pt-0">
                <div class="table-responsive">
                    <table class="table align-middle table-row-dashed fs-6 gy-5">
                        <thead>
                            <tr class="text-gray-500 fw-bold fs-7 w-100 text-uppercase">
                                <th class="min-w-120px" v-for="(th, index) in tbody" :key="index">
                                    {{ th }}
                                </th>
                            </tr>
                        </thead>
                        <tbody class="fw-semibold text-gray-600">
                            <tr v-for="(finalid, index) in filanids.data" :key="index">
                                <td class="text-gray-700 fs-4 fw-bold">
                                    {{ finalid?.project_name }}
                                </td>
                                <td>{{ finalid?.complete }}</td>
                                <td>{{ finalid?.count }}</td>
                                <td>
                                    <a target="_blank" :href="`/final-id/${finalid.id}/export`"
                                        class="btn btn-primary m-1 btn-sm"><i class="bi bi-graph-down-arrow"></i>Export Data
                                    </a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="d-flex align-items-center justify-content-center justify-content-md-end mb-10"
                    v-if="filanids.meta">
                    <Pagination :links="filanids.meta.links" />
                </div>
            </div>
        </div>
    </app-layout>
</template>
