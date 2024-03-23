<script>
import { defineComponent } from "vue";
import InputError from "@/jetstream/InputError.vue";

export default defineComponent({
    props: ["image", "selectedImage", "errors", "isUploading"],
    components: {
        InputError,
    },
    methods: {
        handleRemoveClick() {
            this.$emit("remove");
        },
    },
});
</script>
<template>
    <div class="d-flex align-items-center justify-content-between mx-10">
        <div class="text-center w-100">
            <div class="image-input image-input-outline mx-auto" data-kt-image-input="true" style="
                    background-image: url('/assets/media/svg/avatars/blank.svg');
                ">
                <div class="mw-125px h-125px d-flex align-items-center justify-content-center rounded-1 bg-secondary"
                    v-if="isUploading">
                    <div class="spinner-border spinner-border-sm w-50px h-50px"></div>
                </div>
                <div v-else>
                    <img class="image-input-wrapper w-100 h-auto" v-if="image && !selectedImage" :src="`${image}`" />
                    <img class="image-input-wrapper w-100 h-auto" v-else-if="!selectedImage"
                        src="/assets/media/svg/avatars/blank.svg" />
                    <img class="image-input-wrapper w-100 h-auto" v-else :src="selectedImage" />
                </div>
                <label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                    data-kt-image-input-action="change" data-bs-toggle="tooltip" title="Change avatar">
                    <i class="bi bi-pencil-fill fs-7"></i>
                    <input type="file" name="avatar" accept=".png, .jpg, .jpeg" @change="$emit('onchange')" />
                </label>
                <div v-for="(error, index) of errors" :key="index">
                    <input-error :message="error.$message" />
                </div>
            </div>
        </div>
    </div>
</template>
