require('./bootstrap');

// Feather icons are used on some pages
// Replace() replaces [data-feather] elements with icons
import featherIcons from "feather-icons"
featherIcons.replace()

import Alpine from 'alpinejs';
window.Alpine = Alpine;
Alpine.start();

// Mazer internal JS. Include this in your project to get
// the sidebar running.
require("./components/dark")
require("./mazer")
require("./initTheme")
