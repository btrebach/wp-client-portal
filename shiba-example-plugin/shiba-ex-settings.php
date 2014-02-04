<?php
if (!function_exists('is_admin')) {
    header('Status: 403 Forbidden');
    header('HTTP/1.1 403 Forbidden');
    exit();
}

if (!class_exists("Shiba_Example_Settings")) :

/* 
	Create example settings page for our plugin.
	
	- We show how to render our own controls using HTML.
	- We show how to get WordPress to render controls for us using do_settings_sections'
	
	WordPress Settings API tutorials
	http://codex.wordpress.org/Settings_API
	http://ottopress.com/2009/wordpress-settings-api-tutorial/
*/
class Shiba_Example_Settings {

	public static $default_settings = 
		array( 	
			  	'example_text' => 'Test text',
			  	'example_checkbox1' => 'apples',
				'example_checkbox2' => 'oranges',
			  	'mbox_example_text' => 'Shiba example plugin by ShibaShake',
			  	'mbox_example_checkbox1' => 'grapes',
				'mbox_example_checkbox2' => 'lemons'
				);
	var $pagehook, $page_id, $settings_field, $options;

	
	function __construct() {	
		$this->page_id = 'shiba_example';
		// This is the get_options slug used in the database to store our plugin option values.
		$this->settings_field = 'shiba_example_options';
		$this->options = get_option( $this->settings_field );

		add_action('admin_init', array($this,'admin_init'), 20 );
		add_action( 'admin_menu', array($this, 'admin_menu'), 20);
	}
	
	function admin_init() {
		register_setting( $this->settings_field, $this->settings_field, array($this, 'sanitize_theme_options') );
		add_option( $this->settings_field, Shiba_Example_Settings::$default_settings );
		
		
		/* 
			This is needed if we want WordPress to render our settings interface
			for us using -
			do_settings_sections
			
			It sets up different sections and the fields within each section.
		*/
		add_settings_section('shiba_main', '',  
			array($this, 'main_section_text'), 'example_settings_page');

		add_settings_field('example_text', 'Example Text', 
			array($this, 'render_example_text'), 'example_settings_page', 'shiba_main');

		add_settings_field('example_checkbox1', 'Example Checkboxes', 
			array($this, 'render_example_checkbox'), 'example_settings_page', 'shiba_main', 
			array('id' => 'example_checkbox1', 'value' => 'apples', 'text' => 'Apples') );
		add_settings_field('example_checkbox2', '', 
			array($this, 'render_example_checkbox'), 'example_settings_page', 'shiba_main',
			array('id' => 'example_checkbox2', 'value' => 'oranges', 'text' => 'Oranges') );
	}

	function admin_menu() {
		if ( ! current_user_can('update_plugins') )
			return;
	
		// Add a new submenu to the standard Settings panel
		$this->pagehook = $page =  add_options_page(	
			__('Shiba Example', 'shiba_example'), __('Shiba Example', 'shiba_example'), 
			'administrator', $this->page_id, array($this,'render') );
		
		// Executed on-load. Add all metaboxes.
		add_action( 'load-' . $this->pagehook, array( $this, 'metaboxes' ) );

		// Include js, css, or header *only* for our settings page
		add_action("admin_print_scripts-$page", array($this, 'js_includes'));
//		add_action("admin_print_styles-$page", array($this, 'css_includes'));
		add_action("admin_head-$page", array($this, 'admin_head') );
	}

	function admin_head() { ?>
		<style>
		.settings_page_shiba_example label { display:inline-block; width: 150px; }
		</style>

	<?php }

     
	function js_includes() {
		// Needed to allow metabox layout and close functionality.
		wp_enqueue_script( 'postbox' );
	}


	/*
		Sanitize our plugin settings array as needed.
	*/	
	function sanitize_theme_options($options) {
		$options['example_text'] = stripcslashes($options['example_text']);
		return $options;
	}


	/*
		Settings access functions.
		
	*/
	protected function get_field_name( $name ) {

		return sprintf( '%s[%s]', $this->settings_field, $name );

	}

	protected function get_field_id( $id ) {

		return sprintf( '%s[%s]', $this->settings_field, $id );

	}

	protected function get_field_value( $key ) {

		return $this->options[$key];

	}
		

	/*
		Render settings page.
		
	*/
	
