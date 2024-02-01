
<script>
import { defineComponent } from "vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import { Head, Link } from "@inertiajs/inertia-vue3";
import ProjectLinkList from "../Mapping/Components/ProjectLinkList.vue";
import TopCard from "./Components/TopCard.vue";
import Pagination from "../../Jetstream/Pagination.vue";
import Loading from "vue-loading-overlay";
import "vue-loading-overlay/dist/css/index.css";
import { Inertia } from "@inertiajs/inertia";
import ProjectLinkForm from "./Components/Model/ProjectLinkForm.vue";
import Multiselect from "@vueform/multiselect";
export default defineComponent({
    props: [
        "project",
        "project_links",
        "clients",
        "status",
        "suppliers",
        "countries",
    ],
    data() {
        return {
            title: "Project Overview",
            isLoading: false,
            isFullPage: true,
            isModalOpen: false,
            activeId: null,
            form: {},
        };
    },
    components: {
        AppLayout,
        Link,
        Head,
        ProjectLinkList,
        TopCard,
        Pagination,
        Loading,
        ProjectLinkForm,
        Multiselect,
    },
    methods: {
        search() {
            this.isLoading = true;
            Inertia.get(`/project/${this.project.data.id}`, this.form, {
                onFinish(response) {
                    this.isLoading = false;
                },
            });
        },
        showSupplierListModal(id) {
            this.isModalOpen = true;
            this.activeId = id;
        },
        hideSupplierListModal() {
            this.isModalOpen = false;
        },
    },
    created() {
        var url = new URL(window.location.href);
        this.form.q = url.searchParams.get("q");
        this.form.status = url.searchParams.get("status");
    },
});
</script>
<template>
    <Head :title="title" />
    <app-layout :title="title">
        <loading v-model:active="isLoading" :can-cancel="false" :is-full-page="isFullPage" />
        <template #breadcrumb>
            <li class="breadcrumb-item">
                <span class="bullet bg-gray-400 w-5px h-2px"></span>
            </li>
            <li class="breadcrumb-item text-muted">
                <Link class="text-muted text-hover-primary" href="/projects">Projects</Link>
            </li>
            <li class="breadcrumb-item">
                <span class="bullet bg-gray-400 w-5px h-2px"></span>
            </li>
            <li class="breadcrumb-item text-muted">{{ title }}</li>
        </template>
        <template #toolbar v-if="$page.props.user.role.role.slug != 'user'">
            <div class="d-flex align-items-center gap-2 gap-lg-3">
                <Link href="/project/create" class="btn btn-sm fw-bold btn-primary">
                <i class="bi bi-plus-circle"></i>Add New Project</Link>
            </div>
        </template>
        <TopCard :project="project.data" :clients="clients.data" :status="status" />
        <ProjectLinkForm :show="isModalOpen" @hidemodal="hideSupplierListModal" :project="project?.data"
            :countries="countries?.data" />
        <div class="card card-flush mb-5">
            <div class="card-header p-0">
                <form @submit.prevent="search" class="card-title justify-content-startp p-3 gap-2 gap-md-5">
                    <div class="w-200px">
                        <input v-model="form.q" class="form-control form-control-sm form-control-solid" type="text"
                            placeholder="Search here..." />
                    </div>
                    <div class="w-200px">
                        <Multiselect :can-clear="false" :options="$page.props.ziggy.status" label="name" value-prop="value"
                            v-model="form.status" class="form-control form-control-solid"
                            style=" height: 35px !important;min-width: 100px;" placeholder="Select status">
                        </Multiselect>
                    </div>
                    <button class="btn btn-primary btn-sm w-100px">
                        <i class="bi bi-search"></i> Search
                    </button>
                </form>
                <div class="card-toolbar pe-3">
                    <button type="button" v-if="$page.props.user.role.role.slug != 'user'" class="btn btn-primary btn-sm"
                        @click="showSupplierListModal(project?.data?.id)">
                        <i class="bi bi-plus-circle"></i>Add New Link
                    </button>
                </div>
            </div>
        </div>
        <ProjectLinkList :links="project_links.data" :countries="countries?.data" />
    </app-layout>
</template>
