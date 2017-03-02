<?php
if (have_posts()) {
	while (have_posts()) {
		the_post(); ?>
<div id="primary" class="content-area">
	<div id="content" class="content" role="main">
		<div class="row column">
			<h1 class="text-center"><?php the_title(); ?></h1>
		</div>
		<div class="row">
			<div class="small-12  columns">
				<div class="row column">
					<?php the_content(); ?>
				</div>
			</div>
		</div>
	</div>
</div>
<?php
	}
}
?>