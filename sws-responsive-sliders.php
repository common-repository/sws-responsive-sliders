<?php
/*
 * Plugin Name: Sws Responsive Sliders  
 * Plugin URI: http://nddw.com/demo3/sws-res-slider/
 * Description: SWS Slider is quite possibly the best way to show uploaded images in responsive slider.
 * Version: 1.0
 * Author: Technoscore
 * Author URI: http://www.technoscore.com/
 * Text Domain: sws_slider
*/

function sws_res_slider() {
	// Set UI labels for sliders Custom Post Type
	$labels = array(
		'name'                => esc_html__( 'Sliders', 'sws_slider'),
		'singular_name'       => esc_html__( 'Slider', 'sws_slider' ),
		'menu_name'           => esc_html__( 'Sliders', 'sws_slider'),
		'parent_item_colon'   => esc_html__( 'Parent Slider', 'sws_slider'),
		'all_items'           => esc_html__( 'All Sliders', 'sws_slider'),
		'view_item'           => esc_html__( 'View Slider' , 'sws_slider'),
		'add_new_item'        => esc_html__( 'Add New Slider', 'sws_slider'),
		'add_new'             => esc_html__( 'Add New', 'sws_slider'),
		'edit_item'           => esc_html__( 'Edit Slider', 'sws_slider'),
		'update_item'         => esc_html__( 'Update Slider', 'sws_slider' ),
		'search_items'        => esc_html__( 'Search Slider', 'sws_slider' ),
		'not_found'           => esc_html__( 'Not Found', 'sws_slider' ),
		'not_found_in_trash'  => esc_html__( 'Not found in Trash', 'sws_slider' ),
	);
	
	// Set other options for sliders Custom Post Type
	$args = array(
		'label'               => esc_html__( 'sliders', 'sws_slider' ),
		'description'         => esc_html__( 'Slider news and reviews', 'sws_slider'),
		'labels'              => $labels,
		'hierarchical'        => false,
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'show_in_nav_menus'   => true,
		'show_in_admin_bar'   => true,
		'menu_position'       => 5,
		'can_export'          => true,
		'has_archive'         => true,
		'exclude_from_search' => false,
		'publicly_queryable'  => true,
		'capability_type'     => 'page',
	);
	// Registering your sliders Custom Post Type
	register_post_type( 'sliders', $args );
}

/* Hook into the 'init' action so that the function
* Containing our post type registration is not 
* unnecessarily executed. 
*/
add_action( 'init', 'sws_res_slider', 0 );

function sws_res_slider_uploader_scripts() {
	wp_enqueue_media();
	wp_enqueue_script( 'sws_res_slider_admin_scripts',plugin_dir_url( __FILE__ ) . 'assets/js/admin_scripts.js'  );
}

function sws_res_slider_uploader_styles() {
	wp_enqueue_style('thickbox');
}
add_action('admin_print_scripts', 'sws_res_slider_uploader_scripts');
add_action('admin_print_styles', 'sws_res_slider_uploader_styles'); 
add_action( 'admin_init', 'sws_res_slider_add_post_gallery_so_14445904' );
add_action( 'admin_head-post.php', 'sws_res_slider_print_scripts_so_14445904' );
add_action( 'admin_head-post-new.php', 'sws_res_slider_print_scripts_so_14445904' );
add_action( 'save_post', 'sws_res_slider_update_post_gallery_so_14445904', 10, 2 );
 
/**
 * Remove  post Content  of Posts post type
*/ 
add_action('init', 'sws_res_slider_rem_editor_from_post_type');
function sws_res_slider_rem_editor_from_post_type() {
    remove_post_type_support( 'sliders', 'editor' );
}

add_action( 'add_meta_boxes', 'sws_res_slider__meta_box_add' );
function sws_res_slider__meta_box_add()
{
    add_meta_box( 'sws_res_slider_meta-box-id', esc_html__('Slider Options','sws_slider'), 'sws_res_slider_meta_box_cb', 'sliders', 'side', 'low' );
}

