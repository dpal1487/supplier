<script>
import { defineComponent } from "vue";
import useVuelidate from "@vuelidate/core";
import { required } from "@vuelidate/validators";
import InputError from "@/jetstream/InputError.vue";
import JetValidationErrors from "@/Jetstream/ValidationErrors.vue";
import JetInput from "@/Jetstream/Input.vue";
import JetLabel from "@/Jetstream/Label.vue";
export default defineComponent({
    setup() {
        return { v$: useVuelidate() };
    },
    validations() {
        return {
            form: {
                user_name: {
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
        JetValidationErrors,
        InputError,
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
            <div class="row mb-3">
                <div class="col-12">
                    <jet-label
                        for="trafic-details"
                        value="User Name"
                        class="required"
                    />
                    <jet-input
                        id="trafic-details"
                        type="text"
                        placeholder="Enter trafic details"
                        v-model="v$.form.user_name.$model"
                        :class="
                            v$.form.user_name.$errors.length > 0
                                ? 'is-invalid'
                                : ''
                        "
                    />
                    <div
                        v-for="(error, index) of v$.form.user_name.$errors"
                        :key="index"
                    >
                        <input-error :message="error.$message" />
                    </div>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-12">
                    <jet-label
                        for="trafic-details"
                        value="Password"
                        class="required"
                    />
                    <jet-input
                        id="trafic-details"
                        type="text"
                        placeholder="Enter trafic details"
                        v-model="v$.form.password.$model"
                        :class="
                            v$.form.password.$errors.length > 0
                                ? 'is-invalid'
                                : ''
                        "
                    />
                    <div
                        v-for="(error, index) of v$.form.password.$errors"
                        :key="index"
                    >
                        <input-error :message="error.$message" />
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
