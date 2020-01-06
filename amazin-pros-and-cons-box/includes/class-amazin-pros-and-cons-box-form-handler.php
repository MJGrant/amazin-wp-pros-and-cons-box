<?php
defined( 'ABSPATH' ) OR exit;

/**
 * Handle the form submissions
 *
 * @package Package
 * @subpackage Sub Package
 */
class Amazin_Pros_And_Cons_Box_Form_Handler {

    /**
     * Hook 'em all
     */
    public function __construct() {
        add_action( 'admin_init', array( $this, 'handle_form' ) );
    }

    /**
     * Handle the pros and cons box new and edit form
     *
     * @return void
     */
    public function handle_form() {
        if ( ! isset( $_POST['submit_pros_and_cons_box'] ) ) {
            return;
        }

        if ( ! wp_verify_nonce( $_POST['_wpnonce'], '' ) ) {
            die( __( 'Security check failed.', 'apcb' ) );
        }

        if ( ! current_user_can( 'read' ) ) {
            wp_die( __( 'Permission denied!', 'apcb' ) );
        }

        $errors   = array();
        $page_url = admin_url( 'admin.php?page=amazinProsAndConsBox' );
        $field_id = isset( $_POST['field_id'] ) ? intval( $_POST['field_id'] ) : 0;

        // button text is optional, leave it blank to hide button
        $field_buttonText = sanitize_text_field( $_POST['Button-Text'] );
        $field_featuredURL = isset( $_POST['Pros-and-Cons-Item-URL'] ) ? sanitize_text_field( $_POST['Pros-and-Cons-Item-URL'] ) : '';
        

        // some basic validation
        /* 
        if ( ! $field_featuredURL ) {
            $errors[] = __( 'Error: URL is required', 'afb' );
        }
        if ( ! $featuredPostID ) {
            $errors[] = __( 'Error: URL could not be transformed into a post ID', 'afb' );
        } */

        // bail out if error found
        if ( $errors ) {
            $first_error = reset( $errors );
            $redirect_to = add_query_arg( array( 'error' => $first_error ), $page_url );
            wp_safe_redirect( $redirect_to );
            exit;
        }

        $content = array(
            'featuredURL' => $field_featuredURL,
            'featuredPostID' => $featuredPostID,
            'customLabel' => $field_customLabel,
            'customName' => $field_customName,
            'featuredTagline' => $field_tagline,
            'featuredButtonText' => $field_buttonText,
            'featuredImage' => $field_featuredImage //ID of media attachment
        );

        $featured_box = array(
            'ID'            => $field_id,
            'post_title'    => $field_featuredName,
            'post_type'     => 'amazin_featured_box',
            'post_content'  => wp_json_encode($content, JSON_HEX_APOS), //broke when switched this from 'none' to the content array
            'post_status'   => 'publish',
            'post_author'   => 1,
            'post_category' => array( 8,39 )
        );

        // New or edit?
        if ( ! $field_id ) {
            $insert_id = afb_new_featured_box( $featured_box );
        } else {
            $insert_id = afb_update_featured_box( $featured_box );
        }

        if ( is_wp_error( $insert_id ) ) {
            $redirect_to = add_query_arg( array( 'message' => 'error' ), $page_url );
        } else {
            $redirect_to = add_query_arg( array( 'message' => 'success' ), $page_url );
        }

        wp_safe_redirect( $redirect_to );
        exit;
    }
}

new Amazin_Pros_and_Cons_Box_Form_Handler();
