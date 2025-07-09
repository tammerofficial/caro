<template>
  <Dashboard>
    <page-header class="py-3 mb-3" whiteBg :items="bItems" />
    <template v-if="!loading">
      <div class="order_details" v-if="orderDetails != NULL">
        <div
          class="shadow-card mb-3 p-3"
          v-if="orderDetails.payment_required == enums.status.ACTIVE"
        >
          <div class="row">
            <div class="col-12 text-center">
              <p>{{ $t("Payment is incomplete") }}</p>
              <button
                class="btn btn-sm"
                :disabled="payment_processing"
                @click.prevent="PayNow"
              >
                <span v-if="payment_processing">
                  <CSpinner component="span" size="sm" aria-hidden="true" />
                  {{ $t("Please wait") }}
                </span>
                <span v-else>
                  {{ $t("Pay Now") }}
                </span>
              </button>
            </div>
          </div>
        </div>
        <!--Order details header-->
        <div class="shadow-card mb-3 p-3">
          <div class="row">
            <div class="col-12 col-lg-6">
              <h6>{{ $t("Order ID") }} : {{ orderDetails.order_code }}</h6>
              <p class="breadcrumb-item active">
                {{ $t("Order Placed on") }} {{ orderDetails.order_date }}
              </p>
            </div>
            <div
              class="align-items-center col-12 col-lg-6 d-flex justify-content-lg-end"
            >
              <h6 class="mb-0">
                {{ $t("Total") }} :
                <the-currency
                  :amount="orderDetails.total_payable_amount"
                ></the-currency>
              </h6>
              <button
                class="btn btn-sm fz-14 ml-10"
                v-if="
                  orderDetails.can_cancel == enums.status.ACTIVE &&
                  orderDetails.delivery_status !=
                    enums.order_delivery_status.CANCELLED
                "
                @click.prevent="cancelOrder"
              >
                {{ $t("Cancel Order") }}
              </button>
            </div>
          </div>
        </div>
        <!--End order details header-->
        <!--Product list-->
        <div
          class="row"
          v-for="(product, index) in orderDetails.products.data"
          :key="index"
        >
          <div class="col-12">
            <div class="shadow-card mb-30 p-0">
              <div
                class="border-bottom d-flex justify-content-between p-3 pb-2"
              >
                <h5>
                  {{ $t("Package ") + (index + 1) }}
                </h5>
              </div>
              <div class="p-3">
                <div
                  class="row px-12"
                  v-if="
                    product.delivery_status !=
                    enums.order_delivery_status.CANCELLED
                  "
                >
                  <!--Shipping info-->
                  <div class="col-md-12">
                    <div class="order-info d-flex justify-content-between">
                      <!--Delivery time-->
                      <div
                        class="delivery-time"
                        v-if="
                          product.delivery_status !=
                          enums.order_delivery_status.DELIVERED
                        "
                      >
                        <span v-if="product.estimate_delivery_time != null">
                          {{ $t("Estimated Delivery By") }}
                          {{ product.estimate_delivery_time }}
                        </span>
                      </div>
                      <div class="delivery-time" v-else>
                        <span v-if="product.delivered_date != null">
                          {{ $t("Delivered On") }} {{ product.delivered_date }}
                        </span>
                      </div>
                      <!--End delivery time-->
                      <!--Shipping method-->
                      <div
                        class="shipping-method"
                        v-if="orderDetails.pickup_point == null"
                      >
                        {{ $t("Shipping") }}:
                        <span>
                          <the-currency
                            :amount="product.shipping_cost"
                            v-if="product.shipping_cost"
                          >
                          </the-currency>
                        </span>
                        <span v-if="product.shipping != null">
                          ({{ product.shipping["name"] }}
                          <span v-if="product.shipping['via']">
                            {{ $t("via") }} {{ product.shipping["via"] }}
                          </span>
                          )
                        </span>
                        <span v-else> N/A </span>
                      </div>
                      <div class="shipping-method" v-else>
                        <span>{{ $t("Local Pickup") }}</span>
                      </div>
                      <!--End shipping method-->
                    </div>
                  </div>
                  <!--End shipping info-->
                  <!--Order status and tracking history-->
                  <div class="col-12">
                    <div class="order-status-range d-none d-lg-block">
                      <order-steps
                        :status="product.delivery_status"
                      ></order-steps>
                    </div>

                    <order-tracking
                      v-if="product.tracking_list.length > 0"
                      :items="product.tracking_list"
                    ></order-tracking>
                  </div>
                </div>
                <div class="row px-4" v-else>
                  <p class="alert alert-danger">
                    {{ $t("This item has been cancelled") }}
                  </p>
                </div>
                <!--End Order status and  tracking history-->
                <!--Product details-->
                <div class="row px-12">
                  <div class="col-md-12">
                    <div class="product-list-group">
                      <div class="product-list p-3 border">
                        <div class="row gy-10 align-items-center">
                          <div class="col-md-6">
                            <div class="d-flex align-items-center">
                              <router-link
                                :to="`/products/${product.permalink}`"
                              >
                                <img
                                  :src="product.image"
                                  :alt="product.name"
                                  class="cart-image mr-10 rounded-circle"
                                />
                              </router-link>
                              <div class="item-info">
                                <!--Item Name-->
                                <router-link
                                  :title="`${product.name}`"
                                  :to="`/products/${product.permalink}`"
                                  class="cart-product-name product-name text-capitalize"
                                >
                                  {{ product.name }}
                                </router-link>
                                <!--End Item Name-->
                                <!--Variant-->
                                <div
                                  class="product-variant extra-addons-wrap d-flex flex-wrap"
                                  v-if="product.variant != null"
                                >
                                  <product-variant
                                    class="font-weight-medium fz-12"
                                    :variant="product.variant"
                                    tag="p"
                                  ></product-variant>
                                </div>
                                <!--End Variant-->
                                <a
                                  :href="product.attachment"
                                  target="_blank"
                                  v-if="product.attachment"
                                  class="btn-link fz-12"
                                >
                                  {{ $t("View Attachment") }}
                                </a>
                                <!--Shop-->
                                <div
                                  class="extra-addons-wrap d-flex flex-wrap"
                                  v-if="product.shop != null"
                                >
                                  <p class="product-shop fz-12">
                                    {{ $t("Sold By") }}
                                    <router-link
                                      :to="`/shop/${product.shop.shop_slug}`"
                                      target="_blank"
                                      class="link-danger"
                                    >
                                      {{ product.shop.shop_name }}
                                    </router-link>
                                  </p>
                                </div>
                                <!--End shop-->
                              </div>
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div
                              class="align-items-center d-flex justify-content-between right-info"
                            >
                              <div class="price">
                                <the-currency
                                  :amount="product.unit_price"
                                ></the-currency>
                                <span>x{{ product.quantity }}</span>
                              </div>
                              <div class="price">
                                <the-currency
                                  :amount="
                                    product.unit_price * product.quantity
                                  "
                                ></the-currency>
                              </div>
                              <div
                                class="order-action-area"
                                v-if="
                                  product.delivery_status ==
                                  enums.order_delivery_status.DELIVERED
                                "
                              >
                                <!--Refund-->
                                <div class="refund-action-area">
                                  <a
                                    class="write-review"
                                    href="#"
                                    role="button"
                                    v-if="
                                      product.can_return == enums.status.ACTIVE
                                    "
                                    @click.prevent="returnProduct(product.id)"
                                  >
                                    {{ $t("Return") }} / {{ $t("Refund") }}
                                  </a>
                                  <div v-else class="mb-0">
                                    <button
                                      class="write-review disable border-0 p-0 text-uppercase"
                                      title="Return not available"
                                      v-if="
                                        product.return_status.status ==
                                        enums.order_return_status.NOT_AVAILABLE
                                      "
                                      :disabled="
                                        product.return_status.status ==
                                        enums.order_return_status.NOT_AVAILABLE
                                      "
                                    >
                                      {{ $t("Return") }} / {{ $t("Refund") }}
                                    </button>
                                    <p
                                      class="text-capitalize"
                                      :class="product.return_status.class"
                                      v-else
                                    >
                                      {{ product.return_status.label }}
                                    </p>
                                  </div>
                                </div>
                                <!--End Refund-->
                                <!--Review-->
                                <div class="review-action-area">
                                  <a
                                    class="write-review text-uppercase"
                                    href="#"
                                    role="button"
                                    v-if="
                                      product_config.enable_product_reviews ==
                                      enums.status.ACTIVE
                                    "
                                    @click.prevent="
                                      productReview(product.product_id)
                                    "
                                  >
                                    {{ $t("Write a review") }}
                                  </a>
                                </div>
                                <!--End Review-->
                              </div>
                              <div
                                class="order-action-area button"
                                v-if="product.can_cancel == enums.status.ACTIVE"
                              >
                                <button
                                  v-if="
                                    product.can_cancel == enums.status.ACTIVE
                                  "
                                  class="btn btn-sm btn_border fz-14"
                                  title="Cancel item"
                                  :disabled="
                                    product.can_cancel == enums.status.IN_ACTIVE
                                  "
                                  @click.prevent="cancelProduct(product.id)"
                                >
                                  {{ $t("Cancel Order") }}
                                </button>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <!--End product details-->
              </div>
            </div>
          </div>
        </div>
        <!--End product list-->
        <!--Order summery-->
        <div class="row">
          <div class="col-12 col-lg-6">
            <!--Shipping Address-->
            <div class="shadow-card mb-30 p-3">
              <h5 class="order-summery-title">
                {{
                  orderDetails.pickup_point == null
                    ? $t("Shipping Address")
                    : $t("Pickup Point Address")
                }}
              </h5>
              <div class="row">
                <div
                  class="col-lg-12 mt-2 mt-lg-0"
                  v-if="orderDetails.pickup_point == null"
                >
                  <template v-if="orderDetails.shipping_details != null">
                    <p>
                      {{ orderDetails.shipping_details.name }}
                    </p>
                    <p>
                      {{ orderDetails.shipping_details.phone }}
                    </p>
                    <p>
                      <span v-if="orderDetails.shipping_details.address != null"
                        >{{ orderDetails.shipping_details.address }},</span
                      >
                      <span v-if="orderDetails.shipping_details.city != null"
                        >{{ orderDetails.shipping_details.city }},</span
                      >
                      <span v-if="orderDetails.shipping_details.state != null"
                        >{{ orderDetails.shipping_details.state }},</span
                      >
                      <span v-if="orderDetails.shipping_details.country != null"
                        >{{ orderDetails.shipping_details.country }}.</span
                      >
                    </p>
                  </template>
                  <template v-else>
                    <p>{{ $t("Address not found") }}</p>
                  </template>
                </div>
                <div class="col-lg-12 mt-2 mt-lg-0" v-else>
                  <p>
                    {{ orderDetails.pickup_point.name }}
                  </p>
                  <p>
                    {{ orderDetails.pickup_point.phone }}
                  </p>
                  <p>
                    {{ orderDetails.pickup_point.location }}
                  </p>
                </div>
              </div>
            </div>
            <!--End shipping address-->
            <!--Billing address-->
            <div
              class="shadow-card mb-30 p-3"
              v-if="orderDetails.billing_details != null"
            >
              <h5 class="order-summery-title">{{ $t("Billing Address") }}</h5>
              <div class="row">
                <div
                  class="col-lg-12 mt-2 mt-lg-0"
                  v-if="orderDetails.billing_details != null"
                >
                  <p>
                    {{ orderDetails.billing_details.name }}
                  </p>
                  <p>{{ orderDetails.billing_details.phone }}</p>
                  <p>
                    <span v-if="orderDetails.billing_details.address != null"
                      >{{ orderDetails.billing_details.address }},</span
                    >
                    <span v-if="orderDetails.billing_details.city != null"
                      >{{ orderDetails.billing_details.city }},</span
                    >
                    <span v-if="orderDetails.billing_details.state != null"
                      >{{ orderDetails.billing_details.state }},</span
                    >
                    <span v-if="orderDetails.billing_details.country != null"
                      >{{ orderDetails.billing_details.country }}.</span
                    >
                  </p>
                </div>
              </div>
            </div>
            <!--End Billing address-->
          </div>
          <!--Total Summary-->
          <div class="col-12 col-lg-6">
            <div class="shadow-card mb-30 p-3">
              <h5 class="order-summery-title">{{ $t("Total Summary") }}</h5>
              <div class="row">
                <div class="col-lg-12 mt-2 mt-lg-0">
                  <div class="table-responsive">
                    <table class="shop_table w-100">
                      <tbody>
                        <tr class="cart-subtotal">
                          <td>{{ $t("Subtotal") }}</td>
                          <td class="td-right">
                            <the-currency
                              :amount="orderDetails.sub_total"
                            ></the-currency>
                          </td>
                        </tr>
                        <tr class="shipping-cost">
                          <td>{{ $t("Shipping Cost") }}</td>
                          <td class="td-right">
                            <span>+</span>
                            <the-currency
                              :amount="orderDetails.total_delivery_cost"
                            ></the-currency>
                          </td>
                        </tr>
                        <tr
                          class="order-tax border-bottom"
                          v-if="orderDetails.total_tax > 0"
                        >
                          <td>
                            {{ $t("Tax") }}
                          </td>
                          <td class="td-right">
                            <span>+</span>
                            <the-currency
                              :amount="orderDetails.total_tax"
                            ></the-currency>
                          </td>
                        </tr>
                        <tr
                          class="order-savings"
                          v-if="orderDetails.total_discount > 0"
                        >
                          <td>
                            {{ $t("Discount") }}
                          </td>
                          <td class="td-right">
                            <span>-</span>
                            <the-currency
                              :amount="orderDetails.total_discount"
                            ></the-currency>
                          </td>
                        </tr>

                        <tr class="order-total">
                          <td class="font-weight-bold">{{ $t("Total") }}</td>
                          <td class="td-right font-weight-bold">
                            <the-currency
                              :amount="orderDetails.total_payable_amount"
                            ></the-currency>
                          </td>
                        </tr>
                        <tr>
                          <p class="mt-3">
                            {{
                              orderDetails.payment_status == enums.status.ACTIVE
                                ? $t("Paid by")
                                : $t("Payment method")
                            }}
                            {{ orderDetails.payment_method }}
                          </p>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
            <div class="shadow-card mb-30 p-3" v-if="orderDetails.note">
              <h5 class="order-summery-title">{{ $t("Note") }}</h5>
              <div class="row">
                <div class="col-lg-12 mt-2 mt-lg-0">
                  <p>{{ orderDetails.note }}</p>
                </div>
              </div>
            </div>
          </div>
          <!--End Total Summary-->
        </div>
        <!--End order summery-->
      </div>
      <the-not-found v-else title="Order details not found"></the-not-found>
    </template>
    <template v-if="loading">
      <skeleton class="w-100 mb-20" height="70px"></skeleton>
      <skeleton class="w-100" height="500px"></skeleton>
    </template>

    <!--Product review modal-->
    <CModal
      :visible="visibleProductReviewModal"
      size="lg"
      @close="
        () => {
          visibleProductReviewModal = false;
        }
      "
    >
      <CModalHeader>
        <CModalTitle>{{ $t("Review product") }}</CModalTitle>
        <button
          class="btn-circle bg-black size-35"
          @click="
            () => {
              visibleProductReviewModal = false;
            }
          "
        >
          <base-icon-svg name="close" :width="10" :height="10" />
        </button>
      </CModalHeader>
      <CModalBody>
        <div
          class="row mb-20"
          v-if="
            product_config.enable_product_star_rating == enums.status.ACTIVE
          "
        >
          <div class="form-group col-12">
            <label class="font-weight-bold fz-12 mb-2">
              {{ $t("Rating") }}
            </label>
            <div class="stars-wrapper">
              <ul class="stars list-unstyled mb-0">
                <li
                  class="d-inline-block"
                  v-for="star in 5"
                  :key="star"
                  :class="[`star star-${star}`, { active: star <= rating }]"
                  @click="rate(star)"
                >
                  <span class="material-icons"> star </span>
                </li>
                <span class="rating">{{ rating }}</span>
              </ul>
            </div>
            <template v-if="errors.rating">
              <p
                class="fz-12 text-danger mt-1"
                v-for="(error, index) in errors.rating"
                :key="index"
              >
                {{ error }}
              </p>
            </template>
          </div>
        </div>
        <div class="row mb-20">
          <div class="form-group col-12">
            <label class="font-weight-bold fz-12 mb-2">
              {{ $t("Write a review") }}
              <span class="text-danger">*</span></label
            >
            <textarea class="theme-input-style" v-model="review"> </textarea>
            <template v-if="errors.review">
              <p
                class="fz-12 text-danger mt-1"
                v-for="(error, index) in errors.review"
                :key="index"
              >
                {{ error }}
              </p>
            </template>
          </div>
        </div>
        <div class="row mb-20">
          <div class="form-group col-12">
            <label class="font-weight-bold fz-12 mb-2">
              {{ $t("Images") }}
              <span class="text-danger">*</span></label
            >
            <base-file-input
              id="reviewImages"
              name="reviewImages"
              v-on:getFileInput="reviewImages($event)"
            />
            <template v-if="errors.review_images">
              <p
                class="fz-12 text-danger mt-1"
                v-for="(error, index) in errors.review_images"
                :key="index"
              >
                {{ error }}
              </p>
            </template>
          </div>
        </div>
      </CModalBody>
      <CModalFooter>
        <button
          class="btn btn_fill"
          @click.prevent="submitProductReview"
          :disabled="review_submitting"
        >
          <span v-if="review_submitting">
            <CSpinner component="span" size="sm" aria-hidden="true" />
            {{ $t("Please wait") }}
          </span>
          <span v-else>
            {{ $t("Submit") }}
          </span>
        </button>
      </CModalFooter>
    </CModal>
    <!--End product review modal-->
    <!--Product return modal-->
    <CModal
      :visible="visibleProductReturnModal"
      size="lg"
      @close="
        () => {
          visibleProductReturnModal = false;
        }
      "
    >
      <CModalHeader>
        <CModalTitle>{{ $t("Return product") }}</CModalTitle>
        <button
          class="btn-circle bg-black size-35"
          @click="
            () => {
              visibleProductReturnModal = false;
            }
          "
        >
          <base-icon-svg name="close" :width="10" :height="10" />
        </button>
      </CModalHeader>
      <CModalBody>
        <!--Product Details-->
        <div class="row mb-20">
          <div class="form-group col-12">
            <label class="font-weight-bold fz-12 mb-2">
              {{ $t("Product details") }}</label
            >
            <div class="product-list-group mt-0">
              <div class="product-list">
                <div class="row gy-10">
                  <div class="col-md-6">
                    <div class="product-info d-flex">
                      <div class="image">
                        <img
                          :src="returnItem.image"
                          :alt="returnItem.name"
                          class="cart-image"
                        />
                      </div>
                      <div class="title">
                        <h5>
                          {{ returnItem.name }}
                        </h5>
                        <product-variant
                          v-if="returnItem.variant"
                          tag="p"
                          class="mb-0"
                          :variant="returnItem.variant"
                        ></product-variant>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="right-info d-flex justify-content-between">
                      <div class="price">
                        <the-currency
                          :amount="returnItem.unit_price"
                        ></the-currency>
                      </div>
                      <div class="quantity">
                        {{ $t("Qty") }}: {{ returnItem.quantity }}
                      </div>
                      <div class="quantity">
                        {{ $t("Total") }}:<the-currency
                          :amount="returnItem.unit_price * returnItem.quantity"
                        ></the-currency>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!--End Product Details-->
        <!--Refund reason-->
        <div class="row mb-20">
          <div class="form-group col-12">
            <label class="font-weight-bold fz-12 mb-2">
              {{ $t("Refund Reason") }}
              <span class="text-danger">*</span></label
            >
            <select
              class="theme-input-style p-0"
              v-model="refund_reason"
              placeholder="Select a refund reason"
            >
              <option
                v-for="(reason, index) in all_refund_reasons"
                :key="index"
                :value="reason.id"
              >
                {{ reason.name }}
              </option>
            </select>
            <template v-if="errors.refund_reason">
              <p
                class="fz-12 text-danger mt-1"
                v-for="(error, index) in errors.refund_reason"
                :key="index"
              >
                {{ error }}
              </p>
            </template>
          </div>
        </div>
        <!--End refund reason-->
        <!--Comment-->
        <div class="row mb-20">
          <div class="form-group col-12">
            <label class="font-weight-bold fz-12 mb-2">
              {{ $t("Write comment") }}
            </label>
            <textarea class="theme-input-style" v-model="refund_comment">
            </textarea>
            <template v-if="errors.refund_comment">
              <p
                class="fz-12 text-danger mt-1"
                v-for="(error, index) in errors.refund_comment"
                :key="index"
              >
                {{ error }}
              </p>
            </template>
          </div>
        </div>
        <!--End Comment-->
        <!--Images-->
        <div class="row mb-20">
          <div class="form-group col-12">
            <label class="font-weight-bold fz-12 mb-2">
              {{ $t("Images") }}
            </label>
            <base-file-input
              id="reviewImages"
              name="reviewImages"
              v-on:getFileInput="returnImages($event)"
            />
            <template v-if="errors.return_images">
              <p
                class="fz-12 text-danger mt-1"
                v-for="(error, index) in errors.return_images"
                :key="index"
              >
                {{ error }}
              </p>
            </template>
          </div>
        </div>
        <!--End Images-->
      </CModalBody>
      <CModalFooter>
        <button
          class="btn btn_fill"
          @click.prevent="submitProductReturn"
          :disabled="return_submitting"
        >
          <span v-if="return_submitting">
            <CSpinner component="span" size="sm" aria-hidden="true" />
            {{ $t("Please wait") }}
          </span>
          <span v-else>
            {{ $t("Submit") }}
          </span>
        </button>
      </CModalFooter>
    </CModal>
    <!--End product return modal--->
    <!--Order cancel modal-->
    <CModal
      :visible="visibleOrderCancelModal"
      size="sm"
      @close="
        () => {
          visibleOrderCancelModal = false;
        }
      "
    >
      <CModalHeader>
        <CModalTitle>{{ $t("Order Cancel Confirmation") }}</CModalTitle>
        <button
          class="btn-circle bg-black size-35"
          @click="
            () => {
              visibleOrderCancelModal = false;
            }
          "
        >
          <base-icon-svg name="close" :width="10" :height="10" />
        </button>
      </CModalHeader>
      <CModalBody>
        <div class="text-center">
          <p>{{ $t("Are you sure to cancel this order") }}</p>
          <button
            class="btn btn_fill mt-20 rounded-1"
            @click.prevent="confirmCancelOrder"
          >
            {{ $t("Confirm") }}
          </button>
        </div>
      </CModalBody>
    </CModal>
    <!--End product return modal--->
  </Dashboard>
