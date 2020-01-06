<?php
defined( 'ABSPATH' ) OR exit;

/**
 * Admin Menu
 */
class Amazin_Pros_And_Cons_Box_Admin_Menu {

    /**
     * Kick-in the class
     */
    public function __construct() {
        add_action( 'admin_menu', array( $this, 'admin_menu' ) );
    }

    /**
     * Add menu items
     *
     * @return void
     */
    public function admin_menu() {

        /** Top Menu **/
        add_menu_page( __( 'AmazinProsAndConsBox', 'apcb' ), __( 'Amazin\' ProsAndCons Box', 'apcb' ), 'manage_options', 'amazinProsAndConsBox', array( $this, 'plugin_page' ), 'dashicons-grid-view', null );

        add_submenu_page( 'amazinProsAndConsBox', __( 'AmazinProsAndConsBox', 'apcb' ), __( 'AmazinProsAndConsBox', 'apcb' ), 'manage_options', 'amazinProsAndConsBox', array( $this, 'plugin_page' ) );

        wp_enqueue_media();
    }

    /**
     * Handles the plugin page
     *
     * @return void
     */
    public function plugin_page() {
        $action = isset( $_GET['action'] ) ? $_GET['action'] : 'list';
        $ID     = isset( $_GET['ID'] ) ? intval( $_GET['ID'] ) : 0;

        switch ($action) {
            case 'view':

                $template = dirname( __FILE__ ) . '/views/pros-and-cons-box-single.php';
                break;

            case 'edit':
                $template = dirname( __FILE__ ) . '/views/pros-and-cons-box-edit.php';
                break;

            case 'new':
                $template = dirname( __FILE__ ) . '/views/pros-and-cons-box-new.php';
                break;

            default:
                $template = dirname( __FILE__ ) . '/views/pros-and-cons-box-list.php';
                break;
        }

        if ( file_exists( $template ) ) {
            include $template;
        }

    }
}
