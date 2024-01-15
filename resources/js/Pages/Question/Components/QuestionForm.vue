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
    props: ['show', 'id', 'questions', 'industries'],

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
                question_key: {
                    required,
                },
                text: {
                    required,
                },
                language: {
                    required,
                },
                type: {
                    required,
                },
                industry: {
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
                question_key: '',
                text: '',
                type: '',
                industry: {},
                language: '',
            }),
            options: [
                { name: 'Select', type: 'Select' },
                { name: 'Checkbox', type: 'Checkbox' },
                { name: 'Radio', type: 'Radio' },
            ],
        };
    },
    methods: {
        nameWithLang({ name, type }) {
            return `${name} — [${type}]`
        },
        async submit() {
            this.v$.$touch();
            if (!this.v$.form.$invalid) {
                this.processing = true;
                axios.post(this.id ? this.route("question.update", this.id) : this.route('question.store'), this.form)
                    .then((response) => {
                        if (response.data.success) {
                            this.processing = false;
                            toast.success(response.data.message)
                            Inertia.get('/questions')
                            this.$emit('hidemodal')
                        } else {
                            toast.info(response.data.message)
                        }
                        if (response.data.error) {
                            toast.error(response.data.error)
                        }
                    })
            }
        },
    },
    create() {

    },
    watch: {
        id: {
            async handler() {
                this.isLoading = true;
                if (this.id) {
                    const response = await axios.get(`/question/${this.id}/edit`);
                    this.form = response?.data?.question;
                    this.form.industry = response?.data?.question?.industry?.id
                }
                else {
                    this.form = {}
                }
                this.isLoading = false;
            }
        }
    }
});
</script>
<template>
    <Modal :show="show" @onhide="$emit('hidemodal')" :title="id ? 'Edit Question' : 'Add New Question'">
        <SectionLoader v-if="isLoading == true" :width="40" :height="40" />
        <div v-else>
            <JetValidationErrors />
            <form @submit.prevent="submit()">
                <div class="card">
                    <div class="card-body">
                        <div class="row g-5 col-md-12">
                            <div class="fv-row col-6">
                                <jet-label for="industry" value="Industry" />
                                <Multiselect :can-clear="false" :options="industries" label="name" valueProp="id"
                                    class="form-control form-control-lg form-control-solid" placeholder="Select Industry"
                                    v-model="v$.form.industry.$model" track-by="name" :searchable="true" :class="v$.form.industry.$errors.length > 0
                                        ? 'is-invalid'
                                        : ''
                                        " />
                                <div v-for="(error, index) of v$.form.industry.$errors" :key="index">
                                    <input-error :message="error.$message" />
                                </div>

                            </div>
                            <div class="fv-row col-6">
                                <jet-label for="question_key" value="Question Key" />
                                <jet-input id="question_key" type="text" v-model="v$.form.question_key.$model" :class="v$.form.question_key.$errors.length > 0
                                    ? 'is-invalid'
                                    : ''
                                    " placeholder="Question Key" />
                                <div v-for="(error, index) of v$.form.question_key.$errors" :key="index">
                                    <input-error :message="error.$message" />
                                </div>
                            </div>
                            <div class="fv-row col-6">
                                <jet-label for="language" value="Language" />
                                <jet-input id="language" type="text" v-model="v$.form.language.$model" :class="v$.form.language.$errors.length > 0
                                    ? 'is-invalid'
                                    : ''
                                    " placeholder="Language" />
                                <div v-for="(error, index) of v$.form.language.$errors" :key="index">
                                    <input-error :message="error.$message" />
                                </div>
                            </div>


                            <div class="fv-row col-6">
                                <jet-label for="type" value="Type" />
                                <Multiselect :can-clear="false" :options="options" label="name" valueProp="name" id="type"
                                    :custom-label="nameWithLang" class="form-control form-control-lg form-control-solid"
                                    placeholder="Choose One" v-model="v$.form.type.$model" track-by="name" :class="v$.form.type.$errors.length > 0
                                        ? 'is-invalid'
                                        : ''
                                        " />
                                <div v-for="(error, index) of v$.form.type.$errors" :key="index">
                                    <input-error :message="error.$message" />
                                </div>

                            </div>
                            <div class="fv-row col-12">
                                <jet-label for="text" value="Text" />
                                <textarea v-model="v$.form.text.$model" class="form-control form-control-solid" :class="v$.form.text.$errors.length > 0
                                    ? 'is-invalid'
                                    : ''
                                    " placeholder="Text"></textarea>

                                <div v-for="(error, index) of v$.form.text.$errors" :key="index">
                                    <input-error :message="error.$message" />
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="d-flex justify-content-end">
                        <Link href="/question"
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
                    </div>
                </div>
            </form>
        </div>
    </Modal>
</template>
