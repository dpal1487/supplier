<script>
import { defineComponent } from "vue";
import { Link } from "@inertiajs/inertia-vue3";
import useVuelidate from "@vuelidate/core";
import { required } from "@vuelidate/validators";
import JetInput from "@/Jetstream/Input.vue";
import JetLabel from "@/Jetstream/Label.vue";
import InputError from "@/jetstream/InputError.vue";
import JetValidationErrors from "@/Jetstream/ValidationErrors.vue";
import { Inertia } from "@inertiajs/inertia";
import axios from "axios";
import { toast } from "vue3-toastify";


export default defineComponent({
    setup() {
        return { v$: useVuelidate() };
    },
    props: ['activity_type'],

    components: {
        Link,
        JetInput,
        JetLabel,
        InputError,
        JetValidationErrors,
    },
    validations() {
        return {
            form: {
                text: {
                    required,
                },
            },
        };
    },
    data() {
        return {
            isLoading: false,
            processing: false,
            form: this.$inertia.form({
                id: this.activity_type?.id || '',
                text: this.activity_type?.text || '',
            }),
        };
    },
    methods: {
        async submit() {
            this.v$.$touch();
            if (!this.v$.form.$invalid) {
                this.processing = true;
                axios.post(this.form.id ? this.route("activity_type.update", this.id) : this.route('activity_type.store'), this.form)
                    .then((response) => {
                        if (response.data.success) {
                            this.processing = false;
                            toast.success(response.data.message)
                            Inertia.get('/activity_types')
                        }
                        else {
                            toast.error(response.data.message)
                        }
                    })
            }
        },
    },
});
</script>
<template>
    <form @submit.prevent="submit()" class="d-flex flex-column flex-row-fluid gap-7 gap-lg-10">
        <div class="card">
            <div class="card-header">
                <div class="card-title">
                    <h2>General Form</h2>
                </div>
            </div>
            <div class="card-body">
                <div class="row g-5 col-md-12">
                    <div class="fv-row">
                        <jet-label for="text" value="Activity Type" />
                        <textarea id="text" class="form-control" type="text" v-model="v$.form.text.$model" :class="v$.form.text.$errors.length > 0
                            ? 'is-invalid'
                            : ''
                            " placeholder="Activity Type ..." />
                        <div v-for="(error, index) of v$.form.text.$errors" :key="index">
                            <input-error :message="error.$message" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="d-flex justify-content-end gap-5">
                    <Link href="/activity_types"
                        class="btn btn-outline-secondary d-flex align-items-center justify-content-center">
                    Discard
                    </Link>
                    <button type="submit" class="btn btn-primary align-items-center justify-content-center"
                        :class="{ 'text-white-50': processing }">
                        <div v-show="processing" class="spinner-border spinner-border-sm me-1">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <span class="indicator-label">
                            <span>Save</span>
                        </span>
                    </button>
                </div>
            </div>
        </div>
    </form>
</template>
