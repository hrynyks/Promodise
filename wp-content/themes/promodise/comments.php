<div class="comments my-4" id="comments">

	<?php if ( have_comments() ): ?>


        <h3 class="mb-5">Комментарии:</h3>
		<?php the_comments_navigation(); // навигация по комментариям, если их много?>
        <ol class="comment-list p-0">
	        <?php wp_list_comments(
                    [
	                    'walker' => new Promodise_Walker_Comment(), // какой шаблон использовать для комментов
	                    'max_depth' => '2',   // максим. вложенность
	                    'style' => 'ol',  // во что оборачиваем комменты
	                    'callback' => null,  // какая функция будет выводить (отрисовать нам комментарии в начале)
	                    'end-callback' => null,  // в конце
	                    'type' => 'all',
	                    'reply_text' => __('Ответить <i class="fa fa-reply"></i>'),
	                    'page' => '',   // к какой странице комментарий
	                    'per_page' => '10', // 10 комментариев на стр.
	                    'avatar_size' => 80,
	                    'format' => 'html5', // или xhtml, если HTML5 не поддерживается темой
	                    'echo' => true,    // выводить ли список или просто вернуть для разработки
                    ]
            )?>
        </ol>
        <?php if (!comments_open()): ?>
            <p class="no-comments"><?php esc_html_e('Comments are closed.', 'promodise'); ?></p>
        <?php endif;?>
	<?php endif; ?>
</div>

<div class="mt-5 mb-3">
<!--    <h3 class="mt-5 mb-2">Оставьте комментарий</h3>-->
<!--    <p class="mb-4">Ваш E-mail защищен от спама</p>-->
<!--    <form action="#" class="row">-->
<!--        <div class="col-lg-12">-->
<!--            <div class="form-group mb-3">-->
<!--                <textarea cols="30" rows="6" class="form-control" placeholder="Комментарий"></textarea>-->
<!--            </div>-->
<!--        </div>-->
<!--        <div class="col-lg-6">-->
<!--            <div class="form-group mb-3">-->
<!--                <input type="text" class="form-control" placeholder="Имя">-->
<!--            </div>-->
<!--        </div>-->
<!---->
<!--        <div class="col-lg-6">-->
<!--            <div class="form-group mb-4">-->
<!--                <input type="email" class="form-control" placeholder="Email">-->
<!--            </div>-->
<!--        </div>-->
<!---->
<!--        <div class="col-lg-12">-->
<!--            <a href="#" class="btn btn-hero btn-circled">Оставить комментарий</a>-->
<!--        </div>-->
<!--    </form>-->
    <?php
    $defaults = [
    'fields' => [
    'author' => '<div class="row mb-3"><div class="col-lg-6">
            <input class="form-control"  placeholder="Имя" id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30"/>
        </div>',
        'email' => '<div class="col-lg-6">
            <input  placeholder="Email" class="form-control" id="email" name="email" type="email"  value="' . esc_attr($commenter['comment_author_email']) . '" size="30" aria-describedby="email-notes" />
        </div></div>',
    ],
    'comment_field' => '<div class="row mb-3"><div class="col-lg-12">
            <textarea placeholder="Комментарий" class="form-control" id="comment" name="comment" cols="45" rows="8"  aria-required="true" required="required"></textarea>
        </div></div>',
    'must_log_in' => '<p class="must-log-in">' .
        sprintf(esc_html__('Вам нужно <a href="%s">войти,</a>чтобы оставить комментарий.'), wp_login_url(apply_filters('the_permalink', get_permalink($post->ID)))) . '
    </p>',
    'logged_in_as' => '<p class="logged-in-as">' .
        sprintf(__('<a href="%1$s" aria-label="Вы вошли как %2$s.">Вы вошли как %2$s</a>. <a href="%3$s">Выйти?</a>'), get_edit_user_link(), $user_identity, wp_logout_url(apply_filters('the_permalink', get_permalink(($post->ID))))) . '
    </p>',
    'comment_notes_before' => '<p class="comment-notes">
        <span id="email-notes">' . esc_html__('Ваш email защищен от спама.','tangram-booking-system') . '</span>
    </p>',
    'comment_notes_after' => '',
    'id_form' => 'commentform',
    'id_submit' => 'submit',
    'class_form' => 'comment-form',
    'class_submit' => 'btn btn-hero btn-circled',
    'name_submit' => 'submit',
    'title_reply' => __('Оставьте комментарий'),
    'title_reply_to' => __('Ответить %s'),
    'title_reply_before' => '<h3 id="reply-title" class="comment-reply-title">',
        'title_reply_after' => '</h3>',
    'cancel_reply_before' => ' <small>',
        'cancel_reply_after' => '</small>',
    'cancel_reply_link' => __('Отменить отправку'),
    'label_submit' => __('Оставить комментарий'),
    'submit_button' => '<button name="%1$s" type="submit" id="%2$s" class="%3$s" />%4$s</button>',
    'submit_field' => '<p class="form-submit">%1$s %2$s</p>',
    'format' => 'html5',
    ];
    ?>
    <?php comment_form($defaults);?>
</div>