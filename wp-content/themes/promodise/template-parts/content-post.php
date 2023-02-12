<?php if (array_key_exists('class', $args)) echo "<div class=" . $args['class'] . ">" ?>
    <div class="blog-post">
		<?php
		if (has_post_thumbnail()) {
			the_post_thumbnail('post-thumbnail', ['class' => 'img-fluid']);
		} else {
			echo '<img class="img-fluid" src="' . get_template_directory_uri() . '/images/blog/blog-1.jpg"/>';
		}
		?>
        <div class="mt-4 mb-3 d-flex">
            <div class="post-author mr-3">
                <i class="fa fa-user"></i>
                <a href="<?php echo get_author_posts_url(get_the_author_meta('ID'));?>"
                   class="h6 text-uppercase"><?php the_author(); ?></a>
            </div>
            <div class="post-info">
                <i class="fa fa-calendar-check"></i>
				<?php
				$text = get_the_date('j F Y');
				$url = get_the_date('/Y/m/');
				?>
                <span><?php echo get_archives_link($url, $text, ''); ?></span>
            </div>
        </div>
        <a href="<?php the_permalink(); ?>" class="h4 "><?php the_title(); ?></a>
        <p class="mt-3"><?php the_excerpt(); ?></p>
        <a href="<?php the_permalink(); ?>" class="read-more">Читать статью... <i class="fa fa-angle-right"></i></a>
    </div>
<?php if (array_key_exists('class', $args)) echo '</div>' ?>