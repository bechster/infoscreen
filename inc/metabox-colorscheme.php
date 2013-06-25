<?php
/* Use the admin_menu action to define the custom boxes */
add_action('admin_menu', 'infoscreen_create_colorscheme_metabox');

/* Use the save_post action to do something with the data entered */
add_action('save_post', 'infoscreen_colorscheme_save_postdata');

/* Use the save_post action to do something with the data entered */
add_action('save_post', 'infoscreen_transparency_save_postdata');

/* Adds a custom section to the "advanced" Post and Page edit screens */
function infoscreen_create_colorscheme_metabox() {
	if( function_exists( 'add_meta_box' )) {
		add_meta_box(
		'infoscreen-page-colorscheme',
		__( 'Color scheme', 'infoscreen_page_colorscheme' ),
		'colorscheme_metabox',
		'post',
		'normal',
		'high'
				);
	}
}
function colorscheme_metabox() {
	$options = get_option('infoscreen_theme_options');
	$currentvalue = get_post_meta(get_the_ID(), '_infoscreen_colorscheme', true);
	echo $currentvalue;
// 	print_r($options);
	?>
<div>
	<select name="_infoscreen_colorscheme" onChange="this.style.background=this.options[this.selectedIndex].style.background; this.style.color=this.options[this.selectedIndex].style.color;">
		<option style='background: #FFF; color: #000' selected disabled>Choose scheme...</option>
		<?php
		for ($i = 0; $i < $options['colorschemes']; $i += 2){
			$backgroundID = $i+1;
			if(strpos($options['colorscheme'.$i], '#') === false){
// 				echo "<option style='background: #FFF; color: #000'>EMPTY</option>";
			} else {
				echo "<option";
				echo ($currentvalue == $options['colorscheme_name'.$i])? ' selected' : '';
				echo " value='" . $options['colorscheme_name'.$i] . "' ";
				echo "style='color: ";
				echo $options['colorscheme'.$i];
				echo ";";
				echo "background: ";
				echo $options['colorscheme'.$backgroundID];
				echo "';";
				echo ">";
				echo $options['colorscheme_name'.$i];
				echo "</option>";
				echo "\n";
			}
		  }
		  ?>
	</select>
	<input type="hidden" name="infoscreen_colorscheme_noncename"
		id="infoscreen_colorscheme_noncename"
		value="<?php wp_create_nonce( plugin_basename(__FILE__) ); ?>"/>
	</div>
	<label>Transparency</label>
	<div id="slider" style="width: 200px"></div>
	<div> 
	<label for="amount">%</label>
  <input name="_infoscreen_transparency" type="text" id="amount" style="border: 0; color: #f6931f; font-weight: bold; width: 30px" />
	</div>
	<script>jQuery(document).ready(function($){
		  $( "#slider" ).slider({
			    range: "min",
			    min: 0,
			    max: 100,
			    value: <?php echo get_post_meta(get_the_ID(), '_infoscreen_transparency', true);?>,
			    slide: function( event, ui ) {
			      $( "#amount" ).val( ui.value );
			    }
			  });
			  $( "#amount" ).val( $( "#slider" ).slider( "value" ) );
			});
		  </script>
<?php
}

/* When the post is saved, saves our custom data */
function infoscreen_colorscheme_save_postdata( $post_id ) {

	// verify this came from the our screen and with proper authorization,
	// because save_post can be triggered at other times
	if ( !current_user_can( 'edit_post', $post_id ))
		return $post_id;

	// OK, we're authenticated: we need to find and save the data
	$data = $_POST['_infoscreen_colorscheme'];
	if(get_post_meta($post_id, '_infoscreen_colorscheme') == '')
		add_post_meta($post_id, '_infoscreen_colorscheme', $data, true);

	elseif($data != get_post_meta($post_id, '_infoscreen_colorscheme', true))
	update_post_meta($post_id, '_infoscreen_colorscheme', $data);

	elseif($data == '')
	// 		delete_post_meta($post_id, '_infoscreen_layout', get_post_meta($post_id, '_infoscreen_layout', true));

	return $data;
}

/* When the post is saved, saves our custom data */
function infoscreen_transparency_save_postdata( $post_id ) {

	// verify this came from the our screen and with proper authorization,
	// because save_post can be triggered at other times
	if ( !current_user_can( 'edit_post', $post_id ))
		return $post_id;

	// OK, we're authenticated: we need to find and save the data
	$data = $_POST['_infoscreen_transparency'];
	if(get_post_meta($post_id, '_infoscreen_transparency') == '')
		add_post_meta($post_id, '_infoscreen_transparency', $data, true);

	elseif($data != get_post_meta($post_id, '_infoscreen_transparency', true))
	update_post_meta($post_id, '_infoscreen_transparency', $data);

	elseif($data == '')
	// 		delete_post_meta($post_id, '_infoscreen_layout', get_post_meta($post_id, '_infoscreen_layout', true));

	return $data;
}