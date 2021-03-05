<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package BlogZ
 */

$thumbnail_url = get_the_post_thumbnail_url( get_the_ID(), 'blogz-vertical' );

$class  = ! empty( $thumbnail_url ) ? 'bg-overlay ' : '';
$class .= 'bg-cover';
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'adjacent' ); ?>>
	<div class="article__inner <?php echo esc_attr( $class ); ?>" style="background-image: url( <?php echo esc_url( $thumbnail_url ); ?> )">
		<div class="inner__content">
			<?php
			blogz_print_single_category();
			the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
			?>

			<div class="entry-meta">
				<?php
				blogz_posted_on();
				blogz_print_comment_link();
				?>
			</div><!-- .entry-meta -->
		</div>

		<div class="link-more">
			<?php echo wp_kses_post( blogz_more_link() ); ?>
		</div>

	</div>
</article><!-- #post-<?php the_ID(); ?> -->
