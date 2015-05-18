<?php
/**
 * @package Isquar
 */
?>

<li>
<?php the_post_thumbnail('isquar-slider-image'); ?>
<div class="flex-caption">
	<h2><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
</div>
</li>