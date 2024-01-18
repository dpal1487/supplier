<script>
import { defineComponent } from 'vue';
import { Head } from '@inertiajs/inertia-vue3';
import AppLayout from '@/Layouts/AppLayout.vue'
import PermissionForm from './Components/PermissionForm.vue';
import Pagination from "../../Jetstream/Pagination.vue";
import utils from '../../utils';
export default defineComponent({
    props: ['permissions'],
    data() {
        return {
            isEdit: false,
            permission: [],
            showModal: false,
            tbody: [
                "Name",
                "Created Date",
                "Action",
            ],
            q: '',

        }
    },
    components: {
        Head,
        AppLayout,
        PermissionForm,
        Pagination
    },
    methods: {
        toggleModal(value, permission) {
            if (value, permission) {
                this.isEdit = true;
                this.showModal = true;
                this.permission = permission;
            }
            else if (value) {
                this.showModal = true;
            }
            else {
                this.showModal = false;
            }
        },
        async confirmDelete(id, index) {
            this.isLoading = true;
            await utils.deleteIndexDialog(route('industry.destroy', id), this.permissions.data, index);
            this.isLoading = false;
        },
    }
});
</script>

<template>
    <Head />
    <AppLayout>
        <PermissionForm v-if="showModal" :show="showModal" :isEdit="isEdit" @hidemodal="toggleModal(false)"
            :permission="permission" />
        <div class="card card-flush">
            <div class="card-header mt-6">
                <div class="card-title">
                    <div>
                        <form class="d-flex align-items-center position-relative my-1 gap-4" @submit.prevent="search()">
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
                                <input type="text" v-model="q" class="form-control form-control-solid w-250px ps-14"
                                    placeholder="Search " />
                            </div>
                            <button type="submit" class="btn btn-primary">
                                Search
                            </button>
                        </form>
                    </div>
                </div>
                <div class="card-toolbar">
                    <button type="button" class="btn btn-light-primary" @click=toggleModal(true)>
                        <span class="svg-icon svg-icon-3">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <rect opacity="0.3" x="2" y="2" width="20" height="20" rx="5" fill="currentColor" />
                                <rect x="10.8891" y="17.8033" width="12" height="2" rx="1"
                                    transform="rotate(-90 10.8891 17.8033)" fill="currentColor" />
                                <rect x="6.01041" y="10.9247" width="12" height="2" rx="1" fill="currentColor" />
                            </svg>
                        </span>
                        Add Permission</button>
                </div>
            </div>
            <div class="card-body pt-0">
                <table class="table align-middle table-row-dashed fs-6 gy-5 mb-0" id="kt_permissions_table">
                    <thead>
                        <tr class="text-gray-700 text-center fw-bold fs-7 min-w-100px text-uppercase">
                            <th class="min-w-100px" v-for="(th, index) in tbody" :key="index">
                                {{ th }}
                            </th>
                        </tr>
                    </thead>
                    <tbody class="fw-semibold text-gray-500">
                        <tr class="text-center" v-for="(permission, index) in permissions?.data" :key="index">
                            <td>{{ permission.name }}</td>
                            <td>{{ permission.created_at }}</td>
                            <td>
                                <button class="btn btn-icon btn-active-light-primary w-30px h-30px me-3"
                                    @click="toggleModal(true, permission)">
                                    <span class="svg-icon svg-icon-3">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M17.5 11H6.5C4 11 2 9 2 6.5C2 4 4 2 6.5 2H17.5C20 2 22 4 22 6.5C22 9 20 11 17.5 11ZM15 6.5C15 7.9 16.1 9 17.5 9C18.9 9 20 7.9 20 6.5C20 5.1 18.9 4 17.5 4C16.1 4 15 5.1 15 6.5Z"
                                                fill="currentColor" />
                                            <path opacity="0.3"
                                                d="M17.5 22H6.5C4 22 2 20 2 17.5C2 15 4 13 6.5 13H17.5C20 13 22 15 22 17.5C22 20 20 22 17.5 22ZM4 17.5C4 18.9 5.1 20 6.5 20C7.9 20 9 18.9 9 17.5C9 16.1 7.9 15 6.5 15C5.1 15 4 16.1 4 17.5Z"
                                                fill="currentColor" />
                                        </svg>
                                    </span>
                                </button>
                                <button class="btn btn-icon btn-active-light-primary w-30px h-30px" @click="confirmDelete(
                                    permission.id, index
                                )
                                    ">
                                    <span class="svg-icon svg-icon-3">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M5 9C5 8.44772 5.44772 8 6 8H18C18.5523 8 19 8.44772 19 9V18C19 19.6569 17.6569 21 16 21H8C6.34315 21 5 19.6569 5 18V9Z"
                                                fill="currentColor" />
                                            <path opacity="0.5"
                                                d="M5 5C5 4.44772 5.44772 4 6 4H18C18.5523 4 19 4.44772 19 5V5C19 5.55228 18.5523 6 18 6H6C5.44772 6 5 5.55228 5 5V5Z"
                                                fill="currentColor" />
                                            <path opacity="0.5"
                                                d="M9 4C9 3.44772 9.44772 3 10 3H14C14.5523 3 15 3.44772 15 4V4H9V4Z"
                                                fill="currentColor" />
                                        </svg>
                                    </span>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="d-flex align-items-center justify-content-center justify-content-md-end" v-if="permissions.meta">
                <Pagination :links="permissions.meta.links" />
            </div>
        </div>
    </AppLayout>
</template>
