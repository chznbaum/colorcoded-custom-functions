<?php
/**
 * @link https://757colorcoded.org
 * @since 1.0.0
 * @package ColorCoded_Custom_Functions
 *  
 * @wordpress-plugin
 * Plugin Name: ColorCoded Custom Functions
 * Plugin URI: https://757colorcoded.org
 * Description: Custom functions required for 757ColorCoded
 * Version: 1.0.0
 * Author: 757ColorCoded
 * Author URI: https://757colorcoded.org
 * License: GPL-3.0+
 * License URI: http://www.gnu.org/licenses/gpl-3.0.txt
 * Text Domain: colorcoded-custom-functions
 * Domain Path: /languages
 */

/**
 * Remove admin toolbar
 */
add_filter( 'show_admin_bar', '__return_false' );

/**
 * Remove portfolio custom post type
 */
add_action('after_setup_theme', function() {
  remove_action('init', 'portfolio_register');
});

/**
 * Include custom login styles
 */
add_action('login_head', function() {
  echo '<link rel="stylesheet" type="text/css" href="' . get_bloginfo('stylesheet_directory') . '/login/custom-login-styles.css" />';
});

add_filter('login_headerurl', function() {
  return get_bloginfo('url');
});

add_filter('login_headertitle', function() {
  return '757ColorCoded';
});

add_filter('login_redirect', function() {
  return home_url();
}, 10, 3);

/**
 * Register custom post types
 * @link https://codex.wordpress.org/Function_Reference/register_post_type
 */

add_action( 'init', function() {
  $custom_post_types = [
    'session',
    'scholarship'
  ];
  foreach ($custom_post_types as $custom_post_type) {
    $custom_post_type_title = ucfirst($custom_post_type);
    $labels = [
      'name'                  => _x( "{$custom_post_type_title}s", 'post type general name', 'colorcoded-custom-functions' ),
      'singular_name'         => _x( "{$custom_post_type}", 'post type singular name', 'colorcoded-custom-functions' ),
      'menu_name'             => _x( "{$custom_post_type_title}s", 'admin menu', 'colorcoded-custom-functions' ),
      'name_admin_bar'        => _x( "{$custom_post_type_title}", 'add new on admin bar', 'colorcoded-custom-functions' ),
      'add_new'               => _x( 'Add New', $custom_post_type_title, 'colorcoded-custom-functions' ),
      'add_new_item'          => __( "Add New {$custom_post_type_title}", 'colorcoded-custom-functions' ),
      'new_item'              => __( "New {$custom_post_type_title}", 'colorcoded-custom-functions' ),
      'edit_item'             => __( "Edit {$custom_post_type_title}", 'colorcoded-custom-functions' ),
      'view_item'             => __( "View {$custom_post_type_title}", 'colorcoded-custom-functions' ),
      'view_items'            => __( "View {$custom_post_type_title}s", 'colorcoded-custom-functions' ),
      'all_items'             => __( "All {$custom_post_type_title}s", 'colorcoded-custom-functions' ),
      'archives'              => __( "{$custom_post_type_title}s Archives", 'colorcoded-custom-functions' ),
      'attributes'            => __( "{$custom_post_type_title}s Attributes", 'colorcoded-custom-functions' ),
      'insert_into_item'      => __( "Insert into {$custom_post_type}", 'colorcoded-custom-functions' ),
      'uploaded_to_this_item' => __( "Uploaded to this {$custom_post_type}", 'colorcoded-custom-functions' ),
      'search_items'          => __( "Search {$custom_post_type_title}s", 'colorcoded-custom-functions' ),
      'parent_item_colon'     => __( "Parent {$custom_post_type_title}s:", 'colorcoded-custom-functions' ),
      'not_found'             => __( "No {$custom_post_type}s found.", 'colorcoded-custom-functions' ),
      'not_found_in_trash'    => __( "No {$custom_post_type}s found in Trash.", 'colorcoded-custom-functions' ),
    ];
    if ($custom_post_type == 'session') {
      $capability = 'page';
      $icon = 'dashicons-megaphone';
      $taxonomies = [
        'session_format',
        'track',
        'level',
        'category',
        'post_tag',
      ];
    } elseif ($custom_post_type == 'scholarship') {
      $capability = 'post';
      $icon = 'dashicons-tickets-alt';
      $taxonomies = [
        'category',
        'post_tag',
      ];
    }
    $args = [
      'labels'                => $labels,
      'description'           => __( 'Description.', 'colorcoded-custom-functions' ),
      'public'                => true,
      'publicly_queryable'    => true,
      'show_ui'               => true,
      'show_in_menu'          => true,
      'query_var'             => true,
      'rewrite'               => array( 'slug' => "${custom_post_type}" ),
      'capability_type'       => $capability,
      'has_archive'           => true,
      'hierarchical'          => false,
      'menu_position'         => null,
      'menu_icon'             => $icon,
      'supports'              => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'custom-fields', 'revisions' ),
      'taxonomies'            => $taxonomies,
      'can_export'            => true,
    ];
    register_post_type( $custom_post_type, $args );
  }
});

