<?php
/*
Plugin Name: WordPress Special Usernames
Plugin URI: https://github.com/mirzazeyrek/wordpress-special-usernames
Description: Allow special characters and remove minimum character limit in usernames.
Tags: username, multi-site, special characters, restrictions
Version: 1.0
Author: Ugur Mirza Zeyrek
Author URI: http://mirzazeyrek.wordpress.com
*/
// Prevent direct calls
if(!defined('ABSPATH')) exit;

/**
 * Allow special usernames and remove minimum character limit.
 *
 * @wp-hook wpmu_validate_user_signup
 * @param   array $result
 * @return  array
 */
function allow_special_usernames( $result ) {
$error_name = $result[ 'errors' ]->get_error_message( 'user_name' );

if ( ! empty ( $error_name ) 
      && ( $error_name == __( 'Usernames can only contain lowercase letters (a-z) and numbers.' ) 
 	|| $error_name == __( 'Username must be at least 4 characters.' ) )
       && $result['user_name'] == $result['orig_username'] 
       && ! preg_match( '/[^-_a-z0-9]/', $result['user_name'] ) 
   ) {
     unset ( $result[ 'errors' ]->errors[ 'user_name' ] );
     return $result;
   } else {
     return $result;
   }
}

add_filter( 'wpmu_validate_user_signup', 'allow_special_usernames' );
