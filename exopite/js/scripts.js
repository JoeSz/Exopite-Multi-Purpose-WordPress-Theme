!function(a,b){"function"==typeof define&&define.amd?define([],function(){return b()}):"object"==typeof exports?module.exports=b():a.Macy=b()}(this,function(){"use strict";var a=function(b){var e,c={},d=1,f=function(b){for(e in b)Object.prototype.hasOwnProperty.call(b,e)&&("[object Object]"===Object.prototype.toString.call(b[e])?c[e]=a(c[e],b[e]):c[e]=b[e])};for(f(arguments[0]),d=1;d<arguments.length;d++){f(arguments[d])}return c},b={};b.VERSION="1.1.2",b.settings={};var e,f,c={columns:3,margin:2,trueOrder:!0,waitForImages:!1},d={options:{}},g=function(){var b,a=window.innerWidth;for(var c in d.options.breakAt)if(a<c){b=d.options.breakAt[c];break}return b||(b=d.options.columns),b},h=function(a){a=void 0===a||a;var c,b=g();return a?1===b?"100%":(c=(b-1)*d.options.margin/b,"calc("+100/b+"% - "+c+"px)"):100/b},i=function(){var a=h();w(d.elements,function(b,c){c.style.width=a,c.style.position="absolute"})},j=function(a){var e,b=g(),c=0;return 1===++a?0:(e=(d.options.margin-(b-1)*d.options.margin/b)*(a-1),c+=h(!1)*(a-1),"calc("+c+"% + "+e+"px)")},k=function(a,b,c){var f,e=0;if(0===a)return 0;for(var g=0;g<a;g++)f=parseInt(p(d.elements[c[g]],"height").replace("px",""),10),e+=isNaN(f)?0:f+d.options.margin;return e},l=function(a){var b=0,c=[],e=[],f=[];w(d.elements,function(d){b++,b>a&&(b=1,c.push(e),e=[]),e.push(d)}),c.push(e);for(var g=0,h=c.length;g<h;g++)for(var i=c[g],j=0,k=i.length;j<k;j++)f[j]=void 0===f[j]?[]:f[j],f[j].push(i[j]);d.rows=f,n(!1)},m=function(a){for(var b=d.elements,c=[],e=[],f=0;f<a;f++)c[f]=[];for(var g=0;g<b.length;g++)e.push(g);for(var h=0,i=e.length;h<i;h++){var j=o(c);c[j]=void 0===c[j]?[]:c[j],c[j].push(e[h])}d.rows=c,n(!0)},n=function(a){a=a||!1;for(var b=d.elements,c=d.rows,e=0,f=c.length;e<f;e++)for(var g=a?t(c[e]):c[e],h=0,i=g.length;h<i;h++){var l,m;l=j(e),m=k(h,e,g,a),b[g[h]].style.top=m+"px",b[g[h]].style.left=l}},o=function(a){for(var c,e,f,g,b=0,h=0,i=a.length;h<i;h++){for(var j=0;j<a[h].length;j++)g=parseInt(p(d.elements[a[h][j]],"height").replace("px",""),10),b+=isNaN(g)?0:g;f=e,e=void 0===e?b:e>b?b:e,(void 0===f||f>e)&&(c=h),b=0}return c},p=function(a,b){return window.getComputedStyle(a,null).getPropertyValue(b)},q=function(){for(var a=d.rows,b=0,c=0,e=0,f=a.length;e<f;e++){for(var g=0;g<a[e].length;g++)c+=parseInt(p(d.elements[a[e][g]],"height").replace("px",""),10),c+=0!==g?d.options.margin:0;b=b<c?c:b,c=0}return b},r=function(){var a=g();return 1===a?(d.container.style.height="auto",void w(d.elements,function(a,b){b.removeAttribute("style")})):(i(),d.elements=d.container.children,d.options.trueOrder?(l(a),void s()):(m(a),void s()))},s=function(){d.container.style.height=q()+"px"},t=function(a){for(var b=a,c=b.length-1,d=0;d<c;d++)for(var e=0;e<c;e++)if(b[e]>b[e+1]){var f=b[e];b[e]=b[e+1],b[e+1]=f}return b},u=function(a){return document.querySelector(a)},v=function(a){for(var b=d.container.querySelectorAll(a),c=[],e=b.length-1;e>=0;e--)null!==b[e].parentNode&&c.unshift(b[e]);return c},w=function(a,b){for(var c=0,d=a.length;c<d;c++)b(c,a[c])},x=function(a,b){a=a||!1,b=b||!1,"function"==typeof a&&a(),f>=e&&"function"==typeof b&&b()},y=function(){w(d.container.children,function(a,b){b.removeAttribute("style")}),d.container.removeAttribute("style"),window.removeEventListener("resize",r)},z=function(a,b){var c=v("img");e=c.length-1,f=0,w(c,function(c,d){if(d.complete)return f++,void x(a,b);d.addEventListener("load",function(){f++,x(a,b)}),d.addEventListener("error",function(){e--,x(a,b)})})};return b.init=function(b){if(b.container&&(d.container=u(b.container),d.container)){if(delete b.container,d.options=a(c,b),window.addEventListener("resize",r),d.container.style.position="relative",d.elements=d.container.children,!d.options.waitForImages)return r(),void z(function(){r()});z(null,function(){r()})}},b.recalculate=r,b.onImageLoad=z,b.remove=y,b});
(function ( $,window,document){'use strict';$.fn.validator=function(options){function isValidEmailAddress(emailAddress){var pattern=/^([a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+(\.[a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+)*|"((([\t]*\r\n)?[\t]+)?([\x01-\x08\x0b\x0c\x0e-\x1f\x7f\x21\x23-\x5b\x5d-\x7e\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|\\[\x01-\x09\x0b\x0c\x0d-\x7f\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))*(([\t]*\r\n)?[\t]+)?")@(([a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.)+([a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.?$/i;return pattern.test(emailAddress);};this.each(function(){var settings=$.extend({},options);$(this).submit(function(e){var valid=true;var $this=$( this);$.each(settings,function(index,value){var $element=$this.find( index);if (!$element.length)return;var element_value=$element.val();$element.removeClass('error');if ( value=='email'){if (!isValidEmailAddress( element_value)){$element.addClass('error');valid=false;};}else{if ( element_value<value){$element.addClass('error');valid=false;};};});if(!valid){e.preventDefault();}});});};}( jQuery,window,document));;(function( $){"use strict";$( document).ready(function(){$('#commentform').validator({'textarea':10,'#author':3,'#email':'email',});});}(jQuery));(function ($,window,document,undefined){"use strict";var pluginName='slimmenu',oldWindowWidth=0,defaults={resizeWidth:'767',initiallyVisible:false,collapserTitle:'Main Menu',animSpeed:'medium',easingEffect:null,indentChildren:false,childrenIndenter:'&nbsp;&nbsp;',expandIcon:'<i class="mobile-expand-icon fa fa-chevron-down" aria-hidden="true"></i>',collapseIcon:'<i class="mobile-collapse-icon fa fa-chevron-up" aria-hidden="true"></i>',mobileTrigger:'.mobile-button-hamburger'};function Plugin(element,options){this.element=element;this.$elem=$(this.element);this.options=$.extend(defaults,options);this.init();}Plugin.prototype={init:function (){var $window=$(window),options=this.options,$menu=this.$elem,$menuCollapser;$menuCollapser=$menu.prev('.menu-collapser');$menu.on('click','.sub-toggle',function (e){e.preventDefault();e.stopPropagation();var $parentLi=$(this).closest('li');if ($(this).hasClass('expanded')){$(this).removeClass('expanded').html(options.expandIcon);$parentLi.find('>ul').slideUp(options.animSpeed,options.easingEffect);}else{$(this).addClass('expanded').html(options.collapseIcon);$parentLi.find('>ul').slideDown(options.animSpeed,options.easingEffect);}});$menuCollapser.on('click',options.mobileTrigger,function (e){e.preventDefault();$menu.slideToggle(options.animSpeed,options.easingEffect);$menu.toggleClass( 'expanded');});this.resizeMenu();$window.on('resize',this.resizeMenu.bind(this));$window.trigger('resize');},resizeMenu:function (){var self=this,$window=$(window),windowWidth=$window.width(),$options=this.options,$menu=$(this.element),$menuCollapser=$('body').find('.menu-collapser');if (window['innerWidth']!==undefined){if (window['innerWidth']>windowWidth){windowWidth=window['innerWidth'];}}if (windowWidth!=oldWindowWidth){oldWindowWidth=windowWidth;$menu.find('li').each(function (){if ($(this).has('ul').length){if ($(this).addClass('has-submenu').has('.sub-toggle').length){$(this).children('.sub-toggle').html($options.expandIcon);}else{$(this).addClass('has-submenu').append('<span class="sub-toggle">'+$options.expandIcon+'</span>');}}$(this).children('ul').hide().end().find('.sub-toggle').removeClass('expanded').html($options.expandIcon);});if ($options.resizeWidth>=windowWidth){if ($options.indentChildren){$menu.find('ul').each(function (){var $depth=$(this).parents('ul').length;if (!$(this).children('li').children('a').has('i').length){$(this).children('li').children('a').prepend(self.indent($depth,$options));}});}$menu.addClass('collapsed').find('li').has('ul').off('mouseenter mouseleave');$menuCollapser.show();if (!$options.initiallyVisible){$menu.hide();$menu.removeClass( 'expanded');}}else{$menu.find('li').has('ul').on('mouseenter',function (){$(this).find('>ul').stop().slideDown($options.animSpeed,$options.easingEffect);}).on('mouseleave',function (){$(this).find('>ul').stop().slideUp($options.animSpeed,$options.easingEffect);});$menu.removeClass('collapsed').show();$menuCollapser.hide();$menu.removeClass( 'expanded');}}},indent:function (num,options){var i=0,$indent='';for (;i<num;i++){$indent+=options.childrenIndenter;}return '<i>'+$indent+'</i>';}};$.fn[pluginName]=function (options){return this.each(function (){if (!$.data(this,'plugin_'+pluginName)){$.data(this,'plugin_'+pluginName,new Plugin(this,options));}});};}(jQuery,window,document));var $j=jQuery.noConflict();$j(document).ready(function($){console.log('active');$('.slimmenu').slimmenu({resizeWidth:767,initiallyVisible:false,collapserTitle:'Main Menu',animSpeed:'medium',easingEffect:null,indentChildren:false,childrenIndenter:'-'});});(function($){'use strict';$.fn.stickThis=function( options){var inViewport=function( $el){var elH=$el.outerHeight(),H=$(window).height(),r=$el[0].getBoundingClientRect(),t=r.top,b=r.bottom;return Math.max(0,t>0?Math.min(elH,H-t):(b<H?b:H));};var toggleTouch=function( $mobileMenu,$that){setTimeout( function(){var isFixed=$that.css("position")==='fixed';if ( isFixed&&$mobileMenu.hasClass( 'expanded')){$( 'body').addClass( 'noscroll');$( 'html').addClass( 'noscroll');$( 'body').on("touchmove",function(event){event.preventDefault();});$( $mobileMenu).on('touchmove',function(event){var tot=0;$( $mobileMenu).children( 'li:visible').each(function(){tot+=$(this).height();});if( tot>inViewport( $mobileMenu)){event.stopPropagation();}});}else{$( 'body').removeClass( 'noscroll');$( 'html').removeClass( 'noscroll');$( 'body').off( 'touchmove');}},200);};var stickIt=function( stickyTop,zindex,fixedClass,staticClass,$that,callingEvent,mobileWidth,fixedOnStart){var placeholder=$that.next();var placeholderTop=placeholder.offset().top;var selectorHeight=$that.outerHeight();var isFixed=$that.css("position")==='fixed';var fixedInit=false;var adminBarheight=( $( '#wpadminbar').length&&$( '#wpadminbar').css( 'position')==='fixed')?$( '#wpadminbar').height():0;stickyTop+=adminBarheight;if ( ( $( window).scrollTop()>( ( placeholderTop-stickyTop)-selectorHeight))&&!isFixed){if (!fixedOnStart){$that.removeClass( staticClass);$that.addClass( fixedClass);$that.css({'position':'fixed',top:stickyTop+'px'});if ( $( window).width()<( mobileWidth+1)){var menuHeight=$('.menu-collapser').height();placeholder.css({height:menuHeight});}else{placeholder.css({height:selectorHeight});}}fixedInit=true;if ( typeof wp.hooks!=='undefined')wp.hooks.doAction( 'sticky-anything-on-fixed');}else if ( ( $( window).scrollTop()<=( placeholderTop-stickyTop))&&isFixed&&!fixedOnStart){$that.removeClass( fixedClass);$that.addClass( staticClass);$that.removeAttr( 'style');placeholder.css({height:0});if ( typeof wp.hooks!=='undefined')wp.hooks.doAction( 'sticky-anything-on-unfixed');}if ( fixedInit||( isFixed&&callingEvent=='resize')){var placeholderRight=( $( window).width()-( placeholder.offset().left+placeholder.outerWidth()));$that.css({'max-width':placeholder.outerWidth()+'px',left:placeholder.offset().left,right:placeholderRight,'z-index':zindex});}};this.each(function(){var settings=$.extend({top:0,minscreenwidth:0,maxscreenwidth:99999,fixedClass:'sticked',staticClass:'static',placeholderClass:'sticky-placeholder',zindex:1,mobileTrigger:'.mobile-button-hamburger',mobileMenu:'.slimmenu',mobileWidth:767},options);var $that=$( this);var $mobileMenu=$( settings.mobileMenu);var fixedOnStart=( $that.css("position")==='fixed');$( '<div></div>').addClass( $( this).attr( 'class')).addClass( settings.placeholderClass).css( 'background-color',$( this).css( 'backgroundColor')).insertAfter( this);$( settings.mobileTrigger).on('click',function(event){toggleTouch( $mobileMenu,$that);});var checkFixed=function( callingEvent){if ( callingEvent==='resize')toggleTouch( $mobileMenu,$that);var e=window,a='inner';if (!( 'innerWidth' in window)){a='client';e=document.documentElement||document.body;}var viewport=e[a+'Width'];if ( ( viewport>=settings.minscreenwidth)&&( viewport<=settings.maxscreenwidth)&&( viewport>=settings.mobileWidth||( viewport<settings.mobileWidth&&!$mobileMenu.hasClass( 'expanded')))){stickIt( settings.top,settings.zindex,settings.fixedClass,settings.staticClass,$that,callingEvent,settings.mobileWidth,fixedOnStart);}};var throttle_fast=Exopite.throttle( checkFixed,10,'scroll');var throttle_normal=Exopite.throttle( checkFixed,100,'scroll');$( window).on( 'scroll',function(){if( $( window).scrollTop()>200){throttle_normal();}else{throttle_fast();}});$( window).on( 'resize',Exopite.throttle( checkFixed,100,'resize'));return this;});};}(jQuery));;(function( $){"use strict";$( document).ready(function(){$('.main-navigation').stickThis({fixedClass:'floating-menu',staticClass:'normal-menu',zindex:3,mobileWidth:767||767,});});}(jQuery));;(function( $){"use strict";$( document).ready(function(){var container='.content-row.masonry-container';if (( typeof masonry.columns!=='undefined'||masonry.columns!==null)&&$( container+' article').hasClass( 'multi-column')){Macy.init({container:container,margin:0,columns:masonry.columns,widthToContainer:true,breakAt:{854:2,550:1}});if ( typeof wp.hooks!=='undefined'){wp.hooks.addAction( 'infiniteload-load-success',function(){Macy.recalculate();},10);}}var $win=$(window);var isFixedTop=false;if ( $( '.fixed-top').length)isFixedTop=true;$( window).on( 'resize scroll',Exopite.throttle( scrollResize,200,'scroll'));function scrollResize(){scrollToTop();if ( isFixedTop)siteFixedTop();}function adminBarheight(){return ( $( '#wpadminbar').length&&$( '#wpadminbar').css( 'position')==='fixed')?$( '#wpadminbar').height():0;}$( window).on('scroll',function (){if ( isFixedTop&&!$( window).scrollTop()){siteFixedTop();}});if ( isFixedTop)siteFixedTop();function siteFixedTop(){if( $( window).scrollTop()==0){$( '.fixed-top').removeClass('scrolled floating-menu').addClass( 'normal-menu');}else{$( '.fixed-top').removeClass( 'normal-menu').addClass('scrolled floating-menu');}$( '#site-navigation').css( 'top',adminBarheight()+'px');}function scrollToTop(){if ( $win.scrollTop()>200){$( '.scrollToTop').fadeIn();}else{$( '.scrollToTop').fadeOut();}}$( '.skip-link').on( 'click',function( e){e.preventDefault();var contentTop=$( '#content').offset().top;contentTop-=$( '#site-navigation').height();contentTop-=adminBarheight();$("html,body").animate({scrollTop:contentTop},300);});$( '.scrollToTop').click(function(){$( 'html,body').animate({scrollTop:0},800);return false;}).trigger( 'blur');$( '.full-search-menu').on( "click",function( e){e.preventDefault();$( 'body').css( 'overflow','hidden');$( '.full-search').css( 'visibility','visible').animate({opacity:1},200,function(){$( '#full-search-field').focus();});});$( '.full-search').keyup( function (e){if ( $( this).css('opacity')!=0&&e.keyCode==27){closeSearch();}});function closeSearch(){$( '.full-search').animate({opacity:0},200,function( e){$( this).css( 'visibility','hidden');});$( 'body').css( 'overflow','');$( '.full-search.search-field').removeClass( 'search-empty');}$( '.search-close,.search-inner').on( "click",function(){closeSearch();});$( '.full-search.search-field').on( 'input',function(event){if ( $( this).val()){$( this).removeClass( 'search-empty');}});$( '.search-form').on( 'click',function( e){e.stopPropagation();});$( '.search-form').on( 'submit',function( e){var $input=$( this).find( '.search-field');if ( $input.val()==''){e.preventDefault();$input.addClass( 'search-empty');$input.focus();}});var id;$(window).resize(function(){clearTimeout(id);id=setTimeout(calculateOffScreenMenu,500);});calculateOffScreenMenu();function calculateOffScreenMenu(){var menus=$('.desktop-menu ').find('.sub-menu'),screenWidth=$(window).width();menus.show();menus.each(function(index){var thisMenu=$(this),thisMenuWidth=thisMenu.outerWidth(),thisMenuLeft=thisMenu.offset().left;var p=$(this).parents('.sub-menu').last();if(screenWidth<(thisMenuWidth+thisMenuLeft)){p.addClass('sub-menu-left');}else{p.removeClass('sub-menu-left');}});menus.css('display','');}var videoAutoPaused=false;var $videoTag=$('.video-control');$( '.video-control').on( 'click',function(event){this[this.paused ?'play':'pause']();});$( '.hero-header-skip-to-content').on( 'click',function(event){event.preventDefault();var top=$( '#content').offset().top-$( '#site-navigation').height();$("html,body").animate({scrollTop:top},500);});$( '.hero-header-overlay').on( 'click',function(){if (!$videoTag.length)return;if ( $videoTag.get(0).paused){$videoTag.get(0).play();}else{$videoTag.get(0).pause();}});function HTML5VideoHandle(){if ( $( '#content').offset().top<$( window).scrollTop()){if (!$videoTag.get(0).paused){$videoTag.get(0).pause();videoAutoPaused=true;}}else{if ( $videoTag.get(0).paused&&videoAutoPaused){$videoTag.get(0).play();videoAutoPaused=false;}}}function makeFooterVisible(){if( $( window).scrollTop()>( $(document).height()/ 2)){$( '.site-footer').css( 'z-index',1);}else{$( '.site-footer').css( 'z-index',-1);}}makeFooterVisible();$( window).on( 'resize scroll',Exopite.throttle( makeFooterVisible,50,'scroll'));if ( $videoTag.length)$( window).on( 'resize scroll',Exopite.throttle( HTML5VideoHandle,300,'scroll'));function setFixedFooterHeight(){if ( $( '#colophon').css("position")==="fixed"){$( '#content').css( 'margin-bottom',$( '#colophon').height()+'px');}}$( window).on( 'resize scroll',Exopite.throttle( setFixedFooterHeight,200,'scroll'));});}(jQuery));var gaProperty='UA-69830455-1';(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)})(window,document,'script','https://www.google-analytics.com/analytics.js','ga');ga('create',gaProperty,'auto');ga('send','pageview');ga('set','anonymizeIp',true);var disableStr='ga-disable-'+gaProperty;if (document.cookie.indexOf(disableStr+'=true')>-1){window[disableStr]=true;}function gaOptout(){document.cookie=disableStr+'=true;expires=Thu,31 Dec 2099 23:59:59 UTC;path=/';window[disableStr]=true;alert("Opt-out-Cookie wurde erstellt.");}jQuery(document).ready(function($){var filetypes=/\.(zip|pdf)$/i;var baseHref='';if (jQuery('base').attr('href')!=undefined)baseHref=jQuery('base').attr('href');jQuery('a').each(function(){var href=jQuery(this).attr('href');if (href&&href.match(filetypes)){jQuery(this).click(function(){var extension=(/[.]/.exec(href))?/[^.]+$/.exec(href):undefined;var filePath=href;if (typeof ga!=='undefined'){console.log('send event Download '+extension+'-'+filePath);ga('send','event','Download '+extension,filePath);}else{console.log('ga not set!');}if (jQuery(this).attr('target')!=undefined&&jQuery(this).attr('target').toLowerCase()!='_blank'){setTimeout(function(){location.href=baseHref+href;},200);return false;}});}});});