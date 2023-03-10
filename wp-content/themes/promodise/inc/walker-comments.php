<?php
class Promodise_Walker_Comment extends Walker {

    /**
     * What the class handles.
     *
     * @since 2.7.0
     * @var string
     *
     * @see Walker::$tree_type
     */
    public $tree_type = 'comment'; // что мы берем в качестве исходных данных Walker - берем комментарии

    /**
     * Database fields to use.
     *
     * @since 2.7.0
     * @var array
     *
     * @see Walker::$db_fields
     * @todo Decouple this
     */
    public $db_fields = array( // обращение к БД
        'parent' => 'comment_parent',
        'id'     => 'comment_ID',
    );

    /**
     * Starts the list before the elements are added.
     *
     * @since 2.7.0
     *
     * @see Walker::start_lvl()
     * @global int $comment_depth
     *
     * @param string $output Used to append additional content (passed by reference).
     * @param int    $depth  Optional. Depth of the current comment. Default 0.
     * @param array  $args   Optional. Uses 'style' argument for type of HTML list. Default empty array.
     */
    public function start_lvl( &$output, $depth = 0, $args = array() ) { // то, во что мы оборачиваем элементы внутри наших списков комментариев
        $GLOBALS['comment_depth'] = $depth + 1;

        switch ( $args['style'] ) { // это то, что мы указали в: 'style' => 'ol', в функции wp_list_comments()
            case 'div':
                break;
            case 'ol':
                $output .= '<ol class="children">' . "\n"; // для дочерних комментариев
                break;
            case 'ul':
            default:
                $output .= '<ul class="children">' . "\n";
                break;
        }
    }

    /**
     * Ends the list of items after the elements are added.
     *
     * @since 2.7.0
     *
     * @see Walker::end_lvl()
     * @global int $comment_depth
     *
     * @param string $output Used to append additional content (passed by reference).
     * @param int    $depth  Optional. Depth of the current comment. Default 0.
     * @param array  $args   Optional. Will only append content if style argument value is 'ol' or 'ul'.
     *                       Default empty array.
     */
    public function end_lvl( &$output, $depth = 0, $args = array() ) { // здесь мы закрываем теги из функции start_lvl
        $GLOBALS['comment_depth'] = $depth + 1;

        switch ( $args['style'] ) {
            case 'div':
                break;
            case 'ol':
                $output .= "</ol><!-- .children -->\n";
                break;
            case 'ul':
            default:
                $output .= "</ul><!-- .children -->\n";
                break;
        }
    }

    /**
     * Traverses elements to create list from elements.
     *
     * This function is designed to enhance Walker::display_element() to
     * display children of higher nesting levels than selected inline on
     * the highest depth level displayed. This prevents them being orphaned
     * at the end of the comment list.
     *
     * Example: max_depth = 2, with 5 levels of nested content.
     *     1
     *      1.1
     *        1.1.1
     *        1.1.1.1
     *        1.1.1.1.1
     *        1.1.2
     *        1.1.2.1
     *     2
     *      2.2
     *
     * @since 2.7.0
     *
     * @see Walker::display_element()
     * @see wp_list_comments()
     *
     * @param WP_Comment $element           Comment data object.
     * @param array      $children_elements List of elements to continue traversing. Passed by reference.
     * @param int        $max_depth         Max depth to traverse.
     * @param int        $depth             Depth of the current element.
     * @param array      $args              An array of arguments.
     * @param string     $output            Used to append additional content. Passed by reference.
     */
    public function display_element( $element, &$children_elements, $max_depth, $depth, $args, &$output ) {
        if ( ! $element ) {
            return;
        }

        $id_field = $this->db_fields['id'];
        $id       = $element->$id_field;

        parent::display_element( $element, $children_elements, $max_depth, $depth, $args, $output );

        /*
         * If at the max depth, and the current element still has children, loop over those
         * and display them at this level. This is to prevent them being orphaned to the end
         * of the list.
         */
        if ( $max_depth <= $depth + 1 && isset( $children_elements[ $id ] ) ) {
            foreach ( $children_elements[ $id ] as $child ) {
                $this->display_element( $child, $children_elements, $max_depth, $depth, $args, $output );
            }

            unset( $children_elements[ $id ] );
        }

    }

