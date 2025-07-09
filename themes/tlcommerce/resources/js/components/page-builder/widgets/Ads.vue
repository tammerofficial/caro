<template>
    <a :href="imageLink()" :target="imageTarget()">
        <v-lazy-image :src="imageSrc()" alt="Ads Image" />
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
         * Image Src 
         */
         imageSrc() {
            return this.properties['ads_image'] ?? '';
        },

        /**
         * Image Link
         */
        imageLink() {
            return this.properties['ads_url'] ?? '/';
        },

        /**
         * Image Target
         */
        imageTarget() {
            return this.properties['new_window'] && this.properties['new_window'] == '1' ? '_blank' : '_self';
        }
    },
};
</script>
