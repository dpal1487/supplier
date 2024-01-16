<script>
import { defineComponent } from "vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import { Head, Link } from "@inertiajs/inertia-vue3";
import Multiselect from "@vueform/multiselect";
import Pagination from "../../Jetstream/Pagination.vue";
import { Inertia } from "@inertiajs/inertia";
import { toast } from "vue3-toastify";
import Loading from "vue-loading-overlay";
import 'vue-loading-overlay/dist/css/index.css';
import IndustryForm from "./Components/IndustryForm.vue";
import axios from "axios";
import utils from "../../utils";
import NoRecordMessage from "../../Components/NoRecordMessage.vue";
export default defineComponent({
    props: ["industries"],
    data() {
        return {
            form: {},
            isFullPage: true,
            isLoading: false,
            isModalOpen: false,
            activeId: '',
            title: "Industry",
            tbody: [
                "Image",
                "Name",
                "Status",
                "Action",
            ],
            checkbox: [],
        };
    },
    components: {
    AppLayout,
    Link,
    Head,
    Pagination,
    Multiselect,
    Loading,
    IndustryForm,
    NoRecordMessage
},
    methods: {

        showIndustryForm(id) {
            if (id) {
                this.isModalOpen = true;
                this.activeId = id;
            }
            this.isModalOpen = true;
        },
        hideIndustryForm() {
            this.isModalOpen = false;
        },
        async confirmDelete(id, index) {
            this.isLoading = true;
            await utils.deleteIndexDialog(route('industry.destroy', id), this.industries.data, index);
            this.isLoading = false;
        },
        search() {
            Inertia.get("/industries", this.form);
        },
        changeStatus(e, id) {
            this.isLoading = true;
            axios
                .post("/industry/status", { id: id, status: e })
                .then((response) => {
                    if (response.data.success) {
                        toast.success(response.data.message);
                        return;
                    }
                    toast.error(response.data.message);
                })
                .finally(() => (this.isLoading = false));
        },
    },
});
</script>
<template>
    <loading :active="isLoading" :can-cancel="true" :is-full-page="isFullPage"></loading>
    <IndustryForm :show="isModalOpen" @hidemodal="hideIndustryForm" :id="activeId" />
    <app-layout :title="title">
        <template #breadcrumb>
            <li class="breadcrumb-item">
                <span class="bullet bg-gray-400 w-5px h-2px"></span>
            </li>
            <li class="breadcrumb-item">
                <Link href="/industry" class="text-muted text-hover-primary">{{ title }}</Link>
            </li>
        </template>
        <template #toolbar>
            <div class="d-flex align-items-center gap-2 gap-lg-3">
                <button class="btn btn-sm fw-bold btn-primary" @click="showIndustryForm()">
                    <i class="bi bi-plus-circle"></i>Add New Industry
                </button>
            </div>
        </template>

        <Head title="industry" />
        <div class="card">
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
                    <div class="w-100 mw-200px">
                        <Multiselect :can-clear="false" :options="$page.props.ziggy.status" label="name" valueProp="value"
                            class="form-control form-control-solid" placeholder="Select Status" v-model="form.status" />
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
                        <tbody class="fw-semibold text-gray-400" v-if="industries.data.length > 0">
                            <tr v-for="(industry, index) in industries.data" :key="index">
                                <td v-if="industry.image">
                                    <div class="symbol symbol-50px me-5">
                                        <img alt="Logo" :src="industry.image?.url">
                                    </div>
                                </td>
                                <td v-else>
                                    <div class="symbol symbol-50px me-5">
                                        <img alt="Logo" src="/assets/images/comingsoon.png">
                                    </div>
                                </td>
                                <td class="w-300px">{{ industry.name }}</td>
                                <td>
                                    <div class="form-switch form-check-solid d-block form-check-custom form-check-success">
                                        <input class="form-check-input h-20px w-30px" type="checkbox"
                                            @input="changeStatus($event.target.checked, industry.id)"
                                            :checked="industry.status == 1 ? true : false" />
                                    </div>
                                </td>
                                <td class="w-150px">
                                    <div class="dropdown">
                                        <a href="#" class="btn btn-sm btn-light btn-active-light-primary"
                                            :id="`dropdown-${industry.id}`" data-bs-toggle="dropdown"
                                            aria-expanded="false">Actions
                                            <span class="svg-icon svg-icon-5 m-0">
                                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M11.4343 12.7344L7.25 8.55005C6.83579 8.13583 6.16421 8.13584 5.75 8.55005C5.33579 8.96426 5.33579 9.63583 5.75 10.05L11.2929 15.5929C11.6834 15.9835 12.3166 15.9835 12.7071 15.5929L18.25 10.05C18.6642 9.63584 18.6642 8.96426 18.25 8.55005C17.8358 8.13584 17.1642 8.13584 16.75 8.55005L12.5657 12.7344C12.2533 13.0468 11.7467 13.0468 11.4343 12.7344Z"
                                                        fill="currentColor"></path>
                                                </svg>
                                            </span>
                                        </a>
                                        <ul class="dropdown-menu text-small menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4"
                                            :aria-labelled:by="`dropdown-${industry.id}`">
                                            <li class="menu-item px-3">
                                                <button
                                                    class="btn btn-sm dropdown-item align-items-center justify-content-center"
                                                    @click="showIndustryForm(industry?.id)"><i
                                                        class="bi bi-pencil me-2"></i>Edit
                                                </button>
                                            </li>
                                            <li class="menu-item px-3">
                                                <button @click="confirmDelete(
                                                    industry.id, index
                                                )
                                                    "
                                                    class="btn btn-sm dropdown-item align-items-center justify-content-center">
                                                    <i class="bi bi-trash3 me-2"></i>Delete
                                                </button>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
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
                <div class="d-flex align-items-center justify-content-center justify-content-md-end" v-if="industries.meta">
                    <Pagination :links="industries.meta.links" />
                </div>
            </div>
        </div>

    </app-layout>
</template>
