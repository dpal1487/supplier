<script>
import { defineComponent } from "vue";
import { Link } from "@inertiajs/inertia-vue3";
export default defineComponent({
    props: ["projects"],
    components: {
        Link,
    },
});
</script>

<template>
    <div class="card my-5">
        <div class="card-header pt-7">
            <h3 class="card-title align-items-start flex-column">
                <span class="card-label fw-bold text-gray-800 align-middle mb-4">Categories</span>
            </h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4 mb-5">
                    <div class="card card-flush bgi-no-repeat bgi-size-contain bgi-position-x-end" style="
                            background-color: #298356;
                            height: 150px;
                        ">
                        <div class="card-header p-5">
                            <div class="card-title d-flex flex-column">
                                <span class="fs-2hx fw-bold text-white me-2 lh-1 ls-n2">{{ projects?.total_projects
                                    }}</span>
                                <span class="text-white opacity-75 pt-1 fw-semibold fs-6">Projects</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-5">
                    <div class="card card-flush bgi-no-repeat bgi-size-contain bgi-position-x-end" style="
                            background-color: #7f41f1;
                            height: 150px;
                        ">
                        <div class="card-header p-5">
                            <div class="card-title d-flex flex-column">
                                <span class="fs-2hx fw-bold text-white me-2 lh-1 ls-n2">{{ projects.total_clicks
                                    }}</span>
                                <span class="text-white opacity-75 pt-1 fw-semibold fs-6">Total Click</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card card-flush bgi-no-repeat bgi-size-contain bgi-position-x-end" style="
                                background-color: #f1416c;
                                height: 150px;
                            ">
                        <div class="card-header p-5">
                            <div class="card-title d-flex flex-column">
                                <span class="fs-2hx fw-bold text-white me-2 lh-1 ls-n2">{{ projects.completes
                                    }}</span>
                                <span class="text-white opacity-75 pt-1 fw-semibold fs-6">Total Complete</span>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- <div class="col-md-3">
                    <div class="card card-flush bgi-no-repeat bgi-size-contain bgi-position-x-end" style="
                            background-color: #f18741;
                            background-image: url('/assets/media/patterns/vector-1.png');
                            height: 150px;
                        ">
                        <div class="card-header p-5">
                            <div class="card-title d-flex flex-column">
                                <span class="fs-2hx fw-bold text-white me-2 lh-1 ls-n2">{{ projects.closed_projects
                                    }}</span>
                                <span class="text-white opacity-75 pt-1 fw-semibold fs-6">Total Revenue</span>
                            </div>
                        </div>
                    </div>
                </div> -->
            </div>
        </div>
    </div>
</template>
