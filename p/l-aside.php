<?php
$arg_status = array(
		'orderby' => 'rand',
		'showposts' => 4,
		'post__not_in'   => array(get_the_ID(), get_option('sticky_posts')),
		'tax_query' => array(
							array(
								'taxonomy' => 'post_format',
								'field' => 'slug',
								'terms' => array('post-format-aside'),
											'operator' => 'IN'
										)
							)
	);
query_posts( $arg_status );
?>
<div class="lhn pt40 pb30 bg-w">
	<ul class="inner">
		<h3 class="fwt mb10 c5">写过这些</h3>
		<?php while ( have_posts() ) : the_post(); ?>
			<li class="lsn bts">
				<a class="srl" href="<?php the_permalink() ?>">
					<?php the_title(); ?>
					<div class="c4 r-date"><?php the_time('Y-m-d') ?></div>
				</a>
			</li>
		<?php endwhile; ?>
	</ul>
</div>
<?php wp_reset_query(); ?>
