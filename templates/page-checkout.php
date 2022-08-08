<!doctype html>
<html <?php language_attributes(); ?> class="no-js">

<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

	<title><?php wp_title(''); ?></title>
  <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
  <?php if (have_posts()): while(have_posts()): the_post();

    // Banner
    $thumbnail_url = get_the_post_thumbnail_url($post->ID);
    if ($thumbnail_url): ?>
      <section class="checkout-banner" style="background: url('<?= $thumbnail_url ?>') center center;">
    <?php else: ?>
      <section class="checkout-banner checkout-empty-banner">
    <?php endif; ?>

        <div class="checkout-banner__inner-container">
          <?php if (function_exists('the_custom_logo')):
            the_custom_logo();
          endif; ?>
        </div>
      </section>

		<?php the_content(); ?>
	<?php endwhile; endif; ?>

  <?php wp_footer(); ?>
</body>

</html>
