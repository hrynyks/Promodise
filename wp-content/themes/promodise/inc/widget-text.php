<?php
class Promodise_Widget_Text extends WP_Widget{
	public function __construct(){
		parent::__construct('promodise_widget_text', 'Promodise - Текстовый виджет',[
			'name'=>'Promodise - Текстовый виджет',
			'description'=>'Выводит простой текст без верстки',
		]);
	}
	public function form($instance){
		?>

        <p>
            <label for="<?php echo $this->get_field_id('text');?>">Введите текст</label>
            <input
                    type="text"
                    class="widefat"
                    name="<?php echo $this->get_field_name('text')?>>"
                    value="<?php echo $instance['text'];?>"
                    id="<?php echo $this->get_field_id('text');?>"
            >
        </p>

		<?php
	}

	public  function  widget($args, $instance){
		echo $instance['text'];
	}

	public  function  update($new_instance, $old_instance){
		return $new_instance;
	}
}

?>