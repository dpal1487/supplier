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
import DragDropFile from "@/Components/DragDropFile.vue"
import utils from "../../../utils";
import { Inertia } from "@inertiajs/inertia";
import axios from "axios";
import { toast } from "vue3-toastify";


export default defineComponent({
    setup() {
        return { v$: useVuelidate() };
    },
    props: ['show', 'id', 'image', 'industries'],

    components: {
        Link,
        Multiselect,
        JetInput,
        JetLabel,
        InputError,
        JetValidationErrors,
        Modal,
        SectionLoader,
        DragDropFile
    },
    validations() {
        return {
            form: {
                name: {
                    required,
                },
                image: {

                },
                status: {

                }

            },
        };
    },
    data() {
        return {
            isEdit: false,
            isLoading: false,
            isUploading: false,
            processing: false,
            title: "Industry",
            thumbnail: {
                isLoading: false,
                url: null,
            },
            form: this.$inertia.form({
                id: this.blog?.data?.id || '',
                title: this.blog?.data?.title || '',
                status: this.blog?.data?.is_published || 0,
                image: this.image
                    ? this.image?.data
                    : {
                        id: "",
                        url: "",
                    },
            }),
            status: [
                { id: '1', name: 'Published' },
                { id: '0', name: 'Unpublished' },
            ],

        };
    },
    methods: {

        async submit() {
            this.v$.$touch();
            if (!this.v$.form.$invalid) {
                this.processing = true;
                axios.post(this.id ? this.route("industry.update", this.id) : this.route('industry.store'), this.form)
                    .then((response) => {
                        if (response.data.success) {
                            this.processing = false;
                            toast.success(response.data.message)
                            Inertia.get('/industries')
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
        async uploadImage(e) {

            this.thumbnail.isLoading = true;
            const data = await utils.imageUpload(route("image.store", 'industry'), e, this.image?.data?.entity_id);
            if (data.response) {
                this.form.image = data.response.data;
            } else {
                toast.error(data.response);
            }

            this.thumbnail.url = URL.createObjectURL(data.file);

            this.thumbnail.isLoading = false;
        },

        removeSelectedAvatar() {
            this.thumbnail.url = null;
        }
    },
    create() {

    },
    watch: {
        id: {
            async handler() {
                this.isLoading = true;
                if (this.id) {
                    const response = await axios.get(`/industry/${this.id}/edit`);
                    this.form = response?.data?.industry;
                    this.form.industry = response?.data?.industries?.industry?.id
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
    <Modal :show="show" @onhide="$emit('hidemodal')" :title="id ? 'Edit Industry' : 'Add New Industry'">
        <SectionLoader v-if="isLoading == true" :width="40" :height="40" />
        <div v-else>
            <JetValidationErrors />
            <form @submit.prevent="submit()" class="d-flex flex-column flex-row-fluid gap-7 gap-lg-10">
                <div class="">
                    <div class="row g-5">
                        <div class="col-sm-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row mb-5">
                                        <DragDropFile :image="this.form.image" :onchange="uploadImage"
                                            :remove="removeSelectedAvatar" :selectedImage="thumbnail?.url"
                                            :errors="v$.form.image.$errors" :isUploading="thumbnail?.isLoading" />
                                    </div>
                                    <div class="row mb-5">
                                        <jet-label for="name" value="Name" />
                                        <jet-input id="name" type="text" v-model="v$.form.name.$model" :class="v$.form.name.$errors.length > 0
                                            ? 'is-invalid'
                                            : ''
                                            " placeholder="Name" />
                                        <div v-for="(error, index) of v$.form.name.$errors" :key="index">
                                            <input-error :message="error.$message" />
                                        </div>
                                    </div>
                                    <div class="row mb-5">
                                        <jet-label for="page" value="Status" />
                                        <Multiselect :can-clear="false" :options="status" label="name" valueProp="id"
                                            class="form-control form-control-solid" placeholder="Select Status"
                                            v-model="v$.form.status.$model" :class="v$.form.status.$errors.length > 0
                                                ? 'is-invalid'
                                                : ''
                                                " />
                                        <div v-for="(error, index) of v$.form.status.$errors" :key="index">
                                            <input-error :message="error.$message" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="d-flex justify-content-end text-align-center gap-5">
                            <Link href="/industries" class="btn btn-outline-secondary">
                            Discard
                            </Link>
                            <div>
                                <button type="submit" class="btn btn-primary" :class="{ 'text-white-50': processing }">
                                    <div v-show="processing" class="spinner-border spinner-border-sm">
                                        <span class="visually-hidden">Loading...</span>
                                    </div>
                                    <span v-if="this.id">Save Changes</span>
                                    <span v-else>Save</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </Modal>
</template>
