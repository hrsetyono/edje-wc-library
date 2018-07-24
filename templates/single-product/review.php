<?php
/*
  Review Comments Template
  !!Closing </li> is left out in purpose

	Changes:
	1. Added comment-review class to <li>
	2. Wrap avatar and name with <header>.

  @version 2.6.0
*/

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
?>
<li <?php comment_class( 'comment-review' ); #1 ?> id="li-comment-<?php comment_ID() ?>">

	<div id="comment-<?php comment_ID(); ?>" class="comment_container">
    <header class="review-header"> <?php #2 ?>
  		<?php
  		do_action( 'woocommerce_review_before', $comment );
			?>
			<div>
			  <?php
	      do_action( 'woocommerce_review_before_comment_meta', $comment );
	      do_action( 'woocommerce_review_meta', $comment );
	  		?>
			</div>
    </header>

		<div class="review-text">
			<?php
			do_action( 'woocommerce_review_before_comment_text', $comment );
			do_action( 'woocommerce_review_comment_text', $comment );
			do_action( 'woocommerce_review_after_comment_text', $comment );
      ?>
		</div>
	</div>
