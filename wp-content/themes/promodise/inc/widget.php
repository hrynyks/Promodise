<?php
    add_action('widgets_init', my_widget());
    function my_widget() {
        register_sidebar(
            array(
                'name' => 'Виджет вывода текста в правой боковой колонке', // esc_html - функция, которая позволяет подготовить файл для перевода
                'id' => 'text-widget',
                'description' => 'Виджет вывода текста в правой боковой колонке',
                'before_widget' => '<div class="sidebar-widget about-bar  %2$s">', // чтобы не списком шли виджеты, а секциями
                'after_widget' => '</div>',
                'before_title' => '<h5 class="mb-3">',
                'after_title' => '</h5  >',
            )
        );
        register_sidebar(
            array(
                'name' => 'Виджет вывода категорий в правой боковой колонке', // esc_html - функция, которая позволяет подготовить файл для перевода
                'id' => 'categories-widget',
                'description' => 'Виджет вывода категорий в правой боковой колонке',
                'before_widget' => '<div class="sidebar-widget category  %2$s">', // чтобы не списком шли виджеты, а секциями
                'after_widget' => '</div>',
                'before_title' => '<h5 class="mb-3">',
                'after_title' => '</h5  >',
            )
        );
        register_sidebar(
            array(
                'name' => 'Виджет вывода тегов в правой боковой колонке', // esc_html - функция, которая позволяет подготовить файл для перевода
                'id' => 'tags-widget',
                'description' => 'Виджет вывода тегов в правой боковой колонке',
                'before_widget' => '<div class="sidebar-widget tag  %2$s">', // чтобы не списком шли виджеты, а секциями
                'after_widget' => '</div>',
                'before_title' => '<h5 class="mb-3">',
                'after_title' => '</h5  >',
            )
        );
	    register_sidebar(
		    array(
			    'name' => 'Виджет вывода текста', // esc_html - функция, которая позволяет подготовить файл для перевода
			    'id' => 'promodise-text-widget',
			    'description' => 'Виджет вывода текста',
			    'before_widget' => '<div class="sidebar-widget about-bar  %2$s">', // чтобы не списком шли виджеты, а секциями
			    'after_widget' => '</div>',
			    'before_title' => '<h5 class="mb-3">',
			    'after_title' => '</h5  >',
		    )
	    );
	    register_sidebar(
		    array(
			    'name' => 'Виджет загрузки файлов', // esc_html - функция, которая позволяет подготовить файл для перевода
			    'id' => 'download_widget',
			    'description' => 'Виджет загрузки файлов',
			    'before_widget' => '<div class="sidebar-widget about-bar  %2$s">', // чтобы не списком шли виджеты, а секциями
			    'after_widget' => '</div>',
			    'before_title' => '<h5 class="mb-3">',
			    'after_title' => '</h5  >',
		    )
	    );
    }
?>