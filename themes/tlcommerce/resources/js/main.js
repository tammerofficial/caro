import { createApp } from "vue";
import App from "./App.vue";
import router from "./router";
import store from "./store";
import BaseIconSvg from "./components/global/BaseIconSvg.vue";
import SectionTitle from "./components/global/SectionTitle.vue";
import TheLogo from "./components/global/TheLogo.vue";
import Currency from "./components/global/Currency.vue"
import Skeleton from "./components/skeleton/Skeleton.vue"
import BaseFileInput from "./components/global/BaseFileInput.vue"
import i18n from "./i18n_setup";
import vSelect from "vue-select";
import ToastPlugin from 'vue-toast-notification';
import NotFound from "./components/global/NotFound.vue"
import VueSocialSharing from 'vue-social-sharing'

const app = createApp(App);
app.use(store);
app.use(router);
app.use(i18n);
app.use(ToastPlugin);
app.use(VueSocialSharing);
app.component("base-icon-svg", BaseIconSvg);
app.component("base-file-input", BaseFileInput);
app.component("section-title", SectionTitle);
app.component("the-logo", TheLogo);
app.component("the-currency", Currency);
app.component("v-select", vSelect);
app.component('the-not-found', NotFound);
app.component('skeleton', Skeleton);
app.mount("#app");

//Import coreui Styles
import 'bootstrap/dist/css/bootstrap.css'
import "@coreui/coreui/dist/css/coreui.min.css";

//Toast notification
import 'vue-toast-notification/dist/theme-sugar.css';


//Import Google Icons Style
import "./assets/css/google-icons.css";

//Import Main Style
import "./assets/sass/app.scss";
