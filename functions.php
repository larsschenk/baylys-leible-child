<?php
// slow down heartbeat
add_filter('heartbeat_send', 'my_heartbeat_settings');
function my_heartbeat_settings($response)
{
    if ($_POST['interval'] != 60) {
        $response['heartbeat_interval'] = 60;
    }
    return $response;
}
// remove unwanted dashboard widgets for relevant users
function remove_dashboard_widgets()
{
    remove_meta_box('dashboard_primary', 'dashboard', 'normal'); // wp news
    remove_meta_box('dashboard_quick_press', 'dashboard', 'side');
    $user = wp_get_current_user();
    if (!$user->has_cap('manage_options')) {
        remove_meta_box('dashboard_incoming_links', 'dashboard', 'normal');
        remove_meta_box('dashboard_plugins', 'dashboard', 'normal');
        remove_meta_box('dashboard_secondary', 'dashboard', 'normal');
        remove_meta_box('dashboard_incoming_links', 'dashboard', 'normal');
        remove_meta_box('dashboard_recent_drafts', 'dashboard', 'side');
        remove_meta_box('dashboard_recent_comments', 'dashboard', 'normal');
        remove_meta_box('dashboard_right_now', 'dashboard', 'normal');
    }
}
add_action('admin_init', 'remove_dashboard_widgets');
// load parent
add_action('wp_enqueue_scripts', 'enqueue_parent_theme_style');
function enqueue_parent_theme_style()
{
    wp_enqueue_style('parent-style', get_template_directory_uri().'/style.css', array(), '1.1.1');
    wp_enqueue_style('child-style', get_stylesheet_directory_uri().'/baylys-leible-child.css', array(), '1.4.1');
}
