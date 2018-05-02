<?php
defined('ABSPATH') or die( 'You cannot access this page directly.' );

/* Assembly google font query based on settings
 * (include/google-fonts.php)
 *
 * Include <nosrcipt> fall back for JS disabled
 */
$google_fonts = get_google_fonts();

?><script>
var WebFontConfig = {
    google: {
        families: [<?php echo $google_fonts['async']; ?>]
    },
    timeout: 2000,
    active: function() {
      sessionStorage.fonts = true;
    }
};
</script>
<noscript>
    <link href='//fonts.googleapis.com/css?family=<?php echo $google_fonts['regular']; ?>' rel='stylesheet' type='text/css'>
</noscript>
