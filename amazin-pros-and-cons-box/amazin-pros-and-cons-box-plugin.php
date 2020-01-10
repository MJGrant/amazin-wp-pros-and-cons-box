<?php
/**
 * Plugin Name: Amazin' Pros and Cons Box
 * Plugin URI: http://majoh.dev
 * Description: Embed a customizable "pros and cons" list into your posts and pages.
 * Version: 1.1
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
    wp_enqueue_style( 'amazin-pros-and-cons-box-stylesheet', $cssurl, array(), 1.86 );

    register_post_type('amazin_pc_box',
        array(
            'labels' => array(
                'name' => __( 'Amazin Pros and Cons Boxes' ),
                'singular_name' => __( ' Amazin Pros and Cons Box ')
            ),
            'public'            => false,
            'show_ui'           => false,
            'query_var'         => false,
            'rewrite'           => false,
            'capability_type'   => 'amazin_pc_box',
            'has_archive'       => true,
            'can_export'        => true,
        )
    );

    add_option( 'amazin_pros_and_cons_box_option_label', 'Quick Look');
    add_option( 'amazin_pros_and_cons_box_option_pros_label', 'Pros');
    add_option( 'amazin_pros_and_cons_box_option_cons_label', 'Cons');
    add_option( 'amazin_pros_and_cons_box_option_new_tab', false);

    register_setting( 'amazin_pros_and_cons_box_options_group', 'amazin_pros_and_cons_box_option_label', 'amazin_pros_and_cons_box_callback' );
    register_setting( 'amazin_pros_and_cons_box_options_group', 'amazin_pros_and_cons_box_option_pros_label', 'amazin_pros_and_cons_box_callback' );
    register_setting( 'amazin_pros_and_cons_box_options_group', 'amazin_pros_and_cons_box_option_cons_label', 'amazin_pros_and_cons_box_callback' );
    register_setting( 'amazin_pros_and_cons_box_options_group', 'amazin_pros_and_cons_box_option_new_tab', 'amazin_pros_and_cons_box_callback' );

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

    $prosAndConsBoxLabel = get_option('amazin_pros_and_cons_box_option_label');

    $prosAndConsBoxDescription = $content['description'];

    // Use the user's choices for "Pro" and "Con" titles (ie: "Good stuff", "Bad stuff")
    $prosLabel = get_option('amazin_pros_and_cons_box_option_pros_label');
    $consLabel = get_option('amazin_pros_and_cons_box_option_cons_label');

    $newTab = get_option('amazin_pros_and_cons_box_option_new_tab') ? 'target="_blank"' : '';

    $hidePro1 = $content['pro1'] ? '' : 'hidden="true"';
    $hidePro2 = $content['pro2'] ? '' : 'hidden="true"';
    $hidePro3 = $content['pro3'] ? '' : 'hidden="true"';
    $hidePro4 = $content['pro4'] ? '' : 'hidden="true"';
    $hidePro5 = $content['pro5'] ? '' : 'hidden="true"';
    $hidePro6 = $content['pro6'] ? '' : 'hidden="true"';

    $hideCon1 = $content['con1'] ? '' : 'hidden="true"';
    $hideCon2 = $content['con2'] ? '' : 'hidden="true"';
    $hideCon3 = $content['con3'] ? '' : 'hidden="true"';
    $hideCon4 = $content['con4'] ? '' : 'hidden="true"';
    $hideCon5 = $content['con5'] ? '' : 'hidden="true"';
    $hideCon6 = $content['con6'] ? '' : 'hidden="true"';

    $hideButton = $content['buttonText'] ? '' : "hidden=true";

    ?>
        <div class="amazin-pros-and-cons-box" id="<?php echo 'amazin-pros-and-cons-box-id-'.$id; ?>">
            <div class="amazin-pros-and-cons-box-text">
                <!-- label -->
                <h2 class="amazin-pros-and-cons-box-label"><?php echo $prosAndConsBoxLabel ?></h2>
                <!-- Product name (optional) -->
                <h3 class="amazin-pros-and-cons-box-title"><?php echo $prosAndConsBoxTitle ?></h3>
                <!-- Description (optional) -->
                <p class="amazin-pros-and-cons-box-description"><?php echo $prosAndConsBoxDescription ?></p>
            </div>

            <div class="amazin-pros-and-cons-main">
                <!-- left (PROs) -->
                <div class="amazin-pros-and-cons-box-column amazin-pros-and-cons-pros-col">
                    <h4 class="amazin-pros-and-cons-column-label amazin-pros-label"><?php echo $prosLabel ?></h4>
                    <ul class="amazin-pros-and-cons-ul amazin-pros-and-cons-pros-ul">
                        <li <?php echo $hidePro1; ?>><?php echo $content['pro1'] ?></li>
                        <li <?php echo $hidePro2; ?>><?php echo $content['pro2'] ?></li>
                        <li <?php echo $hidePro3; ?>><?php echo $content['pro3'] ?></li>
                        <li <?php echo $hidePro4; ?>><?php echo $content['pro4'] ?></li>
                        <li <?php echo $hidePro5; ?>><?php echo $content['pro5'] ?></li>
                        <li <?php echo $hidePro6; ?>><?php echo $content['pro6'] ?></li>
                    </ul>
                </div>
                <!-- right (CONs) -->
                <div class="amazin-pros-and-cons-box-column amazin-pros-and-cons-cons-col">
                    <h4 class="amazin-pros-and-cons-column-label amazin-cons-label"><?php echo $consLabel ?></h4>
                    <ul class="amazin-pros-and-cons-ul amazin-pros-and-cons-cons-ul">
                        <li <?php echo $hideCon1; ?>><?php echo $content['con1'] ?></li>
                        <li <?php echo $hideCon2; ?>><?php echo $content['con2'] ?></li>
                        <li <?php echo $hideCon3; ?>><?php echo $content['con3'] ?></li>
                        <li <?php echo $hideCon4; ?>><?php echo $content['con4'] ?></li>
                        <li <?php echo $hideCon5; ?>><?php echo $content['con5'] ?></li>
                        <li <?php echo $hideCon6; ?>><?php echo $content['con6'] ?></li>
                    </ul>
                </div>
            </div> <!-- closes side by side columns -->

            <!-- Button (if user elects to show it) -->
            <div class="amazin-pros-and-cons-box-button-wrap" <?php echo $hideButton; ?>>
                <a href="<?php echo $content['url'] ?>" class="amazin-button amazin-pros-and-cons-box-button" <?php echo $newTab ?> ><?php echo $content['buttonText'] ?></a>
            </div>

        </div>
    <?php
    return ob_get_clean();
}

add_shortcode( 'amazin-pros-and-cons-box', 'amazin_pros_and_cons_box_shortcode' );

?>
