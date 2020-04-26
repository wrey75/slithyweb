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
        add_action('init', function() {
            wp_register_style( "slithy_css", plugins_url(). '/slithyweb/css/slithyweb.css');
        });
        $this->add_the_shortcodes();
    }

    public function add_the_shortcodes() {
        add_shortcode('page_extract', array($this, 'page_extract_shortcode'));
        add_shortcode('slithy_tooltip', array($this, 'tooltip_shortcode'));
    }

    public function tooltip_shortcode($atts, $contents = null, $tag=''){
        extract(shortcode_atts(array(
                    'text' => null,
                    'url' => null,
                    'style' => '',
                ), $atts));
        wp_enqueue_style('slithy_css');
        if(!$url && !$text){
            error_log('"text" or "url" is expected for shortcode [slithy_tooltip].');
            return esc_attr($contents);
        }
        if($url != null){
            error_log('"url" capability not yet available for shortcode [slithy_tooltip].');
        }
        return '<span class="slithy_tooltip">' . esc_attr($contents)
                    . '<span class="slithy_tooltiptext">' . esc_attr($text)
                    . '</span></span>';

    }

    /*
    public function page_extract_shortcode($atts, $contents = null, $tag=''){
        extract(shortcode_atts(array(
                    'url' => $_SERVER['REQUEST_URI']
                ), $atts));
        
    }
    */

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
