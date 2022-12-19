<!doctype html>
<html <?php language_attributes(); ?> >
	<head>
		<meta charset="<?php bloginfo( 'charset' ); ?>" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<?php wp_head(); ?>
		<style>
			#site-header,
			#content {
				max-width: 600px;
				padding: 0 1em;
				margin: 0 auto;
			}
		</style>
	</head>
	<body <?php body_class(); ?>>
<header id="masthead">
	<div id="site-header">
<?php
$blog_info    = get_bloginfo( 'name' );
$description  = get_bloginfo( 'description', 'display' );
$show_title   = ( true === get_theme_mod( 'display_title_and_tagline', true ) );
$header_class = $show_title ? 'site-title' : 'screen-reader-text';

?>

<?php if ( has_custom_logo() && $show_title ) : ?>
	<div class="site-logo"><?php the_custom_logo(); ?></div>
<?php endif; ?>

<div class="site-branding">

	<?php if ( has_custom_logo() && ! $show_title ) : ?>
		<div class="site-logo"><?php the_custom_logo(); ?></div>
	<?php endif; ?>

	<?php if ( $blog_info ) : ?>
		<?php if ( is_front_page() && ! is_paged() ) : ?>
			<h1 class="<?php echo esc_attr( $header_class ); ?>"><?php echo esc_html( $blog_info ); ?></h1>
		<?php elseif ( is_front_page() && ! is_home() ) : ?>
			<h1 class="<?php echo esc_attr( $header_class ); ?>"><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php echo esc_html( $blog_info ); ?></a></h1>
		<?php else : ?>
			<p class="<?php echo esc_attr( $header_class ); ?>"><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php echo esc_html( $blog_info ); ?></a></p>
		<?php endif; ?>
	<?php endif; ?>

	<?php if ( $description && true === get_theme_mod( 'display_title_and_tagline', true ) ) : ?>
		<p class="site-description">
			<?php echo $description; // phpcs:ignore WordPress.Security.EscapeOutput ?>
		</p>
	<?php endif; ?>
</div><!-- .site-branding -->
	</div>
</header><!-- #masthead -->
		<div id="page" class="site">
			<div id="content" class="site-content">
				<div id="primary" class="content-area">
					<main id="main" class="site-main">
						<article>
							<header class="entry-header">
								<h1></h1>
							</header><!-- .entry-header -->
							<div class="entry-content"><?php echo $args['body']; ?></div><!-- .entry-content -->
					</main><!-- #main -->
				</div><!-- #primary -->
			</div><!-- #content -->
			<footer id="colophon" class="site-footer">
				<div class="site-info">
					<div class="site-name">
						<?php if ( has_custom_logo() ) : ?>
						<div class="site-logo"><?php the_custom_logo(); ?></div>
						<?php else : ?>
							<?php if ( get_bloginfo( 'name' ) && get_theme_mod( 'display_title_and_tagline', true ) ) : ?>
								<?php if ( is_front_page() && ! is_paged() ) : ?>
									<?php bloginfo( 'name' ); ?>
						<?php else : ?>
						<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php bloginfo( 'name' ); ?></a>
						<?php endif; ?>
						<?php endif; ?>
						<?php endif; ?>
					</div><!-- .site-name -->
				</div><!-- .site-info -->
			</footer><!-- #colophon -->
		</div><!-- #page -->
	</body>
</html>