function sws_res_slider_meta_box_cb( $post )
{
	$values = get_post_custom( $post->ID );
	$slider_shortcode = get_post_meta( $post->ID, 'slider_shortcode', true );
	$auto = isset( $values['sws_res_slider_autostart'] ) ? esc_attr( $values['sws_res_slider_autostart'][0] ) : '';
	$startstop = isset( $values['sws_res_slider_startstop'] ) ? esc_attr( $values['sws_res_slider_startstop'][0] ) : '';
	$autodelay = isset( $values['sws_res_slider_autodelay'] ) ? esc_attr( $values['sws_res_slider_autodelay'][0] ) : '';
	$pager = isset( $values['sws_res_slider_pager'] ) ? esc_attr( $values['sws_res_slider_pager'][0] ) : '';
	$navigation = isset( $values['sws_res_slider_navigation'] ) ? esc_attr( $values['sws_res_slider_navigation'][0] ) : '';
	 ?>

	<p>	
		<label for="slider_shortcode"><?php esc_html_e('Shortcode for slider','sws_slider'); ?></label><br>
		<span><?php echo $slider_shortcode; ?></span>
    </p>
	 <p>
		<label for="sws_res_slider_autostart"><?php esc_html_e('Auto Start','sws_slider'); ?></label>
		<select name="sws_res_slider_autostart" id="sws_res_slider_autostart">
			<option value="true" <?php selected( $auto, 'true' ); ?>><?php esc_html_e('True','sws_slider'); ?></option>
			<option value="false" <?php selected( $auto, 'false' ); ?>><?php esc_html_e('False','sws_slider'); ?></option>
		</select>
	</p>
	<p>
		<label for="sws_res_slider_startstop"><?php esc_html_e('Show Start/Stop icons','sws_slider'); ?> </label>
		<select name="sws_res_slider_startstop" id="sws_res_slider_startstop">
			<option value="true" <?php selected( $startstop, 'true' ); ?>><?php esc_html_e('True','sws_slider'); ?></option>
			<option value="false" <?php selected( $startstop, 'false' ); ?>><?php esc_html_e('False','sws_slider'); ?></option>
		</select>
	</p>		
	<p>
		<label for="sws_res_slider_autodelay"><?php esc_html_e('Auto delay','sws_slider'); ?></label>
		<select name="sws_res_slider_autodelay" id="sws_res_slider_autodelay">
			<option value="0" <?php selected( $autodelay, '0' ); ?>><?php esc_html_e('No Delay','sws_slider'); ?></option>
			<option value="5" <?php selected( $autodelay, '5' ); ?>><?php esc_html_e('5','sws_slider'); ?></option>
			<option value="10" <?php selected( $autodelay, '10' ); ?>><?php esc_html_e('10','sws_slider'); ?></option>
		</select>
	</p>
	<p>
		<label for="sws_res_slider_pager"><?php esc_html_e('Show Pager','sws_slider'); ?></label>
		<select name="sws_res_slider_pager" id="sws_res_slider_pager">
			<option value="true" <?php selected( $pager, 'true' ); ?>><?php esc_html_e('True','sws_slider'); ?></option>
			<option value="false" <?php selected( $pager, 'false' ); ?>><?php esc_html_e('False','sws_slider'); ?></option>
		</select>
	</p>			
	<p>
		<label for="sws_res_slider_navigation"><?php esc_html_e('Show Navigation','sws_slider'); ?></label>
		<select name="sws_res_slider_navigation" id="sws_res_slider_navigation">
			<option value="true" <?php selected( $navigation, 'true' ); ?>><?php esc_html_e('True','sws_slider'); ?></option>
			<option value="false" <?php selected( $navigation, 'false' ); ?>><?php esc_html_e('False','sws_slider'); ?></option>
		</select>
	</p>		
    <?php        
}

/**
 * Add custom Meta Box to Posts post type
*/
function sws_res_slider_add_post_gallery_so_14445904()
{
	add_meta_box(
		'post_gallery',
		'Image Slider',
		'sws_res_slider_post_gallery_options_so_14445904',
		'sliders',
		'normal',
		'core'
	);
}

