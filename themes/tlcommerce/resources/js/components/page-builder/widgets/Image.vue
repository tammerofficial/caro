<template>
    
    <v-lazy-image :src="imageSrc()" alt="Image" v-if="notLink()" />

    <a :href="imageLink()" :target="imageTarget()" v-else>
        <v-lazy-image :src="imageSrc()" alt="Image" />
    </a>

</template>

<script>
import VLazyImage from "v-lazy-image";

export default {
    name: "Image",

    components: {
        "v-lazy-image": VLazyImage,
    },

    props: {
        properties: {
            type: Object,
            default: {},
        }
    },

    methods: {
        /**
         * Image Link
         */
         notLink() {
            return !this.properties['link'] || (this.properties['link'] && this.properties['link'] == 'none');
        },

        /**
         * Image Src 
         */
        imageSrc() {
            return this.properties['widget_image'] ?? '';
        },

        /**
         * Image Link
         */
        imageLink() {
            return this.properties['link'] == 'media_file' ? this.properties['widget_image'] : this.properties['link_url'];
        },

        /**
         * Image Target
         */
        imageTarget() {
            return this.properties['link'] == 'custom_url' && this.properties['new_window'] == '1' ? '_blank' : '_self';
        }
    },
};
</script>
