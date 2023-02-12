<?php

/**
 * Добавление нового виджета Download_Widget.
 */
class Download_Widget extends WP_Widget
{

    // Регистрация виджета используя основной класс
    function __construct()
    {
        // вызов конструктора выглядит так:
        // __construct( $id_base, $name, $widget_options = array(), $control_options = array() )
        parent::__construct(
            'Download_Widget', // ID виджета, если не указать (оставить ''), то ID будет равен названию класса в нижнем регистре: Download_Widget
            'Полезные файлы',
            array('description' => 'Прикрепите ссылки на полезные файлы', 'classname' => 'download')
        );

        // скрипты/стили виджета, только если он активен
        if (is_active_widget(false, false, $this->id_base) || is_customize_preview()) {
            add_action('wp_enqueue_scripts', array($this, 'add_download_scripts'));
            add_action('wp_head', array($this, 'add_download_style'));
        }
    }

    /**
     * Вывод виджета во Фронт-энде
     *
     * @param array $args аргументы виджета.
     * @param array $instance сохраненные данные из настроек
     */
    function widget($args, $instance)
    {
        $title = apply_filters('widget_title', $instance['title']);
        $file = $instance['file'];
        $file_name = $instance['file_name'];
        $file_1 = $instance['file_1'];
        $file_name_1 = $instance['file_name_1'];

        echo $args['before_widget']; // выводим что-то перед виджетом
        if (!empty($title)) { // если тайтл не пустой, то выводим, то, что стоит перед тайтлом
            echo $args['before_title'] . $title . $args['after_title']; // сам  $title и после тайтла:  $args['after_title']
        }
        echo '<a target="__blank" href="' . $file . '"><i class="fa fa-file-pdf"></i>' . $file_name . '</a>
              <a target="__blank" href="' . $file_1 . '"><i class="fa fa-file-pdf"></i>' . $file_name_1 . '</a>';
        echo $args['after_widget'];
    }

    // аргументы before_widget, before_title, after_title - берутся из функции the_widget

    /**
     * Админ-часть виджета
     *
     * @param array $instance сохраненные данные из настроек
     */
    function form($instance)
    {
        $title = $instance['title'] ?: 'Полезные файлы';
        $file_name = $instance['file_name'] ?: 'Название файла';
        $file_name_1 = $instance['file_name_1'] ?: 'Название файла';
        $file = $instance['file'] ?: 'URL файла';
        $file_1 = $instance['file'] ?: 'URL файла';
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>"
                   name="<?php echo $this->get_field_name('title'); ?>" type="text"
                   value="<?php echo esc_attr($title); ?>">
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('file_name'); ?>"><?php _e('Название файла:'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('file_name'); ?>"
                   name="<?php echo $this->get_field_name('file_name'); ?>" type="text"
                   value="<?php echo esc_attr($file_name); ?>">
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('file'); ?>"><?php _e('Ссфлка на файл:'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('file'); ?>"
                   name="<?php echo $this->get_field_name('file'); ?>" type="text"
                   value="<?php echo esc_attr($file); ?>">
        </p>

        <p>
            <label for="<?php echo $this->get_field_id('file_name_1'); ?>"><?php _e('Название файла:'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('file_name_1'); ?>"
                   name="<?php echo $this->get_field_name('file_name_1'); ?>" type="text"
                   value="<?php echo esc_attr($file_name_1); ?>">
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('file_1'); ?>"><?php _e('Ссфлка на файл:'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('file_1'); ?>"
                   name="<?php echo $this->get_field_name('file_1'); ?>" type="text"
                   value="<?php echo esc_attr($file_1); ?>">
        </p>

        <?php
    }

    /**
     * Сохранение настроек виджета. Здесь данные должны быть очищены и возвращены для сохранения их в базу данных.
     *
     * @param array $new_instance новые настройки
     * @param array $old_instance предыдущие настройки
     *
     * @return array данные которые будут сохранены
     * @see WP_Widget::update()
     *
     */
    function update($new_instance, $old_instance)
    { // новое значение $new_instance - будет заменять старое: $old_instance
        $instance = array();
        $instance['title'] = (!empty($new_instance['title'])) ? strip_tags($new_instance['title']) : ''; // если поле не пустое: ! empty( $new_instance['title'] ), то наш инстанс strip_tags( $new_instance['title'] ) - заменяет старый
        $instance['file'] = (!empty($new_instance['file'])) ? strip_tags($new_instance['file']) : ''; // если поле не пустое: ! empty( $new_instance['title'] ), то наш инстанс strip_tags( $new_instance['title'] ) - заменяет старый
        $instance['file_1'] = (!empty($new_instance['file_1'])) ? strip_tags($new_instance['file_1']) : ''; // если поле не пустое: ! empty( $new_instance['title'] ), то наш инстанс strip_tags( $new_instance['title'] ) - заменяет старый
        $instance['file_name'] = (!empty($new_instance['file_name'])) ? strip_tags($new_instance['file_name']) : '';
        $instance['file_name_1'] = (!empty($new_instance['file_name_1'])) ? strip_tags($new_instance['file_name_1']) : '';

        return $instance;
    }

    // скрипт виджета
    function add_download_scripts()
    {
        // фильтр чтобы можно было отключить скрипты
        if (!apply_filters('show_download_script', true, $this->id_base))
            return;

        $theme_url = get_stylesheet_directory_uri();

        // wp_enqueue_script('download_script', $theme_url .'/js/download_script.js' );
    }

    // стили виджета
    function add_download_style()
    {
        // фильтр чтобы можно было отключить стили
        if (!apply_filters('show_download_style', true, $this->id_base))
            return;
        ?>
        <style type="text/css">
            .download a {
                display: block;
            }
        </style>
        <?php
    }

}

// конец класса Download_Widget

