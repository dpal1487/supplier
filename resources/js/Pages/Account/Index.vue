<script>
import { defineComponent, ref } from "vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import { Head } from "@inertiajs/inertia-vue3";
import { toast } from "vue3-toastify";
import ProfileImage from "./Components/ProfileImage.vue";
import ProfileAbout from "./Components/ProfileAbout.vue";
import ContactInformation from "./Components/ContactInformation.vue";
export default defineComponent({
    props: ['user', 'image', 'countries'],

    components: {
        AppLayout,
        Head,
        ProfileImage,
        ProfileAbout,
        ContactInformation,
    },
    data() {
        return {
            title: "Profile ",
        }
    },

});
</script>
<template>

    <Head :title="title" />
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
        <div class="row">
            <div class="col-12 col-md-12 col-lg-4">
                <ProfileImage :image="image.data" />
                <ProfileAbout :user="user.data" />
            </div>
            <div class="col-12 col-md-12 col-lg-8">
                <ContactInformation :supplier="user.data" :countries="countries?.data" />
            </div>
        </div>
    </app-layout>
</template>
