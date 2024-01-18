<script>
import { defineComponent } from "vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import { Head, Link } from "@inertiajs/inertia-vue3";
import Pagination from "../../Jetstream/Pagination.vue";
import { Inertia } from "@inertiajs/inertia";
import Loading from "vue-loading-overlay";
import "vue-loading-overlay/dist/css/index.css";
import utils from "../../utils";
import Multiselect from "@vueform/multiselect";
import NoRecordMessage from "../../Components/NoRecordMessage.vue";

export default defineComponent({
    props: ["clients"],
    data() {
        return {
            form: {},
            tbody: [
                "Company Name",
                "Email",
                "Contact Number",
                "Tax Number",
                "Status",
                "Created At",
                "Action",
            ],
            isLoading: false,
            title: "Clients"
        };
    },
    components: {
    AppLayout,
    Link,
    Head,
    Pagination,
    Loading,
    Multiselect,
    NoRecordMessage
},
    methods: {
        async updateStatus(e, id) {
            this.isLoading = true;
            await utils.changeStatus(route('client.status'), { id: id, status: e });
            this.isLoading = false;
        },

        async confirmDelete(index) {
            this.isLoading = true;
            await utils.deleteIndexDialog(route('client.destroy', this.clients.data[index].id), this.clients.data, index);
            this.isLoading = false;
        },
        search() {
            Inertia.get(
                "/clients",
                this.form,
                {
                    preserveState: true,
                }
            );
        },
    },
});
</script>
<template>
    <app-layout :title="title">
        <loading v-model:active="isLoading" :can-cancel="false" :is-full-page="true" />
        <template #breadcrumb>
            <li class="breadcrumb-item">
                <span class="bullet bg-gray-400 w-5px h-2px"></span>
            </li>
            <li class="breadcrumb-item text-muted">
                {{ title }}
            </li>
        </template>
        <template #toolbar>
            <div class="d-flex align-items-center gap-2 gap-lg-3">
                <Link href="/client/create" class="btn btn-sm fw-bold btn-primary">
                <i class="bi bi-plus-circle"></i>Add New Client</Link>
            </div>
        </template>

        <Head title="Clients" />
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
                        placeholder="Search Client" />
                    <Multiselect :options="$page.props.ziggy.status" label="name" value-prop="value" v-model="form.status"
                        class="form-control form-control-solid w-150px mx-2" placeholder="Select Status" />
                </div>

                <button type="submit" class="btn btn-primary">
                    Search
                </button>
            </form>
            <div class="card-body pt-0">
                <div class="table-responsive">
                    <table class="table align-middle table-row-dashed fs-6 gy-5">
                        <thead>
                            <tr class="text-gray-700 fw-bold fs-7 text-uppercase ">
                                <th v-for="(th, index) in tbody" :key="index">
                                    {{ th }}
                                </th>
                            </tr>
                        </thead>
                        <tbody class="fw-semibold text-gray-500" v-if="clients.data.length > 0">
                            <tr v-for="(client, index) in clients.data" :key="index">
                                <td>
                                    <Link :href="'/client/' + client.id"
                                        class="text-gray-800 text-hover-primary fs-5 fw-bold mb-1" project-filter="name">{{
                                            client.display_name }}</Link>
                                </td>
                                <td>{{ client.email_address }}</td>
                                <td>{{ client.contact_number }}</td>
                                <td>{{ client.tax_number }}</td>
                                <td>
                                    <div class="form-switch form-check-solid d-block form-check-custom form-check-success">
                                        <input class="form-check-input h-20px w-30px" type="checkbox"
                                            @input="updateStatus($event.target.checked, client.id)"
                                            :checked="client.status == 1 ? true : false" />
                                    </div>
                                </td>
                                <td>{{ client.created_at }}</td>
                                <td>
                                    <a href="#" class="btn btn-sm btn-light menu-dropdown" :id="`dropdown-${client.id}`"
                                        data-bs-toggle="dropdown">Actions
                                        <span class="svg-icon svg-icon-5 m-0">
                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M11.4343 12.7344L7.25 8.55005C6.83579 8.13583 6.16421 8.13584 5.75 8.55005C5.33579 8.96426 5.33579 9.63583 5.75 10.05L11.2929 15.5929C11.6834 15.9835 12.3166 15.9835 12.7071 15.5929L18.25 10.05C18.6642 9.63584 18.6642 8.96426 18.25 8.55005C17.8358 8.13584 17.1642 8.13584 16.75 8.55005L12.5657 12.7344C12.2533 13.0468 11.7467 13.0468 11.4343 12.7344Z"
                                                    fill="currentColor"></path>
                                            </svg>
                                        </span>
                                    </a>
                                    <div class="text-left dropdown-menu menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4"
                                        :aria-labelled:by="`dropdown-${client.id}`">
                                        <div class="menu-item px-3">
                                            <Link :href="`/client/${client.id}/edit`" class="menu-link"><i
                                                class="bi bi-pencil me-2"></i>Edit
                                            </Link>
                                        </div>
                                        <div class="menu-item px-3">
                                            <span @click="confirmDelete(index)" class="menu-link"><i
                                                    class="bi bi-trash3 me-2"></i>Delete</span>
                                        </div>
                                    </div>
                                </td>

                            </tr>
                        </tbody>

                        <tbody class="fw-semibold text-gray-600" v-else>
                            <tr class="text-gray-600 fw-bold fs-7 align-middle text-uppercase h-100px">
                                <td colspan="9" class="text-center h-full">
                                    <NoRecordMessage />
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="row mb-5 mx-5" v-if="clients.data.length > 0">
                <div class="col-sm-12 d-flex align-items-center justify-content-between mb-5" v-if="clients.meta">
                    <span class="fw-bold text-gray-700">
                        Showing {{ clients.meta.from }} to {{ clients.meta.to }}
                        of {{ clients.meta.total }} entries
                    </span>
                    <Pagination :links="clients.meta.links" />
                </div>
            </div>
        </div>
    </app-layout>
</template>
