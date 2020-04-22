<?php


// If this file is called directly, abort.
if (!defined('WPINC')) die;

include_once dirname(__FILE__)."/helpers.php";

use \Slithyweb\Helper as Helper;

/**
 * This class is used when the administrator pages are requested.
 */
class SlithyWebPlugin extends Helper {

    public $gtag;

    function __construct() {
        $this->gtag = get_option('slithyweb_gtag', '');
        if($this->gtag){
            add_action('wp_head', function() { $this->google_write_gtag($this->gtag); });
        }
    }

    public function google_write_gtag($gtag){
?>
<script async src="https://www.googletagmanager.com/gtag/js?id=<?php echo $gtag; ?>"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', '<?php echo $gtag; ?>');
</script>
<?php
    } 

}