/**
 * Print the Meta Box content
 */
function sws_res_slider_post_gallery_options_so_14445904()
{
	global $post;
	$gallery_data = get_post_meta( $post->ID, 'gallery_data', true );

	// Use nonce for verification
	wp_nonce_field( plugin_basename( __FILE__ ), 'noncename_so_14445904' ); ?>
 
	<div id="dynamic_form">
		<div id="field_wrap">
		<?php if ( isset( $gallery_data['image_url'] ) ):
				for( $i = 0; $i < count( $gallery_data['image_url'] ); $i++ ): ?>
					<div class="field_row">
						<div class="field_left">
							<div class="form_field">
							  <label><?php esc_html_e('Image URL','sws_slider'); ?></label>
							  <input type="text" class="meta_image_url" name="gallery[image_url][]" value="<?php esc_html_e( $gallery_data['image_url'][$i] ); ?>" />
							</div>
						</div>
 
						<div class="field_right image_wrap">
							<img src="<?php esc_html_e( $gallery_data['image_url'][$i] ); ?>" height="48" width="48" />
						</div>
						
						<div class="field_right">
							<input class="button" type="button" value="<?php esc_html_e('Choose File','sws_slider'); ?>" onclick="sws_slider_add_image(this)" />
							<input class="button" type="button" value="<?php esc_html_e('Remove','sws_slider'); ?>" onclick="sws_slider_remove_field(this)" />
						</div>
						<div class="clear"></div> 
					</div>
			<?php endfor;
		endif; ?>
		</div>
	
		<div style="display:none" id="master-row">
			<div class="field_row">
				<div class="field_left">
					<div class="form_field">
						<label><?php esc_html_e('Image URL','sws_slider'); ?></label>
						<input class="meta_image_url" value="" type="text" name="gallery[image_url][]" />
					</div>
				</div>
				<div class="field_right image_wrap"> </div> 
				<div class="field_right"> 
					<input type="button" class="button" value="<?php esc_html_e('Choose File','sws_slider'); ?>" onclick="sws_slider_add_image(this)" />
					
					<input class="button" type="button" value="<?php esc_html_e('Remove','sws_slider'); ?>" onclick="sws_slider_remove_field(this)" /> 
				</div>
				<div class="clear"></div>
			</div>
		</div>
		<div id="add_field_row">
			<input class="button" type="button" value="<?php esc_html_e('Add New','sws_slider'); ?>" id="add_field_row1"  />
		</div>
	</div>
  <?php
}
 
/**
 * Print styles and scripts
 */
function sws_res_slider_print_scripts_so_14445904()
{
    global $post;
	if( 'sliders' != $post->post_type )
        return;
	wp_enqueue_style( 'sws_slider-css',plugin_dir_url( __FILE__ ) . 'assets/css/metabox.css' );
}
 
/**
 * Save post action, process fields
 */
