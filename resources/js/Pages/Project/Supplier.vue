
<script>
import { defineComponent } from "vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import { Head, Link } from "@inertiajs/inertia-vue3";
import SupplierList from "../Sampling/Components/SupplierList.vue";
import TopCard from "./Components/TopCard.vue";
import { Inertia } from "@inertiajs/inertia";
import Multiselect from "@vueform/multiselect";
import Loading from "vue-loading-overlay";
import 'vue-loading-overlay/dist/css/index.css';
export default defineComponent({
    props: ["project", "suppliers", "supplier_projects", 'clients', 'status'],
    data() {
        return {
            title: "Manage Suppliers",
            form: {},
            isLoading: false,
            isFullPage: true,

        };
    },
    components: {
        AppLayout,
        Link,
        Head,
        SupplierList,
        TopCard,
        Loading,
        Multiselect
    },

    methods: {
        search() {
            this.isLoading = true;
            Inertia.get(
                `/project/${this.project.data.id}/suppliers`,
                this.form,
                {
                    onFinish(response) {
                        this.isLoading = false;
                    },
                })
        }
    },
    created() {
        var url = new URL(window.location.href);
        this.form.supplier = url.searchParams.get("supplier");
        this.form.status = url.searchParams.get("status");
    },
});
</script>
<template>
    <app-layout :title="title">
        <loading v-model:active="isLoading" :can-cancel="false" :is-full-page="isFullPage" />

        <Head title="Project Suppliers" />
        <TopCard :project="project.data" :clients="clients.data" :status="status" />
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
            <li class="breadcrumb-item text-muted">
                Suppliers
            </li>
        </template>
        <div class="card card-flush mb-5">
            <div class="card-header align-items-center px-5">
                <form @submit.prevent="search" class="card-title">
                    <input v-model="form.q" class="form-control form-control-sm form-control-solid" type="text"
                        placeholder="Search here..." />
                    <Multiselect :can-clear="false" :options="$page.props.ziggy.status" label="name" value-prop="value"
                        v-model="form.status" class="multiselect__content ms-3" placeholder="Select status">
                    </Multiselect>
                    <button class="btn btn-primary btn-sm ms-3"><i class="bi bi-search"></i></button>
                </form>
            </div>
        </div>
        <SupplierList :projects="supplier_projects.data" action="project.supplier" v-if="supplier_projects.data.length" />
        <div class="d-flex justify-content-center align-content-center" v-else>
            <div class="text-center py-10">
                <img src="/assets/images/emptyrespondent.png" style="height: 100px" />
                <div class="fw-bold fs-2 text-gray-900 mt-5">
                    No Supplier Found!
                </div>
            </div>
        </div>
    </app-layout>
</template>
