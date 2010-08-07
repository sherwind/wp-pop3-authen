<?php
/*
Plugin Name: POP3 Authentication
Version: 0.1
Plugin URI: http://corps.i.ph/
Description: A wordpress plugin that allows the use of a POP3 server for authentication. For Wordpress 2.7/2.8
Author: Sherwin Daganato
Author URI: http://corps.i.ph/
*/

add_filter('check_password', array('POP3Authen', 'check_password'), 1, 4);

if ( !class_exists('POP3Authen') ) :
class POP3Authen {
    function check_password($check, $entered_pass, $stored_pass, $user_id) {
        $user = new WP_User($user_id);

        // don't login to pop3 server if the user is admin
        if ('admin' == $user->user_login) {
            return $check;
        }

        // XXX: requires php-imap
        // host and port are hardcoded for now
        $mbox = imap_open ("{your.pop3.server:110/pop3}INBOX", $user->user_login, $entered_pass);
        if ($mbox) {
            imap_close($mbox);
            return true;
        }
        return false;
    }
}
endif;

