<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the id=main div and all content after
 *
 * @package InfoScreen
 * @since InfoScreen 1.0
 */
global $post;
global $time_total;
global $time_accu;
$category_slug = explode("?", $_SERVER['REQUEST_URI']);
$args = array( 'category' => $category_slug[1]);
$myposts = get_posts( $args );
foreach( $myposts as $post ) : setup_postdata($post); 
$time_total += get_post_meta(get_the_ID(), '_infoscreen_time', true) * 1000;
endforeach; 
foreach( $myposts as $post ) : setup_postdata($post); ?>

<?php endforeach; ?>

<header id="masthead" class="site-header" role="banner">
	<hgroup>
		<h1 class="site-title">
<?php	
	$options = get_option('infoscreen_theme_options', infoscreen_get_default_theme_options());
?>
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>"
				title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>"
				rel="home">
<?php if ($options['logo'] != "") { ?>
				<img style="max-width: 100%;" alt="<?php bloginfo( 'name' ); ?>" src="<?php echo esc_url( $options['logo'] ); ?>" />
<?php } else { ?>
				<?php bloginfo( 'name' ); ?>
<?php } ?>
			</a>
		</h1>
	</hgroup>
</header>
<!-- #masthead -->
<footer id="colophon" class="site-footer"
	role="contentinfo">
	<div class="site-info">
		<?php do_action( 'infoscreen_credits' ); ?>
		<a href="http://wordpress.org/"
			title="<?php esc_attr_e( 'A Semantic Personal Publishing Platform', 'infoscreen' ); ?>"
			rel="generator"><?php printf( __( 'Proudly powered by %s', 'infoscreen' ), 'WordPress' ); ?>
		</a> <span class="sep"> | </span>
		<?php printf( __( 'Theme: %1$s by %2$s.', 'infoscreen' ), 'InfoScreen', '<a href="https://bechster.dk/" rel="designer">Bechster</a>' ); ?>
	</div>
	<!-- .site-info -->
</footer>
<!-- #colophon -->

<?php wp_footer(); ?>
</body>
</html>
