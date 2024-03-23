<script>
import { defineComponent } from "vue";
import { Link } from "@inertiajs/inertia-vue3";
import ImageInput from "@/Components/ImageInput.vue";
import useVuelidate from "@vuelidate/core";
import { toast } from "vue3-toastify";

export default defineComponent({
    props: ["user", "image"],

    setup() {
        return { v$: useVuelidate() };
    },
    validations() {
        return {
            form: {
                option_name: {},
                auto_load: {},
                image: {},
            },
        };
    },
    components: {
        Link,
        ImageInput,
    },
    data() {
        return {
            url: null,
            form: this.$inertia.form({
                id: this.image?.entity_id,
                image: null,
            }),
        };
    },
    methods: {
        submit() {
            this.v$.$touch();
            if (!this.v$.form.$invalid) {
                this.form
                    .transform((data) => ({
                        ...data,
                    }))
                    .post(this.route("profile-image.store"), {
                        onSuccess: (data) => {
                            toast.success(
                                this.$page.props.jetstream.flash.message
                            );
                            this.isEdit = false;
                        },
                        onError: (error) => {
                            console.log(error.message);
                            toast.error(error.message);
                        },
                    });
            }
        },
        uploadImage(e) {
            const file = e.target.files[0];
            this.url = URL.createObjectURL(file);
            this.form.image = file;
            this.submit();
        },
        removeSelectedAvatar() {
            this.url = null;
        },
    },
});
</script>
<template>
    <div class="card mb-5 mb-xl-5">
        <div class="card-header">
            <div class="card-title">
                <h2>Profile Image</h2>
            </div>
        </div>
        <div class="card-body">
            <div class="align-itemx-center w-100">
                <ImageInput :image="image?.url" :onchange="uploadImage" :remove="removeSelectedAvatar"
                    :selectedImage="url" />
            </div>
        </div>
    </div>
</template>
