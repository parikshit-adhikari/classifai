<?php
/**
 * Recommended Content block markup
 *
 * @package Classifai\Blocks
 *
 * @var array    $attributes         Block attributes.
 * @var string   $content            Block content.
 * @var WP_Block $block              Block instance.
 * @var array    $context            BLock context.
 */

if ( empty( $response ) || empty( $response->rewardActionId ) ) { // phpcs:ignore WordPress.NamingConventions.ValidVariableName.UsedPropertyNotSnakeCase
	return $response;
}

// phpcs:ignore WordPress.NamingConventions.ValidVariableName.UsedPropertyNotSnakeCase
$post_id   = $response->rewardActionId;
$post      = get_post( $post_id );
$post_link = esc_url( get_permalink( $post ) );
$title     = get_the_title( $post );
if ( ! $title ) {
	$title = __( '(no title)', 'classifai' );
}

$class = 'wp-block-classifai-recommended-content';
if ( isset( $attributes['displayPostDate'] ) && $attributes['displayPostDate'] ) {
	$class .= ' has-dates';
}

if ( isset( $attributes['displayAuthor'] ) && $attributes['displayAuthor'] ) {
	$class .= ' has-author';
}
?>
<ul <?php echo get_block_wrapper_attributes( array( 'class' => $class ) ); // phpcs:ignore> ?>>
	<li>
	<?php
	if ( $attributes['displayFeaturedImage'] && has_post_thumbnail( $post ) ) {
		$image_classes = 'wp-block-classifai-recommended-content__featured-image';
		?>
		<div class="<?php echo esc_attr( $image_classes ); ?>">
			<?php
			if ( $attributes['addLinkToFeaturedImage'] ) {
				?>
				<a href="<?php echo esc_url( $post_link ); ?>" aria-label="<?php echo esc_attr( $title ); ?>">
					<?php echo get_the_post_thumbnail( $post ); ?>
				</a>
				<?php
			} else {
				echo get_the_post_thumbnail( $post );
			}
			?>
		</div>
		<?php
	}
	?>
	<a href="<?php echo esc_url( $post_link ); ?>">
		<?php echo esc_html( $title ); ?>
	</a>
	<?php
	if ( isset( $attributes['displayAuthor'] ) && $attributes['displayAuthor'] ) {
		$author_display_name = get_the_author_meta( 'display_name', $post->post_author );

		/* translators: byline. %s: current author. */
		$byline = sprintf( __( 'by %s', 'classifai' ), $author_display_name );
		if ( ! empty( $author_display_name ) ) {
			?>
			<div class="wp-block-classifai-recommended-content__post-author">
				<?php echo esc_html( $byline ); ?>
			</div>
			<?php
		}
	}

	if ( isset( $attributes['displayPostDate'] ) && $attributes['displayPostDate'] ) {
		?>
		<time datetime="<?php echo esc_attr( get_the_date( 'c', $post ) ); ?>" class="wp-block-classifai-recommended-content__post-date">
			<?php echo esc_html( get_the_date( '', $post ) ); ?>
		</time>
		<?php
	}

	if ( isset( $attributes['displayPostExcept'] ) && $attributes['displayPostExcept'] ) {
		$trimmed_excerpt = get_the_excerpt( $post );

		if ( post_password_required( $post ) ) {
			$trimmed_excerpt = __( 'This content is password protected.', 'classifai' );
		}
		?>
		<div class="wp-block-classifai-recommended-content__post-excerpt">
		<?php echo esc_html( $trimmed_excerpt ); ?>
		</div>
		<?php
	}
	?>
	</li>
</ul>
