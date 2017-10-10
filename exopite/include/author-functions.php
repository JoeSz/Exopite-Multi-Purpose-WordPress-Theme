<?php
/*
 * Custom template tags for this theme.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Exopite
 *
 *  - exopite_add_to_author_profile (pluggable)
 *  - exopite_display_author_bio (pluggable)
 *  - exopite_show_extra_profile_fields (pluggable)
 *  - exopite_save_extra_profile_fields (pluggable)
 *  - exopite_display_author_bio (pluggable)
 *  - exopite_get_author_avatar (pluggable)
 *  - exopite_author_meta (pluggable)
 */
// Exit if accessed directly
defined('ABSPATH') or die( 'You cannot access this page directly.' );

/**
 * Add extra contact methodes for authors
 */
add_filter( 'user_contactmethods', 'exopite_add_to_author_profile', 10, 1);
if ( ! function_exists( 'exopite_add_to_author_profile' ) ) {
    function exopite_add_to_author_profile( $contactmethods ) {
        $contactmethods = array();
        $contactmethods['facebook'] = esc_html__( 'Facebook', 'exopite' );
        $contactmethods['twitter'] = esc_html__( 'Twitter', 'exopite' );
        $contactmethods['linkedin'] = esc_html__( 'Linkedin', 'exopite' );
        $contactmethods['googleplus'] = esc_html__( 'Google+', 'exopite' );
        $contactmethods['github'] = esc_html__( 'GitHub', 'exopite' );
        $contactmethods['skype']   = esc_html__( 'Skype Username', 'exopite' );
        $contactmethods['xing']   = esc_html__( 'Xing', 'exopite' );
        $contactmethods['youtube']   = esc_html__( 'Youtube', 'exopite' );
        $contactmethods['rss_url'] = esc_html__( 'RSS URL', 'exopite' );
        return $contactmethods;
    }
}

/**
 * Adds additional user fields
 * more info: http://justintadlock.com/archives/2009/09/10/adding-and-using-custom-user-profile-fields
 *
 * Skills
 * User profile image
 *
 * In above code, we are using show_user_profile,
 * edit_user_profile and user_new_form hooks to add upload button,
 * so that button will be visible to existing user’s profile page as well as when creating new users.
 * @link http://sharethingz.com/wordpress/custom-user-avatar-in-wordpress/
 */
add_action( 'show_user_profile', 'exopite_show_extra_profile_fields' );
add_action( 'edit_user_profile', 'exopite_show_extra_profile_fields' );
add_action( 'user_new_form', 'exopite_show_extra_profile_fields' );
if ( ! function_exists( 'exopite_show_extra_profile_fields' ) ) {
    function exopite_show_extra_profile_fields( $user ) {
        $profile_pic = ( $user !== 'add-new-user' ) ? get_user_meta( $user->ID, 'exopite-user-avatar', true ) : false;

        if( ! empty( $profile_pic ) ){
            $image = wp_get_attachment_image_src( $profile_pic, 'thumbnail' );

        }

        $display = ( empty( $profile_pic ) ) ? 'display:none;' : '';

        ?>
        <h3>Extra profile information</h3>
        <table class="form-table">
            <tr>
                <th><label for="skills">Skills</label></th>
                <td>
                    <input type="text" name="skills" id="skills" value="<?php echo esc_attr( get_the_author_meta( 'skills', $user->ID ) ); ?>" class="regular-text" /><br />
                    <p class="description"><?php esc_html_e( 'Please enter your skills, separated by comma. (e.g.: "C#, PHP")', 'exopite' ); ?></p>
                </td>
            </tr>
        </table>
        <table class="form-table exopite-profile-upload-options">
            <tr>
                <th>
                    <label for="image"><?php esc_attr_e( 'Main Profile Image', 'exopite' ) ?></label>
                </th>

                <td>
                    <input type="hidden" class="regular-text" name="exopite-user-avatar_image_id" id="exopite-user-avatar_image_id" value="<?php echo ! empty( $profile_pic ) ? $profile_pic : ''; ?>" />
                    <input type="button" data-id="exopite-user-avatar_image_id" data-src="exopite-user-avatar-img" class="button exopite-user-avatar-image" name="exopite-user-avatar_image" id="exopite-user-avatar-image" value="Upload" />
                    <img id="exopite-user-avatar-img" src="<?php echo ! empty( $profile_pic ) ? $image[0] : ''; ?>" style="<?php echo $display; ?>max-width: 100px; max-height: 100px;" />
                    <span class="delete-avatar-image" style="<?php echo $display; ?>"><i class="fa fa-times" aria-hidden="true"></i></span>
                    <p class="description"><?php esc_html_e( 'If set, will override gravatar.', 'exopite' ); ?></p>
                </td>
            </tr>
        </table>
    <?php
    }
}

