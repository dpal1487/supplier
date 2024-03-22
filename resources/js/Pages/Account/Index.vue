<script>
import { defineComponent, ref } from "vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import { Head } from "@inertiajs/inertia-vue3";
import { toast } from "vue3-toastify";
import ProfileImage from "./Components/ProfileImage.vue";
import ProfileAbout from "./Components/ProfileAbout.vue";
import ContactInformation from "./Components/ContactInformation.vue";
export default defineComponent({
    props: [],

    components: {
        AppLayout,
        Head,
        ProfileImage,
        ProfileAbout,
        ContactInformation,
    },
    data() {
        return {
            processing: false,
            isLoading: false,
            isFullPage: true,
            form: this.$inertia.form({
                project_name: "",
                client: "",
                project_cpi: "",
                project_length: "",
                project_ir: "",
                start_date: new Date(),
                end_date: "",
                sample_size: "",
                project_link: "",
                project_country: "",
                project_state: [],
                project_city: [],
                project_zipcode: "",
                project_status: "live",
                target: "",
                device_type: [],
                project_type: "single",
                add_more: "",
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
            title: "Project Create",
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
                    .post(
                        route().current() == "project.create"
                            ? this.route("project.store")
                            : this.route("project.update", this.project.id),
                        {
                            onSuccess: (data) => {
                                toast.success(
                                    this.$page.props.jetstream.flash.message
                                );
                                this.processing = false;
                            },
                            onError: (data) => {
                                if (data.message) {
                                    toast.error(data.message);
                                } else {
                                    // console.log(data)
                                }
                            },
                        }
                    );
            }
        },
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
                <a href="/projects" class="text-muted text-hover-primary"
                    >Projects</a
                >
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
            <div class="col-12 col-md-3 col-lg-3">
                <ProfileImage />
                <ProfileAbout />
            </div>
            <div class="col-12 col-md-9 col-lg-9">
                <ContactInformation />
            </div>
        </form>
    </app-layout>
</template>
