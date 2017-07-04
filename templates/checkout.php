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
  <?php if(have_posts()): while(have_posts() ): the_post(); ?>
		<?php the_content(); ?>
	<?php endwhile; endif; ?>

  <?php wp_footer(); ?>
</body>

</html>
