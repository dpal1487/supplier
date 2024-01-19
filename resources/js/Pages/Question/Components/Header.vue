
<script>
import { defineComponent } from "vue";
import { Link } from "@inertiajs/inertia-vue3";
import Vue3autocounter from 'vue3-autocounter';
export default defineComponent({
    props: ['question', 'answers'],
    components: {
        Link,
        Vue3autocounter
    },
    data() {
        return {
            value: this.answers.data.length,
            result: '',
        }

    },
});
</script>
<template>
    <div class="card mb-5 mb-xl-5">
        <div class="card-body pt-5 pb-0">
            <div class="d-flex flex-wrap flex-sm-nowrap mb-3">
                <div class="flex-grow-1">
                    <div class="fs-2 fw-bold m-2">
                        <span class="text-gray-700 text-capitalize">{{ question?.question_key }}</span>
                    </div>
                    <div class="d-flex flex-wrap flex-stack mx-3">
                        <div class="d-flex flex-column flex-grow-1">
                            <div class="d-flex flex-wrap">
                                <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 mb-2">
                                    <div class="d-flex align-items-center">
                                        <div class="fs-2 fw-bold mx-2">
                                            <Vue3autocounter ref='counter' :startAmount='0' :endAmount=value :duration='1'
                                                separator=',' :autoinit='true' />
                                        </div>
                                    </div>
                                    <div class="fw-bold fs-6 text-gray-900">Answwers</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
