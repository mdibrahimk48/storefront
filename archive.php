<?php
/**
 * The template for displaying archive pages.
 *
 * Learn more: https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package storefront
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

		<?php if ( have_posts() ) : ?>

			<header class="page-header">
				<?php
					the_archive_title( '<h1 class="page-title">', '</h1>' );
					the_archive_description( '<div class="taxonomy-description">', '</div>' );
				?>
			</header><!-- .page-header -->

			<?php
			get_template_part( 'loop' );

		else :

			get_template_part( 'content', 'none' );

		endif;
		?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
do_action( 'storefront_sidebar' );
get_footer();


// add_filter( 'template_include', 'woocommerce_archive_template', 99 );

// function woocommerce_archive_template( $template ) {

//     if ( is_woocommerce() && is_archive() ) {
//         $new_template = get_stylesheet_directory() . '/woocommerce/archive-product.php';
//         if ( !empty( $new_template ) ) {
//             return $new_template;
//         }
//     }

//     return $template;
// }