/**
 * Register session format taxonomy
 */
add_action( 'init', function () {
  $labels = array(
    'name' => _x( 'Session Formats', 'colorcoded-custom-functions' ),
    'singular_name' => _x( 'Session Format', 'colorcoded-custom-functions' ),
    'menu_name' => _x( 'Session Formats', 'colorcoded-custom-functions' ),
    'all_items' => __( 'All Session Formats', 'colorcoded-custom-functions' ),
    'edit_item' => __( 'Edit Session Format', 'colorcoded-custom-functions' ),
    'view_item' => __( 'View Session Format', 'colorcoded-custom-functions' ),
    'update_item' => __( 'Update Session Format', 'colorcoded-custom-functions' ),
    'add_new_item' => __( 'Add New Session Format', 'colorcoded-custom-functions' ),
    'parent_item' => __( 'Parent Session Format', 'colorcoded-custom-functions' ),
    'parent_item_colon' => __( 'Parent Session Format:', 'colorcoded-custom-functions' ),
    'search_items' => __( 'Search Session Formats', 'colorcoded-custom-functions' ),
    'popular_items' => __( 'Popular Session Formats', 'colorcoded-custom-functions' ),
    'separate_items_with_commas' => __( 'Separate session formats with commas', 'colorcoded-custom-functions' ),
    'add_or_remove_items' => __( 'Add or remove session formats', 'colorcoded-custom-functions' ),
    'not_found' => __( 'No session formats found.', 'colorcoded-custom-functions' ),
  );
  $args = array(
    'labels' => $labels,
    'public' => true,
    'publicly_queryable' => true,
    'show_ui' => true,
    'show_in_menu' => true,
    'show_in_nav_menus' => true,
    'show_in_quick_edit' => true,
    'show_admin_column' => true,
    'hierarchical' => true,
    'query_var' => true,
    'rewrite' => array( 'slug' => 'session-format' ),
  );

  register_taxonomy( 'session_format', 'session', $args );
});

/**
 * Register track taxonomy
 */
add_action( 'init', function () {
  $labels = array(
    'name' => _x( 'Tracks', 'colorcoded-custom-functions' ),
    'singular_name' => _x( 'Track', 'colorcoded-custom-functions' ),
    'menu_name' => _x( 'Tracks', 'colorcoded-custom-functions' ),
    'all_items' => __( 'All Tracks', 'colorcoded-custom-functions' ),
    'edit_item' => __( 'Edit Track', 'colorcoded-custom-functions' ),
    'view_item' => __( 'View Track', 'colorcoded-custom-functions' ),
    'update_item' => __( 'Update Track', 'colorcoded-custom-functions' ),
    'add_new_item' => __( 'Add New Track', 'colorcoded-custom-functions' ),
    'parent_item' => __( 'Parent Track', 'colorcoded-custom-functions' ),
    'parent_item_colon' => __( 'Parent Track:', 'colorcoded-custom-functions' ),
    'search_items' => __( 'Search Tracks', 'colorcoded-custom-functions' ),
    'popular_items' => __( 'Popular Tracks', 'colorcoded-custom-functions' ),
    'separate_items_with_commas' => __( 'Separate tracks with commas', 'colorcoded-custom-functions' ),
    'add_or_remove_items' => __( 'Add or remove tracks', 'colorcoded-custom-functions' ),
    'not_found' => __( 'No tracks found.', 'colorcoded-custom-functions' ),
  );
  $args = array(
    'labels' => $labels,
    'public' => true,
    'publicly_queryable' => true,
    'show_ui' => true,
    'show_in_menu' => true,
    'show_in_nav_menus' => true,
    'show_in_quick_edit' => true,
    'show_admin_column' => true,
    'hierarchical' => true,
    'query_var' => true,
    'rewrite' => array( 'slug' => 'track' ),
  );

  register_taxonomy( 'track', 'session', $args );
});

/**
 * Register level taxonomy
 */
