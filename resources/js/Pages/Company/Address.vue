<script>
import { defineComponent } from "vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import Header from "./Components/Header.vue";
import { Head, Link } from "@inertiajs/inertia-vue3";
import { toast } from "vue3-toastify";
import JetInput from "@/Jetstream/Input.vue";
import JetLabel from "@/Jetstream/Label.vue";
import InputError from "@/jetstream/InputError.vue";
import useVuelidate from "@vuelidate/core";
import { required } from "@vuelidate/validators";
import Multiselect from "@vueform/multiselect";
import JetValidationErrors from "@/Jetstream/ValidationErrors.vue";

export default defineComponent({
    setup() {
        return { v$: useVuelidate() };
    },
    props: ['company', 'address', 'countries'],
    components: {
        AppLayout,
        Header,
        Link,
        Head,
        JetInput,
        JetLabel,
        InputError,
        Multiselect,
        JetValidationErrors
    },
    validations() {
        return {
            form: {
                address: {
                    required,
                },

                city: {
                    required,
                },
                state: {
                    required,
                },
                pincode: {
                    required,
                },
                country: {
                    required,
                },
            },
        };
    },
    data() {
        return {
            processing: false,
            form: this.$inertia.form({
                id: this.address?.data?.id || '',
                company_id: this.company?.data?.id || '',
                address: this.address?.data?.address || '',
                city: this.address?.data?.city || '',
                state: this.address?.data?.state || '',
                pincode: this.address?.data?.pincode || '',
                country: this.address?.data?.country?.id || '',
            }),
            isEdit: false,
            title: "Company Address",
            states: [],
            cities: [],
        };
    },
    methods: {
        submit() {
            this.v$.$touch();
            if (!this.v$.form.$invalid) {
                this.form.transform((data) => ({
                    ...data,
                }))
                    .post(this.route("company.address"),
                        {
                            onSuccess: (data) => {
                                toast.success(this.$page.props.jetstream.flash.message);
                                this.isEdit = false;
                            },
                            onError: (data) => {
                                console.log(data);
                            },
                        });
            }
        },
        changeStatus() {

        }
    },
    created() {
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
                <Link href="/company" class="text-muted text-hover-primary">Compant</Link>
            </li>
            <li class="breadcrumb-item">
                <span class="bullet bg-gray-400 w-5px h-2px"></span>
            </li>
            <li class="breadcrumb-item text-muted">
                {{ company.data.company_name }}
            </li>
        </template>
        <Header :company="company?.data" :address="address?.data" />
        <div class="card mb-5 mb-xl-10">
            <div class="card-header cursor-pointer">
                <div class="card-title m-0">
                    <h3 class="fw-bold m-0">Company Address </h3>
                </div>
                <button class="btn btn-primary align-self-center btn-sm"
                    @click="this.isEdit = this.isEdit ? false : true"><i class="bi bi-pencil me-2"></i>Edit Address
                </button>
            </div>
            <div class="card-body" v-if="isEdit">
                <div class="row">
                    <div class="col-12">
                        <JetValidationErrors />
                        <form @submit.prevent="submit">
                            <div class="row mb-6">
                                <label for="address" class="col-lg-4 col-form-label required fw-bold fs-6">Address
                                </label>
                                <div class="col-lg-8">
                                    <jet-input id="address" type="text" v-model="v$.form.address.$model" :class="v$.form.address.$errors.length > 0
                                        ? 'is-invalid'
                                        : ''
                                        " placeholder="Address" />
                                    <div v-for="(error, index) of v$.form.address.$errors" :key="index">
                                        <input-error :message="error.$message" />
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-6">
                                <label for="city" class="col-lg-4 col-form-label required fw-bold fs-6">City
                                </label>
                                <div class="col-lg-8">
                                    <jet-input id="city" type="text" v-model="v$.form.city.$model" :class="v$.form.city.$errors.length > 0
                                        ? 'is-invalid'
                                        : ''
                                        " placeholder="City" />
                                    <div v-for="(error, index) of v$.form.city.$errors" :key="index">
                                        <input-error :message="error.$message" />
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-6">
                                <label for="state" class="col-lg-4 col-form-label required fw-bold fs-6">State</label>
                                <div class="col-lg-8">
                                    <jet-input id="state" type="text" v-model="v$.form.state.$model" :class="v$.form.state.$errors.length > 0
                                        ? 'is-invalid'
                                        : ''
                                        " placeholder="State" />
                                    <div v-for="(error, index) of v$.form.state.$errors" :key="index">
                                        <input-error :message="error.$message" />
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-6">
                                <label class="col-lg-4 col-form-label fw-bold fs-6">
                                    <span class="required">Country</span>
                                </label>
                                <div class="col-lg-8 fv-row">
                                    <Multiselect :can-clear="false" :options="countries.data" label="label" valueProp="id"
                                        class="form-control form-control-lg form-control-solid" placeholder="Select One"
                                        v-model="v$.form.country.$model" track-by="label" :searchable="true" :class="v$.form.country.$errors.length > 0
                                            ? 'is-invalid'
                                            : ''
                                            " />
                                    <div v-for="(error, index) of v$.form.country.$errors" :key="index">
                                        <input-error :message="error.$message" />
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-6">
                                <label class="col-lg-4 col-form-label fw-bold fs-6">Pincode</label>
                                <div class="col-lg-8">
                                    <jet-input id="pincode" type="text" v-model="v$.form.pincode.$model" :class="v$.form.pincode.$errors.length > 0
                                        ? 'is-invalid'
                                        : ''
                                        " placeholder="Pincode" />
                                    <div v-for="(error, index) of v$.form.pincode.$errors" :key="index">
                                        <input-error :message="error.$message" />
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex justify-content-end mt-4">
                                <button type="button" class="btn btn-outline-secondary me-5"
                                    @click="this.isEdit = false">Discard</button>
                                <button type="submit" class="btn btn-primary" :class="{ 'text-white-50': form.processing }">
                                    <div v-show="form.processing" class="spinner-border spinner-border-sm">
                                        <span class="visually-hidden">Loading...</span>
                                    </div>
                                    Save Changes
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="card-body" v-else>
                <div class="row mb-7">
                    <label class="col-6 fw-bold fs-5 text-gray-800">Address</label>
                    <div class="col-lg-6">
                        <span class="fw-bold fs-6 text-gray-700"> {{ address?.data?.address }}</span>
                    </div>
                </div>

                <div class="row mb-7">
                    <label class="col-6 fw-bold fs-5 text-gray-800">City</label>
                    <div class="col-lg-6 fv-row">
                        <span class="fw-bold text-gray-700 fs-6">{{ address?.data?.city }}
                        </span>
                    </div>
                </div>
                <div class="row mb-7">
                    <label class="col-6 fw-bold fs-5 text-gray-800">State</label>
                    <div class="col-lg-6 d-flex align-items-center">
                        <span class="fw-bold fs-6 text-gray-700 me-2">{{ address?.data?.state }}
                        </span>
                    </div>
                </div>
                <div class="row mb-7">
                    <label class="col-6 fw-bold fs-5 text-gray-800">Pincode</label>
                    <div class="col-lg-6 d-flex align-items-center">
                        <span class="fw-bold fs-6 text-gray-700">{{ address?.data?.pincode }}
                        </span>
                    </div>
                </div>
                <div class="row mb-7">
                    <label class="col-6 fw-bold fs-5 text-gray-800">Country</label>
                    <div class="col-lg-6">
                        <span class="fw-bold fs-6 text-gray-700">{{ address?.data?.country?.name }}</span>
                    </div>
                </div>
            </div>
        </div>
    </app-layout>
</template>
