<script>
import { defineComponent } from "vue";
import InputError from "@/jetstream/InputError.vue";
import { Link } from "@inertiajs/inertia-vue3";
import JetValidationErrors from "@/Jetstream/ValidationErrors.vue";
import JetInput from "@/Jetstream/Input.vue";
import JetLabel from "@/Jetstream/Label.vue";
import useVuelidate from "@vuelidate/core";
import Multiselect from "@vueform/multiselect";

import { required, numeric } from "@vuelidate/validators";
import { toast } from "vue3-toastify";
import axios from "axios";
export default defineComponent({
    props: ["countries", "supplier"],
    setup() {
        return { v$: useVuelidate() };
    },

    validations() {
        return {
            form: {
                company_name: {
                    required,
                },
                name: {
                    required,
                },
                phone: {
                    required,
                    numeric,
                },
                contact_email: {
                    required,
                },
                rfq_email: {
                    required,
                },
                skype: {
                    required,
                },
                aol: {
                    required,
                },
                mailing_adress: {
                    required,
                },
                city: {
                    required,
                },
                state: {
                    required,
                },
                zipcode: {
                    required,
                },
                final_id: {
                    required,
                },
                country: {
                    required,
                },
                traffic_details: {
                    required,
                },
                name_of_contact: {},
            },
        };
    },

    components: {
        JetInput,
        JetLabel,
        JetValidationErrors,
        InputError,
        Multiselect,
        Link,
    },

    data() {
        return {
            processing: false,
            isLoading: false,
            isFullPage: true,
            form: this.$inertia.form({
                company_name: "All Research Solutions ",
                name: this.supplier?.supplier_name || "",
                phone: this?.supplier?.email_address || "",
                contact_email: this?.supplier?.email_address || "",
                rfq_email: this?.supplier?.email_address || "",
                skype: this?.supplier?.skype_profile || "",
                aol: this?.supplier?.email_address || "",
                mailing_adress: this?.supplier?.email_address || "",
                city: this?.supplier?.email_address || "",
                state: this?.supplier?.email_address || "",
                zipcode: this?.supplier?.email_address || "",
                final_id: this?.supplier?.email_address || "",
                country: this?.supplier?.email_address || "",
                traffic_details: this?.supplier?.email_address || "",
                name_of_contact: this?.supplier?.email_address || "",
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
                    .post(
                        route().current() == "account.create"
                            ? this.route("account.store")
                            : this.route("account.update", this.user.id),
                        {
                            onSuccess: (data) => {
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
        getStates(id) {
            const state = this.states?.data?.find((state) => state.id == id);
            this.form.project_state = state?.name;
            axios
                .get("/account/state", {
                    params: {
                        country_id: id,
                    },
                })
                .then((response) => {
                    if (response.data?.states?.length > 0) {
                        this.states = response.data.states;
                        this.cities = response.data?.cities;
                    } else {
                        this.states = [];
                        this.cities = [];
                    }
                });
        },
    },
});
</script>

<template>
    <form @submit.prevent="submit" autocomplete="off">
        <div class="card mb-5">
            <div class="card-header">
                <div class="card-title">
                    <h2>Contact Information</h2>
                </div>
            </div>
            <div class="card-body pt-2">
                <div class="row mb-3">
                    <div class="col-6">
                        <jet-label for="company-name" value="Company Name" class="required" />
                        <jet-input id="company-name" type="text" placeholder="Enter company name"
                            v-model="v$.form.company_name.$model" :class="v$.form.company_name.$errors.length > 0
        ? 'is-invalid'
        : ''
        " />
                        <div v-for="(error, index) of v$.form.company_name.$errors" :key="index">
                            <input-error :message="error.$message" />
                        </div>
                    </div>
                    <div class="col-6">
                        <jet-label for="name" value="Name" class="required" />
                        <jet-input id="name" type="text" placeholder="Enter Name " v-model="v$.form.name.$model" :class="v$.form.name.$errors.length > 0 ? 'is-invalid' : ''
        " />
                        <div v-for="(error, index) of v$.form.name.$errors" :key="index">
                            <input-error :message="error.$message" />
                        </div>
                    </div>
                </div>
                <div class="row mb-3">

                    <div class="col-md-6 col-sm-12">
                        <jet-label for="phone" value="Phone" class="required" />
                        <jet-input id="phone" type="text" placeholder="Enter phone number "
                            v-model="v$.form.phone.$model"
                            :class="v$.form.phone.$errors.length > 0 ? 'is-invalid' : ''" />
                        <div v-for="(error, index) of v$.form.phone.$errors" :key="index">
                            <input-error :message="error.$message" />
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-12">
                        <jet-label for="contact-email" value="Contact Email" class="required" />
                        <jet-input id="contact-email" type="text" placeholder="Enter contact email"
                            v-model="v$.form.contact_email.$model"
                            :class="v$.form.contact_email.$errors.length > 0 ? 'is-invalid' : ''" />
                        <div v-for="(error, index) of v$.form.contact_email.$errors" :key="index">
                            <input-error :message="error.$message" />
                        </div>
                    </div>
                </div>
                <div class="row mb-3">

                    <div class="col-md-6 col-sm-12">
                        <jet-label for="rfq-email" value="RFQ Email" class="required" />
                        <jet-input id="rdq-email" type="text" placeholder="Enter RFQ email"
                            v-model="v$.form.rfq_email.$model"
                            :class="v$.form.rfq_email.$errors.length > 0 ? 'is-invalid' : ''" />
                        <div v-for="(error, index) of v$.form.rfq_email.$errors" :key="index">
                            <input-error :message="error.$message" />
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-12">
                        <jet-label for="skype-profile" value="Skype" class="required" />
                        <jet-input id="skype-profile" type="text" placeholder="Enter skype profile "
                            v-model="v$.form.skype.$model"
                            :class="v$.form.skype.$errors.length > 0 ? 'is-invalid' : ''" />
                        <div v-for="(error, index) of v$.form.skype.$errors" :key="index">
                            <input-error :message="error.$message" />
                        </div>
                    </div>
                </div>

                <div class="row mb-3">

                    <div class="col-md-6 col-sm-12">
                        <jet-label for="aol" value="AOL" class="required" />
                        <jet-input id="aol" type="text" placeholder="Enter AOL " v-model="v$.form.aol.$model"
                            :class="v$.form.aol.$errors.length > 0 ? 'is-invalid' : ''" />
                        <div v-for="(error, index) of v$.form.aol.$errors" :key="index">
                            <input-error :message="error.$message" />
                        </div>
                    </div>
                    <div class="col-6">
                        <jet-label for="mailing-address" value="Mailing Address" class="required" />
                        <jet-input id="mailing-address" type="text" placeholder="Enter mailing address"
                            v-model="v$.form.mailing_adress.$model"
                            :class="v$.form.mailing_adress.$errors.length > 0 ? 'is-invalid' : ''" />
                        <div v-for="(error, index) of v$.form.mailing_adress.$errors" :key="index">
                            <input-error :message="error.$message" />
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-6">
                        <jet-label for="city" value="City" class="required" />
                        <jet-input id="city" type="text" placeholder="Enter city" v-model="v$.form.city.$model"
                            :class="v$.form.city.$errors.length > 0 ? 'is-invalid' : ''" />
                        <div v-for="(error, index) of v$.form.city.$errors" :key="index">
                            <input-error :message="error.$message" />
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-12">
                        <jet-label for="state" value="State" class="required" />
                        <jet-input id="state" type="text" placeholder="Enter state" v-model="v$.form.state.$model"
                            :class="v$.form.state.$errors.length > 0 ? 'is-invalid' : ''" />
                        <div v-for="(error, index) of v$.form.state.$errors" :key="index">
                            <input-error :message="error.$message" />
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6 col-sm-12">
                        <jet-label for="zipcode" value="Zipcode" class="required" />
                        <jet-input id="zipcode" type="text" placeholder="Enter zipcode" v-model="v$.form.zipcode.$model"
                            :class="v$.form.zipcode.$errors.length > 0 ? 'is-invalid' : ''" />
                        <div v-for="(error, index) of v$.form.zipcode.$errors" :key="index">
                            <input-error :message="error.$message" />
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-12">
                        <jet-label for="country" value="Country" class="required" />
                        <Multiselect :can-clear="false" :options="countries" label="label" valueProp="id"
                            class="form-control form-control-solid" placeholder="Select country" :searchable="true"
                            v-model="v$.form.country.$model"
                            :class="v$.form.country.$errors.length > 0 ? 'is-invalid' : ''" />
                        <div v-for="(error, index) of v$.form.country.$errors" :key="index">
                            <input-error :message="error.$message" />
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-12 col-sm-12">
                        <jet-label for="final-id" value="Final ID" class="required" />
                        <jet-input id="final-id" type="text" placeholder="Enter final id"
                            v-model="v$.form.final_id.$model"
                            :class="v$.form.final_id.$errors.length > 0 ? 'is-invalid' : ''" />
                        <div v-for="(error, index) of v$.form.final_id.$errors" :key="index">
                            <input-error :message="error.$message" />
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <div class="card mb-5">
            <div class="card-header">
                <div class="card-title">
                    <h2>Additional Information</h2>
                </div>
            </div>
            <div class="card-body pt-2">
                <div class="row mb-3">
                    <div class="col-12">
                        <jet-label value="Trafic Details" />
                        <jet-input type="text" placeholder="Enter trafic details"
                            v-model="v$.form.traffic_details.$model"
                            :class="v$.form.traffic_details.$errors.length > 0 ? 'is-invalid' : ''" />
                        <div v-for="(error, index) of v$.form.traffic_details.$errors" :key="index">
                            <input-error :message="error.$message" />
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6 col-sm-12">
                        <jet-label for="name-of-contact" value="Name OF Contact" />
                        <jet-input id="name-of-contact" type="text" placeholder="Enter name of contact"
                            v-model="v$.form.name_of_contact.$model"
                            :class="v$.form.name_of_contact.$errors.length > 0 ? 'is-invalid' : ''" />
                        <div v-for="(error, index) of v$.form.name_of_contact.$errors" :key="index">
                            <input-error :message="error.$message" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="d-flex justify-content-end">
            <button type="submit" class="btn btn-primary" :class="{ 'text-white-50': form.processing }">
                <div v-show="form.processing" class="spinner-border spinner-border-sm">
                    <span class="visually-hidden">Loading...</span>
                </div>
                Save
            </button>
        </div>
    </form>
</template>
