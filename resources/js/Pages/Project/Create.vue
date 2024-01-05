<script>
import { defineComponent, ref } from "vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import { Head, Link } from "@inertiajs/inertia-vue3";
import AppToolbar from "../../Layouts/AppToolbar.vue";
// import RadioType from "./Components/QuestionTypes/RadioType.vue"
import Multiselect from "@vueform/multiselect";
import InputError from "@/jetstream/InputError.vue";
import JetValidationErrors from "@/Jetstream/ValidationErrors.vue";
import JetInput from "@/Jetstream/Input.vue";
import JetLabel from "@/Jetstream/Label.vue";
import useVuelidate from "@vuelidate/core";
import { required, numeric, url } from "@vuelidate/validators";
import VueDatePicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css'
import { toast } from "vue3-toastify";
import axios from "axios";
export default defineComponent({
    props: ["clients", "countries", 'status'],

    setup() {
        return { v$: useVuelidate() };
    },
    components: {
        AppLayout,
        AppToolbar,
        Link,
        Head,
        Multiselect,
        JetInput,
        JetLabel,
        JetValidationErrors,
        InputError,
        VueDatePicker,
    },
    validations() {
        return {
            form: {
                project_name: {
                    required,
                },
                client: {
                    required,
                },
                project_cpi: {
                    required,
                    numeric,
                },
                project_length: {
                    required,
                    numeric,
                },
                project_ir: {
                    required,
                    numeric,
                },
                start_date: {
                    required,
                },
                end_date: {
                    required,
                },
                sample_size: {
                    required,
                    numeric,
                },
                project_link: {
                    required, url
                },
                project_country: {
                },
                project_status: {
                    required,
                },
                device_type: {
                    required,
                },
                project_type: {
                    required,
                },
            },
        };
    },
    data() {
        return {
            processing: false,
            isLoading: false,
            isFullPage: true,
            form: this.$inertia.form({
                project_name: '',
                client: '',
                project_cpi: "",
                project_length: "",
                project_ir: "",
                start_date: new Date(),
                end_date: '',
                sample_size: "",
                project_link: "",
                project_country: '',
                project_state: '',
                project_city: '',
                project_zipcode: '',
                project_status: 'live',
                target: '',
                device_type: [],
                project_type: 'single',
                add_more: '',
            }),
            devices: [
                {
                    label: "Desktop/Laptop",
                    value: "desktop",
                },
                {
                    label: "Mobile",
                    value: "mobile",
                },
                {
                    label: "Tablet",
                    value: "tablet",
                },
            ],
            title: 'Project Create',
            state: 0,
            states: [],
            city: 0,
            cities: [],
        };
    },
    methods: {

        submit() {
            this.v$.$touch();
            this.processing = true;
            if (!this.v$.form.$invalid) {
                this.form
                    .transform((data) => ({
                        ...data,
                    }))
                    .post(route().current() == 'project.create' ? this.route('project.store') : this.route('project.update', this.project.id), {
                        onSuccess: (data) => {
                            toast.success(this.$page.props.jetstream.flash.message);
                            this.processing = false
                        },
                        onError: (data) => {
                            if (data.message) {
                                toast.error(data.message)
                            }
                            else {
                                // console.log(data)
                            }
                        },
                    });
            }
        },
        getSegment(numberSegment) {
            let path = window.location.pathname;
            let segments = path.split("/");
            return segments[numberSegment];
        },
        getStates(id) {
            axios.get('/project/state', {
                params: {
                    country_id: id
                }
            }).then((response) => {
                if (response.data?.data?.length > 0) {
                    this.states = response.data;
                }
                else {
                    this.states = []
                }
            });
        },
        getCity(id) {
            axios.get('/project/city', {
                params: {
                    state_id: id
                }
            }).then((response) => {
                if (response.data?.data?.length > 0) {
                    this.cities = response.data;
                }
                else {
                    this.cities = []
                }

            });
        }

    },
    created() {
    },
});
</script>
<template>
    <Head title="Add New Project" />
    <app-layout :title="title">
        <template #breadcrumb>
            <li class="breadcrumb-item">
                <span class="bullet bg-gray-400 w-5px h-2px"></span>
            </li>
            <li class="breadcrumb-item text-muted">
                <a href="/projects" class="text-muted text-hover-primary">Projects</a>
            </li>
            <li class="breadcrumb-item">
                <span class="bullet bg-gray-400 w-5px h-2px"></span>
            </li>
            <li class="breadcrumb-item text-muted">
                {{ title }}
            </li>
        </template>
        <JetValidationErrors />
        <form @submit.prevent="submit" autocomplete="off" class="row">
            <div class="col-12 col-md-4 col-lg-4">
                <div class="card mb-5 gap-5">
                    <div class="card-header">
                        <div class="card-title">
                            <h2>Status</h2>
                        </div>
                    </div>
                    <div class="card-body pt-0">
                        <div class="fv-row mb-2">
                            <Multiselect id="project-status" :can-clear="false" :options="status.data" label="label"
                                valueProp="value" class="form-control form-control-solid" placeholder="Select status"
                                :class="v$.form.project_status.$errors.length > 0
                                    ? 'is-invalid'
                                    : ''
                                    " v-model="v$.form.project_status.$model" />
                            <div v-for="(error, index) of v$.form.project_status
                                .$errors" :key="index">
                                <input-error :message="error.$message" />
                            </div>
                        </div>
                        <div class="text-muted fs-7">Set the project status.</div>
                    </div>
                </div>
                <div class="card mb-5 gap-5">
                    <div class="card-header">
                        <div class="card-title">
                            <h2>Device Type</h2>
                        </div>
                    </div>
                    <div class="card-body pt-0">
                        <div class="fv-row mb-2">
                            <Multiselect id="project-status" :can-clear="false" :options="devices" label="label"
                                valueProp="value" class="form-control form-control-solid" placeholder="Select status"
                                mode="tags" :close-on-select="false" :create-option="true" :class="v$.form.device_type.$errors.length > 0
                                    ? 'is-invalid'
                                    : ''
                                    " v-model="v$.form.device_type.$model" />
                            <div v-for="(error, index) of v$.form.device_type
                                .$errors" :key="index">
                                <input-error :message="error.$message" />
                            </div>
                        </div>
                        <div class="text-muted fs-7">
                            Set the project device type.
                        </div>
                    </div>
                </div>

                <div class="card mb-5 gap-5">
                    <div class="card-header">
                        <div class="card-title">
                            <h2>Project Link Type</h2>
                        </div>
                    </div>
                    <div class="card-body pt-0">
                        <div class="fv-row mb-2">
                            <Multiselect :can-clear="false" id="project-status" :options="[
                                {
                                    label: 'Single Link',
                                    value: 'single',
                                },
                                {
                                    label: 'Multi Link',
                                    value: 'multi',
                                },
                            ]" label="label" valueProp="value" class="form-control form-control-solid"
                                placeholder="Select status" :class="v$.form.project_type.$errors.length > 0
                                    ? 'is-invalid'
                                    : ''
                                    " v-model="v$.form.project_type.$model" />
                            <div v-for="(error, index) of v$.form.project_type
                                .$errors" :key="index">
                                <input-error :message="error.$message" />
                            </div>
                        </div>
                        <div class="text-muted fs-7">
                            Set the project link type.
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-8 col-lg-8">
                <div class="card mb-5">
                    <div class="card-header">
                        <div class="card-title">
                            <h2>General</h2>
                        </div>
                    </div>
                    <div class="card-body pt-2">
                        <div class="row mb-3">
                            <div class="col-12">

                                <jet-label for="project-name" value="Project Name" />
                                <jet-input id="project-name" type="text" placeholder="Enter project Name / ID"
                                    v-model="v$.form.project_name.$model" :class="v$.form.project_name.$errors.length > 0
                                        ? 'is-invalid'
                                        : ''
                                        " />
                                <div v-for="(error, index) of v$.form.project_name
                                    .$errors" :key="index">
                                    <input-error :message="error.$message" />
                                </div>
                            </div>

                        </div>
                        <div class="row mb-3">

                            <div class="col-md-6 col-sm-12">
                                <jet-label for="project-client" value="Project Client" />
                                <Multiselect :can-clear="false" id="project-client" :options="clients.data"
                                    label="display_name" valueProp="id" class="form-control form-control-solid"
                                    placeholder="Select client" :searchable="true" :class="v$.form.client.$errors.length > 0
                                        ? 'is-invalid'
                                        : ''
                                        " v-model="form.client" />
                                <div v-for="(error, index) of v$.form.client
                                    .$errors" :key="index">
                                    <input-error :message="error.$message" />
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <jet-label for="project-country" value="Project Country" />
                                <Multiselect :can-clear="false" @change='getStates' :options="countries.data" label="label"
                                    valueProp="id" class="form-control form-control-solid" placeholder="Select country"
                                    :searchable="true" v-model="form.project_country" />
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6 col-sm-12">
                                <jet-label for="project-state" value="Project State" />
                                <Multiselect :can-clear="false" @change='getCity' id="project-state" :options="states.data"
                                    label="name" valueProp="id" class="form-control form-control-solid"
                                    placeholder="Select state" :searchable="true" v-model="form.project_state"
                                    :disabled="!form.project_country" />

                            </div>
                            <div class="col-md-6 col-sm-12">
                                <jet-label for="project-city" value="Project city" />
                                <Multiselect :can-clear="false" :options="cities.data" label="name" valueProp="id"
                                    class="form-control form-control-solid" placeholder="Select city" :searchable="true"
                                    v-model="form.project_city" :disabled="!form.project_state" />
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-12">
                                <jet-label for="project-zipcode" value="Project zipcode" />
                                <textarea id="project-zipcode" class="form-control form-control-solid" type="text"
                                    placeholder="Project zipcode .." v-model="form.project_zipcode" />
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6 col-sm-12">
                                <jet-label for="project-start" value="Project start date" />
                                <VueDatePicker v-model="v$.form.start_date.$model" :enable-time-picker="false"
                                    :clearable="false" auto-apply
                                    input-class-name="form-control form-control-lg form-control-solid fw-normal" :class="v$.form.start_date.$errors.length > 0
                                        ? 'is-invalid'
                                        : ''
                                        " placeholder="Project start date"></VueDatePicker>

                                <div v-for="(error, index) of v$.form.start_date
                                    .$errors" :key="index">
                                    <input-error :message="error.$message" />
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <jet-label for="project-end" value="Project end date" />
                                <VueDatePicker v-model="v$.form.end_date.$model" :enable-time-picker="false"
                                    :clearable="false" auto-apply
                                    input-class-name="form-control form-control-lg form-control-solid fw-normal" :class="v$.form.end_date.$errors.length > 0
                                        ? 'is-invalid'
                                        : ''
                                        " placeholder="Project end date"></VueDatePicker>
                                <div v-for="(error, index) of v$.form.end_date
                                    .$errors" :key="index">
                                    <input-error :message="error.$message" />
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <jet-label for="project-target" value="Project Target" />
                                <textarea rows="5" class="form-control form-control-solid" v-model="form.target"
                                    id="project-target" placeholder="Type important message here..."></textarea>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="card mb-5">
                    <div class="card-header">
                        <div class="card-title">
                            <h2>Pricing</h2>
                        </div>
                    </div>
                    <div class="card-body pt-2">
                        <div class="row mb-3">
                            <div class="col-12">
                                <jet-label for="project-link" value="Project Link" />
                                <jet-input id="project-link" type="text"
                                    placeholder="https://www.example.com?id=RespondentID"
                                    v-model="v$.form.project_link.$model" :class="v$.form.project_link.$errors.length > 0
                                        ? 'is-invalid'
                                        : ''
                                        " />
                                <div v-for="(error, index) of v$.form
                                    .project_link.$errors" :key="index">
                                    <input-error :message="error.$message" />
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6 col-sm-12">
                                <jet-label for="project-cpi" value="Project CPC/CPI" />
                                <jet-input id="project-cpi" step="0.01" type="number" placeholder="Enter project CPI/CPC"
                                    v-model="v$.form.project_cpi.$model" :class="v$.form.project_cpi.$errors.length > 0
                                        ? 'is-invalid'
                                        : ''
                                        " />
                                <div v-for="(error, index) of v$.form.project_cpi
                                    .$errors" :key="index">
                                    <input-error :message="error.$message" />
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <jet-label for="sample-size" value="Sample Size" />
                                <jet-input id="sample-size" type="number" placeholder="Enter sample size"
                                    v-model="v$.form.sample_size.$model" :class="v$.form.sample_size.$errors.length > 0
                                        ? 'is-invalid'
                                        : ''
                                        " />
                                <div v-for="(error, index) of v$.form.sample_size
                                    .$errors" :key="index">
                                    <input-error :message="error.$message" />
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6 col-sm-12">
                                <jet-label for="project-loi" value="Project Length (LOI)" />
                                <jet-input id="project-loi" type="number" placeholder="Enter project length (LOI)"
                                    v-model="v$.form.project_length.$model" :class="v$.form.project_length.$errors.length >
                                        0
                                        ? 'is-invalid'
                                        : ''
                                        " />
                                <div v-for="(error, index) of v$.form
                                    .project_length.$errors" :key="index">
                                    <input-error :message="error.$message" />
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <jet-label for="project-ir" value="Incedance Rate (IR)" />
                                <jet-input id="project-ir" type="number" placeholder="Enter incedance rate (IR)"
                                    v-model="v$.form.project_ir.$model" :class="v$.form.project_ir.$errors.length > 0
                                        ? 'is-invalid'
                                        : ''
                                        " />
                                <div v-for="(error, index) of v$.form.project_ir
                                    .$errors" :key="index">
                                    <input-error :message="error.$message" />
                                </div>
                            </div>
                        </div>
                        <div class="fv-row col-12 mt-5">
                            <div class="form-check">
                                <input class="form-check-input" v-model="form.add_more" type="checkbox" value=""
                                    id="addMore" />
                                <label class="form-check-label" for="addMore">
                                    Add More Project
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="d-flex justify-content-end">
                    <Link href="/projects" class="btn btn-secondary me-5">
                    Discard
                    </Link>
                    <button type="submit" class="btn btn-primary" :class="{ 'text-white-50': form.processing }">
                        <div v-show="form.processing" class="spinner-border spinner-border-sm">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        Save
                    </button>
                </div>
            </div>
        </form>
    </app-layout>
</template>
