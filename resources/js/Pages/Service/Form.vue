<script>
import { defineComponent } from "vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import { Head, Link } from "@inertiajs/inertia-vue3";
import Multiselect from "@vueform/multiselect";
import JetInput from "@/Jetstream/Input.vue";
import JetLabel from "@/Jetstream/Label.vue";
import InputError from "@/jetstream/InputError.vue";
import useVuelidate from "@vuelidate/core";
import { required } from "@vuelidate/validators";
import { toast } from "vue3-toastify";
import ClassicEditor from '@ckeditor/ckeditor5-build-classic';
import utils from "../../utils";
import ImageInput from "@/Components/ImageInput.vue"
import DragDropFile from "@/Components/DragDropFile.vue"

export default defineComponent({
    props: ['service', 'image'],
    setup() {
        return { v$: useVuelidate() };
    },
    validations() {
        return {
            form: {
                name: {
                    required,
                },
                page: {
                    required,
                },
                description: {
                    required,
                },
                image: {

                },
            },
        };
    },
    data() {
        return {
            editor: ClassicEditor,
            isEdit: false,
            isUploading: false,
            processing: false,
            thumbnail: {
                isLoading: false,
                url: null,
            },
            form: this.$inertia.form({
                id: this.service?.data?.id || '',
                name: this.service?.data?.name || '',
                page: this.service?.data?.page || '',
                description: this.service?.data.description || '',
                image: this.image
                    ? this.image
                    : {
                        id: "",
                        url: "",
                    },
            }),
        };
    },
    components: {
        AppLayout,
        Link,
        Head,
        Multiselect,
        JetInput,
        JetLabel,
        InputError,
        ClassicEditor,
        ImageInput,
        DragDropFile
    },
    methods: {
        submit() {
            this.v$.$touch();
            if (!this.v$.form.$invalid) {
                if (route().current() == 'service.create') {
                    this.form.transform((data) => ({
                        ...data,
                    }))
                        .post(this.route("service.store"), {
                            onSuccess: (data) => {
                                toast.success(this.$page.props.jetstream.flash.message);
                                this.isEdit = false;
                            },
                            onError: (data) => {
                                if (data.message) {
                                    toast.error(data.message);
                                }
                            },
                        })
                }
                if (route().current() == 'service.edit') {
                    this.form.transform((data) => ({
                        ...data,
                    }))
                        .put(this.route('service.update', this.form.id), {
                            onSuccess: (data) => {
                                toast.success(this.$page.props.jetstream.flash.message);
                                this.isEdit = false;
                            },
                            onError: (data) => {
                                if (data.message) {
                                    toast.error(data.message);
                                }
                            },
                        })
                }
            }
        },
        async uploadImage(e) {
            this.thumbnail.isLoading = true;
            const data = await utils.imageUpload(route("image.store", 'service'), e);
            if (data.response.success) {
                this.form.image = data.response.data;
            } else {
                toast.error(data.response.message);
            }

            this.thumbnail.url = URL.createObjectURL(data.file);

            this.thumbnail.isLoading = false;
        },

        removeSelectedAvatar() {
            this.thumbnail.url = null;
        }
    },
    created() {
        if (route().current() == 'service.edit') {
            this.isEdit = true;
        }
    }
});
</script>
<template>
    <Head :title="isEdit ? 'Edit Service' : `Add New Service`" />
    <AppLayout :title="isEdit ? 'Edit Service' : `Add New Service`">
        <template #breadcrumb>
            <li class="breadcrumb-item">
                <span class="bullet bg-gray-400 w-5px h-2px"></span>
            </li>
            <li class="breadcrumb-item">
                <Link href="/service" class="text-muted text-hover-primary">Service</Link>
            </li>
            <li class="breadcrumb-item">
                <span class="bullet bg-gray-400 w-5px h-2px"></span>
            </li>
            <li class="breadcrumb-item">
                <span class="text-muted text-hover-primary">Service Form</span>
            </li>
        </template>
        <div class="d-flex flex-column flex-lg-row flex-column-fluid justify-content-center">
            <div class="col-12">
                <form @submit.prevent="submit()" class="d-flex flex-column flex-row-fluid gap-7 gap-lg-10">
                    <div class="">
                        <div class="row g-5">
                            <div class="col-4">
                                <div class="card p-6">
                                    <div class="fv-row">
                                        <ImageInput :image="this.image?.data" :onchange="uploadImage"
                                            :remove="removeSelectedAvatar" :selectedImage="thumbnail?.url"
                                            :errors="v$.form.image.$errors" :isUploading="thumbnail?.isLoading" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-8 ">
                                <div class="card p-6">
                                    <div class="fv-row mb-6">
                                        <jet-label for="name" value="Service Name" />
                                        <jet-input id="name" type="text" v-model="v$.form.name.$model" :class="v$.form.name.$errors.length > 0
                                            ? 'is-invalid'
                                            : ''
                                            " placeholder="Service Name" />
                                        <div v-for="(error, index) of v$.form.name.$errors" :key="index">
                                            <input-error :message="error.$message" />
                                        </div>
                                    </div>
                                    <div class="fv-row mb-6">
                                        <jet-label for="page" value="Page Name" />
                                        <jet-input id="page" type="text" v-model="v$.form.page.$model" :class="v$.form.page.$errors.length > 0
                                            ? 'is-invalid'
                                            : ''
                                            " placeholder="Page Name" />
                                        <div v-for="(error, index) of v$.form.page.$errors" :key="index">
                                            <input-error :message="error.$message" />
                                        </div>
                                    </div>
                                    <div class="fv-row">
                                        <jet-label for="description" value="Description" />
                                        <ckeditor :editor="editor" v-model="v$.form.description.$model"
                                            class="form-control form-control-solid" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="d-flex justify-content-end text-align-center gap-5">
                                <Link href="/service" class="btn btn-outline-secondary">
                                Discard
                                </Link>
                                <div>
                                    <button type="submit" class="btn btn-primary align-items-center justify-content-center"
                                        :data-kt-indicator="form.processing ? 'on' : 'off'">
                                        <span v-if="route().current() == 'service.edit'">Save Changes</span>
                                        <span v-if="route().current() == 'service.create'">Save</span>
                                        <span class="indicator-progress">
                                            Please wait... <span
                                                class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                        </span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </AppLayout>
</template>
