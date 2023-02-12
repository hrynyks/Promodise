
<?php get_header('page')?>
<section class="section blog-wrap ">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <div class="row">
                    <?php if(have_posts()): while ( have_posts() ) : the_post();?>
                    <div class="col-lg-6">
                        <?php echo get_template_part('template-parts/content');?>
                    </div>
                    <?php endwhile; else : ?>
                        <p>Записей нет.</p>
                    <?php endif; ?>

                    <?php
                    global $wp_query;
                    $pageNum = (get_query_var('paged')) ? get_query_var('paged') : 1;
                    $max_pages = $wp_query->max_num_pages;
                    if( $pageNum < $max_pages ):
                    ?>

                        <div class="row my-row">
                            <div id="loadmore"><a data-max_pages="<?= $max_pages ?>" data-paged="<?= $pageNum ?>" href="#">Загрузить еще</a></div>
                        </div>

                    <?php endif;?>



                </div>
            </div>
         <?php get_sidebar()?>
        </div>
    </div>
    </div>
</section>
<?php get_footer()?>


