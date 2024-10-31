<?php
/*
Plugin Name: Really Simple Tweet
Version: 1.0
Author: Roger Howorth
Description: Function to send text as a tweet. Gets your Twitter username and password from Twitter Tools plugin.
Author URI: http://www.thehypervisor.com
Plugin URI: http://www.thehypervisor.com/really-simple-tweet/

License: GPL2

    Copyright 2009-2010  Roger Howorth  (email : roger@rogerh.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License version 2, 
    as published by the Free Software Foundation. 
    
    You may NOT assume that you can use any other version of the GPL.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.
    
    The license for this software can likely be found here: 
    http://www.gnu.org/licenses/gpl-2.0.html
*/


function simple_tweet() {
        $num_args = func_num_args();
        if ( $num_args == '0' )
           wp_die('You must pass some text to simple_tweet when you invoke the function. E.g. simple_tweet("string_to_tweet")');
        $args = func_get_args();
        $tweet = $args[0];
        if ( $num_args == 1) { 
	    $twitter_username = get_option('aktt_twitter_username');
	    $twitter_password = get_option('aktt_twitter_password');
        } else {
 	    $twitter_username = $args[1];
	    $twitter_password = $args[2];
        }
	require_once(ABSPATH.WPINC.'/class-snoopy.php');
        //now let's Tweet!
        $snoop = new Snoopy();
        $snoop->agent = 'www.thehypervisor.com';
        $snoop->user = $twitter_username;
        $snoop->pass = $twitter_password;
        $snoop->submit(
            'http://twitter.com/statuses/update.json',
            array(
                'status' => $tweet,
                'source' => 'www.thehypervisor.com'
            )
        );
        // Test Twitter result ok
	if (strpos($snoop->response_code, '200')) {
		// Succeeded, you're good to go
	} else {
		wp_die('Function simple_tweet: Twitter login failed. You must configure Twitter Tools with your Twitter username and password, or supply this information when calling simple_tweet. E.g. simple_tweet( "text_to_tweet", "your_Twitter_username","your_twitter_password")');
	}
}
?>
