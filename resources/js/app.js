import './blockquote';
import './linkify-anchors';
import './highlight-active-link';

import Prism from 'prismjs';
import SmoothScroll from 'smoothscroll-for-websites';

Prism.highlightAll();

window.Vue = require('vue');

import CarbonAds from './components/CarbonAds.vue';
import ToggleMenu from './components/ToggleMenu.vue';

Vue.component('carbon-ads', CarbonAds);
Vue.component('toggle-menu', ToggleMenu);

const app = new Vue({
    el: '#app',
});