add_action( 'init', function () {
  $labels = array(
    'name' => _x( 'Levels', 'colorcoded-custom-functions' ),
    'singular_name' => _x( 'Level', 'colorcoded-custom-functions' ),
    'menu_name' => _x( 'Levels', 'colorcoded-custom-functions' ),
    'all_items' => __( 'All Levels', 'colorcoded-custom-functions' ),
    'edit_item' => __( 'Edit Level', 'colorcoded-custom-functions' ),
    'view_item' => __( 'View Level', 'colorcoded-custom-functions' ),
    'update_item' => __( 'Update Level', 'colorcoded-custom-functions' ),
    'add_new_item' => __( 'Add New Level', 'colorcoded-custom-functions' ),
    'parent_item' => __( 'Parent Level', 'colorcoded-custom-functions' ),
    'parent_item_colon' => __( 'Parent Level:', 'colorcoded-custom-functions' ),
    'search_items' => __( 'Search Levels', 'colorcoded-custom-functions' ),
    'popular_items' => __( 'Popular Levels', 'colorcoded-custom-functions' ),
    'separate_items_with_commas' => __( 'Separate levels with commas', 'colorcoded-custom-functions' ),
    'add_or_remove_items' => __( 'Add or remove levels', 'colorcoded-custom-functions' ),
    'not_found' => __( 'No levels found.', 'colorcoded-custom-functions' ),
  );
  $args = array(
    'labels' => $labels,
    'public' => true,
    'publicly_queryable' => true,
    'show_ui' => true,
    'show_in_menu' => true,
    'show_in_nav_menus' => true,
    'show_in_quick_edit' => true,
    'show_admin_column' => true,
    'hierarchical' => true,
    'query_var' => true,
    'rewrite' => array( 'slug' => 'level' ),
  );

  register_taxonomy( 'level', 'session', $args );
});

/**
 * Set custom post type for Gravity Forms
 */
add_filter( 'gform_post_data', function($post_data, $form, $entry) {
  // Only change post type on session submission form
  if ($form['id'] != 4) {
    return $post_data;
  }
  $post_data['post_type'] = 'session';
  return $post_data;
}, 10, 3 );

/**
 * Add session custom meta boxes
 */
add_action( 'add_meta_boxes_session', function($post) {
  add_meta_box( 'speaker-details', __( 'Speaker Details', 'colorcoded-custom-functions' ), 'speaker_details_build_meta_box', 'session', 'normal', 'high');
});

function speaker_details_build_meta_box( $post ) {
	$meta = get_post_meta( $post->ID );
	?>
	<label for="speaker_name_field">Name</label>
	<input type="text" name="speaker_name_field" id="speaker_name_field" value="<?php echo $meta['speaker_name'][0] ?>">
	<label for="speaker_email_field">Email</label>
	<input type="email" name="speaker_email_field" id="speaker_email_field" value="<?php echo $meta['speaker_email'][0] ?>">
  <br>
	<label for="speaker_tagline_field">Tagline</label>
	<input type="text" name="speaker_tagline_field" id="speaker_tagline_field" value="<?php echo $meta['speaker_tagline'][0] ?>">
  <br>
	<label for="speaker_bio_field">Bio</label>
  <textarea name="speaker_bio_field" id="speaker_bio_field" rows="10" cols="50"><?php echo $meta['speaker_bio'][0] ?></textarea>
  <br>
	<?php $photos_count = $meta['speaker_photos'] ? count( $meta['speaker_photos'] ) : 0;
	$i = 0;
	while ( $i < $photos_count ) {
		?>
		<br>
		<img src="<?php echo $meta['speaker_photos'][$i] ?>" height="150">
		<input type="checkbox" name="<?php echo "speaker_photos_delete_field_{$i}" ?>" id="<?php echo "speaker_photos_delete_field_{$i}" ?>">
		<label for="<?php echo "speaker_photos_delete_field_{$i}" ?>">Delete Photo</label>
		<br>
		<?php
		$i++;
	} ?>
		<label for="<?php echo "speaker_photos_field_0" ?>">Add More Photos</label>
		<input type="file" name="<?php echo "speaker_photos_field_0" ?>" id="<?php echo "speaker_photos_field_0" ?>" accept="image/*">
		<input type="file" name="<?php echo "speaker_photos_field_1" ?>" id="<?php echo "speaker_photos_field_1" ?>" accept="image/*">
		<input type="file" name="<?php echo "speaker_photos_field_2" ?>" id="<?php echo "speaker_photos_field_2" ?>" accept="image/*">
	<?php
}

