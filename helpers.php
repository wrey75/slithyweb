<?php

namespace Slithyweb;

/**
 * This is an helper class for our internal classes.
 * 
 * The operator are relative to translations and also
 * to create HTML tags
 * 
 */
class Helper { 

    //
    // HELPERS TO BE INCLUDED IN CLASSES AND PROVIDES
    // SOME USEFUL OPERATORS WITHOUT ANY RISK OF SOME
    // NAME DUPLICATIONS.
    //
    // THIS CODE CAN BE REUSED QUITE EASILY
    //

    const DOMAIN = 'slithy-web';

    /**
     * Translate a text using the defined DOMAIN.
     */
    public static function T($str){
        return __($str, self::DOMAIN); 
    }

    public static function parag($str){
        printf("<p>%s</p>\n", __($str, self::DOMAIN)); 
    }

	/**
	 * This function creates a HTML/XML tag based on the name and the attributes.
	 * 
	 * If the name finishes with "/", the tag will
	 * be an opening one and a closing one. Typically
	 * the tag named "img/" will produce <img .... />
	 * 
	 * @param string $name the tag name.
	 * @param array $attributes the attributes as a dictionary
	 */
	public static function tag( $name, $attributes = array() ){
		$close = ">";
		if( $name[ strlen($name)-1 ] == "/" ){
			$name = substr($name, 0, -1);
			$close = "/>";
		}
		$tag = "<" . $name;
  	
		if( count($attributes) > 0 ){
			if( !is_array($attributes) ){
				echo "<pre>"; debug_print_backtrace(); echo "</pre>";
				trigger_error( "array expected but [".$attributes."] received." );
			}
			else {
				foreach( $attributes as $key => $value ){
					if( is_int($key) ){
						// if the key is not provided or numeric, then the tag is made
                        // only of the value without the "=" like "ckecked" in <option> tag.
						$tag .= ' ' . $value;
					}
					else if( isset($value) ){
						if( is_array($value) ){
							// When the argument is given as an array, implode it to
							// a single value (usefull for "class" attribute). 
							$value = implode(' ',$value);
						}
						// $tag .= " $key=\"".str_replace("\"", "&quot;", str_replace("&", "&amp;", $value)).'"';
                        // Use the WordPress escaping rather the manual one
						$tag .= " $key=\"".esc_attr($value).'"';
					}
				}
			}
		}
		return $tag . $close;
	}

}
