import './bootstrap';
import '~resources/scss/app.scss';
import * as bootstrap from 'bootstrap';
import.meta.glob([
    '../img/**'
])
import Alpine from 'alpinejs';
window.Alpine = Alpine;
Alpine.start();