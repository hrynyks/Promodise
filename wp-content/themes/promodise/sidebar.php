<div class="col-lg-4">
    <div class="row">
        <div class="col-lg-12">
            <div class="sidebar-widget search">
            <?php get_search_form()?>
            </div>
        </div>

        <div class="col-lg-12">
            <?php dynamic_sidebar('text-widget')?>
        </div>

        <div class="col-lg-12">
            <?php dynamic_sidebar('categories-widget')?>
        </div>

        <div class="col-lg-12">
            <?php dynamic_sidebar('tags-widget')?>
        </div>
        <div class="col-lg-12">
            <?php dynamic_sidebar('download_widget');?>
<!--            <div class="sidebar-widget download">-->
<!--                <h5 class="mb-4">Полезные файлы</h5>-->
<!--                <a href="#"> <i class="fa fa-file-pdf"></i>Презентация Promodise</a>-->
<!--                <a href="#"> <i class="fa fa-file-pdf"></i>10 источников бесплатного SEO</a>-->
<!--            </div>-->
        </div>

    </div>
</div>