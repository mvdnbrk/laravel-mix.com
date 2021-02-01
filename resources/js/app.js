import './blockquote';
import './linkify-anchors';
import './highlight-active-link';

import Prism from 'prismjs';

Prism.highlightAll();

window.Vue = require('vue');

import Count from './components/Count.vue';
import Dropdown from './components/Dropdown.vue';
import CarbonAds from './components/CarbonAds.vue';
import ToggleMenu from './components/ToggleMenu.vue';
import { VueScrollIndicator } from 'vue-scroll-indicator';

Vue.component('count', Count);
Vue.component('dropdown', Dropdown);
Vue.component('carbon-ads', CarbonAds);
Vue.component('toggle-menu', ToggleMenu);
Vue.component('scroll-indicator', VueScrollIndicator);

const app = new Vue({
    el: '#app',
});
