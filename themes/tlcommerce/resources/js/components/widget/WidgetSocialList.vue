<template>
    <ul class="nav share-list">
        <li v-for="(social, index) in socialList" :key="`social-${index}`">
            <a
                :class="this.footerStyle.custom_footer==1?'custom-icon-style btn-circle size-35':'btn-circle bg-transparent size-35'"
                :href="social.social_icon_url"
                target="_blank"
            >
            <i :class="'fa '+social.social_icon"></i>
            </a>
        </li>
    </ul>
</template>

<script>
export default {
    name: "SocialList",
    props: {
        socialList: {
            type: Array,
            default: () => [
                {
                    social_icon_title: "facebook",
                    social_icon: "fa-facebook-f",
                    social_icon_url: "http://facebook.com",
                },
                {
                    social_icon_title: "twitter",
                    social_icon: "fa-twitter",
                    social_icon_url: "http://twitter.com",
                },
                {
                    social_icon_title: "pinterest",
                    social_icon: "fa-pinterest",
                    social_icon_url: "http://pinterest.com",
                },
                {
                    social_icon_title: "instagram",
                    social_icon: "fa-instagram",    
                    social_icon_url: "http://instagram.com",
                },
            ],
        },
        styleTwo: {
            type: Boolean,
            default: false,
        },
        footerStyle: {
            type: Object,
            required: false,
            default: () => {
                return {};
            },
        },
    },
};
</script>

<style scoped>
</style>