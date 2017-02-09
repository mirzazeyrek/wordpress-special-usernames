<?php
/*
Plugin Name: WordPress Special Usernames
Plugin URI: https://github.com/mirzazeyrek/wordpress-special-usernames
Description: Allow special characters in usernames.
Tags: username, multi-site, special characters, restrictions
Version: 1.0
Author: Ugur Mirza Zeyrek
Author URI: http://mirzazeyrek.wordpress.com
*/
// Prevent direct calls
if(!defined('ABSPATH')) exit;

/**
 * Allow special usernames
 *
 * @wp-hook wpmu_validate_user_signup
 * @param   array $result
 * @return  array
 * @source http://stackoverflow.com/questions/32047894/username-only-lowercase-and-numbers-in-wp-multi/32054345#32054345
 */
function wpmu_no_username_error( $result ) {
    $error_name = $result[ 'errors' ]->get_error_messages( 'user_name' );
    if ( empty ( $error_name ) 
        or false===$key=array_search( __( 'Usernames can only contain lowercase letters (a-z) and numbers.' ), $error_name)
    ) {
    return $result;
    }
//  only remove the error we are disabling, leaving all others
    unset ( $result[ 'errors' ]->errors[ 'user_name' ][$key] );
/**
 *  re-sequence errors in case a non sequential array matters
 *  e.g. if a core change put this message in element 0 then get_error_message() would not behave as expected)
 */
    $result[ 'errors' ]->errors[ 'user_name' ] = array_values( $result[ 'errors' ]->errors[ 'user_name' ] );
    return $result;
}
add_filter( 'wpmu_validate_user_signup', 'wpmu_no_username_error' );