	function render() {
		global $wp_meta_boxes;

		$messages[1] = __('Shiba Example action taken.', 'shiba_example');
		
		if ( isset($_GET['message']) && (int) $_GET['message'] ) {
			$message = $messages[$_GET['message']];
			$_SERVER['REQUEST_URI'] = remove_query_arg(array('message'), $_SERVER['REQUEST_URI']);
		}
		
		$title = __('Shiba Example', 'shiba_example');
		?>
		<div class="wrap">   
			<?php screen_icon(); ?>
			<h2><?php echo esc_html( $title ); ?></h2>
		
			<?php
				if ( !empty($message) ) : 
				?>
				<div id="message" class="updated fade"><p><?php echo $message; ?></p></div>
				<?php 
				endif; 
			?>
			<form method="post" action="options.php">
				<p>
				<input type="submit" class="button button-primary" name="save_options" value="<?php esc_attr_e('Save Options'); ?>" />
				
				</p>
                
                <div class="metabox-holder">
                    <div class="postbox-container" style="width: 99%;">
                    <?php 
						// Render metaboxes
                        settings_fields($this->settings_field); 
                        do_meta_boxes( $this->pagehook, 'main', null );
                      	if ( isset( $wp_meta_boxes[$this->pagehook]['column2'] ) )
 							do_meta_boxes( $this->pagehook, 'column2', null );
                    ?>
                    </div>
                </div>

				<p>
				<input type="submit" class="button button-primary" name="save_options" value="<?php esc_attr_e('Save Options'); ?>" />
				
				</p>
			</form>
		</div>
        
        <!-- Needed to allow metabox layout and close functionality. -->
		<script type="text/javascript">
			//<![CDATA[
			jQuery(document).ready( function ($) {
				// close postboxes that should be closed
				$('.if-js-closed').removeClass('if-js-closed').addClass('closed');
				// postboxes setup
				postboxes.add_postbox_toggles('<?php echo $this->pagehook; ?>');
			});
			//]]>
		</script>
	<?php }
	
	
	function metaboxes() {

		// Example metabox showing plugin version and release date. 
		// Also includes and example input text box, rendered in HTML in the info_box function
		add_meta_box( 'shiba-example-version', __( 'Information', 'shiba_example' ), array( $this, 'info_box' ), $this->pagehook, 'main', 'high' );

		// Example metabox containing two example checkbox controls.
		// Also includes and example input text box, rendered in HTML in the condition_box function
		add_meta_box( 'shiba-example-conditions', __( 'Example Conditions', 'shiba_example' ), array( $this, 'condition_box' ), $this->pagehook, 'main' );

		// Example metabox containing an example text box & two example checkbox controls.
		// Example settings rendered by WordPress using the do_settings_sections function.
		add_meta_box( 	'shiba-example-all', 
						__( 'Rendered by WordPress using do_settings_sections', 'shiba_example' ), 
						array( $this, 'do_settings_box' ), $this->pagehook, 'main' );

	}

	function info_box() {

		?>
		<p><strong><?php _e( 'Version:', 'shiba_example' ); ?></strong> <?php echo SHIBA_EXAMPLE_VERSION; ?> <?php echo '&middot;'; ?> <strong><?php _e( 'Released:', 'shiba_example' ); ?></strong> <?php echo SHIBA_EXAMPLE_RELEASE_DATE; ?></p>

		<p>
 			<label for="<?php echo $this->get_field_id( 'mbox_example_text' ); ?>"><?php _e( 'Example Text', 'shiba_example' ); ?></label>
			<input type="text" name="<?php echo $this->get_field_name( 'mbox_example_text' ); ?>" id="<?php echo $this->get_field_id( 'mbox_example_text' ); ?>" value="<?php echo esc_attr( $this->get_field_value( 'mbox_example_text' ) ); ?>" style="width:50%;" />
		</p>

		<?php

	}
	
	function condition_box() {
	?>
		<p>        
			<input type="checkbox" name="<?php echo $this->get_field_name( 'mbox_example_checkbox1' ); ?>" id="<?php echo $this->get_field_id( 'mbox_example_checkbox1' ); ?>" value="grapes" <?php echo isset($this->options['mbox_example_checkbox1']) ? 'checked' : '';?> /> 
			<label for="<?php echo $this->get_field_id( 'mbox_example_checkbox1' ); ?>"><?php _e( 'Grapes', 'shiba_example' ); ?></label>
            <br/>
            
            
			<input type="checkbox" name="<?php echo $this->get_field_name( 'mbox_example_checkbox2' ); ?>" id="<?php echo $this->get_field_id( 'mbox_example_checkbox2' ); ?>" value="lemons" <?php echo isset($this->options['mbox_example_checkbox2']) ? 'checked' : '';?> /> 
			<label for="<?php echo $this->get_field_id( 'mbox_example_checkbox2' ); ?>"><?php _e( 'Lemons', 'shiba_example' ); ?></label>
            
		</p>
	<?php }


	function do_settings_box() {
		do_settings_sections('example_settings_page'); 
	}
	
	/* 
		WordPress settings rendering functions
		
		ONLY NEEDED if we are using wordpress to render our controls (do_settings_sections)
	*/
																	  
																	  
	function main_section_text() {
		echo '<p>Some example inputs.</p>';
	}
	
	function render_example_text() { 
		?>
        <input id="example_text" style="width:50%;"  type="text" name="<?php echo $this->get_field_name( 'example_text' ); ?>" value="<?php echo esc_attr( $this->get_field_value( 'example_text' ) ); ?>" />	
		<?php 
	}
	
	function render_example_checkbox($args) {
		$id = 'shiba_example_options['.$args['id'].']';
		?>
  		<input name="<?php echo $id;?>" type="checkbox" value="<?php echo $args['value'];?>" <?php echo isset($this->options[$args['id']]) ? 'checked' : '';?> /> <?php echo " {$args['text']}"; ?> <br/>
		<?php 
	}
	

} // end class
endif;
?>