function sws_res_slider_update_post_gallery_so_14445904( $post_id, $post_object ) {
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )  
        return;
   
    if ( 'revision' == $post_object->post_type )
        return;
 
    if ( !wp_verify_nonce( $_POST['noncename_so_14445904'], plugin_basename( __FILE__ ) ) )
        return;
 
    if ( 'sliders' != $_POST['post_type']) // here you can set post type name
        return;
 
    if ( $_POST['gallery'] ):
		
		update_post_meta( $post_id, 'slider_shortcode', "[sws_res_slider slider_id='".$post_id."']" );
		$gallery_data = array();
        for ($i = 0; $i < count( $_POST['gallery']['image_url'] ); $i++ ):
            if ( '' != $_POST['gallery']['image_url'][ $i ] ):
                $gallery_data['image_url'][]  = $_POST['gallery']['image_url'][ $i ];
            endif;
        endfor;
 
        if ( $gallery_data ) 
            update_post_meta( $post_id, 'gallery_data', $gallery_data );
        else 
            delete_post_meta( $post_id, 'gallery_data' );
    else:
        delete_post_meta( $post_id, 'gallery_data' );
    endif;
	
	   
    if( isset( $_POST['sws_res_slider_autostart'] ) ){
		$sws_res_slider_autostart = sanitize_text_field( $_POST['sws_res_slider_autostart'] ) ;
        update_post_meta( $post_id, 'sws_res_slider_autostart',$sws_res_slider_autostart );
    }           
    if( isset( $_POST['sws_res_slider_startstop'] ) ){
		$sws_res_slider_startstop = sanitize_text_field( $_POST['sws_res_slider_startstop'] ) ;
        update_post_meta( $post_id, 'sws_res_slider_startstop', $sws_res_slider_startstop );
    }
	
    if( isset( $_POST['sws_res_slider_autodelay'] ) ){
		$sws_res_slider_autodelay = sanitize_text_field( $_POST['sws_res_slider_autodelay'] ) ;
        update_post_meta( $post_id, 'sws_res_slider_autodelay', $sws_res_slider_autodelay );
     }
	 
    if( isset( $_POST['sws_res_slider_pager'] ) ){
		$sws_res_slider_pager = sanitize_text_field( $_POST['sws_res_slider_pager'] ) ;
        update_post_meta( $post_id, 'sws_res_slider_pager', $sws_res_slider_pager);
    }
	
    if( isset( $_POST['sws_res_slider_navigation'] ) ){
		$sws_res_slider_navigation = sanitize_text_field( $_POST['sws_res_slider_navigation'] ) ;
        update_post_meta( $post_id, 'sws_res_slider_navigation', $sws_res_slider_navigation);
	}
}

function sws_res_slider_shordcode( $atts ) {

	$slider_id = $atts['slider_id'];
	wp_register_script('sws_slider-bxslider',plugin_dir_url( __FILE__ ).'assets/js/jquery.bxslider.js','','4.6.1',true);
	wp_enqueue_script( 'sws_slider-bxslider');
	wp_register_script('sws_slider-custom',plugin_dir_url( __FILE__ ).'assets/js/scripts.js','','1.0',true);
	wp_enqueue_script( 'sws_slider-custom' );
	wp_enqueue_style( 'sws_slider-bxslider',plugin_dir_url( __FILE__ ) . 'assets/css/jquery.bxslider.css' ); 

	$values1 = get_post_custom(  $slider_id );
	$auto1 = isset( $values1['sws_res_slider_autostart'] ) ? esc_attr( $values1['sws_res_slider_autostart'][0] ) : '';
	$startstop1 = isset( $values1['sws_res_slider_startstop'] ) ? esc_attr( $values1['sws_res_slider_startstop'][0] ) : '';
	$autodelay1 = isset( $values1['sws_res_slider_autodelay'] ) ? esc_attr( $values1['sws_res_slider_autodelay'][0] ) : '';
	$pager1 = isset( $values1['sws_res_slider_pager'] ) ? esc_attr( $values1['sws_res_slider_pager'][0] ) : '';
	$navigation1 = isset( $values1['sws_res_slider_navigation'] ) ? esc_attr( $values1['sws_res_slider_navigation'][0] ) : '';

	$html = '<ul class="bxslider" >'; 
	$gallery_data = get_post_meta( $slider_id, "gallery_data", true );

    if ( isset( $gallery_data["image_url"] ) ):
        for( $i = 0; $i < count( $gallery_data["image_url"] ); $i++ ):
			$html .= '<li><img src="'.$gallery_data["image_url"][$i].'" /></li>';
		endfor;
	endif; 
	
	$html .= '</ul>';  
 ?>
<script>
var $ = jQuery.noConflict();
jQuery(document).ready(function(){	
	$(".bxslider").bxSlider({
		auto: <?php echo $auto1 ?>,  
		autoControls: false, 
		autoDelay:<?php echo $autodelay1 ?>,
		pager:<?php echo $pager1 ?>,
		controls:<?php echo $navigation1 ?>,
		slideMargin: 20,
		onSliderLoad: function(){
	  } 
	});  
});
</script>
<?php  return $html;
}
add_shortcode( 'sws_res_slider', 'sws_res_slider_shordcode' );