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
            wp_register_script( "slithy_js", plugins_url(). '/slithyweb/js/slithyweb.js');
        });
        $this->add_the_shortcodes();
    }

    public function add_the_shortcodes() {
        add_shortcode('slithy_extract', array($this, 'page_extract_shortcode'));
        add_shortcode('slithy_tooltip', array($this, 'tooltip_shortcode'));
    }

    /**
     *
     * [slithy_tooltip] gives you the capability to add Tooltips in your pages or posts. To do this,
     * simply add the shortcode with the agument 'text' that must contains the text of the shortcode.
     */
    public function tooltip_shortcode($atts, $contents = null, $tag=''){
        extract(shortcode_atts(array(
                    'text' => null,
                    'name' => null,
                    'dir' => null,
                    'url' => null,
                    'style' => '',
                ), $atts));
        wp_enqueue_style('slithy_css');
        if( $name ){
            global $wpdb;
            // We rely on the "Name Directory" plugin if exists
            $directory = intval($dir); 
            $query = "SELECT description FROM {$wpdb->prefix}name_directory_name WHERE name = %s";
            if($directory > 0){
                // No need to escape, the value is an integer
                $query .= " AND directory = $directory";
            }
            $final_query = $wpdb->prepare($query, $name);
            $definition = $wpdb->get_var($final_query);
            if($definition){
                $text = $definition;
                if(!$contents){
                    // If we have found something and no contents provided, use the name as the text.
                    $contents = $name;
                }
            }
        }
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

    public function page_extract_shortcode($atts, $contents = null, $tag=''){
        extract(shortcode_atts(array(
                    'url' => $_SERVER['REQUEST_URI']
                ), $atts));
        
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
