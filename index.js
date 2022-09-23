// Language: javascript
// Path: CMPE2550\index.js
// Change nav bar depending on screen size
$(document).ready(function() {
    $('#menu-toggle').on('click', function() {
        $('.navbar').toggleClass('expand');
    });
});