add_action('post_edit_form_tag', function() {
  echo 'enctype="multipart/form-data"';
});

add_action( 'save_post_session', function($post_id) {
  if ( defined( 'DOING_AUTOSAVE') && DOING_AUTOSAVE ) {
		return $post_id;
	}
	if ( array_key_exists( 'speaker_name_field', $_POST ) ) {
		if ( ! add_post_meta( $post_id, 'speaker_name', $_POST['speaker_name_field'], true ) ) {
			update_post_meta( $post_id, 'speaker_name', $_POST['speaker_name_field'] );
		}
	}
	if ( array_key_exists( 'speaker_email_field', $_POST ) ) {
		if ( ! add_post_meta( $post_id, 'speaker_email', $_POST['speaker_email_field'], true ) ) {
			update_post_meta( $post_id, 'speaker_email', $_POST['speaker_email_field'] );
		}
	}
	if ( array_key_exists( 'speaker_tagline_field', $_POST ) ) {
		if ( ! add_post_meta( $post_id, 'speaker_tagline', $_POST['speaker_tagline_field'], true ) ) {
			update_post_meta( $post_id, 'speaker_tagline', $_POST['speaker_tagline_field'] );
		}
	}
	if ( array_key_exists( 'speaker_bio_field', $_POST ) ) {
		if ( ! add_post_meta( $post_id, 'speaker_bio', $_POST['speaker_bio_field'], true ) ) {
			update_post_meta( $post_id, 'speaker_bio', $_POST['speaker_bio_field'] );
		}
	}
	$speaker_photos_deletions = preg_grep( '/^speaker_photos_delete_field_*/', array_keys( $_POST ) );
	$speaker_photos_deletion_count = count( $speaker_photos_deletions );
	if ( $speaker_photos_deletion_count > 0 ) {
		foreach ( $speaker_photos_deletions as $deletion ) {
			$deletion_index = substr( $deletion, -1 );
			$image_list = get_post_meta( $post_id, 'speaker_photos', false );
			$image_to_delete = $image_list[$deletion_index];
			delete_post_meta( $post_id, 'speaker_photos', $image_to_delete );
		}
	}
	$speaker_photos_fields = preg_grep( '/^speaker_photos_field_*/', array_keys( $_FILES ) );
	$speaker_photos_fields_count = count( $speaker_photos_fields );
	if ( $speaker_photos_fields_count > 0 ) {
		foreach ( $speaker_photos_fields as $field ) {
			if ( empty( $_FILES[$field]['name'] ) ) {
				continue;
			}
			$supported_types = array( 'image/jpg', 'image/jpeg', 'image/gif', 'image/png', 'image/tif', 'image/tiff' );
			$arr_file_type = wp_check_filetype( basename( $_FILES[$field]['name'] ) );
			$uploaded_type = $arr_file_type['type'];
			if ( !in_array( $uploaded_type, $supported_types ) ) {
				wp_die( "The file that you've uploaded is not an image." );
				return $post_id;
			}
			$upload = wp_upload_bits( $_FILES[$field]['name'], null, file_get_contents( $_FILES[$field]['tmp_name'] ) );
			if ( isset( $upload['error'] ) && $upload['error'] != 0 ) {
				wp_die( 'There was an error uploading your file. The error is: ' . $upload['error'] );
				return $post_id;
			}
			add_post_meta( $post_id, 'speaker_photos', $upload['url'] );
		}
	}
});

/**
 * Adds the builder to custom post types
 */
function enfold_customization_posts_builder( $boxes ){
  if( empty( $boxes ) ) {
    return $boxes;
  }
  foreach( $boxes as $key => $box ) {
    $boxes[$key]['page'][] = 'session';
    $boxes[$key]['page'][] = 'scholarship';
  }
  return $boxes;
}
add_filter( 'avf_builder_boxes', 'enfold_customization_posts_builder', 10, 1 );

/**
 * Remove theme debugging info
 */
add_action( 'init', function() {
  remove_action( 'wp_head', 'avia_debugging_info', 1000 );
  remove_action( 'admin_print_scripts', 'avia_debugging_info', 1000 );
});

/**
 * Add login/logout item to menu
 */
add_filter('wp_nav_menu_items', function($items, $args) {
  ob_start();
  wp_loginout('index.php');
  $login_out_link = ob_get_contents();
  ob_end_clean();
  $items .= '<li>'. $login_out_link .'</li>';
  return $items;
}, 10, 2);
