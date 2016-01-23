<?php
/**
 * The template for displaying all single posts and attachments
 *
 * @package WordPress
 * @subpackage Twenty_Fifteen
 * @since Twenty Fifteen 1.0
 */

get_header(); ?>


<div id="primary" class="content-area">
	<div id="content" class="content" role="main">
		<?php while ( have_posts() ) : the_post(); ?>
			<div class="row">
				<div class="medium-9 columns">
					<div class="row">
						<div class="medium-4 columns">
							<?php
							$gallery = get_field('slider');
							if( $gallery ):
								?>
								<div class="slick">
									<?php foreach( $gallery as $image ): ?>
										<div>
											<img src="<?php echo $image['sizes']['large']; ?>" alt="<?php echo $image['alt']; ?>" />
										</div>
									<?php endforeach; ?>
								</div>
							<?php endif; ?>

							<h4>Ingredients</h4>
							<?php
							if( have_rows('ingredients') ):
								$i = 0;
								while ( have_rows('ingredients') ) : the_row();
									$i++;
									?>
									<div class="row">
										<div class="small-3 columns">
											<div class="switch tiny">
												<input class="switch-input" id="ingredient-<?php echo $i; ?>" type="checkbox" name="ingredient-<?php echo $id; ?>">
												<label class="switch-paddle" for="ingredient-<?php echo $i; ?>">
													<span class="show-for-sr">Download Kittens</span>
												</label>
											</div>
										</div>
										<div class="small-9 columns">
											<p class="switch-text"><?php the_sub_field('ingredient'); ?></p>
										</div>
									</div>
									<?php
								endwhile;
							endif;
							?>
						</div>
						<div class="medium-8 columns">
							<h1><?php the_title(); ?></h1>
							<div id="share">
								<span class='st_pinterest_large' displayText='Pinterest'></span>
								<span class='st_facebook_large' displayText='Facebook'></span>
								<span class='st_stumbleupon_large' displayText='StumbleUpon'></span>
								<span class='st_twitter_large' displayText='Tweet'></span>
								<span class='st_googleplus_large' displayText='Google +'></span>
								<span class='st_print_large' displayText='Print'></span>
								<span class='st_email_large' displayText='Email'></span>
							</div>
							<?php the_field('teaser_description'); ?>
							<div id="directions">
								<h4>Directions</h4>
								<?php
								if( have_rows('directions') ):
								$i = 0;
								while ( have_rows('directions') ) : the_row();
								$i++;
								?>
									<div class="direction"><?php the_sub_field('direction'); ?></div>
								<?php
								endwhile;
								endif;
								?>
							</div>
						</div>
					</div>
				</div>
				<div class="medium-3 columns">
					<div id="side">
						<div id="author">
							<?php echo get_avatar( get_the_author_meta( 'ID' ), 60 ); ?>
							<h4 class="text-right">By <?php the_author_meta( 'first_name'); ?> <?php the_author_meta( 'last_name'); ?></h4>
							</div>
						<table id="details">
							<tr>
								<th>Servings</th>
								<td><?php the_field('servings') ?></td>
							</tr>
							<tr>
								<th>Preparation</th>
								<td><?php the_field('preperation_time') ?></td>
							</tr>
							<tr>
								<th>Cook</th>
								<td><?php the_field('cook_time') ?></td>
							</tr>
							<tr>
								<th>Ready in</th>
								<td><?php the_field('ready_in') ?></td>
							</tr>
							<tr>
								<th>Difficulty</th>
								<td>
									<?php
										$difficulty = wp_get_post_terms(get_the_ID(), 'difficulty', array("fields" => "all"))[0]->name;
										$link = get_term_link( $difficulty, 'difficulty' );
									?>
									<a href="<?php echo $link; ?>"><?php echo $difficulty; ?></a>
								</td>
							</tr>
							<tr>
								<th>Category</th>
								<td>
									<?php
									$difficulty = wp_get_post_terms(get_the_ID(), 'food_category', array("fields" => "all"))[0]->name;
									$link = get_term_link( $difficulty, 'food_category' );
									?>
									<a href="<?php echo $link; ?>"><?php echo $difficulty; ?></a>
								</td>
							</tr>
						</table>
						<aside id="custom">
							<h4>Splace for Manual HTML</h4>
							<p>
								Lorem ipsum dolor sit amet, consectetur adipiscing elit.
								Integer imperdiet, augue eu elementum faucibus,
								felis ante posuere lacus, blandit viverra turpis mi dapibus mi.
								Nullam pharetra id dui nec.
							</p>
							<p>
								Lorem ipsum dolor sit amet, consectetur adipiscing elit.
								Integer imperdiet, augue eu elementum faucibus,
								felis ante posuere lacus, blandit viverra turpis mi dapibus mi.
								Nullam pharetra id dui nec.
							</p>
							<p>
								Lorem ipsum dolor sit amet, consectetur adipiscing elit.
								Integer imperdiet, augue eu elementum faucibus,
								felis ante posuere lacus, blandit viverra turpis mi dapibus mi.
								Nullam pharetra id dui nec.
							</p>
							<p>
								Lorem ipsum dolor sit amet, consectetur adipiscing elit.
								Integer imperdiet, augue eu elementum faucibus,
								felis ante posuere lacus, blandit viverra turpis mi dapibus mi.
								Nullam pharetra id dui nec.
							</p>
							<p>
								Lorem ipsum dolor sit amet, consectetur adipiscing elit.
								Integer imperdiet, augue eu elementum faucibus,
								felis ante posuere lacus, blandit viverra turpis mi dapibus mi.
								Nullam pharetra id dui nec.
							</p>
						</aside>
					</div>
				</div>
			</div>
		<?php endwhile;	?>
	</div>
</div>

<script type="text/javascript">var switchTo5x=true;</script>
<script type="text/javascript" src="http://w.sharethis.com/button/buttons.js"></script>
<script type="text/javascript">stLight.options({publisher: "31abfba6-0978-4139-8479-d6e96f61d25f", doNotHash: false, doNotCopy: false, hashAddressBar: false});</script>

<?php get_footer(); ?>