/**
 * Saves additional user fields to the database
 */
add_action( 'personal_options_update', 'exopite_save_extra_profile_fields' );
add_action( 'edit_user_profile_update', 'exopite_save_extra_profile_fields' );
if ( ! function_exists( 'exopite_save_extra_profile_fields' ) ) {
    function exopite_save_extra_profile_fields( $user_id ) {

        if ( ! current_user_can( 'edit_user', $user_id ) )
            return false;

        update_usermeta( $user_id, 'skills', esc_attr( $_POST['skills'] ) );

        /*
         * update_usermeta() and update_user_meta() behave differently
         * https://core.trac.wordpress.org/ticket/13088
         */
        $profile_pic = empty($_POST['exopite-user-avatar_image_id']) ? '' : $_POST['exopite-user-avatar_image_id'];
        update_user_meta( $user_id, 'exopite-user-avatar', $profile_pic );

    }
}

/**
 * Generate and hook author bio
 */
add_action( 'exopite_hooks_post_footer', 'exopite_display_author_bio', 20 );
if ( ! function_exists( 'exopite_display_author_bio' ) ) {
    function exopite_display_author_bio() {
        //$exopite_settings['exopite-single-display-author-bio'] = true;
        $exopite_settings = get_option( 'exopite_options' );
        /*
         * Diplay author bio on a single post
         */
        if ( get_the_author_meta( 'description' ) && ( ! isset( $exopite_settings['exopite-single-display-author-bio'] ) || $exopite_settings['exopite-single-display-author-bio'] == true ) ){
            echo exopite_author_meta();
        }
    }
}

/**
 * Get user avatar image.
 * - If exopite-user-avatar meta set, then get the image from there,
 * - if not, return gravatar.
 * - Also can apply exopite-author-avatar-[user-id]
 */
if ( ! function_exists( 'exopite_get_author_avatar' ) ) {
    function exopite_get_author_avatar( $user_id ) {
        $avatar_id = get_user_meta( $user_id,  'exopite-user-avatar', true );

        $image  = wp_get_attachment_image_src( $avatar_id, 'avatar' );
        if( $image ) {
            $avatar = '<img alt="avatar" src="' . $image[0] . '" class="avatar photo" height="' . $image[2] .'" width="' . $image[1] . '" />';
        } else {
            $avatar = get_avatar( get_the_author_meta('user_email'), 145 );
        }

        return apply_filters( 'exopite-author-avatar-' . $user_id, $avatar );
    }
}

