import "/node_modules/@preline/collapse/index.js";

import { themeChange } from "theme-change";
themeChange();

document.addEventListener('DOMContentLoaded', function() {
    // Function to update icon based on theme
    function updateIcon() {
        const currentTheme = document.documentElement.getAttribute('data-theme');
        if (currentTheme === 'light') {
            document.getElementById("theme-toggle").checked = false;
        } else {
            document.getElementById("theme-toggle").checked = true;
        }
    }

    // Update icon on page load
    updateIcon();

});
