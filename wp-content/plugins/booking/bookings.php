<?php

/**
 * @package bookings
 * @version 1.0.0
 */
/*Plugin Name: Reservation
Description: ceci est mon plugin de reservation
Author: WALLES Julien
Version: 1.0
*/

include('inc/widget-upcoming-bookings.php' );

define( 'ROOT', plugins_url( '', __FILE__ ) );
define( 'IMAGES', ROOT . '/images/' );
define( 'STYLES', ROOT . '/css/' );
define( 'SCRIPTS', ROOT . '/js/' );


function bookings_database() 
{
    global $wpdb;

    $table_name = $wpdb->prefix . 'bookings';
    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE $table_name (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        first_name varchar(50) NOT NULL,
        last_name varchar(50) NOT NULL,
        email varchar(50) NOT NULL,
        booking_id int NOT NULL,
        PRIMARY KEY (id)
        ) $charset_collate;";

        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
        add_option('bookings_db_version', '1.0');
}
register_activation_hook(__FILE__, 'bookings_database');



function uep_custom_post_type() 
{
    $labels = array(
        'name'                  =>   __( 'Bookings', 'uep' ),
        'singular_name'         =>   __( 'Booking', 'uep' ),
        'add_new_item'          =>   __( 'Add New Booking', 'uep' ),
        'all_items'             =>   __( 'All Bookings', 'uep' ),
        'edit_item'             =>   __( 'Edit Booking', 'uep' ),
        'new_item'              =>   __( 'New Booking', 'uep' ),
        'view_item'             =>   __( 'View Booking', 'uep' ),
        'not_found'             =>   __( 'No Bookings Found', 'uep' ),
        'not_found_in_trash'    =>   __( 'No Bookings Found in Trash', 'uep' )
    );
 
    $supports = array(
        'title',
        'editor',
        'excerpt'
    );
 
    $args = array(
        'label'         =>   __( 'Bookings', 'uep' ),
        'labels'        =>   $labels,
        'description'   =>   __( 'A list of upcoming bookings', 'uep' ),
        'public'        =>   true,
        'show_in_menu'  =>   true,
        'menu_icon'     =>   'dashicons-admin-customizer',
        'has_archive'   =>   true,
        'rewrite'       =>   true,
        'supports'      =>   $supports
    );
 
    register_post_type( 'booking', $args );
}
add_action( 'init', 'uep_custom_post_type' );

function uep_add_booking_info_metabox() 
{
    add_meta_box(
        'uep-booking-info-metabox',
        __( 'Booking Info', 'uep' ),
        'uep_render_booking_info_metabox',
        'booking',
        'side',
        'core'
    );
}
add_action( 'add_meta_boxes', 'uep_add_booking_info_metabox' );


function uep_render_booking_info_metabox( $post ) 
{
 
    // generate a nonce field
    wp_nonce_field( basename( __FILE__ ), 'uep-booking-info-nonce' );
 
    // get previously saved meta values (if any)
    $booking_start_date = get_post_meta( $post->ID, 'booking-start-date', true );
    $booking_end_date = get_post_meta( $post->ID, 'booking-end-date', true );
    $booking_venue = get_post_meta( $post->ID, 'booking-venue', true );
 
    // if there is previously saved value then retrieve it, else set it to the current time
    $booking_start_date = ! empty( $booking_start_date ) ? $booking_start_date : time();
 
    //we assume that if the end date is not present, booking ends on the same day
    $booking_end_date = ! empty( $booking_end_date ) ? $booking_end_date : $booking_start_date;
 
    ?>
 
<label for="uep-booking-start-date"><?php _e( 'Booking Start Date:', 'uep' ); ?></label>
        <input class="widefat uep-booking-date-input" id="uep-booking-start-date" type="text" name="uep-booking-start-date" placeholder="Format: February 18, 2014" value="<?php echo date( 'F d, Y', $booking_start_date ); ?>" />
 
<label for="uep-booking-end-date"><?php _e( 'Booking End Date:', 'uep' ); ?></label>
        <input class="widefat uep-booking-date-input" id="uep-booking-end-date" type="text" name="uep-booking-end-date" placeholder="Format: February 18, 2014" value="<?php echo date( 'F d, Y', $booking_end_date ); ?>" />
 
<label for="uep-booking-venue"><?php _e( 'Booking Venue:', 'uep' ); ?></label>
        <input class="widefat" id="uep-booking-venue" type="text" name="uep-booking-venue" placeholder="eg. Times Square" value="<?php echo $booking_venue; ?>" />
 
<?php } ?>


<?php

