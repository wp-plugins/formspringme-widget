<?php
/**
Plugin Name: Formspring.me Widget
Plugin URI: http://www.noahcoffey.com/formspring-wordpress-widget
Description: Adds a Formspring.me question box to your sidebar.
Version: 0.3
Author: Noah Coffey
Author URI: http://www.noahcoffey.com
**/


// [formspring]
function formspring_func($atts) {
	extract(shortcode_atts(array(
		'username' => 'formspringapi',
		'questions' => '5',
		'ask' => 'no',
	), $atts));
		
	echo '<link type="text/css" rel="stylesheet" href="' . get_bloginfo('wpurl') . '/wp-content/plugins/formspringme-widget/fsmWidget.css" />' . "\n";

	if ($ask=="yes"){
		$fsmSize = 		"large";
		$fsmWidth =		"400px";
		$fsmHeight =	"200px";
	
		echo '<iframe src="http://www.formspring.me/widget/view/'.$username.'?&size='.$fsmSize.'&bgcolor='.$fsmBGColor.'&fgcolor='.$fsmFGColor.'" frameborder="0" scrolling="no" width="'.$fsmWidth.'" height="'.$fsmHeight.'" style="border:none;padding:0;margin:0;"><a href="http://www.formspring.me/'.$username.'">http://www.formspring.me/'.$username.'</a></iframe>';

	}
	

?>
<?php // Get RSS Feed(s)
include_once(ABSPATH . WPINC . '/feed.php');

// Get a SimplePie feed object from the specified feed source.
$rss = fetch_feed("http://www.formspring.me/profile/{$username}.rss");
if (!is_wp_error( $rss ) ) : // Checks that the object is created correctly 
    // Figure out how many total items there are 
    $maxitems = $rss->get_item_quantity($questions); 

    // Build an array of all the items, starting with element 0 (first element).
    $rss_items = $rss->get_items(0, $maxitems); 
endif;
?>

<div class="fsquestions">
    <?php if ($maxitems == 0) echo '<li>No questions.</li>';
    else
    // Loop through each feed item and display each item as a hyperlink.
    foreach ( $rss_items as $item ) : ?>
    	<div class="qa">
	        <div class="question"><?php echo $item->get_title(); ?></div>
	        <div class="answer"><?php echo $item->get_content(); ?></div>
		</div>
    <?php endforeach; ?>
</div>
<?php
}

add_shortcode('formspring', 'formspring_func');


add_action( 'widgets_init', 'fsm_load_widgets' );

function fsm_load_widgets() {
	register_widget( 'fsmWidget' );
}

class fsmWidget extends WP_Widget {

	/**
	 * Widget setup.
	 */
	function fsmWidget() {
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'fsmWidgetBox', 'description' =>'Displays a FormSpring.me question box on your sidebar.' );

		/* Widget control settings. */
		$control_ops = array( 'width' => 180, 'height' => 275, 'id_base' => 'fsmWidget' );

		/* Create the widget. */
		$this->WP_Widget( 'fsmWidget', 'FormSpring.me Widget', $widget_ops);
	}

	/**
	 * How to display the widget on the screen.
	 */
	function widget( $args, $instance ) {
		extract( $args );

		/* Our variables from the widget settings. */
		$title = apply_filters('widget_title', $instance['title'] );
		$fsmUsername = 	$instance['fsmUsername'];
		$fsmSize = 		$instance['fsmSize'];
		$fsmBGColor = 	urlencode($instance['fsmBGColor']);
		$fsmFGColor = 	urlencode($instance['fsmFGColor']);

		switch ($fsmSize) {
		    case "small":
		        $fsmHeight =	"275px";
		        $fsmWidth =		"120px";
		        break;
		    case "medium":
		        $fsmHeight =	"275px";
		        $fsmWidth =		"180px";
		        break;
		    case "large":
		        $fsmHeight =	"400px";
		        $fsmWidth =		"275px";
		        break;
		}

		/* Before widget (defined by themes). */
		echo $before_widget;

		/* Display the widget title if one was input (before and after defined by themes). */
		if ( $title )
			echo $before_title . $title . $after_title;

		echo '<iframe src="http://www.formspring.me/widget/view/'.$fsmUsername.'?&size='.$fsmSize.'&bgcolor='.$fsmBGColor.'&fgcolor='.$fsmFGColor.'" frameborder="0" scrolling="no" width="'.$fsmWidth.'" height="'.$fsmHeight.'" style="border:none;"><a href="http://www.formspring.me/'.$fsmUsername.'">http://www.formspring.me/'.$fsmUsername.'</a></iframe>';

		/* After widget (defined by themes). */
		echo $after_widget;
	}

	/**
	 * Update the widget settings.
	 */
	function update( $new_instance, $old_instance ) {

		$instance = $old_instance;

		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['fsmUsername'] = strip_tags( $new_instance['fsmUsername'] );
		$instance['fsmSize'] = strip_tags( $new_instance['fsmSize'] );

		$instance['fsmBGColor'] = $new_instance['fsmBGColor'];
		$instance['fsmFGColor'] = $new_instance['fsmFGColor'];

		return $instance;

	}

	/**
	 * Displays the widget settings controls on the widget panel.
	 */
	function form( $instance ) {

		/* Set up some default widget settings. */
		$defaults = array( 'title' => 'Ask Me Anything', 'fsmUsername' => '', 'fsmSize' => 'medium', 'fsmBGColor' => '#CCCCCC', 'fsmFGColor' => '#FFFFFF' );
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>

		<!-- Widget Title: Text Input -->
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>">Title</label>
			<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>"  />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'fsmUsername' ); ?>">FormSpring.me Username</label>
			<input id="<?php echo $this->get_field_id( 'fsmUsername' ); ?>" name="<?php echo $this->get_field_name( 'fsmUsername' ); ?>" value="<?php echo $instance['fsmUsername']; ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'fsmSize' ); ?>">Size</label> 
			<select id="<?php echo $this->get_field_id( 'fsmSize' ); ?>" name="<?php echo $this->get_field_name( 'fsmSize' ); ?>" class="widefat" style="width:100%;">
				<option <?php if ( 'small' == $instance['fsmSize'] ) echo 'selected="selected"'; ?>>small</option>
				<option <?php if ( 'medium' == $instance['fsmSize'] ) echo 'selected="selected"'; ?>>medium</option>
				<option <?php if ( 'large' == $instance['fsmSize'] ) echo 'selected="selected"'; ?>>large</option>
			</select>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'fsmBGColor' ); ?>">Background Color</label>
			<input id="<?php echo $this->get_field_id( 'fsmBGColor' ); ?>" name="<?php echo $this->get_field_name( 'fsmBGColor' ); ?>" value="<?php echo $instance['fsmBGColor']; ?>"  />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'fsmFGColor' ); ?>">Foreground Color</label>
			<input id="<?php echo $this->get_field_id( 'fsmFGColor' ); ?>" name="<?php echo $this->get_field_name( 'fsmFGColor' ); ?>" value="<?php echo $instance['fsmFGColor']; ?>"  />
		</p>

	<?php
	}
}

?>