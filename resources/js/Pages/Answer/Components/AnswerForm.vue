<script>
import { defineComponent } from "vue";
import { Link } from "@inertiajs/inertia-vue3";
import Multiselect from "@vueform/multiselect";
import useVuelidate from "@vuelidate/core";
import { required, numeric, url } from "@vuelidate/validators";
import JetInput from "@/Jetstream/Input.vue";
import JetLabel from "@/Jetstream/Label.vue";
import InputError from "@/jetstream/InputError.vue";
import JetValidationErrors from "@/Jetstream/ValidationErrors.vue";
import Modal from "@/Components/Modal.vue";
import SectionLoader from "../../../Components/SectionLoader.vue";
// import utils from "../../../../utils";
import { Inertia } from "@inertiajs/inertia";
import axios from "axios";
import { toast } from "vue3-toastify";


export default defineComponent({
    setup() {
        return { v$: useVuelidate() };
    },
    props: ['show', 'id'],

    components: {
        Link,
        Multiselect,
        JetInput,
        JetLabel,
        InputError,
        JetValidationErrors,
        Modal,
        SectionLoader
    },
    validations() {
        return {
            form: {
                question: {
                    required,
                },
                answer: {
                    required,
                },
                order_by: {
                    required,
                }
            },
        };
    },
    data() {
        return {
            isLoading: false,
            processing: false,
            form: this.$inertia.form({
                id: '',
                question: {},
                answer: '',
                order_by: '',
            }),
            order_by: [
                { id: '1', name: 'Ascending' },
                { id: '0', name: 'Descending' },
            ],
        };
    },
    methods: {
        async submit() {
            this.v$.$touch();
            if (!this.v$.form.$invalid) {
                if (this.id) {
                    this.processing = true;
                    axios.put(this.route("answer.update", this.id), this.form)
                        .then((response) => {
                            if (response.data.success) {
                                this.processing = false;
                                toast.success(response.data.message)
                                Inertia.get('/answer')
                            } else {
                                toast.info(response.data.message)
                            }
                            if (response.data.error) {
                                toast.error(response.data.error)
                            }
                        })
                } else {
                    axios.post(this.route('answer.store'), this.form)
                        .then((response) => {
                            if (response.data.success) {
                                toast.success(response.data.message)
                                this.processing = false;
                                if (this.form.add_more != true) {
                                    this.$emit('hidemodal')
                                    Inertia.get('/answer')
                                }
                                this.form.question = ''
                                this.form.answer = ''
                                this.form.order_by = ''
                            } else {
                                toast.info(response.data.message)
                            }
                            if (response.data.error) {
                                toast.error(response.data.error)
                            }
                        })
                }
            }
        },
    },
    create() {

    },
    watch: {
        id: {
            async handler() {
                this.isLoading = true;
                const response = await axios.get(`/answer/${this.id}/edit`);

                this.form = response?.data?.answer;
                this.questions = response?.data?.questions;
                this.isLoading = false;
            }
        }
    }
});
</script>
<template>
    <Modal :show="show" @onhide="$emit('hidemodal')" :title="id ? 'Edit Link Form' : 'Add New Answer'" page="Answer">
        <SectionLoader v-if="isLoading == true" :width="40" :height="40" />
        <div v-else>
            <JetValidationErrors />
            <form @submit.prevent="submit()" class="d-flex flex-column flex-row-fluid">
                <div class="card ">
                    <div class="card-body p-0">
                        <div class="row col-md-12">
                            <div class="fv-row col-6">
                                <jet-label for="question" value="Question" />
                                <Multiselect :canClear="false" :options="questions" label="question_key" valueProp="id"
                                    class="form-control form-control-lg form-control-solid" placeholder="Select One"
                                    v-model="v$.form.question.$model" track-by="question_key" :searchable="true" :class="v$.form.question.$errors.length > 0
                                        ? 'is-invalid'
                                        : ''
                                        " />
                                <div v-for="(error, index) of v$.form.question.$errors" :key="index">
                                    <input-error :message="error.$message" />
                                </div>
                            </div>
                            <div class="fv-row col-6">
                                <jet-label for="answer" value="Answer" />
                                <jet-input id="answer" type="text" v-model="v$.form.answer.$model" :class="v$.form.answer.$errors.length > 0
                                    ? 'is-invalid'
                                    : ''
                                    " placeholder="Answer" />
                                <div v-for="(error, index) of v$.form.answer.$errors" :key="index">
                                    <input-error :message="error.$message" />
                                </div>
                            </div>
                            <div class="fv-row col-6">
                                <jet-label for="order_by" value="Order By" />
                                <Multiselect :canClear="false" :options="order_by" label="name" valueProp="id"
                                    class="form-control form-control-lg form-control-solid" placeholder="Select One"
                                    v-model="v$.form.order_by.$model" track-by="name" :searchable="true" :class="v$.form.order_by.$errors.length > 0
                                        ? 'is-invalid'
                                        : ''
                                        " />
                                <div v-for="(error, index) of v$.form.order_by.$errors" :key="index">
                                    <input-error :message="error.$message" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--end::Variations-->
                <div class="row">
                    <div class="d-flex justify-content-end">
                        <Link href="/answer"
                            class="btn btn-outline-secondary d-flex align-items-center justify-content-center">
                        Discard
                        </Link>
                        <button type="submit" class="btn btn-primary align-items-center justify-content-center mx-5"
                            :data-kt-indicator="processing ? 'on' : 'off'">
                            <span class="indicator-progress">
                                Please wait... <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                            </span>
                            <span class="indicator-label ">
                                <span v-if="id">Save Changes</span>
                                <span v-else>Save</span>
                            </span>

                        </button>
                        <!--end::Button-->
                    </div>
                </div>
                <!--end::Actions-->
            </form>
        </div>
    </Modal>
</template>