if ( ! function_exists( 'exopite_author_meta' ) ) {
    function exopite_author_meta() {

        global $post;

        // Detect if it is a single post with a post author
        if ( ( is_author() || is_single() ) && isset( $post->post_author ) ) {

            // Get author's display name
            $display_name = sanitize_text_field( get_the_author_meta( 'display_name', $post->post_author ) );

            // If display name is not available then use nickname as display name
            if ( empty( $display_name ) ) $display_name = sanitize_text_field( get_the_author_meta( 'nickname', $post->post_author ) );

            // Get author's biographical information or description
            $user_description = wp_kses( get_the_author_meta( 'user_description', $post->post_author ), ExopiteSettings::getValue( 'allowed-htmls' ) );

            // Get author's website URL
            $user_website = esc_url( get_the_author_meta( 'url', $post->post_author ) );

            // Get link to the author archive page
            $user_posts = esc_url( get_author_posts_url( get_the_author_meta( 'ID' , $post->post_author ) ) );

            $user_meta = get_user_meta( get_the_author_meta( 'ID' , $post->post_author ) );

            $user_skills = '';
            if ( ! empty( $user_meta['skills'][0] ) ) {
                $user_skills = '<div class="exopite-user-skills">';
                $user_skills_temp = explode( ',', $user_meta['skills'][0] );
                foreach ( $user_skills_temp as $skill ) {
                    $user_skills .= '<span class="exopite-user-skill">' . sanitize_text_field( trim( $skill ) ) . '</span>';
                }
                $user_skills .= '</div>';
            }

            $author_details = '<div class="exopite-author secondary-box"'. WP_Schema::get_attribute( 'author', false ) . '><div class="row">';

            // Author socials
            $author_social = '';
            if ( ! empty( $user_meta['facebook'][0] ) ) $author_social .= '<li class=""><a href="' . esc_url( $user_meta['facebook'][0] ) . '" target="_blank"></a></li>';
            if ( ! empty( $user_meta['twitter'][0] ) ) $author_social .= '<li class=""><a href="' . esc_url( $user_meta['twitter'][0] ) . '" target="_blank"></a></li>';
            if ( ! empty( $user_meta['linkedin_profile'][0] ) ) $author_social .= '<li class=""><a href="' . esc_url( $user_meta['linkedin_profile'][0] ) . '" target="_blank"></a></li>';
            if ( ! empty( $user_meta['googleplus'][0] ) ) $author_social .= '<li class=""><a href="' . esc_url( $user_meta['googleplus'][0] ) . '" target="_blank"></a></li>';
            if ( ! empty( $user_meta['github'][0] ) ) $author_social .= '<li class=""><a href="' . esc_url( $user_meta['github'][0] ) . '" target="_blank"></a></li>';
            if ( ! empty( $user_meta['skype'][0] ) ) $author_social .= '<li class=""><a href="skype:' . esc_url( $user_meta['skype'][0] ) . '?call"></a></li>';
            if ( ! empty( $user_meta['xing'][0] ) ) $author_social .= '<li class=""><a href="' . esc_url( $user_meta['xing'][0] ) . '" target="_blank"></a></li>';
            if ( ! empty( $user_meta['youtube'][0] ) ) $author_social .= '<li class=""><a href="' . esc_url( $user_meta['youtube'][0] ) . '" target="_blank"></a></li>';
            if ( ! empty( $user_meta['rss_url'][0] ) ) $author_social .= '<li class=""><a href="' . esc_url( $user_meta['rss_url'][0] ) . '"></a></li>';

            if ( ! empty( $author_social ) ) {
                $author_social = '<div class="exopite-author-social social-menu"><ul>' . $author_social . '</ul></div>';
            }

            // Do not display it on the author archive page, there already has a header
            $author_title = ( ! empty( $display_name ) && ! is_author() ) ? '<div class="exopite-author-title h4">' . esc_attr__( 'Written by', 'exopite') . ' ' . $display_name . '</div>' : '';
            $author_website = ( ! empty( $user_website ) ) ? ' | <a href="' . $user_website .'" target="_blank" rel="nofollow">' . esc_attr__( 'Website', 'exopite') . '</a>' : '';
            $author_posts = '<div class="exopite-author-links"><a href="'. $user_posts .'">' . esc_attr__( 'All posts by', 'exopite') . ' ' . $display_name . '</a>' . $author_website . '</div>';

            $avatar = apply_filters( 'exopite-author-avatar-' . get_the_author_meta( 'ID' ), exopite_get_author_avatar( get_the_author_meta( 'ID' ) ) );

            // Author avatar and bio
            if ( ! empty( $user_description ) ) $author_details .= '<div class="col-sm-5 col-md-4 text-center exopite-author-avatar"><a href="'. $user_posts .'">' . $avatar . '</a>' . $author_social . '</div><div class="col-sm-7 col-md-8 exopite-author-info">' . $author_title . $author_posts . $user_skills . '<div class="exopite-author-description">' . nl2br( $user_description )  . '</div></div>';


            $author_details .= '</div></div><!-- .exopite-author -->';
        }

        return $author_details;
    }
}
