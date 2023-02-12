<?php get_header('page') ?>
<section class="section blog-wrap ">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <div class="row">
                    <?php if (have_posts()): while (have_posts()) : the_post(); ?>
                        <div class="col-lg-12">
                            <?php echo get_template_part( 'template-parts/content', get_post_type() ); ?>
                            <?php if ( comments_open() || get_comments_number() ) :
	                            comments_template(); // если нет шаблона comments.php, то выведится базовый шаблон wordpressa comments.php
                            endif;
                            ?>
                        </div>
                    <?php endwhile; else : ?>
                        <p>Записей нет.</p>
                    <?php endif; ?>
                </div>
            </div>
            <?php get_sidebar() ?>
        </div>
    </div>
</section>
<?php get_footer() ?>


