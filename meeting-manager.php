<?php
/**
 * Plugin name: Meeting Manager
 * Plugin URI: https://onlytarikul.com
 * Description: Get information from external APIs in WordPress
 * Author: Laurence Bahiirwa
 * Author URI: https://onlytarikul.com
 * version: 0.1.0
 * License: GPL2 or later.
 * text-domain: wecoder-meeting
 */

// If this file is access directly, abort!!!
defined('ABSPATH') or die('Unauthorized Access');

// library include
require_once 'lib/firebase/php-jwt/src/JWT.php';

function my_generate_jwt_key()
{
    $key = 'j1n_ugpFQa-C1lreE6rIzw';
    $secret = 'rxlan32Bv5Va3ATVuYLQJUwalAqYg49ZW8yq';
    $token = array(
        'iss' => $key,
        'exp' => time() + 3600, // 60 seconds as suggested
    );
    return JWT::encode($token, $secret);
}

/**
 * Register a custom menu page.
 */

add_shortcode('zoom_meeting', 'my_shortcode_content');

function my_shortcode_content()
{

    $data['host_id'] = 'tarikul47@gmail.com';

    $data = [
        'topic' => "New Meeting by Raju at night",
        'start_time' => '2022-07-19',
        'password' => '1234',
        'duration' => 60,
    ];

    // create arguments
    $arguments = [
        'method' => 'POST',
        //'sslverify' => false,
        'body' => !empty($data) ? wp_json_encode($data) : array(),
        'headers' => [
            'Authorization' => 'Bearer ' . my_generate_jwt_key(),
            'Content-Type' => 'application/json',
        ],
    ];

    $remote_url = "https://api.zoom.us/v2/users/tarikul47@gmail.com/meetings";

    $response = wp_remote_post($remote_url, $arguments);
    //$response_body = wp_remote_retrieve_body($response);
    $response_code = wp_remote_retrieve_response_code($response);

    if (is_wp_error($response)) {
        $error_msg = date('d m Y g:i:a ') . $response->get_error_message();
        return $error_msg;
    } else {
        $data = json_decode(wp_remote_retrieve_body($response));

        $meeting_data = [
            'topic' => $data->topic,
            'start_time' =>  $data->start_time,
            'uuid'=> $data->uuid,
            'password' => $data->password,
        ];

        ob_start();
        require 'views/meeting.php';
        return ob_get_clean();
    }
}