</template>

<script>
import PageHeader from "@/components/pageheader/PageHeader.vue";
import ShowingPerPage from "@/components/ui/ShowingPerPage.vue";
import Dashboard from "@/views/dashboard.vue";
import OrderTracking from "../../../components/ui/OrderTracking.vue";
import OrderSteps from "../../../components/ui/OrderSteps.vue";
import ProductVariant from "@/components/ui/ProductVariant.vue";
import enums from "../../../enums/enums";
import axios from "axios";
import { mapState } from "vuex";
import { CSpinner } from "@coreui/vue";
import {
  CDropdown,
  CDropdownToggle,
  CModal,
  CModalHeader,
  CModalTitle,
  CModalBody,
  CModalFooter,
} from "@coreui/vue";
export default {
  name: "OrderDetails",
  components: {
    ProductVariant,
    CSpinner,
    OrderSteps,
    PageHeader,
    ShowingPerPage,
    Dashboard,
    CDropdown,
    CDropdownToggle,
    CModal,
    CModalHeader,
    CModalTitle,
    CModalBody,
    CModalFooter,
    OrderTracking,
  },
  data() {
    return {
      pageTitle: "Purchase History",
      loading: false,
      success: false,
      bItems: [
        {
          text: this.$t("Home"),
          href: "/",
        },
        {
          text: this.$t("Dashboard"),
          href: "/dashboard",
        },
        {
          text: this.$t("Order Details"),
          active: true,
        },
      ],
      orderDetails: null,
      enums: enums,
      errors: [],
      visibleProductReviewModal: false,
      visibleProductReturnModal: false,
      visibleOrderCancelModal: false,
      review_product_id: "",
      rating: 5,
      review: "",
      review_images: [],
      return_images: [],
      refund_comment: "",
      all_refund_reasons: [],
      refund_reason: "",
      returnItem: "",
      cancelItem: "",
      review_submitting: false,
      return_submitting: false,
      payment_processing: false,
    };
  },
  watch: {
    perPage() {
      if (this.perPage == null) {
        this.perPage = this.totalRows;
      }
    },
  },
  computed: mapState({
    customerToken: (state) => state.customerToken,
    product_config: (state) => state.siteSettings,
  }),
  mounted() {
    document.title = this.$t("Dashboard") + " | " + this.$t("Order Details");
    this.getCustomerOrderDetails();
  },
  methods: {
    /**
     * Rating
     */
    rate(star) {
      if (typeof star === "number" && star <= 5 && star >= 1) {
        this.rating = this.rating === star ? star - 1 : star;
      }
    },
    /**
     * Get order details
     */
    getRefundReasons() {
      axios
        .get("/api/refund/v1/get-refund-reasons")
        .then((response) => {
          if (response.data.success) {
            this.all_refund_reasons = response.data.data;
          } else {
            this.all_refund_reasons = [];
          }
        })
        .catch((error) => {
          this.all_refund_reasons = [];
        });
    },

    /**
     * Get order details
     */
    getCustomerOrderDetails() {
      this.loading = true;
      axios
        .post(
          "/api/v1/ecommerce-core/customer/order/details",
          {
            order_id: this.$route.params.id,
          },
          {
            headers: {
              Authorization: `Bearer ${this.customerToken}`,
            },
          }
        )
        .then((response) => {
          if (response.data.success) {
            this.loading = false;
            this.orderDetails = response.data.data;
            this.success = true;
          } else {
            this.loading = false;
          }
        })
        .catch((error) => {
          this.loading = false;
        });
    },
    /**
     * Open product review popup
     */
    productReview(product_id) {
      this.review_product_id = product_id;
      this.visibleProductReviewModal = true;
    },
    /**
     * review image input value
     *
     * @param {*} e
     */
    reviewImages(e) {
      this.review_images = e;
    },
    /**
     * Store product review
     *
     */
    submitProductReview() {
      this.review_submitting = true;
      this.errors = [];
      let formData = new FormData();
      formData.append("product_id", this.review_product_id);
      formData.append("rating", this.rating);
      formData.append("order_id", this.orderDetails.id);
      formData.append("review", this.review);
      for (let z = 0; z < this.review_images.length; z++) {
        let file = this.review_images[z];
        formData.append("review_images[" + z + "]", file);
      }
      axios
        .post("/api/v1/ecommerce-core/customer/review-product", formData, {
          headers: {
            Authorization: `Bearer ${this.customerToken}`,
            "Content-Type": "multipart/form-data",
          },
        })
        .then((response) => {
          if (response.data.success) {
            this.review_submitting = false;
            this.visibleProductReviewModal = false;
            this.$toast.success(this.$t("Review submitted successfully"));
            this.review_product_id = "";
            this.rating = 5;
            this.review = "";
            this.review_images = [];
          } else {
            this.$toast.error(this.$t("Review submitted failed"));
          }
        })
        .catch((error) => {
          this.review_submitting = false;
          if (error.response.status == 422) {
            this.errors = error.response.data.errors;
          } else {
            this.$toast.error(this.$t("Review submitted failed"));
          }
        });
    },
    /**
     * Display product return modal
     */
    returnProduct(id) {
      this.getRefundReasons();
      let return_product = this.orderDetails.products.data.find(
        (product) => product.id == id
      );
      if (return_product) {
        this.returnItem = return_product;
        this.visibleProductReturnModal = true;
      }
    },
    /**
     * return product image input value
     */
    returnImages(e) {
      this.return_images = e;
    },
    /**
     * Submit product return
     */
    submitProductReturn() {
      this.return_submitting = true;
      this.errors = [];
      let formData = new FormData();
      formData.append("package_id", this.returnItem.id);
      formData.append("refund_comment", this.refund_comment);
      formData.append("refund_reason", this.refund_reason);
      for (let z = 0; z < this.return_images.length; z++) {
        let file = this.return_images[z];
        formData.append("return_images[" + z + "]", file);
      }
      axios
        .post("/api/v1/ecommerce-core/customer/order/return", formData, {
          headers: {
            Authorization: `Bearer ${this.customerToken}`,
            "Content-Type": "multipart/form-data",
          },
        })
        .then((response) => {
          if (response.data.success) {
            this.visibleProductReturnModal = false;
            this.getCustomerOrderDetails();
            this.$toast.success(
              this.$t("Product return request submitted successfully")
            );
            this.returnItem = null;
            this.refund_comment = "";
            this.return_images = [];
          } else {
            this.$toast.error(this.$t("Return request submit failed"));
          }
          this.return_submitting = false;
        })
        .catch((error) => {
          if (error.response.status == 422) {
            this.errors = error.response.data.errors;
          } else {
            this.$toast.error(this.$t("Return request submit failed"));
          }
          this.return_submitting = false;
        });
    },

    /**
     * Cancel single item from order
     *
     * @param {*} item_id
     */
    cancelProduct(item_id) {
      this.cancelItem = item_id;
      this.visibleOrderCancelModal = true;
    },
    /**
     * Will cancel order
     */
    cancelOrder() {
      this.visibleOrderCancelModal = true;
    },
    /**
     * Will confirm cancel order
     */
    confirmCancelOrder() {
      axios
        .post(
          "/api/v1/ecommerce-core/customer/cancel-order",
          {
            order_id: this.orderDetails.id,
            item_id: this.cancelItem,
          },
          {
            headers: {
              Authorization: `Bearer ${this.customerToken}`,
            },
          }
        )
        .then((response) => {
          this.visibleOrderCancelModal = false;
          if (response.data.success) {
            this.getCustomerOrderDetails();
            if (this.cancelItem != null) {
              this.cancelItem = "";
              this.$toast.success(this.$t("Item cancel successfully"));
            } else {
              this.$toast.success(this.$t("Order cancel successfully"));
            }
          } else {
            this.$toast.error(this.$t("Cancel order failed"));
          }
        })
        .catch((error) => {
          this.visibleOrderCancelModal = false;
          this.$toast.error(this.$t("Order cancel failed"));
        });
    },
    /**
     * Will generate order payment list
     */
    PayNow() {
      this.payment_processing = true;
      axios
        .post(
          "/api/v1/ecommerce-core/customer/make-order-payment",
          {
            order_id: this.orderDetails.id,
          },
          {
            headers: {
              Authorization: `Bearer ${this.customerToken}`,
            },
          }
        )
        .then((response) => {
          if (response.data.success) {
            window.location.href = response.data.link;
          } else {
            this.payment_processing = false;
            this.$toast.error(this.$t("Something went wrong"));
          }
        })
        .catch((error) => {
          this.payment_processing = false;
          this.$toast.error(this.$t("Something went wrong"));
        });
    },
  },
};
</script>

