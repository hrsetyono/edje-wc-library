<?php
/**
 * Changes:
 * - Wrapped the avatar and name in `<header>`
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
?>

<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
	<div id="comment-<?php comment_ID(); ?>" class="comment_container">

    <header class="h-review-header">
      <?php
        /**
         * @hooked woocommerce_review_display_gravatar - 10
         */
        do_action('woocommerce_review_before', $comment);
      ?>
      <div>
        <?php
          /**
           * @hooked woocommerce_review_display_rating - 10
           */
          do_action('woocommerce_review_before_comment_meta', $comment);

          /**
           * @hooked woocommerce_review_display_meta - 10
           */
          do_action('woocommerce_review_meta', $comment);
        ?>
      </div>
    </header>
		<div class="comment-text">
			<?php
			do_action('woocommerce_review_before_comment_text', $comment);

			/**
			 * @hooked woocommerce_review_display_comment_text - 10
			 */
			do_action('woocommerce_review_comment_text', $comment);

			do_action('woocommerce_review_after_comment_text', $comment);
			?>
		</div>
	</div>