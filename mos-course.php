<?php
/*
Plugin Name: Mos Course
Plugin URI: http://URI_Of_Page_Describing_Plugin_and_Updates
Description: Unlike other available WordPress learning managment system (LMS) plugins, <a href="http://mostak.belocal.today/" target="_blank" rel="nofollow">MOS Courses</a> plugin is free, has no recurring subscription fees and has has plenty of features out of the box. Create as many courses and lessons as you’d like and even require users sign up before viewing course content if you’d like. A premium extension will available soon which allows you to sell members only access to your courses.
Version: 1.0.0
Author: Md. Mostak Shahid
Author URI: http://mostak.belocal.today/
License: GPL2
*/
require_once ( plugin_dir_path( __FILE__ ) . 'mos-course-functions.php' );
require_once ( plugin_dir_path( __FILE__ ) . 'mos-course-settings.php' );
require_once ( plugin_dir_path( __FILE__ ) . 'mos-course-post-types.php' );
require_once ( plugin_dir_path( __FILE__ ) . 'mos-course-taxonomy.php' );
require_once ( plugin_dir_path( __FILE__ ) . 'mos-course-metabox.php' );
require_once('plugins/update/plugin-update-checker.php');
$pluginInit = Puc_v4_Factory::buildUpdateChecker(
	'https://raw.githubusercontent.com/mostak-shahid/update/master/mos-course.json',
	__FILE__,
	'mos-course'
);