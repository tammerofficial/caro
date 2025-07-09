<template>
    <div class="widget widget_product_list">
        <div class="widget-title-two d-flex align-items-center mb-0">
            <base-icon-svg :name="icon" :height="30" :width="30" />
            <h4 class="mb-0">{{ title }}</h4>
        </div>

        <ul
            v-if="products.length"
            class="products-list"
            :class="{ 'list-underlined': listUnderlined }"
        >
            <li v-for="(product, index) in products" :key="`product-${index}`">
                <single-product
                    :key="`banner-product-${index}`"
                    :item="product"
                    :style-two="productStyleTwo"
                    small
                />
            </li>
        </ul>
    </div>
</template>

<script>
import SingleProduct from '../product/SingleProduct.vue'
export default {
    name: 'WidgetProductList',
    components: {
        SingleProduct,
    },
    props: {
        icon: {
            type: String,
            default: 'dubbleStar',
        },
        title: {
            type: String,
            default: 'Special Offers',
        },
        products: {
            type: Array,
            default: () => [],
        },
        productStyleTwo: {
            type: Boolean,
            default: false,
        },
        listUnderlined: {
            type: Boolean,
            default: false,
        },
    },
}
</script>
