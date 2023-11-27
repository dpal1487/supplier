<script>
import { defineComponent } from "vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import { Head, Link } from "@inertiajs/inertia-vue3";
import Multiselect from "@vueform/multiselect";
import AddressForm from "./Components/AddressForm.vue";
import Header from "./Components/Header.vue";
import { toast } from "vue3-toastify";
import Swal from "sweetalert2";
export default defineComponent({
    props: ["client", "address", "countries"],
    components: {
        AppLayout,
        Link,
        Head,
        Multiselect,
        AddressForm,
        Header,
    },
    data() {
        return {
            isEdit: false,
            isAdd: false,
            form: {
                processing: false,
            },
            title: "Client Address",
        };
    },
    methods: {
        submit(form) {
            this.form = form;
            this.form
                .transform((data) => ({
                    ...data,
                }))
                .post(
                   this.route(
                              "client.updateAddress",
                              this.client.data.id
                          ),
                    {
                        onSuccess: (data) => {
                            toast.success(
                                this.$page.props.jetstream.flash.message
                            );
                            this.isEdit = false;
                            this.isAdd = false;
                        },
                        onError: (data) => {
                            console.log(data);
                        },
                    }
                );
        },
        toggleModal(isEdit, address) {
            this.isEdit = isEdit;
            this.form = address;
        },
        confirmDelete(index) {
            Swal.fire({
                title: "Are you sure you want to delete ?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#dc3545",
                cancelButtonColor: "#6c757d",
                confirmButtonText: "Yes, delete it!",
            }).then((result) => {
                if (result.isConfirmed) {
                    axios
                        .delete(
                            this.route(
                                "client.delAddress",
                                this.addresses.data[index].id
                            )
                        )
                        .then((response) => {
                            toast.success(response.data.message);
                            if (response.data.success) {
                                this.addresses.data.splice(index, 1);
                                return;
                            }
                        })

                        .catch((error) => {
                            if (error.response.status == 400) {
                                toast.error(error.response.data.message);
                            }
                        });
                } else if (result.dismiss === "cancel") {
                    Swal.fire({
                        text: " was not deleted.",
                        icon: "error",
                        buttonsStyling: false,
                        confirmButtonText: "Ok, got it!",
                        customClass: {
                            confirmButton: "btn fw-bold btn-primary",
                        },
                    });
                }
            });
        },
    },
    created() {},
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
                <Link href="/clients" class="text-muted text-hover-primary"
                    >Clients</Link
                >
            </li>
            <li class="breadcrumb-item">
                <span class="bullet bg-gray-400 w-5px h-2px"></span>
            </li>
            <li class="breadcrumb-item text-muted">
                {{ client.data.name }}
            </li>
        </template>
        <Header :client="client.data" :address="address.data" />
        <div class="card">
            <div class="card-header">
                <!--begin::Title-->
                <!--begin::Card title-->
                <div class="card-title m-0">
                    <h3 class="fw-bold m-0">Manage Address</h3>
                </div>
                <!--end::Card title-->
                <button
                    class="btn btn-primary btn-sm align-self-center"
                    v-if="!isEdit"
                    @click="(this.isAdd = true), (this.form = {})"
                >
                    <i class="bi bi-plus-circle"></i>Add New Address
                </button>
                <!--end::Title-->
            </div>
            <div class="card-body">
                <!--begin::Form-->
                <div class="row">
                    <div class="col-6">
                        <address-form
                            @submitted="submit"
                            :countries="countries.data"
                            :address="address.data"
                            :client="client.data"
                        >
                            <template #action>
                                <div class="d-flex justify-content-end">
                                    <button
                                        type="submit"
                                        class="btn btn-primary"
                                        :class="{
                                            'text-white-50': form.processing,
                                        }"
                                    >
                                        <div
                                            v-show="form.processing"
                                            class="spinner-border spinner-border-sm"
                                        >
                                            <span class="visually-hidden"
                                                >Loading...</span
                                            >
                                        </div>
                                        Save Changes
                                    </button>
                                </div>
                            </template>
                        </address-form>
                    </div>
                </div>
            </div>
        </div>
    </app-layout>
</template>
