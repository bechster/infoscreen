<?php
/**
 * @package InfoScreen
 * @since InfoScreen 1.0
 */
	
	$options = get_option('infoscreen_theme_options');
?>
<li id="post-<?php the_ID(); ?>" <?php post_class('slide'); ?> <?php
	if( !has_shortcode( $post->post_content, 'mbYTPlayer') ) { ?>
		style="background-image:url('<?php infoscreen_img_src('slide-img'); ?>');"
	<?php } ?>>
	<div class="slide-content <?php 
	/* $options = get_option('infoscreen_theme_options');
	for ($i = 1; $i <= $options['colorschemes']; $i++){
		if ($options['csid'.$i] == get_post_meta(get_the_ID(), '_infoscreen_colorscheme', true)){
			$font = hex2rgb($options['colorscheme_font_field'.$i]);
			$bg = hex2rgb($options['colorscheme_bg_field'.$i]);
		}
		else {
			$font = hex2rgb($options['colorscheme_font_field1']);
			$bg = hex2rgb($options['colorscheme_bg_field1']);
		}
	} */
	
	$currentid = get_post_meta(get_the_ID(), '_infoscreen_colorscheme', true);
	$colorscheme_exsists = 0;
	for ($i = 1; $i <= $options['colorschemes']; $i++){
		if($currentid == $options['csid'.$i]){
			$colorscheme_exsists = 1;
			$font = hex2rgb($options['colorscheme_font_field'.$i]);
			$bg = hex2rgb($options['colorscheme_bg_field'.$i]);
		}
		else if($currentid == null){
			$font = hex2rgb($options['colorscheme_font_field1']);
			$bg = hex2rgb($options['colorscheme_bg_field1']);
		} 
	}
	if($colorscheme_exsists == 0){
			$font = hex2rgb($options['colorscheme_font_field1']);
			$bg = hex2rgb($options['colorscheme_bg_field1']);
	}
	
	if (get_post_meta(get_the_ID(), '_infoscreen_layout', true) != '') {
		$layout = get_post_meta(get_the_ID(), '_infoscreen_layout', true);
	} else {
		$layout = 'layout-txt';
	}
	echo $layout . '"';
	$transparency_value = get_post_meta(get_the_ID(), '_infoscreen_transparency', true)/100;
	if (get_post_meta(get_the_ID(), '_infoscreen_layout', true) != 'layout-img') {
		echo 'style="color: rgb('.$font.'); background: rgba('.$bg.','.$transparency_value.');">';
	} else {
		echo '>';
	}
	?>
		<header class="entry-header">
		<h1 class="entry-title" >
			<?php the_title(); ?>
		</h1>
		<?php if ( 'post' == get_post_type() ) : ?>
		<?php endif; ?>
		</header>
		<!-- .entry-header -->
		<div class="entry-content">
			<?php 
			the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'infoscreen' ) ); ?>
			<?php wp_link_pages( array( 'before' => '<div class="page-links">' . __( 'Pages:', 'infoscreen' ), 'after' => '</div>' ) ); ?>
		</div>
		<!-- .entry-content -->
		<div class="branding" <?php
	if (get_post_meta(get_the_ID(), '_infoscreen_layout', true) != 'layout-img') {
		echo 'style="border-color: rgba('.$font.',.5);"';
	} ?>
		><?php 
$options = get_option('infoscreen_theme_options', infoscreen_get_default_theme_options()); 

if ($options['logo'] != "") {
?><img class="logo" alt="<?php bloginfo( 'name' ); ?>" src="<?php echo esc_url( $options['logo'] ); ?>" /><?php 
} else { 
?><span class="logo"><?php bloginfo( 'name' ); ?></span><?php
} 
?></div>
	</div>
	<!-- .slide-content -->
	<?php //edit_post_link( __( 'Edit', 'infoscreen' ), '<span class="edit-link">', '</span>' ); ?>
</li>
<!-- #post-## -->