<script>
import { defineComponent } from "vue";
import { Link } from "@inertiajs/inertia-vue3";
import Loading from "vue-loading-overlay";
import "vue-loading-overlay/dist/css/index.css";
import ProjectLinkListItem from "./ProjectLinkListItem.vue";
import SupplierListModel from "./Modal/SupplierListModel.vue";
import CopyLinkButton from "../../../Components/CopyLinkButton.vue";
import ProjectLinkForm from "../../Project/Components/Model/ProjectLinkForm.vue";
import utils from "../../../utils";
export default defineComponent({

    props: ["links", "countries", "project"],
    data() {
        return {
            isLoading: false,
            isFullPage: true,
            isModalOpen: false,
            isFormModalOpen: false,
            activeId: null,
            projectId: null,
            pageName: null
        };
    },
    components: {
        Link,
        Loading,
        SupplierListModel,
        CopyLinkButton,
        ProjectLinkListItem,
        ProjectLinkForm
    },
    methods: {
        async confirmDelete(index) {
            await utils.deleteIndexDialog(
                route("mapping.destroy", this.links[index].id),
                this.links,
                index
            );
        },
        showSupplierListModal(id) {
            this.isModalOpen = true;
            this.activeId = id;
        },
        hideSupplierListModal() {
            this.isModalOpen = false;
        },

        showProjectLinkForm(value) {
            this.isFormModalOpen = true;
            this.projectId = value.id;
            this.pageName = value.pageName;
        },
        hideProjectLinkForm() {
            this.isFormModalOpen = false;
        },


    },
    created() { },
});
</script>
<template>
    <loading :active="isLoading" :can-cancel="true" :is-full-page="isFullPage"></loading>
    <SupplierListModel :show="isModalOpen" @hidemodal="hideSupplierListModal" :id="activeId" />
    <ProjectLinkForm :show="isFormModalOpen" @hidemodal="hideProjectLinkForm" :id="projectId" :countries="countries"
        :pageName="pageName" />
    <div class="card mb-5" v-for="(project_link, index) in links" :key="index">
        <ProjectLinkListItem :index="index" :project_link="project_link" @onSupplier="showSupplierListModal"
            @editProjectLink="showProjectLinkForm" @onDelete="confirmDelete" />
    </div>
</template>
