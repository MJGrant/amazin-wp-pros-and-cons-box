<?php
/**
 * Plugin Name: Amazin' Pros and Cons Box
 * Plugin URI: http://majoh.dev
 * Description: Embed a customizable "pros and cons" list into your posts and pages.
 * Version: 1.0
 * Author: Mandi Burley
 * Author URI: http://majoh.dev
 */

defined( 'ABSPATH' ) OR exit;

add_action( 'init', function() {
    include dirname( __FILE__ ) . '/includes/class-amazin-pros-and-cons-box-admin-menu.php';
    include dirname( __FILE__ ) . '/includes/class-amazin-pros-and-cons-box-list-table.php';
    include dirname( __FILE__ ) . '/includes/class-amazin-pros-and-cons-box-form-handler.php';
    include dirname( __FILE__ ) . '/includes/amazin-pros-and-cons-box-functions.php';

    // WordPress image upload library
    wp_enqueue_media();
    $jsurl = plugin_dir_url(__FILE__) . 'admin.js';
    wp_enqueue_script('admin', $jsurl, array( 'jquery' ), 1.4, true);

    $cssurl = plugin_dir_url(__FILE__) . 'styles.css';
    wp_enqueue_style( 'amazin-pros-and-cons-box-stylesheet', $cssurl, array(), 1.39 );

    register_post_type('amazin_pros_and_cons_box',
        array(
            'labels' => array(
                'name' => __( 'Amazin Pros and Cons Boxes' ),
                'singular_name' => __( ' Amazin Pros and Cons Box ')
            ),
            'public'            => false,
            'show_ui'           => false,
            'query_var'         => false,
            'rewrite'           => false,
            'capability_type'   => 'amazin_pros_and_cons_box',
            'has_archive'       => true,
            'can_export'        => true,
        )
    );

    add_option( 'amazin_pros_and_cons_box_option_pro_label', 'Pros');
    add_option( 'amazin_pros_and_cons_box_option_con_label', 'Cons');

    register_setting( 'amazin_pros_and_cons_box_options_group', 'amazin_pros_and_cons_box_option_pro_label', 'amazin_pros_and_cons_box_callback' );
    register_setting( 'amazin_pros_and_cons_box_options_group', 'amazin_pros_and_cons_box_option_con_label', 'amazin_pros_and_cons_box_callback' );

    add_filter( 'plugin_action_links_' . plugin_basename(__FILE__), 'amazin_pros_and_cons_add_plugin_action_links' );

    new Amazin_Pros_And_Cons_Box_Admin_Menu();
});

function amazin_pros_and_cons_add_plugin_action_links( $links ) {
    $plugin_url = admin_url( 'admin.php?page=amazinProsAndConsBox' );
    $links[] = '<a href="' . $plugin_url . '">' . __( 'Manage Pros and Cons Boxes', 'apcb' ) . '</a>';
    return $links;
}

function amazin_pros_and_cons_box_shortcode( $atts ) {
    $a = shortcode_atts( array(
        'id' => 'id'
        ), $atts );

    $prosAndConsBox = get_post($a['id']);

    if ($prosAndConsBox) {
        return amazin_pros_and_cons_box_render_in_post($prosAndConsBox);
    } else {
        return 'Error displaying Amazin Pros and Cons Box';
    }
}

function amazin_pros_and_cons_box_render_in_post($prosAndConsBox) {
    ob_start();
    $id = $prosAndConsBox->ID;
    $prosAndConsBoxTitle = $prosAndConsBox->post_title;
    $item = apcb_get_pros_and_cons_box( $id );

    // "content" contains two objects, one for each of the two lists (pros and cons) 
    $content = json_decode($item->post_content, true);

    // Use the user's choices for "Pro" and "Con" titles (ie: "Good stuff", "Bad stuff")
    $prosLabel = get_option('amazin_pros_and_cons_box_option_pros_label');
    $consLabel = get_option('amazin_pros_and_cons_box_option_cons_label');

    ?>
        <div class="amazin-pros-and-cons-box" id="<?php echo 'amazin-pros-and-cons-box-id-'.$id; ?>">
            <div class="amazin-pros-and-cons-box">
                <!-- title (if any) -->
                <h2 class="amazin-pros-and-cons-box-title"><?php echo $prosAndConsBoxTitle ?></h2>

                <!-- [ ][ ] -->
                <div class="amazin-pros-and-cons-row">
                    <!-- left (PROs) -->
                    <div class="amazin-pros-and-cons-box-column amazin-pros-and-cons-pros-col">
                        <h2 class="amazin-pros-label"><?php echo $prosLabel ?></h2>
                        <ul class="amazin-pros-and-cons-pros-ul">
                            <li>Pro 1</li>
                            <li>Pro 2</li>
                        </ul>
                    </div>
                    <!-- right (CONs) -->
                    <div class="amazin-pros-and-cons-box-column amazin-pros-and-cons-cons-col">
                        <h2 class="amazin-cons-label"><?php echo $consLabel ?></h2>
                        <ul class="amazin-pros-and-cons-cons-ul">
                            <li>Con 1</li>
                            <li>Con 2</li>
                        </ul>
                    </div>
                </div> <!-- closes side by side columns -->

                <!-- Button (if user elects to show it) -->
                <div class="amazin-pros-and-cons-box-button-wrap">
                    <a href="<?php echo $content['productUrl'] ?>" class="amazin-pros-and-cons-box-button" <?php echo $newTab ?> ><?php echo $content['productButtonText'] ?></a>
                </div>
            </div>
        </div>
    <?php
    return ob_get_clean();
}

add_shortcode( 'amazin-pros-and-cons-box', 'amazin_pros_and_cons_box_shortcode' );

?>
