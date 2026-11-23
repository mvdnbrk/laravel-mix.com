import './blockquote';
import './linkify-anchors';
import './highlight-active-link';

import Prism from 'prismjs';

Prism.highlightAll();

import { createApp } from 'vue';

import Count from './components/Count.vue';
import Dropdown from './components/Dropdown.vue';
import CarbonAds from './components/CarbonAds.vue';
import ToggleMenu from './components/ToggleMenu.vue';
import ScrollIndicator from './components/ScrollIndicator.vue';

const app = createApp({});

app.component('count', Count);
app.component('dropdown', Dropdown);
app.component('carbon-ads', CarbonAds);
app.component('toggle-menu', ToggleMenu);
app.component('scroll-indicator', ScrollIndicator);

app.mount('#app');
