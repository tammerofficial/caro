<template>
  <div class="shadow-card mb-30">
    <div
      class="d-flex flex-wrap align-items-center justify-content-between mb-3"
    >
      <h3 class="checkout-title">{{ $t("Delivery & Shipping") }}</h3>
      <router-link
        to="/dashboard/address"
        class="btn_underline"
        v-if="isCustomerLogin"
        >{{ $t("Manage Address") }}</router-link
      >
    </div>

    <!--Delivery Options-->
    <div class="row mt-3">
      <div class="col-12">
        <ul
          class="form-selector-list hide-radio justify-content-between list-unstyled mb-3"
        >
          <li class="m-0 m-w-100 mb-3 single-form-selector">
            <span
              class="custom-radio-btn"
              :class="{ active: isActiveHomeDelivery }"
            >
              <label>
                <input
                  type="radio"
                  value="Pickup"
                  class="shipping-method delivery-type-pickup"
                  name="delivery-options"
                  :checked="isActiveHomeDelivery"
                  v-on:change="
                    () => {
                      isActiveHomeDelivery = true;
                      isActivePickupPoint = false;
                      errors = [];
                    }
                  "
                />
                <span class="icon-wrap"
                  ><span class="material-icons"> local_shipping </span></span
                >
                <span class="label-title">{{ $t("Home Delivery") }}</span>
              </label>
            </span>
          </li>
          <li
            class="m-0 m-w-100 mb-3 single-form-selector"
            v-if="
              config.enable_pickuppoint_in_checkout == enums.status.ACTIVE &&
              config.is_active_pickuppoint == enums.status.ACTIVE
            "
          >
            <span
              class="custom-radio-btn"
              :class="{ active: isActivePickupPoint }"
            >
              <label>
                <input
                  type="radio"
                  value="Delivery"
                  class="shipping-method delivery-type-delivery"
                  name="delivery-options"
                  :checked="isActivePickupPoint"
                  v-on:change="
                    () => {
                      isActiveHomeDelivery = false;
                      isActivePickupPoint = true;
                      errors = [];
                    }
                  "
                />
                <span class="icon-wrap"
                  ><span class="material-icons">
                    store_mall_directory
                  </span></span
                >
                <span class="label-title">{{ $t("Collect From Store") }}</span>
              </label>
            </span>
          </li>
        </ul>
      </div>
    </div>
    <!--End Delivery Options-->

    <!--Home Delivery-->
    <template v-if="isActiveHomeDelivery">
      <!--Login user Checkout-->
      <div v-if="isCustomerLogin">
        <!--Shipping Address-->
        <div class="row" v-if="isActiveHomeDelivery">
          <div class="col-12">
            <h5>{{ $t("Shipping Details") }}</h5>
            <div class="save-adderss row" v-if="customerAddress.length > 0">
              <div
                class="col-lg-12 mb-4"
                v-for="address in customerAddress"
                :key="address.name"
              >
                <span
                  class="custom-radio-btn"
                  ref="addressRadio"
                  :class="{
                    active:
                      customerShippingInfo != null &&
                      address.id == customerShippingInfo.id,
                  }"
                >
                  <label class="radio-label">
                    <input
                      name="customerShippingAddress"
                      type="radio"
                      :value="address"
                      v-model="customerShippingInfo"
                      @change.prevent="checkedAddress"
                      :checked="
                        customerShippingInfo != null &&
                        address.id == customerShippingInfo.id
                      "
                    />
                    <span class="radio-text">
                      <span class="font-weight-bold">{{ address.name }}</span>
                      <br />
                      <span> {{ $t("Address:") }} {{ address.address }} </span>
                      <br />
                      <span>{{ $t("Phone:") }} {{ address.phone }}</span>
                      <br />
                      <span>
                        {{ $t("Postal Code:") }} {{ address.postal_code }}
                      </span>
                      <br />
                      <span v-if="address.city != null">
                        {{ address.city.name }} ,
                      </span>
                      <span v-if="address.state != null">
                        {{ address.state.name }} ,
                      </span>
                      <span v-if="address.country != null">
                        {{ address.country.name }}
                      </span>
                    </span>
                  </label>
                </span>
              </div>
            </div>
            <div class="save-adderss row" v-else>
              <div class="col-lg-12 mb-4">
                <p class="alert alert-danger">{{ $t("No address found") }}</p>
                <router-link to="/dashboard/address" class="btn_underline">{{
                  $t("Add new address")
                }}</router-link>
              </div>
            </div>
          </div>
        </div>
        <!--End Shipping Address-->
        <!--Billing Address-->
        <div
          class="row"
          v-if="
            config.enable_billing_address == enums.status.ACTIVE &&
            config.use_shipping_address_as_billing_address !=
              enums.status.ACTIVE
          "
        >
          <div class="col-12">
            <h5>{{ $t("Billing Details") }}</h5>
            <div class="save-adderss row">
              <div
                class="col-lg-12 mb-4"
                v-for="address in customerAddress"
                :key="address.name"
              >
                <span
                  class="custom-radio-btn"
                  ref="billingAddressRadio"
                  :class="{
                    active:
                      customerBillingInfo != null &&
                      address.id == customerBillingInfo.id,
                  }"
                >
                  <label class="radio-label">
                    <input
                      name="customerBillingAddress"
                      type="radio"
                      :value="address"
                      v-model="customerBillingInfo"
                      @change.prevent="checkedBillingAddress"
                      :checked="
                        customerBillingInfo != null &&
                        address.id == customerBillingInfo.id
                      "
                    />
                    <span class="radio-text">
                      <span class="font-weight-bold">{{ address.name }}</span>
                      <br />
                      <span> {{ $t("Address:") }} {{ address.address }} </span>
                      <br />
                      <span>{{ $t("Phone:") }} {{ address.phone }}</span>
                      <br />
                      <span>
                        {{ $t("Postal Code:") }} {{ address.postal_code }}
                      </span>
                      <br />
                      <span v-if="address.city != null">
                        {{ address.city.name }} ,
                      </span>
                      <span v-if="address.state != null">
                        {{ address.state.name }} ,
                      </span>
                      <span v-if="address.country != null">
                        {{ address.country.name }}
                      </span>
                    </span>
                  </label>
                </span>
              </div>
            </div>
          </div>
        </div>
        <!--End Billing Address-->
      </div>
      <!--End Login user Checkout-->

      <!--Guest Checkout -->
      <div v-if="!isCustomerLogin">
        <div
          class="row"
          v-if="
            config.enable_personal_info_guest_checkout == enums.status.ACTIVE
          "
        >
          <h5>{{ $t("Personal Information") }}</h5>
          <div class="form-group mb-20 col-lg-6">
            <input
              type="text"
              v-bind:placeholder="$t('Your Name')"
              class="theme-input-style"
              v-model="guestCustomerInfo.name"
            />
            <div v-for="error in errors" :key="error.customer_name">
              <p
                class="text-danger validation-error"
                v-if="error.customer_name"
              >
                {{ error.customer_name }}
              </p>
            </div>
          </div>
          <div class="form-group mb-20 col-lg-6">
            <input
              type="email"
              v-bind:placeholder="$t('Email')"
              v-model="guestCustomerInfo.email"
              class="theme-input-style"
            />
            <div v-for="error in errors" :key="error.customer_email">
              <p
                class="text-danger validation-error"
                v-if="error.customer_email"
              >
                {{ error.customer_email }}
              </p>
            </div>
          </div>
          <div
            class="form-group mb-20 col-lg-6"
            v-if="
              config.create_account_in_guest_checkout == enums.status.ACTIVE
            "
          >
            <label class="d-flex gap-1 radio-label">
              <input
                name="createNewAccount"
                type="checkbox"
                @change="isActiveCreateNewAccount = !isActiveCreateNewAccount"
                :checked="isActiveCreateNewAccount"
              />
              <span class="radio-text"> {{ $t("Create an Account") }} ? </span>
            </label>
          </div>
          <div
            class="row m-0 p-0"
            v-if="
              isActiveCreateNewAccount &&
              config.create_account_in_guest_checkout == enums.status.ACTIVE
            "
          >
            <div class="form-group mb-20 col-lg-6">
              <input
                type="password"
                placeholder="Password"
                class="theme-input-style"
                v-model="guestCustomerInfo.password"
              />
              <div v-for="error in errors" :key="error.customer_password">
                <p
                  class="text-danger validation-error"
                  v-if="error.customer_password"
                >
                  {{ error.customer_password }}
                </p>
              </div>
            </div>
            <div class="form-group mb-20 col-lg-6">
              <input
                type="password"
                placeholder="Confirm Password"
                v-model="guestCustomerInfo.confirm_password"
                class="theme-input-style"
              />
              <div
                v-for="error in errors"
                :key="error.customer_confirm_password"
              >
                <p
                  class="text-danger validation-error"
                  v-if="error.customer_confirm_password"
                >
                  {{ error.customer_confirm_password }}
                </p>
              </div>
            </div>
          </div>
        </div>
        <!--Guest Shipping Address-->
        <div class="row guest-shipping-address" v-if="isActiveHomeDelivery">
          <div class="col-12">
            <h5>{{ $t("Shipping Details") }}</h5>
          </div>
          <div
            class="form-group mb-20 col-lg-6"
            v-if="config.enable_name_in_checkout == enums.status.ACTIVE"
          >
            <input
              type="text"
              v-bind:placeholder="$t('Your Name')"
              v-model="guestShippingInfo.name"
              class="theme-input-style"
            />
            <div v-for="error in errors" :key="error.shipping_name">
              <p
                class="text-danger validation-error"
                v-if="error.shipping_name"
              >
                {{ error.shipping_name }}
              </p>
            </div>
          </div>
          <div
            class="form-group mb-20 col-lg-6"
            v-if="config.enable_email_in_checkout == enums.status.ACTIVE"
          >
            <input
              type="email"
              v-bind:placeholder="$t('Email Address')"
              v-model="guestShippingInfo.email"
              class="theme-input-style"
            />
            <div v-for="error in errors" :key="error.shipping_email">
              <p
                class="text-danger validation-error"
                v-if="error.shipping_email"
              >
                {{ error.shipping_email }}
              </p>
            </div>
          </div>
          <div
            class="form-group mb-20 col-lg-6"
            v-if="config.enable_phone_in_checkout == enums.status.ACTIVE"
          >
            <input
              type="tel"
              v-bind:placeholder="$t('Phone Number')"
              v-model="guestShippingInfo.phone"
              class="theme-input-style"
            />
            <div v-for="error in errors" :key="error.shipping_phone">
              <p
                class="text-danger validation-error"
                v-if="error.shipping_phone"
              >
                {{ error.shipping_phone }}
              </p>
            </div>
          </div>
          <div
            class="form-group mb-20 col-lg-6"
            v-if="config.enable_address_in_checkout == enums.status.ACTIVE"
          >
            <input
              type="text"
              class="theme-input-style"
              v-bind:placeholder="$t('Address')"
              v-model="guestShippingInfo.address"
            />
            <div v-for="error in errors" :key="error.shipping_address">
              <p
                class="text-danger validation-error"
                v-if="error.shipping_address"
              >
                {{ error.shipping_address }}
              </p>
            </div>
          </div>

          <div
            v-if="config.enable_post_code_in_checkout == enums.status.ACTIVE"
            :class="
              config.hide_country_state_city_in_checkout == enums.status.ACTIVE
                ? 'form-group mb-20 col-lg-12'
                : 'form-group mb-20 col-lg-6'
            "
          >
            <input
              type="text"
              class="theme-input-style"
              v-bind:placeholder="$t('Postal Code')"
              v-model="guestShippingInfo.postal_code"
            />
            <div v-for="error in errors" :key="error.shipping_postal_code">
              <p
                class="text-danger validation-error"
                v-if="error.shipping_postal_code"
              >
                {{ error.shipping_postal_code }}
              </p>
            </div>
          </div>

          <div
            class="form-group mb-20 col-lg-6"
            v-if="
              config.hide_country_state_city_in_checkout !=
                enums.status.ACTIVE && countries.length > 1
            "
          >
            <v-select
              :options="countries"
              v-model="guestShippingInfo.country"
              label="name"
              :clearable="false"
            ></v-select>
            <div v-for="error in errors" :key="error.shipping_country">
              <p
                class="text-danger validation-error"
                v-if="error.shipping_country"
              >
                {{ error.shipping_country }}
              </p>
            </div>
          </div>
          <div
            class="form-group mb-20 col-lg-6"
            v-if="
              config.hide_country_state_city_in_checkout != enums.status.ACTIVE
            "
          >
            <v-select
              :options="guestShippingInfo.states_options"
              v-model="guestShippingInfo.state"
              label="name"
              :clearable="false"
            ></v-select>
            <div v-for="error in errors" :key="error.shipping_state">
              <p
                class="text-danger validation-error"
                v-if="error.shipping_state"
              >
                {{ error.shipping_state }}
              </p>
            </div>
          </div>
          <div
            class="form-group mb-20 col-lg-6"
            v-if="
              config.hide_country_state_city_in_checkout != enums.status.ACTIVE
            "
          >
            <v-select
              :options="guestShippingInfo.cities_options"
              v-model="guestShippingInfo.city"
              label="name"
              :clearable="false"
            ></v-select>
            <div v-for="error in errors" :key="error.shipping_city">
              <p
                class="text-danger validation-error"
                v-if="error.shipping_city"
              >
                {{ error.shipping_city }}
              </p>
            </div>
          </div>
        </div>
        <!--End Guest Shipping Address-->
        <!--Bill to different Address-->
        <div
          class="row"
          v-if="
            config.use_shipping_address_as_billing_address !=
              enums.status.ACTIVE &&
            config.enable_billing_address == enums.status.ACTIVE
          "
        >
          <div class="col-12">
            <div class="form-group mb-20 col-lg-6" v-if="isActiveHomeDelivery">
              <label class="d-flex gap-1 radio-label">
                <input
                  name="billToDifferentAddress"
                  type="checkbox"
                  @change="
                    isActiveBillToDifferentAddress =
                      !isActiveBillToDifferentAddress
                  "
                />
                <span class="radio-text">
                  {{ $t("Bill to Different Address") }} ?
                </span>
              </label>
            </div>
          </div>
        </div>
        <!--End Bill to different Address-->
        <!--Guest Billing Address-->
        <div
          class="row guest-billing-address"
          v-if="
            config.enable_billing_address == enums.status.ACTIVE &&
            config.use_shipping_address_as_billing_address !=
              enums.status.ACTIVE &&
            isActiveBillToDifferentAddress
          "
        >
          <div class="col-12">
            <h5>{{ $t("Billing Details") }}</h5>
          </div>
          <div class="form-group mb-20 col-lg-6">
            <input
              type="text"
              v-bind:placeholder="$t('Your Name')"
              v-model="guestBillingInfo.name"
              class="theme-input-style"
            />
            <div v-for="error in errors" :key="error.billing_name">
              <p class="text-danger validation-error" v-if="error.billing_name">
                {{ error.billing_name }}
              </p>
            </div>
          </div>
          <div class="form-group mb-20 col-lg-6">
            <input
              type="email"
              v-bind:placeholder="$t('Email Address')"
              v-model="guestBillingInfo.email"
              class="theme-input-style"
            />
            <div v-for="error in errors" :key="error.billing_email">
              <p
                class="text-danger validation-error"
                v-if="error.billing_email"
              >
                {{ error.billing_email }}
              </p>
            </div>
          </div>
          <div class="form-group mb-20 col-lg-6">
            <input
              type="tel"
              v-bind:placeholder="$t('Phone Number')"
              v-model="guestBillingInfo.phone"
              class="theme-input-style"
            />
            <div v-for="error in errors" :key="error.billing_phone">
              <p
                class="text-danger validation-error"
                v-if="error.billing_phone"
              >
                {{ error.billing_phone }}
              </p>
            </div>
          </div>
          <div class="form-group mb-20 col-lg-6">
            <input
              type="text"
              class="theme-input-style"
              v-bind:placeholder="$t('Address')"
              v-model="guestBillingInfo.address"
            />
            <div v-for="error in errors" :key="error.billing_address">
              <p
                class="text-danger validation-error"
                v-if="error.billing_address"
              >
                {{ error.billing_address }}
              </p>
            </div>
          </div>
          <div
            :class="
              config.hide_country_state_city_in_checkout == enums.status.ACTIVE
                ? 'form-group mb-20 col-lg-12'
                : 'form-group mb-20 col-lg-6'
            "
          >
            <input
              type="text"
              class="theme-input-style"
              v-bind:placeholder="$t('Postal Code')"
              v-model="guestBillingInfo.postal_code"
            />
            <div v-for="error in errors" :key="error.billing_postal_code">
              <p
                class="text-danger validation-error"
                v-if="error.billing_postal_code"
              >
                {{ error.billing_postal_code }}
              </p>
            </div>
          </div>
          <div
            class="form-group mb-20 col-lg-6"
            v-if="
              config.hide_country_state_city_in_checkout != enums.status.ACTIVE
            "
          >
            <v-select
              :options="countries"
              v-model="guestBillingInfo.country"
              label="name"
              :clearable="false"
            ></v-select>
            <div v-for="error in errors" :key="error.billing_country">
              <p
                class="text-danger validation-error"
                v-if="error.billing_country"
              >
                {{ error.billing_country }}
              </p>
            </div>
          </div>
          <div
            class="form-group mb-20 col-lg-6"
            v-if="
              config.hide_country_state_city_in_checkout != enums.status.ACTIVE
            "
          >
            <v-select
              :options="guestBillingInfo.states_options"
              v-model="guestBillingInfo.state"
              label="name"
              :clearable="false"
            ></v-select>
            <div v-for="error in errors" :key="error.billing_state">
              <p
                class="text-danger validation-error"
                v-if="error.billing_state"
              >
                {{ error.billing_state }}
              </p>
            </div>
          </div>
          <div
            class="form-group mb-20 col-lg-6"
            v-if="
              config.hide_country_state_city_in_checkout != enums.status.ACTIVE
            "
          >
            <v-select
              :options="guestBillingInfo.cities_options"
              v-model="guestBillingInfo.city"
              :clearable="false"
              label="name"
            ></v-select>
            <div v-for="error in errors" :key="error.billing_city">
              <p class="text-danger validation-error" v-if="error.billing_city">
                {{ error.billing_city }}
              </p>
            </div>
          </div>
        </div>
        <!--End Guest Billing Address-->
      </div>
      <!--End Guest Checkout -->
    </template>
    <!--End Home delivery-->

    <!--Pickup point Selector-->
    <div class="row" v-if="isActivePickupPoint">
      <div class="row" v-if="!isCustomerLogin">
        <h5>{{ $t("Personal Information") }}</h5>
        <div class="form-group mb-20 col-lg-6">
          <input
            type="text"
            v-bind:placeholder="$t('Your Name')"
            class="theme-input-style"
            v-model="guestCustomerInfo.name"
          />
          <div v-for="error in errors" :key="error.customer_name">
            <p class="text-danger validation-error" v-if="error.customer_name">
              {{ error.customer_name }}
            </p>
          </div>
        </div>
        <div class="form-group mb-20 col-lg-6">
          <input
            type="email"
            v-bind:placeholder="$t('Email')"
            v-model="guestCustomerInfo.email"
            class="theme-input-style"
          />
          <div v-for="error in errors" :key="error.customer_email">
            <p class="text-danger validation-error" v-if="error.customer_email">
              {{ error.customer_email }}
            </p>
          </div>
        </div>
        <div
          class="form-group mb-20 col-lg-6"
          v-if="config.create_account_in_guest_checkout == enums.status.ACTIVE"
        >
          <label class="d-flex gap-1 radio-label">
            <input
              name="createNewAccount"
              type="checkbox"
              @change="isActiveCreateNewAccount = !isActiveCreateNewAccount"
              :checked="isActiveCreateNewAccount"
            />
            <span class="radio-text"> {{ $t("Create an Account") }} ? </span>
          </label>
        </div>
        <div
          class="row m-0 p-0"
          v-if="
            isActiveCreateNewAccount &&
            config.create_account_in_guest_checkout == enums.status.ACTIVE
          "
        >
          <div class="form-group mb-20 col-lg-6">
            <input
              type="password"
              placeholder="Password"
              class="theme-input-style"
              v-model="guestCustomerInfo.password"
            />
            <div v-for="error in errors" :key="error.customer_password">
              <p
                class="text-danger validation-error"
                v-if="error.customer_password"
              >
                {{ error.customer_password }}
              </p>
            </div>
          </div>
          <div class="form-group mb-20 col-lg-6">
            <input
              type="password"
              placeholder="Confirm Password"
              v-model="guestCustomerInfo.confirm_password"
              class="theme-input-style"
            />
            <div v-for="error in errors" :key="error.customer_confirm_password">
              <p
                class="text-danger validation-error"
                v-if="error.customer_confirm_password"
              >
                {{ error.customer_confirm_password }}
              </p>
            </div>
          </div>
        </div>
      </div>
      <div class="form-group mb-20 col-lg-12">
        <h5>{{ $t("Pickup Point") }}</h5>
        <v-select
          :options="pickupPoints"
          :clearable="false"
          :searchable="true"
          v-model="selectedPickupPoints"
          label="name"
          class="pickup-point-select"
        >
          <template v-slot:selected-option="option">
            <div class="row">
              <p class="col-12 font-weight-bold mb-0">{{ option.name }}</p>
              <p v-if="option.location" class="mb-0">
                <span>{{ option.location }}</span>
              </p>
              <p v-if="option.phone" class="mb-0">
                <span>{{ option.phone }}</span>
              </p>
              <p class="mb-0" v-if="option.zone_name != null">
                <span>{{ option.zone_name }}</span>
              </p>
            </div>
          </template>
          <template v-slot:option="option">
            <p class="col-12 font-weight-bold mb-0">{{ option.name }}</p>
            <p class="mb-0">
              <span>{{ option.location }}</span>
            </p>
            <p class="mb-0">
              <span>{{ option.phone }}</span>
            </p>
            <p class="mb-0" v-if="option.zone_name != null">
              <span>{{ option.zone_name }}</span>
            </p>
          </template>
        </v-select>
        <div v-for="error in errors" :key="error.pickup_point">
          <p class="text-danger validation-error" v-if="error.pickup_point">
            {{ error.pickup_point }}
          </p>
        </div>
      </div>
    </div>
    <!--End Pickup Point Selector-->

    <!--Delivery not available alert-->
    <div
      class="row m-0"
      v-if="
        (deliveryNotAvailable &&
          guestShippingInfo &&
          guestShippingInfo.city &&
          guestShippingInfo.city.id) ||
        (deliveryNotAvailable &&
          customerShippingInfo &&
          customerShippingInfo.city &&
          customerShippingInfo.city.id)
      "
    >
      <div class="alert alert-danger col-12">
        <p class="d-flex align-items-center justify-content-center">
          {{ $t("Delivery not available at this location") }}
        </p>
      </div>
    </div>
    <!--End delivery not available alert-->

    <!--Action area-->
    <div class="row">
      <div class="col-12 d-flex flex-wrap justify-content-between">
        <button
          type="button"
          class="btn btn_border m-w-100 mb-10 justify-content-center"
          @click.prevent="goPreviousStep"
        >
          <span class="material-icons me-2"> arrow_back </span>
          {{ $t("Previous") }}
        </button>
        <button
          type="button"
          class="btn btn_fill m-w-100 mb-10 justify-content-center"
          :disabled="deliveryNotAvailable"
          @click.prevent="goNextStep"
        >
          {{ $t("Continue") }}
          <span class="material-icons ms-2"> arrow_forward </span>
        </button>
      </div>
    </div>
    <!--End Action Area-->

    <!--Shipping mot available Product modal-->
    <CModal
      :visible="notAvailableProductsModal"
      size="lg"
      @close.prevent="
        () => {
          notAvailableProductsModal = false;
        }
      "
    >
      <CModalHeader>
        <CModalTitle>{{ $t("Shipping not available products") }}</CModalTitle>
        <button
          class="btn-circle bg-black size-35"
          @click.prevent="
            () => {
              notAvailableProductsModal = false;
            }
          "
        >
          <base-icon-svg name="close" :width="10" :height="10" />
        </button>
      </CModalHeader>
      <CModalBody>
        <div class="row mb-20">
          <div class="col-12">
            <table class="border-bottom-0 cart-table table-responsive w-100">
              <tbody>
                <tr class="font-weight-bold">
                  <td>{{ $t("Product") }}</td>
                  <td>{{ $t("Quantity") }}</td>
                  <td class="text-right">{{ $t("Total") }}</td>
                </tr>
                <tr
                  class="products"
                  v-for="tdata in shippingNotAvailableProducts"
                  :key="tdata.id"
                >
                  <td>
                    <div class="d-flex align-items-center">
                      <router-link to="#">
                        <img
                          :src="tdata.image"
                          :alt="tdata.name"
                          class="cart-image mr-10 rounded-circle"
                        />
                      </router-link>
                      <span>
                        <router-link to="#" class="product-name">{{
                          tdata.name
                        }}</router-link>
                        <div class="extra-addons-wrap d-flex flex-wrap">
                          <span class="product-variant" v-if="tdata.variant">
                            <span class="font-weight-medium">{{
                              tdata.variant
                            }}</span>
                          </span>
                        </div>
                      </span>
                    </div>
                  </td>
                  <td>
                    {{ tdata.quantity }}
                  </td>
                  <td>
                    <the-currency
                      :amount="tdata.unitPrice * tdata.quantity"
                    ></the-currency>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </CModalBody>
      <CModalFooter>
        <router-link to="/cart" class="btn btn_fill">
          {{ $t("Update cart") }}
        </router-link>
      </CModalFooter>
    </CModal>
    <!--End Shipping mot available Product modal-->
  </div>
