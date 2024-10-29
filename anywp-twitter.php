<?php
/*
Plugin Name: AnyWP Twitter
Plugin URI: http://anywp.com/plugins
Description: Display a list of latest tweets.
Author: AnyWP
Version: 1.0
Author URI: http://anywp.com
*/

class AnyWP_Twitter extends WP_Widget {
		
	function AnyWP_Twitter() {
		$widget_ops = array('description' => __('Display a list of latest tweets', 'AnyWP'));
		parent::WP_Widget(false, __('AnyWP Twitter', 'AnyWP'), $widget_ops);
	}

	function form($instance) {
		$title = if_var_isset($instance['title'], '');
		$username = if_var_isset($instance['username'], '');
		$tweets = if_var_isset($instance['tweets'], '');
		$avatar = (if_var_isset($instance['avatar'], false) ? ' checked="checked"' : '');
		echo '<p><label for="' . $this->get_field_id('title') . '">' . __('Title:', 'AnyWP') . '</label><br /><input class="widefat" id="' . $this->get_field_id('title') . '" name="' . $this->get_field_name('title') . '" type="text" value="' . esc_attr($title) . '" /></p>';
		echo '<p><label for="' . $this->get_field_id('username') . '">' . __('Twitter ID:', 'AnyWP') . '</label><br /><input class="widefat" id="' . $this->get_field_id('username') . '" name="' . $this->get_field_name('username') . '" type="text" value="' . esc_attr($username) . '" /></p>';
		echo '<p><label for="' . $this->get_field_id('tweets') . '">' . __('Number of Tweets:', 'AnyWP') . '</label><br /><input class="widefat" id="' . $this->get_field_id('tweets') . '" name="' . $this->get_field_name('tweets') . '" type="text" value="' . esc_attr($tweets) . '" /></p>';
		echo '<p><label for="' . $this->get_field_id('avatar') . '">' . __('Show Avatar:', 'AnyWP') . '</label> <input id="' . $this->get_field_id('avatar') . '" name="' . $this->get_field_name('avatar') . '" type="checkbox"' . $avatar  . ' /></p>';
	}

	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['title'] = $new_instance['title'];
		$instance['username'] = $new_instance['username'];
		$instance['tweets'] = $new_instance['tweets'];
		$instance['avatar'] = $new_instance['avatar'];
		return $instance;
	}

	function widget($args, $instance) {
		extract($args, EXTR_SKIP);
		echo $before_widget;
		$title = if_var_isset($instance['title'], '');
		if ($title != '') echo $before_title . $title . $after_title;
		echo '<div class="tweetFeed"></div>';
		echo '<script type="text/javascript">';
		echo 'jQuery(document).ready(function() {';
		echo 'jQuery(".tweetFeed").tweet({';
		echo 'join_text: null,';
		echo 'username: "' . if_var_isset($instance['username'], '') . '",';
		echo 'count: ' . if_var_isset($instance['tweets'], 0) . ',';
		echo 'avatar_size: ' . (if_var_isset($instance['avatar'], false) ? '32' : 'null');
		echo '});';
		echo '});';
		echo '</script>';
		echo $after_widget;
	}
}

if (! function_exists('if_var_isset')) {
	function if_var_isset(&$check, $or = null) {
		return (isset($check) ? $check : $or);
	}
}
	
function anywp_twitter_widget() {
	register_widget('AnyWP_Twitter');
	wp_enqueue_script('js_tweet',  plugins_url('/jquery.tweet.js', __FILE__), array('jquery'), false, false);
	wp_enqueue_style('css_tweet', plugins_url('/jquery.tweet.css', __FILE__), array(), false);
}
add_action('widgets_init', 'anywp_twitter_widget');

?>