    /**
     * Starts the element output.
     *
     * @since 2.7.0
     *
     * @see Walker::start_el()
     * @see wp_list_comments()
     * @global int        $comment_depth
     * @global WP_Comment $comment       Global comment object.
     *
     * @param string     $output  Used to append additional content. Passed by reference.
     * @param WP_Comment $comment Comment data object.
     * @param int        $depth   Optional. Depth of the current comment in reference to parents. Default 0.
     * @param array      $args    Optional. An array of arguments. Default empty array.
     * @param int        $id      Optional. ID of the current comment. Default 0 (unused).
     */
    public function start_el( &$output, $comment, $depth = 0, $args = array(), $id = 0 ) {
        $depth++;
        $GLOBALS['comment_depth'] = $depth;
        $GLOBALS['comment']       = $comment;

        if ( ! empty( $args['callback'] ) ) {
            ob_start();
            call_user_func( $args['callback'], $comment, $args, $depth );
            $output .= ob_get_clean();
            return;
        }

        if ( 'comment' === $comment->comment_type ) {
            add_filter( 'comment_text', array( $this, 'filter_comment_text' ), 40, 2 ); // функция, которая очищает комментарии от ссылок и всего прочего
        }

        // в зависимости от разных комментариев - мы будем запускать разные функции
        if ( ( 'pingback' === $comment->comment_type || 'trackback' === $comment->comment_type ) && $args['short_ping'] ) {
            ob_start();
            $this->ping( $comment, $depth, $args );
            $output .= ob_get_clean();
        } elseif ( 'html5' === $args['format'] ) {
            ob_start();
            $this->html5_comment( $comment, $depth, $args );
            $output .= ob_get_clean();
        } else {
            ob_start();
            $this->comment( $comment, $depth, $args );
            $output .= ob_get_clean();
        }

        if ( 'comment' === $comment->comment_type ) {
            remove_filter( 'comment_text', array( $this, 'filter_comment_text' ), 40 );
        }
    }

    /**
     * Ends the element output, if needed.
     *
     * @since 2.7.0
     *
     * @see Walker::end_el()
     * @see wp_list_comments()
     *
     * @param string     $output  Used to append additional content. Passed by reference.
     * @param WP_Comment $comment The current comment object. Default current comment.
     * @param int        $depth   Optional. Depth of the current comment. Default 0.
     * @param array      $args    Optional. An array of arguments. Default empty array.
     */
    public function end_el( &$output, $comment, $depth = 0, $args = array() ) {
        if ( ! empty( $args['end-callback'] ) ) {
            ob_start();
            call_user_func( $args['end-callback'], $comment, $args, $depth );
            $output .= ob_get_clean();
            return;
        }
        if ( 'div' === $args['style'] ) {
            $output .= "</div><!-- #comment-## -->\n";
        } else {
            $output .= "</li><!-- #comment-## -->\n";
        }
    }

    /**
     * Outputs a pingback comment.
     *
     * @since 3.6.0
     *
     * @see wp_list_comments()
     *
     * @param WP_Comment $comment The comment object.
     * @param int        $depth   Depth of the current comment.
     * @param array      $args    An array of arguments.
     */
    protected function ping( $comment, $depth, $args ) {
        $tag = ( 'div' === $args['style'] ) ? 'div' : 'li';
        ?>
        <<?php echo $tag; ?> id="comment-<?php comment_ID(); ?>" <?php comment_class( '', $comment ); ?>>
        <div class="comment-body">
            <?php _e( 'Pingback:' ); ?> <?php comment_author_link( $comment ); ?> <?php edit_comment_link( __( 'Edit' ), '<span class="edit-link">', '</span>' ); ?>
        </div>
        <?php
    }

    /**
     * Filters the comment text.
     *
     * Removes links from the pending comment's text if the commenter did not consent
     * to the comment cookies.
     *
     * @since 5.4.2
     *
     * @param string          $comment_text Text of the current comment.
     * @param WP_Comment|null $comment      The comment object. Null if not found.
     * @return string Filtered text of the current comment.
     */
    public function filter_comment_text( $comment_text, $comment ) {
        $commenter          = wp_get_current_commenter();
        $show_pending_links = ! empty( $commenter['comment_author'] );

        if ( $comment && '0' == $comment->comment_approved && ! $show_pending_links ) {
            $comment_text = wp_kses( $comment_text, array() );
        }

        return $comment_text;
    }

