<?php
/**
 * Plugin Name: Comment Email Reply (Chinese-Simp-CssModified)
 * Plugin URI:  http://github.com/tinycq/comment-email-reply
 * Description:通过邮件的方式，简单地提醒用户其评论已经得到了回复，并且修改了原作的表现样式(邮件提示已经汉化).
 * Version:     1.0.3
 * Author:      Tinycq
 * Author:      http://tinycq.com
 * Reference:   Jan Eichhorn @ http://kilozwo.de SourceCodeVersion:1.0.3 Source Plugin URI:http://kilozwo.de/wordpress-comment-email-reply-plugin
 * License:     GPLv2
 */

load_plugin_textdomain('tcq_plugin', false, basename( dirname( __FILE__ ) ) . '/languages' );

add_action('wp_insert_comment','tcq_comment_inserted',99,2);

function tcq_comment_inserted($comment_id, $comment_object) {
    if ($comment_object->comment_parent > 0) {
        $comment_parent = get_comment($comment_object->comment_parent);

        $mailcontent = __('你好： ','tcq_plugin').' '.$comment_parent->comment_author.',<br>'.$comment_object->comment_author.' '.__(' 您在这篇文章上的评论有了回复：','tcq_plugin').' <a href="'.get_permalink($comment_parent->comment_post_ID).'">'.get_the_title($comment_parent->comment_post_ID).'</a>:<hr><br>回复内容：<br>'.$comment_object->comment_content.'<br><hr><br>'.__('查看或者回复:','tcq_plugin').' <a href="'.get_comment_link( $comment_parent->comment_ID ).'">'.get_comment_link( $comment_parent->comment_ID ).'</a>';

        $headers  = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";

        wp_mail($comment_parent->comment_author_email,'['.get_option('blogname').'] '.__('您的评论有了新的回复：','tcq_plugin'),$mailcontent,$headers);
    }
}

?>