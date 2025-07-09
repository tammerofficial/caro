<template>
    <div v-html="createTag(properties.tag, properties.heading_text_t_)"></div>
</template>

<script>
export default {
    name: "HeadingTag",
    props: {
        properties: {
            type: Object,
            default: {},
        }
    },
    mounted() {
        
    },
    methods: {
        /**
         * Make Tag
         */
        createTag(tag, text){
            return `<${tag}> ${text} </${tag}>`;
        }
    },
};
</script>
