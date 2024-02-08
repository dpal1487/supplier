<script>
import { defineComponent } from 'vue';

export default defineComponent({
    props: {
        type: {
            type: String,
            default: "Submit"
        }
    }
})
</script>
<template>
    <button :type="type" class="btn btn-primary text-uppercase">
        <slot></slot>
    </button>
</template>

