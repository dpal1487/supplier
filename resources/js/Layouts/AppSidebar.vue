<script>
import { defineComponent } from "vue";
import { Link } from "@inertiajs/inertia-vue3";
import { Inertia } from "@inertiajs/inertia";
export default defineComponent({
    props: ["projects", "status", "sidebar"],
    emits: ["check", "toggleSidebar"],
    components: {
        Link,
    },
    data() {
        return {
            navigations: [
                {
                    link: "/",
                    route: "dashboard",
                    title: "Dashboard",
                    icon: "bi bi-pie-chart-fill",
                    role: ["pm", "admin"],
                },
                {
                    link: "/master",
                    route: "master.index",
                    title: "Master",
                    icon: "bi bi-pie-chart-fill",
                    role: ["pm", "admin"],
                },
                {
                    link: "/projects",
                    route: "projects.index",
                    title: "Projects",
                    icon: "bi bi-card-heading",
                    role: ["pm", "account", "admin", "user"],
                },
                {
                    link: "/clients",
                    route: "clients.index",
                    title: "Clients",
                    icon: "bi bi-journal-code",
                    role: ["pm", "admin"],
                },
                {
                    link: "/suppliers",
                    route: "suppliers.index",
                    title: "Suppliers",
                    icon: "bi bi-collection-fill",
                    role: ["pm", "admin"],
                },
                {
                    link: "/invoices",
                    route: "invoice.index",
                    title: "Invoices",
                    icon: "bi bi-receipt",
                    role: ["account", "admin"],
                },
                {
                    link: "/users",
                    route: "users.index",
                    title: "Users",
                    icon: "bi bi-person-badge-fill",
                    role: ["pm", "admin"],
                },
                {
                    link: "/final-id",
                    route: "final-id.index",
                    title: "Final ID",
                    icon: "bi bi-card-heading",
                    role: ["pm", "admin"],
                },
                {
                    link: "/service",
                    route: "service.index",
                    title: "Services",
                    icon: "bi bi-diagram-3",
                    role: ["pm", "admin"],
                },
                {
                    link: "/testimonial",
                    route: "testimonial.index",
                    title: "Testimonial",
                    icon: "bi bi-clipboard2-pulse",
                    role: ["pm", "admin"],
                },
                {
                    link: "/blog",
                    route: "blog.index",
                    title: "Blogs",
                    icon: "bi bi-file-post",
                    role: ["pm", "admin"],
                },
                {
                    link: "/questions",
                    route: "questions.index",
                    title: "Questions",
                    icon: "bi bi-question-square",
                    role: ["pm", "admin"],
                },
                {
                    link: "/answers",
                    route: "answers.index",
                    title: "Answers",
                    icon: "bi bi-book",
                    role: ["pm", "admin"],
                },
                {
                    link: "/industries",
                    route: "industries.index",
                    title: "Industries",
                    icon: "bi bi-rss-fill",
                    role: ["pm", "admin"],
                },
                {
                    link: "/activity_types",
                    route: "activity_types.index",
                    title: "Activity Types",
                    icon: "bi bi-book",
                    role: ["pm", "admin"],
                },
                {
                    link: "/login_activities",
                    route: "login_activities.index",
                    title: "Login Activities",
                    icon: "bi bi-person-check",
                    role: ["pm", "admin"],
                },
                {
                    link: "/role",
                    route: "role.index",
                    title: "Role",
                    icon: "bi bi-people",
                    role: ["pm", "admin"],
                },
                {
                    link: "/permissions",
                    route: "permission.index",
                    title: "Permissions",
                    icon: "bi bi-people",
                    role: ["pm", "admin"],
                },
            ],
        };
    },
    methods: {
        search() {
            console.log(this.q);
        },
        updateSelected(id, e) {
            console.log(id);
            console.log(e);
        },
        logout() {
            Inertia.post(route("logout"));
        },
    },
    created() {},
});
</script>
<template>
    <div
        class="app-sidebar flex-column"
        :style="`left: ${
            sidebar ? '0px' : 'calc(0px - var(--kt-app-sidebar-width))'
        }; transition: .4s all ease;`"
    >
        <div
            class="app-sidebar-logo px-6"
            style="border-bottom: 1px solid rgb(64, 64, 64); height: 70px"
        >
            <Link href="/">
                <img
                    alt="Logo"
                    src="/assets/images/logo-light.png"
                    class="h-50px app-sidebar-logo-default"
                />
            </Link>
            <button
                @click="() => this.$emit('toggleSidebar')"
                class="bg-white btn btn-icon btn-shadow btn-sm btn-color-muted btn-active-color-primary body-bg h-30px w-30px position-absolute translate-middle shadow-lg"
                :style="`top: 28px; left: ${
                    !sidebar
                        ? 'calc(10px + var(--kt-app-sidebar-width))'
                        : '100%'
                }; `"
            >
                <span
                    style="transition: 0.4s all ease"
                    :class="`svg-icon svg-icon-2 ${!sidebar && 'rotate-180'}`"
                >
                    <svg
                        width="24"
                        height="24"
                        viewBox="0 0 24 24"
                        fill="none"
                        xmlns="http://www.w3.org/2000/svg"
                    >
                        <path
                            opacity="0.5"
                            d="M14.2657 11.4343L18.45 7.25C18.8642 6.83579 18.8642 6.16421 18.45 5.75C18.0358 5.33579 17.3642 5.33579 16.95 5.75L11.4071 11.2929C11.0166 11.6834 11.0166 12.3166 11.4071 12.7071L16.95 18.25C17.3642 18.6642 18.0358 18.6642 18.45 18.25C18.8642 17.8358 18.8642 17.1642 18.45 16.75L14.2657 12.5657C13.9533 12.2533 13.9533 11.7467 14.2657 11.4343Z"
                            fill="currentColor"
                        ></path>
                        <path
                            d="M8.2657 11.4343L12.45 7.25C12.8642 6.83579 12.8642 6.16421 12.45 5.75C12.0358 5.33579 11.3642 5.33579 10.95 5.75L5.40712 11.2929C5.01659 11.6834 5.01659 12.3166 5.40712 12.7071L10.95 18.25C11.3642 18.6642 12.0358 18.6642 12.45 18.25C12.8642 17.8358 12.8642 17.1642 12.45 16.75L8.2657 12.5657C7.95328 12.2533 7.95328 11.7467 8.2657 11.4343Z"
                            fill="currentColor"
                        ></path>
                    </svg>
                </span>
            </button>
        </div>
        <div class="app-sidebar-menu overflow-hidden flex-column-fluid">
            <div class="app-sidebar-wrapper">
                <div class="scroll customscrollbar my-5 h-100">
                    <div
                        class="menu menu-column menu-rounded menu-sub-indention px-3"
                    >
                        <div
                            class="menu-item m-0"
                            v-for="(navigation, index) in navigations"
                            :key="index"
                        >
                            <Link
                                :class="` ${
                                    navigation.route === route().current()
                                        ? 'menu-link m-0 active'
                                        : 'menu-link m-0'
                                } `"
                                v-if="
                                    navigation?.role?.includes(
                                        $page?.props?.ziggy?.user?.role?.role
                                            ?.slug
                                    )
                                "
                                :href="navigation.link"
                            >
                                <i :class="`${navigation.icon} mx-2 fs-2`"></i>
                                {{ navigation.title }}
                            </Link>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="app-sidebar-footer flex-column-auto m-0 pb-6 px-6">
            <form method="post" @submit.prevent="logout">
                <button
                    type="submit"
                    class="btn btn-flex flex-center btn-danger overflow-hidden text-nowrap px-0 h-40px w-100"
                >
                    <span class="btn-label me-3">Logout</span>
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        xmlns:xlink="http://www.w3.org/1999/xlink"
                        fill="#ffffff"
                        width="14" height="14"
                        version="1.1"
                        id="Capa_1"
                        viewBox="0 0 384.971 384.971"
                        xml:space="preserve"
                    >
                        <g>
                            <g id="Sign_Out">
                                <path
                                    d="M180.455,360.91H24.061V24.061h156.394c6.641,0,12.03-5.39,12.03-12.03s-5.39-12.03-12.03-12.03H12.03    C5.39,0.001,0,5.39,0,12.031V372.94c0,6.641,5.39,12.03,12.03,12.03h168.424c6.641,0,12.03-5.39,12.03-12.03    C192.485,366.299,187.095,360.91,180.455,360.91z"
                                />
                                <path
                                    d="M381.481,184.088l-83.009-84.2c-4.704-4.752-12.319-4.74-17.011,0c-4.704,4.74-4.704,12.439,0,17.179l62.558,63.46H96.279    c-6.641,0-12.03,5.438-12.03,12.151c0,6.713,5.39,12.151,12.03,12.151h247.74l-62.558,63.46c-4.704,4.752-4.704,12.439,0,17.179    c4.704,4.752,12.319,4.752,17.011,0l82.997-84.2C386.113,196.588,386.161,188.756,381.481,184.088z"
                                />
                            </g>
                        </g>
                    </svg>
                </button>
            </form>
        </div>
    </div>
</template>
