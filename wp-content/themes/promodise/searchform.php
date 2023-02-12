<form class="form-group" action="<?php echo home_url('/')?>" method="get">
    <input type="text" id="s" name="s" placeholder="поиск" class="form-control" value="<?php echo get_search_query(); ?>">
        <i class="fa fa-search"></i>
</form>