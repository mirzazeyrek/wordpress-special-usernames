<?php

/**
 * Allow special usernames
 *
 * @wp-hook wpmu_validate_user_signup
 * @param   array $result
 * @return  array
 */
function allow_special_usernames( $result ) {
  $error_name = $result[ 'errors' ]->get_error_message( 'user_name' );

  if ( ! empty ( $error_name ) 
      && $error_name == __( 'Only lowercase letters (a-z) and numbers are allowed.' ) 
      && $result['user_name'] == $result['orig_username'] 
      && ! preg_match( '/[^-a-z0-9]/', $result['user_name'] ) 
  ) {
    unset ( $result[ 'errors' ]->errors[ 'user_name' ] );
    return $result;
  }
  else {
    return $result;
  }
}
add_filter( 'wpmu_validate_user_signup', 'allow_special_usernames' );