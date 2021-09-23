<?php

/**
 * Class Upcoming_Events
 */
class Upcoming_Bookings extends WP_Widget {

	/**
	 * Initializing the widget
	 */
	public function __construct() {
		$widget_ops = array(
			'class'			=>	'uep_upcoming_bookings',
			'description'	=>	__( 'A widget to display a list of upcoming bookings', 'uep' )
		);

		parent::__construct(
			'uep_upcoming_bookings',			//base id
			__( 'Upcoming Bookings', 'uep' ),	//title
			$widget_ops
		);
	}


	/**
	 * Displaying the widget on the back-end
	 * @param  array $instance An instance of the widget
	 */
	public function form( $instance ) {
		$widget_defaults = array(
			'title'			=>	'Upcoming Bookings',
			'number_bookings'	=>	5
		);

		$instance  = wp_parse_args( (array) $instance, $widget_defaults );
		?>
		
		<!-- Rendering the widget form in the admin -->
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title', 'uep' ); ?></label>
			<input type="text" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" class="widefat" value="<?php echo esc_attr( $instance['title'] ); ?>">
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'number_bookings' ); ?>"><?php _e( 'Number of bookings to show', 'uep' ); ?></label>
			<select id="<?php echo $this->get_field_id( 'number_bookings' ); ?>" name="<?php echo $this->get_field_name( 'number_bookings' ); ?>" class="widefat">
				<?php for ( $i = 1; $i <= 10; $i++ ): ?>
					<option value="<?php echo $i; ?>" <?php selected( $i, $instance['number_bookings'], true ); ?>><?php echo $i; ?></option>
				<?php endfor; ?>
			</select>
		</p>

		<?php
	}


	/**
	 * Making the widget updateable
	 * @param  array $new_instance New instance of the widget
	 * @param  array $old_instance Old instance of the widget
	 * @return array An updated instance of the widget
	 */
	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		$instance['title'] = $new_instance['title'];
		$instance['number_bookings'] = $new_instance['number_bookings'];

		return $instance;
	}


	/**
	 * Displaying the widget on the front-end
	 * @param  array $args     Widget options
	 * @param  array $instance An instance of the widget
	 */
	public function widget( $args, $instance ) {

		extract( $args );
		$title = apply_filters( 'widget_title', $instance['title'] );

		//Preparing the query for bookings
		$meta_quer_args = array(
			'relation'	=>	'AND',
			array(
				'key'		=>	'booking-end-date',
				'value'		=>	time(),
				'compare'	=>	'>='
			)
		);

		$query_args = array(
			'post_type'				=>	'booking',
			'posts_per_page'		=>	$instance['number_bookings'],
			'post_status'			=>	'publish',
			'ignore_sticky_posts'	=>	true,
			'meta_key'				=>	'booking-start-date',
			'orderby'				=>	'meta_value_num',
			'order'					=>	'ASC',
			'meta_query'			=>	$meta_quer_args
		);

		$upcoming_bookings = new WP_Query( $query_args );

		//Preparing to show the bookings
		echo $before_widget;
		if ( $title ) {
			echo $before_title . $title . $after_title;
		}
		?>
		
		<ul class="uep_booking_entries">
			<?php while( $upcoming_bookings->have_posts() ): $upcoming_bookings->the_post();
				$booking_start_date = get_post_meta( get_the_ID(), 'booking-start-date', true );
				$booking_end_date = get_post_meta( get_the_ID(), 'booking-end-date', true );
				$booking_venue = get_post_meta( get_the_ID(), 'booking-venue', true ); 
			?>
				<li class="uep_booking_entry">
					<h4><a href="<?php the_permalink(); ?>" class="uep_booking_title"><?php the_title(); ?></a> <span class="booking_venue">at <?php echo $booking_venue; ?></span></h4>
					<?php the_excerpt(); ?>
					<time class="uep_booking_date"><?php echo date( 'F d, Y', $booking_start_date ); ?> &ndash; <?php echo date( 'F d, Y', $booking_end_date ); ?></time>
				</li>
			<?php endwhile; ?>
		</ul>

		<a href="<?php echo get_post_type_archive_link( 'booking' ); ?>">View All Bookings</a>

		<?php
		wp_reset_query();

		echo $after_widget;

	}
}

function uep_register_widget() {
	register_widget( 'Upcoming_Bookings' );
}
add_action( 'widgets_init', 'uep_register_widget' );
