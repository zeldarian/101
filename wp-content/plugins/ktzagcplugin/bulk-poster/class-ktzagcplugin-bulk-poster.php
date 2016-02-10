<?php
/**
 * Post_Type For campaign Ktzagcplugin Bulk Posters.
 *
 * @link       http://kentooz.com
 * @since      1.0.0
 *
 * @package    ktzagcplugin
 * @subpackage ktzagcplugin/admin
 */
/**
 * Post_Type For campaign Ktzagcplugin Bulk Posters.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the dashboard-specific stylesheet and JavaScript.
 *
 * @package    ktzagcplugin
 * @subpackage ktzagcplugin/admin
 * @author     Your Name <g14nblog@gmail.com>
 */
 
if ( !defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Campaign
 */
class Ktzplg_Camp_Bulkposter {

	/**
	 * Setup.
	 */
	public static function init() {
		add_action( 'init', array( __CLASS__, 'wp_init' ), 11 );
		add_action( 'admin_init', array( __CLASS__, 'admin_init' ) );
		add_action( 'add_meta_boxes', array( __CLASS__, 'add_meta_boxes' ), 10, 2 );
		add_filter( 'enter_title_here', array( __CLASS__, 'enter_title_here' ), 10, 2 );
		add_action( 'save_post', array( __CLASS__, 'save_post' ), 10, 2 );
		add_action( 'admin_menu', array( __CLASS__, 'remove_custom_taxonomy' ) );	
		add_action( 'admin_head-post.php', array( __CLASS__, 'hide_publishing_actions' ) );
		add_action( 'admin_head-post-new.php', array( __CLASS__, 'hide_publishing_actions' ) );
		add_filter( 'post_row_actions', array( __CLASS__, 'post_row_actions' ) );
		add_filter( 'post_updated_messages', array( __CLASS__, 'post_updated_messages' ) );
	}

	/**
	 * Hooked on the init action, register the post type.
	 */
	public static function wp_init() {
		self::post_type();
	}

	/**
	 * Admin hooks.
	 */
	public static function admin_init() {
		add_filter( 'parent_file', array( __CLASS__, 'parent_file' ) );
	}

	/**
	 * Sets the parent menu when adding or editing a Campaign. Keeps the
	 * ktzagcplugin menu open and marks the Campaign menu item as active.
	 * 
	 * @param string $parent_file
	 * @return string
	 */
	public static function parent_file( $parent_file ) {
		global $submenu_file;
		switch ( $submenu_file ) {
			case 'post-new.php?post_type=camp_bulkposter' :
			case 'edit.php?post_type=camp_bulkposter' :
				$parent_file = 'ktzagcplugin';
				// Campaigns menu item marked active when adding a Campaigns
				$submenu_file = 'edit.php?post_type=camp_bulkposter';
				break;
		}
		return $parent_file;
	}

	/**
	 * Register the Campaigns post type.
	 */
	public static function post_type() {
		register_post_type(
			'camp_bulkposter',
			array(
				'labels' => array(
					'name'               => __( 'Bulk Posters Campaign', 'ktzagcplugin' ),
					'singular_name'      => __( 'Campaign', 'ktzagcplugin' ),
					'all_items'          => __( 'Bulk Posters Campaign', 'ktzagcplugin' ),
					'add_new'            => __( 'New Campaign', 'ktzagcplugin' ),
					'add_new_item'       => __( 'Add New Campaign', 'ktzagcplugin' ),
					'edit'               => __( 'Edit', 'ktzagcplugin' ),
					'edit_item'          => __( 'Edit Campaign', 'ktzagcplugin' ),
					'new_item'           => __( 'New Campaign', 'ktzagcplugin' ),
					'not_found'          => __( 'No Campaigns found', 'ktzagcplugin' ),
					'not_found_in_trash' => __( 'No Campaigns found in trash', 'ktzagcplugin' ),
					'parent'             => __( 'Parent Campaign', 'ktzagcplugin' ),
					'search_items'       => __( 'Search Campaigns', 'ktzagcplugin' ),
					'view'               => __( 'View Campaign', 'ktzagcplugin' ),
					'view_item'          => __( 'View Campaign', 'ktzagcplugin' ),
					'menu_name'          => __( 'Campaigns', 'ktzagcplugin' )
				),
				'capability_type'     => array( 'camp_bulkposter', 'camp_bulkposters' ),
				'description'         => __( 'Ktzagcplugin Bulk Posters', 'ktzagcplugin' ),
				'exclude_from_search' => true,
				'has_archive'         => false,
				'hierarchical'        => false,
				'map_meta_cap'        => true,
				'public'              => false,
				'publicly_queryable'  => false,
				'query_var'           => true,
				'rewrite'             => false,
				'show_in_nav_menus'   => false,
				'show_ui'             => true,
				'supports'            => array( 'title' ),
				'show_in_menu'        => false, // *
			)
		);
		
		// * 'show_in_menu' => 'ktzgacplugin-admin' would add as it as an item to the ktzgacplugin menu
		//   but it would replace the main menu item and the admin_menu action would need a lower
		//   than standard priority (e.g. 9) to avoid that ... messy, hacky, so we
		//   rather add it there using add_submenu_page
		self::create_capabilities();
	}

	/**
	 * Creates capabilities to handle Campaigns.
	 * Administrators have all capabilities.
	 * Assures that these capabilities exist.
	 */
	public static function create_capabilities() {
		global $wp_roles;
		$admin = $wp_roles->get_role( 'administrator' );
		if ( $admin !== null ) {
			$caps = self::get_capabilities();
			foreach( $caps as $key => $capability ) {
				if ( !$admin->has_cap( $capability ) ) {
					$admin->add_cap( $capability );
				}
			}
		}
	}

	/**
	 * Returns an array of relevant capabilities for the camp_bulkposter post type.
	 * @return array
	 */
	public static function get_capabilities() {
		return array(
			'edit_posts'             => 'edit_camp_bulkposters',
			'edit_others_posts'      => 'edit_others_camp_bulkposters',
			'publish_posts'          => 'publish_camp_bulkposters',
			'read_private_posts'     => 'read_private_camp_bulkposters',
			'delete_posts'           => 'delete_camp_bulkposters',
			'delete_private_posts'   => 'delete_private_camp_bulkposters',
			'delete_published_posts' => 'delete_published_camp_bulkposters',
			'delete_others_posts'    => 'delete_others_camp_bulkposters',
			'edit_private_posts'     => 'edit_private_camp_bulkposters',
			'edit_published_posts'   => 'edit_published_camp_bulkposters',
		);
	}

	/**
	 * Adds a meta box for the keyword.
	 */
	public static function add_meta_boxes( $post_type, $post ) {
		if ( $post_type == 'camp_bulkposter' ) {

			add_meta_box(
				'keyword',
				__( 'Bulk Keyword Poster', 'ktzagcplugin' ),
				array( __CLASS__, 'keyword_meta_box' ),
				'camp_bulkposter',
				'normal',
				'high'
			);

		}
	}

	/**
	 * Replacement indicating Campaigns rather than title ...
	 * 
	 * @param string $title
	 * @param WP_Post $post
	 * @return string
	 */
	public static function enter_title_here( $title, $post ) {
		if ( $post->post_type == 'camp_bulkposter' ) {
			return __( 'Enter Name of Campaign', 'ktzagcplugin' );
		}
		return $title;
	}
	
	// $custom_taxonomy_slug is the slug of your taxonomy, e.g. 'genre' )
	// $custom_post_type is the "slug" of your post type, e.g. 'movies' )
	public static function remove_custom_taxonomy()
	{
		remove_meta_box('slugdiv', 'camp_bulkposter', 'side' );
	}
	
	/**
	 * Hide format @ Publish Metabox except publish button and trash
	 */
	public static function hide_publishing_actions(){
			$my_post_type = 'camp_bulkposter';
			global $post;
			if($post->post_type == $my_post_type){
				echo '
					<style type="text/css">
						#misc-publishing-actions,
						#minor-publishing-actions{
							display:none;
						}
					</style>
				';
			}
	}

	/**
	 * Renders the keyword meta box.
	 * 
	 * @param object $post camp_bulkposter
	 */
	public static function keyword_meta_box( $post ) {
		$output = '';
		
		# keyword post meta
		$keyword = get_post_meta( $post->ID, 'keyword', true );
		$output .= '<div style="padding-bottom:20px;margin-bottom:20px;border-bottom:1px solid #efefef;">';
		$output .= '<label>';
		$output .= __( 'Keywords:', 'ktzagcplugin' );
		$output .= ' ';
		$output .= sprintf( '<textarea row="6" style="display:block;height:300px;width:100%%" name="keyword">%s</textarea>', esc_attr( $keyword ) );
		$output .= '</label>';
		$output .= '<p class="description">';
		$output .= __( 'Fill with keyword, this keyword will automatic post with schedule post setting below. Please add keyword per line for example:<br>Keyword 1<br>Keyword 2<br>Keyword 3', 'ktzagcplugin' );
		$output .= '</p>';
		$output .= '</div>';
		
		# Post type
		$ktzplg_post_type = get_post_meta( $post->ID, 'ktzplg_post_type', true );
		if ( empty( $ktzplg_post_type ) ) {
			$ktzplg_post_type = 'post';
		}
		$output .= '<div style="padding-bottom:20px;margin-bottom:20px;border-bottom:1px solid #efefef;">';
		$output .= '<label>';
		$output .= __( 'Post Type:', 'ktzagcplugin' );
		$output .= ' ';
		$output .= '<select name="ktzplg_post_type" class="widefat">';
		$output .= '<option value="post" ' . selected( $ktzplg_post_type, 'post', false ) . '>Post</option>';
		$output .= '<option value="page" ' . selected( $ktzplg_post_type, 'page', false ) . '>Page</option>';
		$output .= '</select>';
		$output .= '</label>';
		$output .= '<p class="description">';
		$output .= __( 'Please select post type here, you can post in post_type post or page.', 'ktzagcplugin' );
		$output .= '</p>';
		$output .= '</div>';
		
		# Count post meta
		$count = get_post_meta( $post->ID, 'count', true );
		if ( empty( $count ) ) {
			$count = 1;
		}
		$output .= '<div style="padding-bottom:20px;margin-bottom:20px;border-bottom:1px solid #efefef;">';
		$output .= '<label>';
		$output .= __( 'Count:', 'ktzagcplugin' );
		$output .= ' ';
		$output .= sprintf( '<input type="number" style="display:block;width:100%%" name="count" value="%s" />', esc_attr( $count ) );
		$output .= '</label>';
		$output .= '<p class="description">';
		$output .= __( 'How much post you want posted immediately after publish this campaign', 'ktzagcplugin' );
		$output .= '</p>';
		$output .= '</div>';
		
		# Category ID post meta
		$category_id = get_post_meta( $post->ID, 'category_id', true );
		if ( empty( $category_id ) ) {
			$category_id = 1;
		}
		$output .= '<div style="padding-bottom:20px;margin-bottom:20px;border-bottom:1px solid #efefef;">';
		$output .= '<label>';
		$output .= __( 'Category:', 'ktzagcplugin' );
		$output .= ' ';
		$output .= '<select name="category_id" class="widefat">';
		$blog_categories = get_categories( array('orderby' => 'id', 'hide_empty' => 0) ); 
			foreach( $blog_categories as $category ) :
				$output .= '<option value="' . $category->term_id . '" ' . selected( $category_id, $category->term_id, false ) . '>' . $category->name . '</option>';
			endforeach;
		$output .= '</select>';
		$output .= '</label>';
		$output .= '<p class="description">';
		$output .= __( 'Please select post category for this campaign.', 'ktzagcplugin' );
		$output .= '</p>';
		$output .= '</div>';
		
		# Post status
		$status = get_post_meta( $post->ID, 'status', true );
		if ( empty( $status ) ) {
			$status = 'publish';
		}
		$output .= '<div style="padding-bottom:20px;margin-bottom:20px;border-bottom:1px solid #efefef;">';
		$output .= '<label>';
		$output .= __( 'Post status:', 'ktzagcplugin' );
		$output .= ' ';
		$output .= '<select name="status" class="widefat">';
		$output .= '<option value="publish" ' . selected( $status, 'publish', false ) . '>Publish</option>';
		$output .= '<option value="draft" ' . selected( $status, 'draft', false ) . '>Draft</option>';
		$output .= '</select>';
		$output .= '</label>';
		$output .= '<p class="description">';
		$output .= __( 'Please select post status here, you can publish post or save post as draft.', 'ktzagcplugin' );
		$output .= '</p>';
		$output .= '</div>';
		
		# Schedule Post
		$ktzplg_next = get_post_meta( $post->ID, 'ktzplg_next', true );
		if ( empty( $ktzplg_next ) ) {
			$ktzplg_next = 24;
		}
		$ktzplg_next_time = get_post_meta( $post->ID, 'ktzplg_next_time', true );
		if ( empty( $ktzplg_next_time ) ) {
			$ktzplg_next_time = 'hours';
		}
		$output .= '<div style="padding-bottom:20px;margin-bottom:20px;border-bottom:1px solid #efefef;">';
		$output .= '<label>';
		$output .= __( 'Schedule Auto Posting:', 'ktzagcplugin' );
		$output .= '<br />';
		$output .= '</label>';
		$output .= sprintf( '<input type="number" name="ktzplg_next" value="%s" />', esc_attr( $ktzplg_next ) );
		$output .= '<input name="ktzplg_next_time" style="margin-left:10px;" value="seconds" type="radio" ' . checked( $ktzplg_next_time, 'seconds', false ) . '>seconds';
		$output .= '<input name="ktzplg_next_time" style="margin-left:10px;" value="hours" type="radio" ' . checked( $ktzplg_next_time, 'hours', false ) . '>hours';
		$output .= '<input name="ktzplg_next_time" style="margin-left:10px;" value="days" type="radio" ' . checked( $ktzplg_next_time, 'days', false ) . '>days';
		$output .= '<p class="description">';
		$output .= __( 'Please fill time or time range between each auto post check. ', 'ktzagcplugin' );
		$output .= '</p>';
		$output .= '</div>';
		
		echo $output;
	}
	
	/**
	 * Save post meta.
	 * 
	 * @param int $post_id
	 * @param object $post
	 */
	public static function save_post( $post_id = null, $post = null ) {
		if ( ! ( ( defined( "DOING_AUTOSAVE" ) && DOING_AUTOSAVE ) ) ) {
			if ( $post->post_type == 'camp_bulkposter' ) {
				if ( $post->post_status != 'auto-draft' ) {

					# keyword meta post
					$keyword = isset( $_POST['keyword'] ) ? trim( $_POST['keyword'] ) : '';
					delete_post_meta( $post_id, 'keyword' );
					if ( !empty( $keyword ) ) {
						add_post_meta( $post_id, 'keyword', $keyword );
					}
					
					# Count meta post
					$count = isset( $_POST['count'] ) ? trim( $_POST['count'] ) : '';
					delete_post_meta( $post_id, 'count' );
					if ( !empty( $count ) ) {
						add_post_meta( $post_id, 'count', $count );
					}
					
					# Category ID
					$category_id = isset( $_POST['category_id'] ) ? trim( $_POST['category_id'] ) : '';
					delete_post_meta( $post_id, 'category_id' );
					if ( !empty( $category_id ) ) {
						add_post_meta( $post_id, 'category_id', $category_id );
					}
					
					# Post Status
					$status = isset( $_POST['status'] ) ? trim( $_POST['status'] ) : '';
					delete_post_meta( $post_id, 'status' );
					if ( !empty( $status ) ) {
						add_post_meta( $post_id, 'status', $status );
					}
					
					# Post Type
					$ktzplg_post_type = isset( $_POST['ktzplg_post_type'] ) ? trim( $_POST['ktzplg_post_type'] ) : '';
					delete_post_meta( $post_id, 'ktzplg_post_type' );
					if ( !empty( $ktzplg_post_type ) ) {
						add_post_meta( $post_id, 'ktzplg_post_type', $ktzplg_post_type );
					}
					
					# Schedule Post
					$ktzplg_next = isset( $_POST['ktzplg_next'] ) ? trim( $_POST['ktzplg_next'] ) : '';
					delete_post_meta( $post_id, 'ktzplg_next' );
					if ( !empty( $ktzplg_next ) ) {
						add_post_meta( $post_id, 'ktzplg_next', $ktzplg_next );
					}
					$ktzplg_next_time = isset( $_POST['ktzplg_next_time'] ) ? trim( $_POST['ktzplg_next_time'] ) : '';
					delete_post_meta( $post_id, 'ktzplg_next_time' );
					if ( !empty( $ktzplg_next_time ) ) {
						add_post_meta( $post_id, 'ktzplg_next_time', $ktzplg_next_time );
					}
					
					# Logical insert post after Publish campaign
					if ( !empty( $count ) && !empty( $keyword ) ) {
						
						$keyword = explode( "\n", $keyword );
						
						# Rand Keyword Submission
						if( count( $keyword > 0 ) ) {
							shuffle( $keyword );
							$keyword = array_slice( $keyword, 0, $count );
						}
						
						foreach ( $keyword as $kwd ){
							
							$title = sanitize_title( $kwd );
							$title = str_replace('-',' ', $title);
							$title = ucwords( $title );
							
							# https://developer.wordpress.org/reference/functions/post_exists/
							$post_id = post_exists( $title );
							
							$content = Ktzagcplugin_Option::get_option( 'ktzplg_agc_content' );
							$replace_with_this = ' keyword="' . $title . '"]';
							$content_wow = str_replace( ']', $replace_with_this, $content );
							$content = do_shortcode( $content_wow );
							
							# if not post same keyword do it..
							if ( !$post_id ) {
								
								# Insert post => ktzplg_insert_post ( $post_type='', $title = '', $status = '', $category_id = array() , $content = '', $author = '' );
								ktzplg_insert_post ( $ktzplg_post_type, $title, $status, array( $category_id ) , $content , 1 );
								
							}
							
						} # end if foreach ( $keyword as $kwd )
						
					} # end if !empty( $count ) && !empty( $keyword )
					
				} # end if ( $post->post_status != 'auto-draft' )
			}
		}
	}

	/**
	 * View action removed.
	 * 
	 * @param array $actions
	 * @return array
	 */
	public static function post_row_actions( $actions ) {
		$post_type = get_post_type();
		if ( $post_type == 'camp_bulkposter' ) {
			unset( $actions['view'] );
			unset( $actions['inline hide-if-no-js'] );
		}
		return $actions;
	}

	/**
	 * Messages overriden.
	 * 
	 * @param array $messages
	 * @return array
	 */
	public static function post_updated_messages( $messages ) {
		$post = get_post();
		$messages['camp_bulkposter'] = array(
			0 => '',
			1 => __( 'Campaign updated.', 'ktzagcplugin' ),
			2 => __( 'Custom field updated.', 'ktzagcplugin' ),
			3 => __( 'Custom field deleted.', 'ktzagcplugin' ),
			4 => __( 'Campaign updated.', 'ktzagcplugin' ),
			5 => isset( $_GET['revision'] ) ? sprintf( __( 'Campaign restored to revision from %s', 'ktzagcplugin' ), wp_post_revision_title( ( int ) $_GET['revision'], false ) ) : false,
			6 => __( 'Campaign published.', 'ktzagcplugin' ),
			7 => __( 'Campaign saved.', 'ktzagcplugin' ),
			8 => __( 'Campaign submitted.', 'ktzagcplugin' ),
			9 => sprintf( __( 'Campaign scheduled for: <strong>%1$s</strong>.', 'ktzagcplugin' ), date_i18n( __( 'M j, Y @ G:i' ), strtotime( $post->post_date ) ) ),
			10 => __( 'Campaign draft updated.', 'ktzagcplugin' )
		);
		return $messages;
	}
}
Ktzplg_Camp_Bulkposter::init();