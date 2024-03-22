<script>
import { defineComponent } from "vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import { Link, Head } from "@inertiajs/inertia-vue3";
export default defineComponent({
    props: ["revenue"],
    components: {
        AppLayout,
        Link,
        Head,
    },
    data() {
        return {};
    },
});
</script>

<template>
    <div class="card my-5">
        <div class="card-header pt-7">
            <h3 class="card-title align-items-start flex-column">
                <span class="card-label fw-bold text-gray-800 align-middle mb-4"
                    >Revenue Dashboard</span
                >
            </h3>
        </div>
        <div class="card-body pt-2">
            <div class="row">
                <div class="col-md-6 mb-5"></div>
            </div>
        </div>
    </div>
</template>
