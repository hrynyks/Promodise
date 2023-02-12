<div class="blog-post">
    <!--    <img src="images/blog/blog-1.jpg" alt="" class="img-fluid">-->
    <?php the_post_thumbnail('medium', ['class'=> 'img-fluid']);?>
    <div class="mt-4 mb-3 d-flex">
        <div class="post-author mr-3">
            <i class="fa fa-user"></i>
            <a href="<?php echo get_author_posts_url(get_the_author_meta('ID'))?>">
                <span class="h6 text-uppercase"><?php the_author()?></span>
            </a>
        </div>
        <div class="post-info">
            <i class="fa fa-calendar-check"></i>
            <span><?php the_time('d F Y')?></span>
        </div>
    </div>
    <a href="<?php the_permalink()?>" class="h4 "><?php the_title()?></a>
    <p class="mt-3"><?php the_excerpt()?></p>
    <a href="<?php the_permalink()?>" class="read-more">Читать статью <i class="fa fa-angle-right"></i></a>
</div>