<?php

/*
Plugin Name: Wordpress Visitors
Plugin URI: http://jakir.newstylebd.com/
Description: All visitors, Todays visitors, Current visitors are available in this plugins.
Version: 1.0
Author: http://jakir.newstylebd.com/
License: none
*/
require_once ('total_visitor_counter.php');
class wp_visitors extends Total_visitor_counter
{
    function __construct() {
        parent::__construct(false, $name = __('Wordpress Visitors'));
    }
    
    function widget($args, $instance) { 
            
        ?>
        <div class="container00">
            <div class="container01">Visitors</div><hr class="hrow00">
            
            <div>
                <?php echo $this->VisitorCounter(); ?>
                <span>Online Visitors : </span> 
                <span class='online_visitor'><?php echo $this->onlineVisitor(); ?></span> 
            </div>
            <div>
                <span>Todays Hits : </span>
                <span class="todays_hit"><?php $this->todaysVisitor(); ?></span>
            </div>
            <div>
                <span>Total Hits : </span>
                <span class="total_hit"><?php $this->getAmountVisitors(); ?></span>
            </div>
        </div>
        <?php
    }
    
    function update() {
    }
    
    function form() {
    }

}



register_activation_hook(__FILE__,'dbsync_install');
function dbsync_install()
{
	global $wpdb;
	global $dbsync_db_version;
	
	$dbsync_tt_table = $wpdb->prefix."counter_total";

	$sql = "CREATE TABLE ".$dbsync_tt_table." (id bigint(20) NOT NULL AUTO_INCREMENT,
	ip varchar(255) NOT NULL,
	browser varchar(255) NOT NULL,
	lastvisit datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
	UNIQUE KEY id(id)
	)";

	require_once(ABSPATH. 'wp-admin/includes/upgrade.php');
	dbDelta($sql);
	add_option("dbsync_db_version",$dbsync_db_version);
}






add_action('widgets_init', 'wp_visitors_widget_registration');  

function wp_visitors_widget_registration() {  
    register_widget('wp_visitors'); 
}




function add_ajax_file()
{
    wp_enqueue_script('my-ajax',  plugins_url('/js/ajax.js',__FILE__),array('jquery'),TRUE);
    wp_localize_script('my-ajax', 'my_ajax_url', array(
       'ajax_url'=>  admin_url('admin-ajax.php') 
    ));    
}
add_action('wp_enqueue_scripts','add_ajax_file');
add_action('wp_ajax_ajax_online_visitor','ajax_online_visitor');
add_action('wp_ajax_nopriv_ajax_online_visitor','ajax_online_visitor');
add_action('wp_ajax_ajax_todays_hit','ajax_todays_hit');
add_action('wp_ajax_nopriv_ajax_todays_hit','ajax_todays_hit');
add_action('wp_ajax_ajax_total_hit','ajax_total_hit');
add_action('wp_ajax_nopriv_ajax_total_hit','ajax_total_hit');


function ajax_online_visitor()
{
    global $wpdb;
    $wpdb->get_row( "SELECT COUNT(id) AS tid FROM wp_counter_total WHERE lastvisit >= '".date('Y-m-d H:i:s', strtotime('-5 minutes'))."' GROUP BY ip,browser" );
    echo $wpdb->num_rows;
    wp_die();
}

function ajax_todays_hit()
{
    global $wpdb;
    $row = $wpdb->get_row( "SELECT COUNT(id) AS tid FROM wp_counter_total WHERE DATE(lastvisit) = '".date('Y-m-d')."'" );
    echo $row->tid;
    wp_die();
}


function ajax_total_hit()
{
    global $wpdb;
    $row = $wpdb->get_row( "SELECT COUNT(id) AS tid FROM wp_counter_total" );
    echo $row->tid;
    wp_die();
}

?>