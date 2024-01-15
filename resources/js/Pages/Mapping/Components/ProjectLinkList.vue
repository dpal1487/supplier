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
    <div class="card mb-5" v-if="links?.length > 0" v-for="(project_link, index) in links" :key="index">
        <ProjectLinkListItem :index="index" :project_link="project_link" @onSupplier="showSupplierListModal"
            @editProjectLink="showProjectLinkForm" @onDelete="confirmDelete" />
    </div>
    <div class="d-flex justify-content-center align-content-center" v-else>
        <div class="text-center py-10">
            <img src="/assets/images/emptyrespondent.png" style="height: 100px" />
            <div class="fw-bold fs-2 text-gray-900 mt-5">
                No Project Link Found!
            </div>
        </div>
    </div>
</template>