    /** Вывод одного комментария
     * Outputs a single comment.
     *
     * @since 3.6.0
     *
     * @see wp_list_comments()
     *
     * @param WP_Comment $comment Comment to display.
     * @param int        $depth   Depth of the current comment.
     * @param array      $args    An array of arguments.
     */
    protected function comment( $comment, $depth, $args ) {
        if ( 'div' === $args['style'] ) {
            $tag       = 'div';
            $add_below = 'comment';
        } else {
            $tag       = 'li';
            $add_below = 'div-comment';
        }

        $commenter          = wp_get_current_commenter();
        $show_pending_links = isset( $commenter['comment_author'] ) && $commenter['comment_author'];

        if ( $commenter['comment_author_email'] ) {
            $moderation_note = __( 'Your comment is awaiting moderation.' );
        } else {
            $moderation_note = __( 'Your comment is awaiting moderation. This is a preview; your comment will be visible after it has been approved.' );
        }
        ?>
        <<?php echo $tag; ?> <?php comment_class( $this->has_children ? 'parent' : '', $comment ); ?> id="comment-<?php comment_ID(); ?>">
        <?php if ( 'div' !== $args['style'] ) : ?>
            <div id="div-comment-<?php comment_ID(); ?>" class="comment-body">
        <?php endif; ?>
        <div class="comment-author vcard">
            <?php
            if ( 0 != $args['avatar_size'] ) {
                echo get_avatar( $comment, $args['avatar_size'] );
            }
            ?>
            <?php
            $comment_author = get_comment_author_link( $comment );

            if ( '0' == $comment->comment_approved && ! $show_pending_links ) {
                $comment_author = get_comment_author( $comment );
            }

            printf(
            /* translators: %s: Comment author link. */
                __( '%s <span class="says">says:</span>' ),
                sprintf( '<cite class="fn">%s</cite>', $comment_author )
            );
            ?>
        </div>
        <?php if ( '0' == $comment->comment_approved ) : ?>
            <em class="comment-awaiting-moderation"><?php echo $moderation_note; ?></em>
            <br />
        <?php endif; ?>

        <div class="comment-meta commentmetadata">
            <?php
            printf(
                '<a href="%s">%s</a>',
                esc_url( get_comment_link( $comment, $args ) ),
                sprintf(
                /* translators: 1: Comment date, 2: Comment time. */
                    __( '%1$s at %2$s' ),
                    get_comment_date( '', $comment ),
                    get_comment_time()
                )
            );

            edit_comment_link( __( '(Edit)' ), ' &nbsp;&nbsp;', '' );
            ?>
        </div>

        <?php
        comment_text(
            $comment,
            array_merge(
                $args,
                array(
                    'add_below' => $add_below,
                    'depth'     => $depth,
                    'max_depth' => $args['max_depth'],
                )
            )
        );
        ?>

        <?php
        comment_reply_link(
            array_merge(
                $args,
                array(
                    'add_below' => $add_below,
                    'depth'     => $depth,
                    'max_depth' => $args['max_depth'],
                    'before'    => '<div class="reply">',
                    'after'     => '</div>',
                )
            )
        );
        ?>

        <?php if ( 'div' !== $args['style'] ) : ?>
            </div>
        <?php endif; ?>
        <?php
    }

