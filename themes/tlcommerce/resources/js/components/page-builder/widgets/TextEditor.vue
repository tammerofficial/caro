<template>
    <div v-html="properties['text_content_t_']"></div>
</template>

<script>
export default {
    name: "TextEditor",
    props: {
        properties: {
            type: Object,
            default: {},
        }
    },
};
</script>
