<?php

/*-----------------------------------------------------------------------------------*/
/*	 Widget for Twitter Display
/*-----------------------------------------------------------------------------------*/

class WP_Widget_Recent_Tweets extends WP_Widget {

	function WP_Widget_Recent_Tweets() {

		$widget_ops = array('classname' => 'widget_recent_tweets','description' => __('Custom Widget that displays recent tweets.', MAX_SHORTNAME) );
		$this->WP_Widget( 'custom_recent_tweets', __('Custom Recent Tweets',MAX_SHORTNAME), $widget_ops );
		$this->alt_option_name = 'widget_recent_tweets';

    add_action( 'save_post', array(&$this, 'flush_widget_cache') );
    add_action( 'deleted_post', array(&$this, 'flush_widget_cache') );
    add_action( 'switch_theme', array(&$this, 'flush_widget_cache') );

	}

/*-----------------------------------------------------------------------------------*/
/*	Display Widget
/*-----------------------------------------------------------------------------------*/

	function widget( $args, $instance ) {

        $cache = wp_cache_get('widget_custom_recent_tweets', 'widget');

        if ( !is_array($cache) )
            $cache = array();

        if ( isset($cache[$args['widget_id']]) ) {
            echo $cache[$args['widget_id']];
            return;
        }

        ob_start();
        extract($args);

		$title    = apply_filters('widget_title', $instance['title'] );
		$user     = $instance['user'];
		$tweets   = $instance['tweets'];
		$api      = $instance['twitterapi'];

		echo $before_widget;

		if ( $title )
			echo $before_title . $title . $after_title;

		 ?>

    <?php if($api != "") : ?>
    <a class="twitter-timeline" href="https://twitter.com/twitterapi" data-widget-id="<?php echo $api ?>" data-theme="dark" data-link-color="#c73a3a" data-chrome="noheader nofooter noborders transparent" data-related="twitterapi,twitter" data-aria-polite="assertive" data-tweet-limit="<?php echo $tweets; ?>" height="500" lang="EN">Tweets von <?php echo $instance['user'] ?></a>
    <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>

    <?php else : ?>

    <p><strong><?php _e('Please add a valid Twitter Data Widget API Key in your Widget Settings', MAX_SHORTNAME) ?></strong></p>

    <?php endif; ?>

		<?php

		echo $after_widget;

    if($api != "") :
      max_get_twitter_js();
    endif;

    $cache[$args['widget_id']] = ob_get_flush();
    wp_cache_set('widget_custom_recent_tweets', $cache, 'widget');

	}

/*-----------------------------------------------------------------------------------*/
/*	Update Widget
/*-----------------------------------------------------------------------------------*/

	function update( $new_instance, $old_instance ) {

		$instance = $old_instance;

		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['user'] = strip_tags( $new_instance['user'] );
		$instance['tweets'] = strip_tags( $new_instance['tweets'] );
		$instance['twitterapi'] = strip_tags( $new_instance['twitterapi'] );

		$this->flush_widget_cache();

        $alloptions = wp_cache_get( 'alloptions', 'options' );
        if ( isset($alloptions['widget_custom_recent_tweets']) )
            delete_option('widget_custom_recent_tweets');

        return $instance;
	}

    function flush_widget_cache() {
        wp_cache_delete('widget_custom_recent_tweets', 'widget');
    }


/*-----------------------------------------------------------------------------------*/
/*	Widget Settings
/*-----------------------------------------------------------------------------------*/

	function form( $instance ) {

		$settings = array(
			'user' => 'envato',
			'tweets' => '5',
			'title' => 'Recent Tweets',
			'twitterapi' => ''
		);

		$instance = wp_parse_args( (array) $instance, $settings ); ?>

		<ul>

			<li>
				<p>
					<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', MAX_SHORTNAME) ?></label>
					<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" />
				</p>
			</li>

			<li>
				<p>
					<label for="<?php echo $this->get_field_id( 'user' ); ?>"><?php _e('Twitter Username:', MAX_SHORTNAME) ?></label>
					<input class="widefat" id="<?php echo $this->get_field_id( 'user' ); ?>" name="<?php echo $this->get_field_name( 'user' ); ?>" value="<?php echo $instance['user']; ?>" />
				</p>
			</li>

			<li>
				<p>
					<label for="<?php echo $this->get_field_id( 'tweets' ); ?>"><?php _e('Number of tweets:', MAX_SHORTNAME) ?></label>
					<input class="widefat" id="<?php echo $this->get_field_id( 'tweets' ); ?>" name="<?php echo $this->get_field_name( 'tweets' ); ?>" value="<?php echo $instance['tweets']; ?>" />
				</p>
			</li>

			<li>
				<p>
					<label for="<?php echo $this->get_field_id( 'twitterapi' ); ?>"><?php _e('Data Widget API:', MAX_SHORTNAME) ?></label>
					<input class="widefat" id="<?php echo $this->get_field_id( 'twitterapi' ); ?>" name="<?php echo $this->get_field_name( 'twitterapi' ); ?>" value="<?php echo $instance['twitterapi']; ?>" />
				</p>
					<p>
					  <small>
					  <strong><?php _e("How to get a Twitter Data Widget API key?", MAX_SHORTNAME) ?></strong><br />
					  1. <?php _e("Sign in on twitter.com", MAX_SHORTNAME) ?><br />
            2. <a href="https://twitter.com/settings/widgets/new" target="_blank"><?php _e("Create a new widget", MAX_SHORTNAME) ?> </a><br />
            3. <?php _e("The widget-id is provided by Twitter (https://twitter.com/settings/widgets/xxxxxxxx/ - the xxx is your widget-id)", MAX_SHORTNAME) ?><br />
            4. <?php _e("You don't have to make any settings on this widget. We are doing it for you in the theme.", MAX_SHORTNAME) ?>
            </small>
					</p>
			</li>

		</ul>

		<?php
	}
}

/*-----------------------------------------------------------------------------------*/
/*	Register Widget
/*-----------------------------------------------------------------------------------*/

add_action( 'widgets_init', 'max_recent_tweets_widgets' );

function max_recent_tweets_widgets() {
	register_widget( 'WP_Widget_Recent_Tweets' );
}

?>
