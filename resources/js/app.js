import.meta.glob([
    '../images/**',
    '../fonts/**'
]);

import $ from "jquery";
window.$ = window.jQuery = $;

import * as bootstrap from 'bootstrap';
window.bootstrap = bootstrap;

import 'admin-lte';
import 'bootstrap-table';

import 'bootstrap-table/dist/extensions/export/bootstrap-table-export.min.js';
import 'bootstrap-table/dist/Locale/bootstrap-table-pt-BR.min.js';
        
import './core/app';
import './core/fetch';
import './core/modal';
import './core/submitForm';
import './core/message';
import './core/confirm';

document.addEventListener("DOMContentLoaded", function () {
    App.init();
});
