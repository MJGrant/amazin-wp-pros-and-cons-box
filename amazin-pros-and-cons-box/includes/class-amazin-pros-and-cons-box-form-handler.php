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


        // every field is optional, so just take what's in each and sanitize it
        $field_title = isset( $_POST['Product-Name'] ) ? sanitize_text_field( $_POST['Product-Name'] ) : '';
        $field_description = isset( $_POST['Description'] ) ? sanitize_text_field( $_POST['Description'] ) : '';

        $field_pro1 = sanitize_text_field( $_POST['Pro-Input-1'] );
        $field_pro2 = sanitize_text_field( $_POST['Pro-Input-2'] ); 
        $field_pro3 = sanitize_text_field( $_POST['Pro-Input-3'] ); 
        $field_pro4 = sanitize_text_field( $_POST['Pro-Input-4'] ); 
        $field_pro5 = sanitize_text_field( $_POST['Pro-Input-5'] ); 
        $field_pro6 = sanitize_text_field( $_POST['Pro-Input-6'] ); 

        $field_con1 = sanitize_text_field( $_POST['Con-Input-1'] );
        $field_con2 = sanitize_text_field( $_POST['Con-Input-2'] ); 
        $field_con3 = sanitize_text_field( $_POST['Con-Input-3'] ); 
        $field_con4 = sanitize_text_field( $_POST['Con-Input-4'] ); 
        $field_con5 = sanitize_text_field( $_POST['Con-Input-5'] ); 
        $field_con6 = sanitize_text_field( $_POST['Con-Input-6'] ); 

        $field_buttonText = sanitize_text_field( $_POST['Button-Text'] );
        $field_url = sanitize_text_field( $_POST['URL'] );

        // bail out if error found
        if ( $errors ) {
            $first_error = reset( $errors );
            $redirect_to = add_query_arg( array( 'error' => $first_error ), $page_url );
            wp_safe_redirect( $redirect_to );
            exit;
        }

        // save everything to $content (product title is saved as post title) 
        $content = array(
            'label' => $field_label,
            'description' => $field_description,
            'pro1' => $field_pro1,
            'pro2' => $field_pro2,
            'pro3' => $field_pro3,
            'pro4' => $field_pro4,
            'pro5' => $field_pro5,
            'pro6' => $field_pro6,
            'con1' => $field_con1,
            'con2' => $field_con2,
            'con3' => $field_con3,
            'con4' => $field_con4,
            'con5' => $field_con5,
            'con6' => $field_con6,
            'url' => $field_url,
            'buttonText' => $field_buttonText
        );

        $pros_and_cons_box = array(
            'ID'            => $field_id,
            'post_title'    => $field_title,
            'post_type'     => 'amazin_pc_box',
            'post_content'  => wp_json_encode($content, JSON_HEX_APOS), //broke when switched this from 'none' to the content array
            'post_status'   => 'publish',
            'post_author'   => 1,
            'post_category' => array( 8,39 )
        );

        // New or edit?
        if ( ! $field_id ) {
            $insert_id = apcb_new_pros_and_cons_box( $pros_and_cons_box );
        } else {
            $insert_id = apcb_update_pros_and_cons_box( $pros_and_cons_box );
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
