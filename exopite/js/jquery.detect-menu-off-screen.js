/**
 * Calculate if menu off the screen
 */
 var id;
 $(window).resize(function() {
     clearTimeout(id);
     id = setTimeout(calculateOffScreenMenu, 500);
 });

 calculateOffScreenMenu();

 function calculateOffScreenMenu() {
     var menus = $('.desktop-menu ').find('.sub-menu'),
     screenWidth = $(window).width();

     menus.show();
     menus.each(function(index) {
         var thisMenu = $(this),
         thisMenuWidth = thisMenu.outerWidth(),
         thisMenuLeft = thisMenu.offset().left;
         var p = $(this).parents('.sub-menu').last();
         if(screenWidth < (thisMenuWidth + thisMenuLeft)) {
             p.addClass('sub-menu-left');
         } else {
             p.removeClass('sub-menu-left');
         }
     });
     menus.css('display', '');
 }
