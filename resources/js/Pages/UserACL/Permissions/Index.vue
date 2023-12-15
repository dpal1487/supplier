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
				"ASSIGNED TO",
				"CREATED DATE",
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
					<table class="table align-middle table-row-dashed fs-6 gy-5 text-center">
						<thead>
							<tr class="text-gray-400 fw-bold fs-7 text-uppercase ">
								<th v-for="(th, index) in tbody" :key="index">
									{{ th }}
								</th>
							</tr>
						</thead>
						<tbody class="fw-semibold text-gray-600">
							<tr v-for="(permission, index) in permissions.data" :key="index">
								<td>{{ permission.name }}</td>
								<td>{{ permission }}</td>
								<td>{{ permission.created_at }}</td>
								<td class="text-end">
									<button class="btn btn-icon btn-active-light-primary w-30px h-30px me-3"
										@click="toggleModal(true, permission.id)">
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
									<button class="btn btn-icon btn-active-light-primary w-30px h-30px"
										@click="confirmDelete(permission.id, index)">
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