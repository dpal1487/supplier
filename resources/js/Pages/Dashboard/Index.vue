<script>
import { defineComponent } from "vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import { Link, Head } from "@inertiajs/inertia-vue3";
import Categories from "./Component/Categories.vue";
import Invoice from "./Component/Invoice.vue";
export default defineComponent({
    props: ["projects", "invoice", "revenue"],
    components: {
        AppLayout,
        Link,
        Head,
        Categories,
        Invoice,
    },
    data() {
        return {};
    },
});
</script>

<template>
    <app-layout title="Dashboard">
        <Categories :projects="projects?.data?.report" />
        <Invoice :invoice="projects?.data" />
    </app-layout>
</template>
