<?php get_header()?>

<div class="page-banner-area page-contact" id="page-banner">
    <div class="overlay dark-overlay"></div>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 m-auto text-center col-sm-12 col-md-12">
                <div class="banner-content content-padding">
                    <h1 class="text-white">
                        <?php
                        if(is_category()) {
                            echo get_queried_object()->name;
                        }

                        if (is_tag()) {  echo get_queried_object()->name; }
                        ?>

                    </h1>
                    <p>
                        <?php
                        if(is_category()) {
                            echo get_queried_object()->description;
                        }

                        if (is_tag()) {  echo get_queried_object()->description; }
                        ?>
                    </p>
                    <p>

                        <?php
                        if(is_author()) {
                            echo get_the_author_meta('display_name');
                        }
                        ?>

                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

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
                </div>
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
            <?php get_sidebar()?>
        </div>
    </div>
    </div>
</section>

<?php get_footer()?>