function booking_form() 
{
    ob_start();
    if (isset($_POST['booking'])) {
        $lastname = sanitize_text_field($_POST["last_name"]);
        $firstname = sanitize_text_field($_POST["first_name"]);
        $booking = intval(sanitize_text_field($_POST['booking_id']));

        if ($lastname != '' && $firstname != '') {
            global $wpdb;

            $table_name = $wpdb->prefix . 'bookings';

            $wpdb->insert(
                $table_name,
                array(
                    'last_name' => $lastname,
                    'first_name' => $firstname,
                    'email' => $email,
                    'booking_id' => $booking,
                )
            );

            echo "<h4>Merci! Nous vous re-contacterons dès que possible.</h4>";
        }
    }

    echo "<form method='POST'>";
    echo "<input type='hidden' name='booking_id' value=".get_the_ID().">";
    echo "<label  for='last_name' > Votre nom</label>";
    echo "<input type='text' name='last_name' placeholder='Votre nom' style='width:100%' required>";
    echo "<label  for='first_name' > Votre prenom</label>";
    echo "<input type='text' name='first_name' placeholder='Votre Prenom' style='width:100%' required>";
    echo "<label  for='first_name' > Votre email</label>";
    echo "<input type='email' name='email' placeholder='Votre email' style='width:100%' required>";
    
    echo "<input type='submit' name='booking' value='Je participe'>";
    echo "</form>";

    return ob_get_clean();
}
add_shortcode('subscribeBooking', 'booking_form');


//ajout du plugin au menu
function addBooking_plugin_to_admin() 
{
    function booking_content()
    {
        echo "<h1>Reservations</h1>";
        echo "<div style='margin-right:20px'>";

        if (class_exists('WP_List_Table')) {
            require_once(ABSPATH . 'wp-admin/includes/class-wp-list-table.php');
            require_once(plugin_dir_path(__FILE__) . 'booking-list-table.php');
            $bookingListTable = new BookingListTable();
            $bookingListTable->prepare_items();
            $bookingListTable->display();
        } else {
            echo "WP_List_Table n'est pas disponible.";
        }

        echo "</div>";
    }

    add_menu_page('Bookings', 'Bookings', 'manage_options', 'booking-plugin', 'booking_content');
}
add_action('admin_menu', 'addBooking_plugin_to_admin');


/**
 * Enqueueing styles for the front-end widget
 */
function uep_widget_style() 
{
	if ( is_active_widget( '', '', 'uep_upcoming_bookings', true ) ) {
		wp_enqueue_style(
			'upcoming-bookings',
			STYLES . 'style.css',
			false,
			'1.0',
			'all'
		);
	}
}
add_action( 'wp_enqueue_scripts', 'uep_widget_style' );


/**
 * Flushing rewrite rules on plugin activation/deactivation
 * for better working of permalink structure
 */
function uep_activation_deactivation() 
{
	uep_custom_post_type();
	flush_rewrite_rules();
}
register_activation_hook( __FILE__, 'uep_activation_deactivation' );


// Obtention des valeurs de champ de méta d'événement enregistrées dans la base de données

function uep_save_booking_info( $post_id ) 
{
 
    // checking if the post being saved is an 'booking',
    // if not, then return
    if ( 'booking' != $_POST['post_type'] ) {
        return;
    }
 
    // checking for the 'save' status
    $is_autosave = wp_is_post_autosave( $post_id );
    $is_revision = wp_is_post_revision( $post_id );
    $is_valid_nonce = ( isset( $_POST['uep-booking-info-nonce'] ) && ( wp_verify_nonce( $_POST['uep-booking-info-nonce'], basename( __FILE__ ) ) ) ) ? true : false;
 
    // exit depending on the save status or if the nonce is not valid
    if ( $is_autosave || $is_revision || ! $is_valid_nonce ) {
        return;
    }
 
    // checking for the values and performing necessary actions
    if ( isset( $_POST['uep-booking-start-date'] ) ) {
        update_post_meta( $post_id, 'booking-start-date', strtotime( $_POST['uep-booking-start-date'] ) );
    }
 
    if ( isset( $_POST['uep-booking-end-date'] ) ) {
        update_post_meta( $post_id, 'booking-end-date', strtotime( $_POST['uep-booking-end-date'] ) );
    }
 
    if ( isset( $_POST['uep-booking-venue'] ) ) {
        update_post_meta( $post_id, 'booking-venue', sanitize_text_field( $_POST['uep-booking-venue'] ) );
    }
}
add_action( 'save_post', 'uep_save_booking_info' );


// ajout de colonnes personnalisées dans le PostAdmin

function uep_custom_columns_head( $defaults ) 
{
    unset( $defaults['date'] );
 
    $defaults['booking_start_date'] = __( 'Start Date', 'uep' );
    $defaults['booking_end_date'] = __( 'End Date', 'uep' );
    $defaults['booking_venue'] = __( 'Venue', 'uep' );
 
    return $defaults;
}
add_filter( 'manage_edit-booking_columns', 'uep_custom_columns_head', 10 );


function uep_custom_columns_content( $column_name, $post_id ) 
{
    if ( 'booking_start_date' == $column_name ) {
        $start_date = get_post_meta( $post_id, 'booking-start-date', true );
        echo date( 'g:i', $start_date );
    }
 
    if ( 'booking_end_date' == $column_name ) {
        $end_date = get_post_meta( $post_id, 'booking-end-date', true );
        echo date( 'g:i', $end_date );
    }
 
    if ( 'booking_venue' == $column_name ) {
        $venue = get_post_meta( $post_id, 'booking-venue', true );
        echo $venue;
    }
}
add_action( 'manage_booking_posts_custom_column', 'uep_custom_columns_content', 10, 2 );