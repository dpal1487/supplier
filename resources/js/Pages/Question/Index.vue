<script>
import { defineComponent, ref } from "vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import { Head, Link } from "@inertiajs/inertia-vue3";
import Pagination from "../../Jetstream/Pagination.vue";
import Multiselect from "@vueform/multiselect";
import { Inertia } from "@inertiajs/inertia";
import Loading from "vue-loading-overlay";
import utils from "../../utils";
import QuestionForm from "./Components/QuestionForm.vue";
import NoRecordMessage from "../../Components/NoRecordMessage.vue";
export default defineComponent({
    props: ["questions", "industries"],

    data() {
        return {
            form: {},
            title: "Question",
            isModalOpen: false,
            activeId: '',
            tbody: [
                "Industry Name",
                "Question",
                "Text",
                "Language",
                "Type",
                "Action",
            ],
        };
    },
    components: {
        AppLayout,
        Link,
        Head,
        Pagination,
        Multiselect,
        Loading,
        QuestionForm,
        NoRecordMessage
    },
    methods: {
        async confirmDelete(id, index) {
            this.isLoading = true;
            await utils.deleteIndexDialog(route('question.delete', id), this.questions.data, index);
            this.isLoading = false;
        },
        search() {
            Inertia.get("/questions", this.form);
        },

        showQuestionForm(id) {
            if (id) {
                this.isModalOpen = true;
                this.activeId = id;
            }
            this.isModalOpen = true;
        },
        hideQuestionForm() {
            this.isModalOpen = false;
        },

    },
});
</script>
<template>
    <app-layout :title="title">
        <QuestionForm :show="isModalOpen" @hidemodal="hideQuestionForm" :id="activeId" :questions="questions"
            :industries="industries" />
        <template #breadcrumb>
            <li class="breadcrumb-item">
                <span class="bullet bg-gray-400 w-5px h-2px"></span>
            </li>
            <li class="breadcrumb-item">
                <Link href="/questions" class="text-muted text-hover-primary">Questions</Link>
            </li>
        </template>
        <template #toolbar>
            <div class="d-flex align-items-center gap-2 gap-lg-3">
                <button class="btn btn-sm fw-bold btn-primary" @click="showQuestionForm()">
                    <i class="bi bi-plus-circle"></i>Add New Question
                </button>
            </div>
        </template>

        <Head title="Question" />
        <div class="card">
                <form class="card-header justify-content-start p-5 gap-3" @submit.prevent="search()">
                    <div class="d-flex align-items-center position-relative">
                        <span class="svg-icon svg-icon-1 position-absolute ms-4"><svg width="24" height="24"
                                viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2" rx="1"
                                    transform="rotate(45 17.0365 15.1223)" fill="currentColor"></rect>
                                <path
                                    d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z"
                                    fill="currentColor"></path>
                            </svg>
                        </span>
                        <input type="text" v-model="form.q" class="form-control form-control-solid w-250px ps-14"
                            placeholder="Search " />
                    </div>
                    <button type="submit" class="btn btn-primary">
                        Search
                    </button>
                </form>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table align-middle table-row-dashed fs-6 gy-5 text-left">
                        <thead>
                            <tr class="text-gray-700 fw-bold fs-7 text-uppercase">
                                <th v-for="(th, index) in tbody" :key="index">
                                    {{ th }}
                                </th>
                            </tr>
                        </thead>
                        <tbody class="fw-semibold text-gray-500" v-if="questions.data.length > 0">
                            <tr v-for="(question, index) in questions.data" :key="index">
                                <td class="w-150px">
                                    <Link :href="'/question/' + question.id"
                                        class="text-gray-800 text-hover-primary fs-5 fw-bold mb-1 text-capitalize">{{
                                            question?.industry?.name }} </Link>
                                </td>
                                <td class="w-150px">{{ question.question_key }}</td>
                                <td class="w-450px">{{ question.text }}</td>
                                <td>{{ question.language }}</td>
                                <td class="">
                                    <span class="badge text-gray-500 badge-light-secondary rounded-pill">{{
                                        question.type }}</span>
                                </td>
                                <td class="w-150px">
                                    <div class="dropdown">
                                        <a href="#" class="btn btn-sm btn-light btn-active-light-primary"
                                            :id="`dropdown-${question.id}`" data-bs-toggle="dropdown"
                                            aria-expanded="false">Actions
                                            <span class="svg-icon svg-icon-5 m-0">
                                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M11.4343 12.7344L7.25 8.55005C6.83579 8.13583 6.16421 8.13584 5.75 8.55005C5.33579 8.96426 5.33579 9.63583 5.75 10.05L11.2929 15.5929C11.6834 15.9835 12.3166 15.9835 12.7071 15.5929L18.25 10.05C18.6642 9.63584 18.6642 8.96426 18.25 8.55005C17.8358 8.13584 17.1642 8.13584 16.75 8.55005L12.5657 12.7344C12.2533 13.0468 11.7467 13.0468 11.4343 12.7344Z"
                                                        fill="currentColor"></path>
                                                </svg>
                                            </span>
                                        </a>
                                        <ul class="dropdown-menu text-small menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4"
                                            :aria-labelled:by="`dropdown-${question.id}`">
                                            <li class="menu-item px-3">
                                                <button
                                                    class="btn btn-sm dropdown-item align-items-center justify-content-center"
                                                    @click="showQuestionForm(question?.id)">
                                                    <i class="bi bi-pencil"></i>Edit
                                                </button>
                                            </li>
                                            <li class="menu-item px-3">
                                                <button @click="confirmDelete(
                                                    question.id, index
                                                )
                                                    "
                                                    class="btn btn-sm dropdown-item align-items-center justify-content-center">
                                                    <i class="bi bi-trash"></i> Delete
                                                </button>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                        <tbody class="fw-semibold text-gray-600" v-else>
                            <tr class="text-gray-600 fw-bold fs-7 align-middle text-uppercase h-100px">
                                <td colspan="6" class="text-center h-full">
                                    <NoRecordMessage />
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="card-footer">
                <div class="row" v-if="questions.data.length > 0">
                    <div
                        class="col-sm-12 d-flex align-items-center justify-content-between"
                        v-if="questions.meta"
                    >
                        <span class="fw-bold text-gray-700">
                            Showing {{ questions.meta.from }} to
                            {{ questions.meta.to }} of
                            {{ questions.meta.total }} entries
                        </span>
                        <Pagination :links="questions.meta.links" />
                    </div>
                </div>
            </div>
        </div>
    </app-layout>
</template>
