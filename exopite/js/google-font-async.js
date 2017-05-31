/**
 * Google font async loading
 *
 * https://css-tricks.com/loading-web-fonts-with-the-web-font-loader/
 * https://github.com/typekit/webfontloader
 */
 var wf = document.createElement("script");
 wf.src = ('https:' == document.location.protocol ? 'https' : 'http') +
     '://cdnjs.cloudflare.com/ajax/libs/webfont/1.6.27/webfontloader.js';
 wf.async = 'true';
 document.head.appendChild(wf);