    /** Вывод комментариев в HTML5 формате
     * Outputs a comment in the HTML5 format.
     *
     * @since 3.6.0
     *
     * @see wp_list_comments()
     *
     * @param WP_Comment $comment Comment to display.
     * @param int        $depth   Depth of the current comment.
     * @param array      $args    An array of arguments.
     */
    protected function html5_comment( $comment, $depth, $args ) {
        $tag = ( 'div' === $args['style'] ) ? 'div' : 'li'; // если будут выбран div, то дочерние элементы будут иметь div

        $commenter          = wp_get_current_commenter();
        $show_pending_links = ! empty( $commenter['comment_author'] );

        if ( $commenter['comment_author_email'] ) {
            $moderation_note = __( 'Ваш комментарий ждет модерации.' );
        } else {
            $moderation_note = __( 'Ваш комментарий ждет модерации. Это превью. Ваш комментарий будет опубликован после проверки' );
        }
        ?>
        <<?php echo $tag; ?> id="comment-<?php comment_ID(); ?>" <?php comment_class( $this->has_children ? 'parent' : '', $comment ); ?>><!--если комментарий имеет дочерние элементы, то ему вешается класс parent, иначе никакой доп. класс не вешается
        -->
        <article id="div-comment-<?php comment_ID(); ?>" class="comment-body media mb-4">
            <?php
            if ( 0 != $args['avatar_size'] ) {
                echo get_avatar( $comment, $args['avatar_size'], 'mystery', '', ['class'=>'img-fluid d-flex mr-4 rounded']); // mystery - какая картинка по умолчанию будет для пользователей, которые прописали комментарий 'mm' или 'mysterman' - неизвестный человек
                                                                                              // alt - оставим пустым
            }
            ?>
            <footer> <!--так как у нас htm5 -разметка, то оставим footer-->
<!--                <div class="comment-author vcard">-->
<!--                   --><?php
//                    if ( 0 != $args['avatar_size'] ) {
//                        echo get_avatar( $comment, $args['avatar_size'] );
//                    }
//                    ?>
                    <?php
                    $comment_author = get_comment_author_link( $comment ); // ссылка на атора

                    if ( '0' == $comment->comment_approved && ! $show_pending_links ) {
                        $comment_author = get_comment_author( $comment ); // если коммент есть и он подтвержден, то добавляем ссылку на сам комментарий автора
                    }
//
//                    printf(
//                    /* translators: %s: Comment author link. */
//                        __( '%s <span class="says">says:</span>' ),
//                        sprintf( '<b class="fn">%s</b>', $comment_author )
//                    );

                    printf(
                        __( '%s' ), sprintf( '<h5>%s</h5>', $comment_author )
                    );


                    ?>
<!--                </div>-->  <!-- .comment-author -->

                <div class="comment-metadata">
                    <?php
                    printf(
                        '<a class="text-muted" href="%s"><time datetime="%s">%s</time></a>',  // здесь берем ссылку на время
                        esc_url( get_comment_link( $comment, $args ) ),
                        get_comment_time( 'c' ),
                        sprintf(
                        /* translators: 1: Comment date, 2: Comment time. */
                            __( '%1$s at %2$s' ),
                            get_comment_date( 'j F Y', $comment ), // указываем нужный формат даты
                            get_comment_time()
                        )
                    );

                    edit_comment_link( __( 'Edit' ), ' <span class="edit-link">', '</span>' );
                    ?>
                </div><!-- .comment-metadata -->

                <?php if ( '0' == $comment->comment_approved ) : ?>
                    <em class="comment-awaiting-moderation"><?php echo $moderation_note; ?></em>
                <?php endif; ?>

                <div class="mt-2">
                    <?php comment_text(); ?>
                </div><!-- .comment-content -->

                <?php
                if ( '1' == $comment->comment_approved || $show_pending_links ) {  // если комментарий готов, то выводм кнопку: <div class="reply">
                    comment_reply_link(
                        array_merge(
                            $args,
                            array(
                                'add_below' => 'div-comment',
                                'depth'     => $depth,
                                'max_depth' => $args['max_depth'],
                                'before'    => '<div class="reply">',
                                'after'     => '</div>',
                            )
                        )
                    );
                }
                ?>

            </footer><!-- .comment-meta -->

<!--            <div class="comment-content">-->
<!--                --><?php //comment_text(); ?>
<!--            </div>-->

<!--            --><?php
//            if ( '1' == $comment->comment_approved || $show_pending_links ) {
//                comment_reply_link(
//                    array_merge(
//                        $args,
//                        array(
//                            'add_below' => 'div-comment',
//                            'depth'     => $depth,
//                            'max_depth' => $args['max_depth'],
//                            'before'    => '<div class="reply">',
//                            'after'     => '</div>',
//                        )
//                    )
//                );
//            }
//            ?>
        </article><!-- .comment-body -->
        <?php
    }
}