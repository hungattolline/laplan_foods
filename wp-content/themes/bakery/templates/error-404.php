<?php 
/*
	Template Name: Error 404
*/

if ( ! defined( 'ABSPATH' ) ) exit();

global $wp_query;

$wp_query->set_404();

status_header( 404 );

get_template_part( 404 );

exit();
