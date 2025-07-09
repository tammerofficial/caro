<template>
    <span class="icon-wrapper">
        <svg
            class="icon"
            :width="width"
            :height="height"
        >
            <use
                v-bind="{
                    'xlink:href':
                        '/themes/tlcommerce/resources/js/assets/images/iconpack.svg#' +
                        name,
                }"
            />
        </svg>
    </span>
</template>

<script>
export default {
    name: "Icon",
    props: {
        name: {
            type: String,
            default: "",
        },
        width: {
            type: [Number, String],
            default: 14,
        },
        height: {
            type: [Number, String],
            default: 14,
        }
    },
};
</script>