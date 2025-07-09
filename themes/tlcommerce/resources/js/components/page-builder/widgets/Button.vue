<template>
    <a :href="url" :target="target" :class="'text-center ' + justify">{{ text }}</a>
</template>

<script>
export default {
    name: "HeadingTag",
    data() {
        return {
            url: '#',
            target: '',
            justify: '',
            text: ''
        }
    },
    props: {
        properties: {
            type: Object,
            default: {},
        }
    },

    mounted() {
        this.url = this.properties['button_url'] ?? this.url;
        this.target = this.properties['new_window'] && this.properties['new_window'] == 1 ? '_blank' : '_self';
        this.justify = this.properties['alignment'] && this.properties['alignment'] == 'justify' ? 'd-block' : '';
        this.text = this.properties['button_text_t_'] ?? this.text;
    },
};
</script>
