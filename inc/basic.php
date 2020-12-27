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

	public static function show304andExit() {
		$protocol = $_SERVER["SERVER_PROTOCOL"];
		if ($protocol != 'HTTP/1.1' && $protocol != 'HTTP/1.0') {
			$protocol = 'HTTP/1.0';
		}
		header($protocol . ' 304 Not Modified');
		exit(0);
	}

    function __construct() {
		add_action( 'template_redirect', function() use ( &$wp ) {
			/**
			 * The following code add a 304 response in case of the "If-None-Match" has been
			 * sent and the post has been pushed before. Note this algorithm works only for
			 * posts and pages. It should give faster responses when a user go back to the
			 * page.
			 *
			 */
	    	if(is_singular() && !is_preview() && !is_user_logged_in() && !headers_sent()){
    			$headers = headers_list();
				$requested = @$_SERVER['HTTP_IF_NONE_MATCH'];
    			if((empty( $headers['etag'] ) || !empty($requested)) && !!get_option('slithyweb_etag', '0')){
					$post_id = get_the_ID();
					$last_modified = get_lastpostmodified();
    				$etag = "wp-${post_id}-" . preg_replace('/[^0-9]/', '-', $last_modified);
					// echo "REQUESTED: '$requested'";
					if(!empty($requested) && strstr($requested, $etag) !== FALSE){
						self::show304andExit();
					}
    				if( $post_id && $last_modified && ! headers_sent() )
        				header("Etag: $etag");	
				}

				$since_last = @$_SERVER['HTTP_IF_MODIFIED_SINCE'];
    			if( (empty( $headers['last-modified'] ) || !empty($since_last)) && !!get_option('slithyweb_last_modified', '0')){
					$last_modified = get_lastpostmodified( 'GMT' );
					$timestamp = strtotime($since_last);
					if($timestamp > 0 && strcmp(date('Y-m-d H:i:s', $timestamp), $last_modified) >= 0){
						self::show304andExit();
					}

    				// Add last modified header
    				if( $last_modified && ! headers_sent() )
        				header( "Last-Modified: " . mysql2date( 'D, d M Y H:i:s', $last_modified, false) . ' GMT' );
				}
    			if( empty( $headers['cache-control'] )){
					$cache_duration = intval(get_option('slithyweb_maxage', "60")) * 60;
					if($cache_duration > 0){
        				header( "Cache-control: max-age=" . $cache_duration);
					}
				}
			}
		});
        if(!current_user_can( 'manage_options' )){
            //  If the current use can manage options, he is an administrator.
            //  Then DO NOT activate the Google Tag to avoid false reports
            //  about visitors.
            $this->gtag = get_option('slithyweb_gtag', '');
            if($this->gtag){
                add_action('wp_head', function() {
                        if(!is_preview()){
                            $this->google_write_gtag($this->gtag); 
                        }
                    });
            }
        }
        $this->add_the_shortcodes();
    }

    public function add_the_shortcodes() {
        add_action('init', function() {
            wp_register_style( "slithy_css", plugin_dir_url(__FILE__). '/css/slithyweb.css');
            wp_register_script( "slithy_js", plugins_url(__FILE__). '/js/slithyweb.js');
        });
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
            } else {
                error_log("Name '$name' not found in post " . get_the_ID() . ". Please check syntax." ); 
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
