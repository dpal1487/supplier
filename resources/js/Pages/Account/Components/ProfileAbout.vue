<script>
import { defineComponent } from "vue";
import useVuelidate from "@vuelidate/core";
import { required } from "@vuelidate/validators";
import InputError from "@/jetstream/InputError.vue";
import JetValidationErrors from "@/Jetstream/ValidationErrors.vue";
import JetInput from "@/Jetstream/Input.vue";
import JetLabel from "@/Jetstream/Label.vue";
import { toast } from "vue3-toastify";
export default defineComponent({
    props: ['user'],
    setup() {
        return { v$: useVuelidate() };
    },
    validations() {
        return {
            form: {
                supplier_name: {
                    required,
                },
                password: {
                    required,
                },
            },
        };
    },
    components: {
        JetInput,
        JetLabel,
        InputError,
    },
    data() {
        return {
            processing: false,
            form: this.$inertia.form({
                id: this.user?.id,
                supplier_name: this.user.supplier_name || "",
                password: "",
            }),
        };
    },
    methods: {
        submit() {
            this.v$.$touch();
            this.processing = true;
            if (!this.v$.form.$invalid) {
                this.form
                    .transform((data) => ({
                        ...data,
                    }))
                    .post(this.route("account.store"),
                        {
                            onSuccess: (data) => {
                                console.log("see this", this.$page.props.jetstream.flash.message)
                                toast.success(
                                    this.$page.props.jetstream.flash.message
                                );
                                this.processing = false;
                            },
                            onError: (data) => {
                                if (data.message) {
                                    toast.error(data.message);
                                } else {
                                    // console.log(data)
                                }
                            },
                        }
                    );
            }
        },
    },
});
</script>

<template>
    <div class="card mb-5 gap-5">
        <div class="card-header">
            <div class="card-title">
                <h2>About Me</h2>
            </div>
        </div>
        <div class="card-body pt-0">
            
            <form @submit.prevent="submit">
                <div class="row mb-3">
                    <div class="col-12">
                        <jet-label value="User Name" class="required" />
                        <jet-input type="text" placeholder="Enter user name" v-model="v$.form.supplier_name.$model"
                            :class="v$.form.supplier_name.$errors.length > 0
                ? 'is-invalid'
                : ''
                " />
                        <div v-for="(error, index) of v$.form.supplier_name.$errors" :key="index">
                            <input-error :message="error.$message" />
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-12">
                        <jet-label value="Password" class="required" />
                        <jet-input type="password" placeholder="Enter password" v-model="v$.form.password.$model"
                            :class="v$.form.password.$errors.length > 0
                ? 'is-invalid'
                : ''
                " />
                        <div v-for="(error, index) of v$.form.password.$errors" :key="index">
                            <input-error :message="error.$message" />
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary w-100 btn-sm"
                    :class="{ 'text-white-50 ': form.processing }">
                    <div v-show="form.processing" class="spinner-border spinner-border-sm">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    Save Information
                </button>
            </form>
        </div>
    </div>
</template>
