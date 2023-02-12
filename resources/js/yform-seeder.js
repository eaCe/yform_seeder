import Alpine from 'alpinejs';
import collapse from '@alpinejs/collapse';
import ajax from '@imacrayon/alpine-ajax'

window.Alpine = Alpine;
Alpine.plugin(collapse);
Alpine.plugin(ajax);

Alpine.start();

import './table';