<style lang="scss" scoped>
@import "../../../assets/sass/00-abstracts/01-variables";
.order-info {
  flex-wrap: wrap;
  gap: 10px;
  padding: 0;
}
.px-12 {
  padding-inline: 12px;
}
.gy-10 {
  gap: 10px 0;
}
.product-list-group {
  margin-top: 45px;
}
.product-list:not(:last-child) {
  margin-bottom: 20px;
}
.product-list .product-info {
  gap: 10px;
}
.product-list .product-info .image {
  max-width: 100px;
}
.product-list .product-info .title h5 {
  display: block;
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
  overflow: hidden;
  text-overflow: ellipsis;
}
.product-list .product-info:not(:last-child) {
  margin-bottom: 10px;
}
.right-info .write-review {
  color: $c1;
  font-weight: 500;
}
.stars-wrapper .stars .star.active {
  color: #ffc107;
}
.stars-wrapper ul li span {
  font-size: 20px;
}
.stars-wrapper ul .rating {
  font-size: 20px;
  margin-left: 10px;
}
.td-right {
  text-align: right;
}

@media (max-width: 575px) {
  .right-info {
    flex-direction: column;
  }
}
.img70 {
  min-width: 70px !important;
  max-width: 70px !important;
}
.refund-action-area .disable {
  background-color: transparent;
  color: #9e9e9e !important;
}
.info {
  color: #17a2b8;
}
.warning {
  color: #e0a800;
}
.primary {
  color: #0069d9;
}
.success {
  color: #218838;
}
.danger {
  color: #c82333;
}
</style>