</template>
<script>
import axios from "axios";
import {
  CModal,
  CModalHeader,
  CModalTitle,
  CModalBody,
  CModalFooter,
} from "@coreui/vue";
export default {
  name: "deliveryShipping",
  emits: ["next-step"],
  components: {
    CModal,
    CModalHeader,
    CModalTitle,
    CModalBody,
    CModalFooter,
  },
  props: {
    config: {
      type: Object,
      required: true,
    },
    enums: {
      type: Object,
      required: true,
    },
    customerAddress: {
      type: Array,
      required: false,
    },
    pickupPoints: {
      type: Array,
      required: false,
    },
    isCustomerLogin: {
      type: Boolean,
      required: false,
      default: false,
    },
  },
  data() {
    return {
      loading: true,
      isActiveHomeDelivery: true,
      isActivePickupPoint: false,
      isActiveCreateNewAccount: false,
      isActiveBillToDifferentAddress: false,
      deliveryNotAvailable: false,
      selectedShippingOption: {},
      selectedPickupPoints: "",
      countries: [],
      guestCustomerInfo: {},
      guestBillingInfo: {},
      guestShippingInfo: {},
      shippingNotAvailableProducts: [],
      notAvailableProductsModal: false,
      customerShippingInfo:
        this.customerAddress.find(
          (address) => address.default_shipping === this.enums.status.ACTIVE
        ) || null,
      customerBillingInfo:
        this.customerAddress.find(
          (address) => address.default_billing === this.enums.status.ACTIVE
        ) || null,
      errors: [],
    };
  },
  mounted() {
    this.getPreviousData();
    this.getCounties();
    this.$store.dispatch("setFinalShippingCost", 0);
    if (
      this.isCustomerLogin &&
      this.customerShippingInfo != null &&
      this.isActiveHomeDelivery
    ) {
      this.getShippingOptions();
    }
  },
  watch: {
    "customerShippingInfo.id"() {
      this.getShippingOptions();
    },
    "guestBillingInfo.country"() {
      this.guestBillingInfo.state = this.$t("Select State");
      this.guestBillingInfo.city = this.$t("Select City");
      this.guestBillingInfo.cities_options = [];
      this.getStates("billing_info");
    },
    "guestBillingInfo.state"() {
      this.guestBillingInfo.city = this.$t("Select City");
      this.getCities("billing_info");
    },
    "guestShippingInfo.country"() {
      this.guestShippingInfo.state = this.$t("Select State");
      this.guestShippingInfo.city = this.$t("Select City");
      this.guestShippingInfo.cities_options = [];
      this.getStates("shipping_info");
    },
    "guestShippingInfo.state"() {
      this.guestShippingInfo.city = this.$t("Select City");
      this.getCities("shipping_info");
    },
    "guestShippingInfo.city"() {
      this.getShippingOptions();
    },
    isActivePickupPoint() {
      this.getShippingOptions();
    },
  },
  methods: {
    /**
     * Will get previously save data
     */
    getPreviousData() {
      let emptyShippingData = {
        id: "",
        name: "",
        email: "",
        phone_code:
          localStorage.getItem("country") != null
            ? JSON.parse(localStorage.getItem("country")).phone_code
            : "",
        phone: "",
        postal_code: "",
        address: "",
        country: this.$t("Select Country"),
      };
      let emptyBillingData = {
        id: "",
        name: "",
        email: "",
        phone_code:
          localStorage.getItem("country") != null
            ? JSON.parse(localStorage.getItem("country")).phone_code
            : "",
        phone: "",
        postal_code: "",
        address: "",
        country: this.$t("Select Country"),
      };
      this.isActivePickupPoint = this.$store.state.isActivePickupPoint;
      this.isActiveHomeDelivery = this.$store.state.isActiveHomeDelivery;

      if (this.isCustomerLogin) {
        //Shipping address
        if (this.$store.state.shippingDetails != null) {
          this.customerShippingInfo = this.$store.state.shippingDetails.name
            ? this.$store.state.shippingDetails
            : emptyShippingData;
        }

        //Billing address
        if (this.$store.state.billingDetails != null) {
          this.customerBillingInfo = this.$store.state.billingDetails
            ? this.$store.state.billingDetails
            : emptyShippingData;
        }
      } else {
        this.isActiveBillToDifferentAddress =
          this.$store.state.isActiveBillToDifferentAddress;

        this.isActiveCreateNewAccount =
          this.$store.state.isActiveCreateNewAccount;

        this.guestBillingInfo =
          this.$store.state.billingDetails != null
            ? this.$store.state.billingDetails
            : emptyBillingData;

        this.guestShippingInfo =
          this.$store.state.shippingDetails != null
            ? this.$store.state.shippingDetails
            : emptyShippingData;

        this.guestCustomerInfo =
          this.$store.state.guestCustomerInfo != null
            ? this.$store.state.guestCustomerInfo
            : {
                name: "",
                email: "",
                password: "",
                confirm_password: "",
              };
      }
      this.selectedPickupPoints =
        this.$store.state.pickupPoint != null
          ? this.$store.state.pickupPoint
          : {
              id: "",
              name: this.$t("Select pickup point"),
              location: "",
              phone: "",
              zone_id: "",
              zone_name: "",
            };
      this.loading = false;
    },
    /**
     * Calculate shipping cost
     */
    getShippingOptions() {
      this.notAvailableProductsModal = false;
      this.shippingNotAvailableProducts = [];
      //Pickup point delivery
      if (this.isActivePickupPoint && !this.isActiveHomeDelivery) {
        this.$store.dispatch("setFinalShippingCost", 0);
        this.deliveryNotAvailable = false;
      }
      //Home Delivery
      if (!this.isActivePickupPoint && this.isActiveHomeDelivery) {
        let city_id = null;
        let post_code = null;
        //Logged customer city id & post code
        if (this.isCustomerLogin && this.customerShippingInfo != null) {
          post_code = this.customerShippingInfo.postal_code;
          city_id =
            this.customerShippingInfo.city != null
              ? this.customerShippingInfo.city.id
              : null;
        }
        //Guest Customer city id & post code
        if (!this.isCustomerLogin && this.guestShippingInfo != null) {
          post_code = this.guestShippingInfo.postal_code;
          city_id =
            this.guestShippingInfo.city != null
              ? this.guestShippingInfo.city.id
              : null;
        }

        axios
          .post("/api/v1/ecommerce-core/get-shipping-options", {
            location: city_id,
            post_code: post_code,
            products: JSON.stringify(this.$store.state.checkoutItems),
            shipping_type: "home_delivery",
          })
          .then((response) => {
            if (response.data.success) {
              if (response.data.shipping_available) {
                this.deliveryNotAvailable = false;
              } else {
                if (response.data.products) {
                  this.shippingNotAvailableProducts = response.data.products;
                  this.notAvailableProductsModal = true;
                }
                this.deliveryNotAvailable = true;
              }
            } else {
              this.$toast.error(response.data.message);
            }
          })
          .catch((error) => {
            this.$store.dispatch("setFinalShippingCost", 0);
            this.deliveryNotAvailable = true;
          });
      }
    },
    /**
     * Go to cart page
     */
    goPreviousStep() {
      this.$router.push("/cart");
    },
    /**
     * Will submit shipping info
     */
    goNextStep() {
      if (this.validateData()) {
        if (!this.deliveryNotAvailable) {
          //Home delivery checkout
          if (this.isActiveHomeDelivery && !this.isActivePickupPoint) {
            let shippingAddress = {};
            let billingAddress = {};
            if (this.isCustomerLogin) {
              shippingAddress = this.customerShippingInfo;
              billingAddress =
                this.config.use_shipping_address_as_billing_address ==
                this.enums.status.ACTIVE
                  ? this.customerShippingInfo
                  : this.customerBillingInfo;
            } else {
              shippingAddress = this.guestShippingInfo;
              billingAddress =
                this.config.use_shipping_address_as_billing_address ==
                  this.enums.status.ACTIVE ||
                !this.isActiveBillToDifferentAddress
                  ? this.guestShippingInfo
                  : this.guestBillingInfo;
              //set guest customer details
              this.$store.dispatch(
                "storeGuestCustomerDetails",
                this.guestCustomerInfo
              );
              //set billed to different address
              this.$store.dispatch(
                "storeIsActiveBillToDifferentAddress",
                this.isActiveBillToDifferentAddress
              );
              //Set create new account in guest checkout
              this.$store.dispatch(
                "storeIsActiveCreateNewAccount",
                this.isActiveCreateNewAccount
              );
            }
            //set home delivery checkout
            this.$store.dispatch(
              "storeHomeDeliveryCheckout",
              this.isActiveHomeDelivery
            );
            //set shipping address
            this.$store.dispatch("storeShippingDetails", shippingAddress);
            //set billing address
            this.$store.dispatch("storeBillingDetails", billingAddress);
            this.$emit("next-step");
          }
          //Pickup point checkout
          if (this.isActivePickupPoint && !this.isActiveHomeDelivery) {
            if (!this.isCustomerLogin) {
              //Guest customer info
              this.$store.dispatch(
                "storeGuestCustomerDetails",
                this.guestCustomerInfo
              );
              //set billed to different address
              this.$store.dispatch(
                "storeIsActiveBillToDifferentAddress",
                this.isActiveBillToDifferentAddress
              );
              //Set create new account in guest checkout
              this.$store.dispatch(
                "storeIsActiveCreateNewAccount",
                this.isActiveCreateNewAccount
              );
            }
            //Store pickup point information
            this.$store.dispatch(
              "storePickoupPoint",
              this.selectedPickupPoints
            );
            //set pickup point checkout
            this.$store.dispatch(
              "storePickoupPointCheckout",
              this.isActivePickupPoint
            );

            this.$emit("next-step");
          }
        } else {
          this.$toast.error(this.$t("Delivery not available in your location"));
        }
      }
    },

    /**
     * Change shipping address
     * @param {*} e
     */
    checkedAddress(e) {
      this.$refs.addressRadio.forEach((element) => {
        element.classList.remove("active");
      });

      e.target.parentElement.parentElement.classList.add("active");
    },
    /**
     * Change  billing address
     * @param {*} e
     */
    checkedBillingAddress(e) {
      this.$refs.billingAddressRadio.forEach((element) => {
        element.classList.remove("active");
      });

      e.target.parentElement.parentElement.classList.add("active");
    },
    /**
     * Validate checkout data
     */
    validateData() {
      this.errors = [];
      //validate data from pickup point
      if (this.isActivePickupPoint) {
        if (!this.selectedPickupPoints.zone_id) {
          this.errors.push({
            pickup_point: this.$t("Please choose a pickup point"),
          });
        }
        if (!this.isCustomerLogin) {
          //Validate Personal Information
          if (!this.guestCustomerInfo.name) {
            this.errors.push({ customer_name: this.$t("Name is required") });
          }
          if (!this.guestCustomerInfo.email) {
            this.errors.push({ customer_email: this.$t("Email is required") });
          }
          //Password validation
          if (this.isActiveCreateNewAccount) {
            if (!this.guestCustomerInfo.password) {
              this.errors.push({
                customer_password: this.$t("Password is required"),
              });
            }
            if (!this.guestCustomerInfo.confirm_password) {
              this.errors.push({
                customer_confirm_password: this.$t("Please conform password"),
              });
            }
            if (
              this.guestCustomerInfo.password !=
              this.guestCustomerInfo.confirm_password
            ) {
              this.errors.push({
                customer_password: this.$t("Password does not match"),
              });
            }
          }
        }
      }

      //validate data for home delivery
      if (this.isActiveHomeDelivery) {
        //Checkout
        if (this.isCustomerLogin) {
          //Validate customer shipping address
          if (this.customerShippingInfo == null) {
            this.errors.push({
              customer_shipping_address: this.$t(
                "Please select shipping address"
              ),
            });
            this.$toast.error(this.$t("Please select shipping address"));
          }
          //validate customer billing address
          if (
            this.config.enable_billing_address == this.enums.status.ACTIVE &&
            this.config.use_shipping_address_as_billing_address !=
              this.enums.status.ACTIVE
          ) {
            if (this.customerBillingInfo == null) {
              this.errors.push({
                customer_billing_address: this.$t(
                  "Please select billing address"
                ),
              });
              this.$toast.error(this.$t("Please select billing address"));
            }
          }
        }

        //Guest Checkout
        if (!this.isCustomerLogin) {
          //Validate Personal Information
          if (
            !this.guestCustomerInfo.name &&
            this.config.enable_personal_info_guest_checkout ==
              this.enums.status.ACTIVE
          ) {
            this.errors.push({ customer_name: this.$t("Name is required") });
          }
          if (
            !this.guestCustomerInfo.email &&
            this.config.enable_personal_info_guest_checkout ==
              this.enums.status.ACTIVE
          ) {
            this.errors.push({ customer_email: this.$t("Email is required") });
          }
          //Password validation
          if (this.isActiveCreateNewAccount) {
            if (!this.guestCustomerInfo.password) {
              this.errors.push({
                customer_password: this.$t("Password is required"),
              });
            }
            if (!this.guestCustomerInfo.confirm_password) {
              this.errors.push({
                customer_confirm_password: this.$t("Please conform password"),
              });
            }
            if (
              this.guestCustomerInfo.password !=
              this.guestCustomerInfo.confirm_password
            ) {
              this.errors.push({
                customer_password: this.$t("Password does not match"),
              });
            }
          }
          //Validate Billing Address
          if (
            this.config.enable_billing_address == this.enums.status.ACTIVE &&
            this.config.use_shipping_address_as_billing_address !=
              this.enums.status.ACTIVE &&
            this.isActiveBillToDifferentAddress
          ) {
            //name validation
            if (!this.guestBillingInfo.name) {
              this.errors.push({ billing_name: this.$t("Name is required") });
            }
            //email validation
            if (!this.guestBillingInfo.email) {
              this.errors.push({ billing_email: this.$t("Email is required") });
            }

            if (!this.guestBillingInfo.phone) {
              this.errors.push({ billing_phone: this.$t("Phone is required") });
            }

            if (!this.guestBillingInfo.address) {
              this.errors.push({
                billing_address: this.$t("Address is required"),
              });
            }

            if (this.config.post_code_required_in_checkout != 2) {
              if (!this.guestBillingInfo.postal_code) {
                this.errors.push({
                  billing_postal_code: this.$t("Postal code is required"),
                });
              }
            }

            //If country , state and city option not hide
            if (this.config.hide_country_state_city_in_checkout != 1) {
              if (!this.guestBillingInfo.country.id) {
                this.errors.push({
                  billing_country: this.$t("Please select a country"),
                });
              }
              if (!this.guestBillingInfo.state.id) {
                this.errors.push({
                  billing_state: this.$t("Please select a state"),
                });
              }
              if (!this.guestBillingInfo.city.id) {
                this.errors.push({
                  billing_city: this.$t("Please select a city"),
                });
              }
            }
          }

          //Validate Shipping Address

          //name validation
          if (
            !this.guestShippingInfo.name &&
            this.config.enable_name_in_checkout == this.enums.status.ACTIVE &&
            this.config.name_required_in_checkout == this.enums.status.ACTIVE
          ) {
            this.errors.push({ shipping_name: this.$t("Name is required") });
          }

          //email validation
          if (
            !this.guestShippingInfo.email &&
            this.config.enable_email_in_checkout == this.enums.status.ACTIVE &&
            this.config.email_required_in_checkout == this.enums.status.ACTIVE
          ) {
            this.errors.push({ shipping_email: this.$t("Email is required") });
          }

          //Phone validation
          if (
            !this.guestShippingInfo.phone &&
            this.config.enable_phone_in_checkout == this.enums.status.ACTIVE &&
            this.config.phone_required_in_checkout == this.enums.status.ACTIVE
          ) {
            this.errors.push({ shipping_phone: this.$t("Phone is required") });
          }

          //address validation
          if (
            !this.guestShippingInfo.address &&
            this.config.enable_address_in_checkout ==
              this.enums.status.ACTIVE &&
            this.config.address_required_in_checkout == this.enums.status.ACTIVE
          ) {
            this.errors.push({
              shipping_address: this.$t("Address is required"),
            });
          }

          //postal code validation
          if (
            !this.guestShippingInfo.postal_code &&
            this.config.post_code_required_in_checkout ==
              this.enums.status.ACTIVE &&
            this.config.post_code_required_in_checkout ==
              this.enums.status.ACTIVE
          ) {
            this.errors.push({
              shipping_postal_code: this.$t("Postal code is required"),
            });
          }

          //If country , state and city option not hide
          if (
            this.config.hide_country_state_city_in_checkout ==
            this.enums.status.IN_ACTIVE
          ) {
            if (!this.guestShippingInfo.country.id) {
              this.errors.push({
                shipping_country: this.$t("Please select a country"),
              });
            }
            if (!this.guestShippingInfo.state.id) {
              this.errors.push({
                shipping_state: this.$t("Please select a state"),
              });
            }
            if (!this.guestShippingInfo.city.id) {
              this.errors.push({
                shipping_city: this.$t("Please select a city"),
              });
            }
          }
        }
      }

      //return result
      if (this.errors.length > 0) {
        return false;
      } else {
        return true;
      }
    },
    /**
     * Get counties list
     */
    getCounties() {
      axios
        .get("/api/v1/ecommerce-core/get-countries")
        .then((response) => {
          if (response.data.success) {
            this.countries = response.data.data.countries;
            if (this.countries.length == 1) {
              this.guestShippingInfo.country = this.countries[0];
              getStates("shipping_info");
            }
          }
        })
        .catch((error) => {
          this.countries = [];
        });
    },
    /**
     * Will get state list of a country
     */
    getStates(origin) {
      let country_id = "";
      if (origin === "billing_info") {
        country_id = this.guestBillingInfo.country
          ? this.guestBillingInfo.country.id
          : "";
      } else if (origin === "shipping_info") {
        country_id = this.guestShippingInfo.country
          ? this.guestShippingInfo.country.id
          : "";
      }
      axios
        .post("/api/v1/ecommerce-core/get-states-of-countries", {
          country_id: country_id,
        })
        .then((response) => {
          if (response.data.success) {
            if (origin === "billing_info") {
              this.guestBillingInfo.states_options = response.data.data.states;
            }
            if (origin === "shipping_info") {
              this.guestShippingInfo.states_options = response.data.data.states;
            }
          }
        })
        .catch((error) => {});
    },
    /**
     * Will get cities list of a state
     */
    getCities(origin) {
      let state = "";
      if (origin === "billing_info") {
        state = this.guestBillingInfo.state
          ? this.guestBillingInfo.state.id
          : "";
      } else if (origin === "shipping_info") {
        state = this.guestShippingInfo.state
          ? this.guestShippingInfo.state.id
          : "";
      }
      axios
        .post("/api/v1/ecommerce-core/get-cities-of-state", {
          state_id: state,
        })
        .then((response) => {
          if (response.data.success) {
            if (origin === "billing_info") {
              this.guestBillingInfo.cities_options = response.data.data.cities;
            }

            if (origin === "shipping_info") {
              this.guestShippingInfo.cities_options = response.data.data.cities;
            }
          }
        })
        .catch((error) => {});
    },
  },
};
</script>
<style lang="scss" scoped>
.product-name {
  display: block;
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
  overflow: hidden;
  text-overflow: ellipsis;
}
</style>