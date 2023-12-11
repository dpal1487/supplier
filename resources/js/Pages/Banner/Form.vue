<script>
import { defineComponent } from "vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import { Head, Link } from "@inertiajs/inertia-vue3";
import Multiselect from "@vueform/multiselect";
import JetInput from "@/Jetstream/Input.vue";
import JetLabel from "@/Jetstream/Label.vue";
import InputError from "@/jetstream/InputError.vue";
import useVuelidate from "@vuelidate/core";
import { required, url } from "@vuelidate/validators";
import { toast } from "vue3-toastify";
import Loading from "vue-loading-overlay";
import 'vue-loading-overlay/dist/css/index.css';
import utils from "../../utils";
import DragDropFile from "@/Components/DragDropFile.vue"

export default defineComponent({
    props: ['banner'],
    setup() {
        return { v$: useVuelidate() };
    },
    validations() {
        return {
            form: {
                image: {},
                title: { required },
                url: { required, url },
                description: { required },
            },
        };
    },
    data() {
        return {
            title: 'Banner',
            isEdit: false,
            service_upload: {
                isLoading: false,
                url: null,
            },
            form: this.$inertia.form({
                id: this.banner?.data?.id || '',
                title: this.banner?.data?.title || '',
                description: this.banner?.data?.description || '',
                url: this.banner?.data?.url || '',
                service_image: this.banner?.data?.image?.id ? this.banner?.data?.image?.id : this.form?.service_image,
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
        Loading,
        DragDropFile,
    },
    methods: {
        submit() {
            this.v$.$touch();
            if (!this.v$.form.$invalid) {
                this.form
                    .transform((data) => ({
                        ...data,
                    }))
                    .post(route().current() == 'banner.create' ? this.route("banner.store") : this.route('banner.update', this.form.id),
                        {
                            onSuccess: (data) => {
                                toast.success(this.$page.props.jetstream.flash.message);
                                this.isEdit = false;
                            },
                            onError: (data) => {
                                toast.error(data.message);
                            },
                        });
            }
        },

        async onBannerChange(e) {
            this.service_upload.isLoading = true;
            const data = await utils.imageUpload(route('upload.service-image'), e, this.form.service_image)
            if (data.response.success) {
                this.form.service_image = data.response.data.id;
            } else {
                toast.error(data.response.message);
            }
            this.service_upload.url = URL.createObjectURL(data.file);

            this.service_upload.isLoading = false;
        },

        removeSelectedAvatar() {
            this.service_upload.url = null;
        }

    },
    created() {
        if (route().current() == 'banner.edit') {
            this.isEdit = true;
        }
    }
});

</script>
<template>
    <Head :title="isEdit ? 'Edit Banner' : `Add New Banner`" />
    <AppLayout :title="isEdit ? 'Edit Banner' : `Add New Banner`">
        <template #breadcrumb>
            <li class="breadcrumb-item">
                <span class="bullet bg-gray-400 w-5px h-2px"></span>
            </li>
            <li class="breadcrumb-item">
                <Link href="/banners" class="text-muted text-hover-primary">Banners</Link>
            </li>
            <li class="breadcrumb-item">
                <span class="bullet bg-gray-400 w-5px h-2px"></span>
            </li>
            <li class="breadcrumb-item">
                <span class="text-muted">Banner Form</span>
            </li>
        </template>

        <form @submit.prevent="submit()" class="form">
            <div class="card g-5 mb-5">
                <div class="card-header">
                    <div class="card-title">
                        <h2>Banner Image </h2>
                    </div>
                </div>
                <div class="card-body pt-5">
                    <div class="fv-row mb-2">
                        <DragDropFile :image="banner?.data?.image?.file_path" :isUploading="banner?.isLoading"
                            @change="onBannerChange" />
                    </div>
                    <div class="text-muted fs-7 mx-2">Allowed file types: png, jpg, jpeg.</div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <div class="card-title">
                        <h2>General</h2>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row col-md-12">
                        <div class="col-md-6">
                            <div class="fv-row mb-5">
                                <jet-label for="title" value="Banner Name" />
                                <jet-input id="title" type="text" v-model="v$.form.title.$model" :class="v$.form.title.$errors.length > 0
                                    ? 'is-invalid'
                                    : ''
                                    " placeholder="Banner Name" />
                                <div v-for="(error, index) of v$.form.title.$errors" :key="index">
                                    <input-error :message="error.$message" />
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="fv-row mb-5">
                                <jet-label for="url" value="Banner URL" />
                                <jet-input id="url" type="text" v-model="v$.form.url.$model" :class="v$.form.url.$errors.length > 0
                                    ? 'is-invalid'
                                    : ''
                                    " placeholder="Banner URL" />
                                <div v-for="(error, index) of v$.form.url.$errors" :key="index">
                                    <input-error :message="error.$message" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="fv-row mb-5">
                        <jet-label for="description" value="Description" />
                        <textarea id="description" v-model="v$.form.description.$model"
                            class="form-control form-control-solid" :class="v$.form.description.$errors.length > 0
                                ? 'is-invalid'
                                : ''
                                " placeholder="Text ..." />

                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-end m-5 gap-5">
                <Link href="/banners" class="btn btn-outline-secondary d-flex align-items-center justify-content-center">
                Discard
                </Link>
                <button type="submit" class="btn btn-primary" :class="{ 'text-white-50': form.processing }">
                    <div v-show="form.processing" class="spinner-border spinner-border-sm">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <span v-if="route().current() == 'banner.edit'">Update</span>
                    <span v-if="route().current() == 'banner.create'">Save</span>
                </button>
            </div>
        </form>
    </AppLayout>
</template>
