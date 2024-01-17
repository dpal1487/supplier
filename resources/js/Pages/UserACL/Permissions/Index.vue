<script>

import { defineComponent } from 'vue';

import AppLayout from '@/Layouts/AppLayout.vue'
import { Head, Link } from '@inertiajs/inertia-vue3';
import PermissionForm from '../Components/PermissionForm.vue';
import { Inertia } from '@inertiajs/inertia';
import Pagination from "../../../Jetstream/Pagination.vue";
import utils from "../../../utils";
export default defineComponent({
    props: ['permissions'],
    data() {
        return {
            isEdit: false,
            permission: [],
            id: '',
            showModal: false,
            title: 'Permissions',
            form: {},
            tbody: [
                "Name",
                "Description",
                "ASSIGNED TO",
                "Action",
            ],
        }
    },
    components: {
        AppLayout,
        Head,
        Link,
        PermissionForm,
        Pagination
    },
    methods: {
        toggleModal(value, id) {
            if (value, id) {
                this.isEdit = true;
                this.showModal = true;
                this.id = id;
            }
            else if (value) {
                this.showModal = true;
                this.isEdit = false;

            }
            else {
                this.showModal = false;
            }
        },
        async confirmDelete(id, index) {
            this.isLoading = true;
            await utils.deleteIndexDialog(route('permission.destroy', id), this.permissions.data, index);
            this.isLoading = false;
        },

        search() {
            Inertia.get(
                "/permissions",
                this.form,

            );
        },
    }
})
</script>

<template>
    <Head :title=title />
    <AppLayout :title="title">
        <PermissionForm v-if="showModal" :show="showModal" :isEdit="isEdit" @hidemodal="toggleModal(false)"
            :permission="permission?.data" :id="id" />
        <template #breadcrumb>
            <li class="breadcrumb-item">
                <span class="bullet bg-gray-400 w-5px h-2px"></span>
            </li>
            <li class="breadcrumb-item">
                <span class="text-muted">Permission</span>
            </li>
        </template>
        <template #toolbar>
            <div class="d-flex align-items-center gap-2 gap-lg-3">
                <button type="button" class="btn btn-sm btn-light-primary" @click="toggleModal(true)">
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
        </template>
        <div class="card card-flush">
            <div class="card-body pt-0">
                <div class="table-responsive">
                    <table class="table align-middle table-row-dashed fs-6 gy-5 text-left">
                        <thead>
                            <tr class="text-gray-600 fw-bold fs-7 text-uppercase">
                                <th v-for="(th, index) in tbody" :key="index" >
                                    {{ th }}
                                </th>
                            </tr>
                        </thead>
                        <tbody class="fw-semibold text-gray-600">
                            <tr v-for="(permission, index) in permissions.data" :key="index">
                                <td>{{ permission.name }}</td>
                                <td>{{ permission.description }}</td>
                                <td v-if="permission.role" class="text-uppercase">{{ permission.role?.map(r => r.name).join(' / ') }}</td>
                                <td v-else>non</td>
                                <td class="d-flex">
                                    <button class="btn btn-icon btn-active-light-primary w-30px h-30px mx-2"
                                        @click="toggleModal(true, permission.id)">
                                        <i class="bi bi-pencil"></i>
                                    </button>
                                    <button class="btn btn-icon btn-active-light-primary w-30px h-30px"
                                        @click="confirmDelete(permission.id, index)">
                                        <i class="bi bi-trash3"></i>
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="row mb-5 mx-5" v-if="permissions.meta">
                <div class="col-sm-12 d-flex align-items-center justify-content-between mb-5">
                    <span class="fw-bold text-gray-700">
                        Showing {{ permissions.meta.from }} to {{ permissions.meta.to }}
                        of {{ permissions.meta.total }} entries
                    </span>
                    <Pagination :links="permissions.meta.links" />
                </div>
            </div>
        </div>
    </AppLayout>
</template>
