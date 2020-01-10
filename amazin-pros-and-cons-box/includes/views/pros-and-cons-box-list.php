<?php
defined( 'ABSPATH' ) OR exit;
?>

<div class="wrap">
    <h2><?php _e( 'Amazin\' Pros and Cons Boxes', 'apcb' ); ?> <a href="<?php echo admin_url( 'admin.php?page=amazinProsAndConsBox&action=new' ); ?>" class="add-new-h2"><?php _e( 'Add New', 'apcb' ); ?></a></h2>
    <div class="notice notice-info not-dismissible">
        <p><strong>Welcome!</strong><br>These are your saved "Pros and Cons" boxes. Here you can create, edit, and manage your pros and cons boxes. Copy and paste a shortcode into the editor to embed a pros and cons box to your post.</p>
    </div>
    <form method="get">
        <input type="hidden" name="page" value="<?php echo $_REQUEST['page'] ?>"/>  <!-- value="ttest_list_table">-->

        <?php
        $list_table = new Amazin_Pros_And_Cons_Box_List_Table();
        $list_table->prepare_items();

        $message = '';
        if ('delete' === $list_table->current_action()) {
            $message = '<div class="updated below-h2" id="message"><p>' . sprintf(__('Pros and Cons Boxes deleted: %d', 'apcb'), count($_REQUEST['id'])) . '</p></div>';
        }
        echo $message;

        $list_table->display();
        ?>
    </form>

    <!-- global plugin options -->
    <form method="post" action="options.php">
        <?php settings_fields('amazin_pros_and_cons_box_options_group' ); ?>
        <?php
            $prosLabel = get_option('amazin_pros_and_cons_box_option_pros_label');
            $consLabel = get_option('amazin_pros_and_cons_box_option_cons_label');
            $newTab = get_option('amazin_pros_and_cons_box_option_new_tab') ? 'checked' : '';
        ?>
        <h3>Pros and Cons box settings</h3>
        <p>These settings are shared by all pros and cons article boxes on your site.</p>
        <table class="form-table">
            <tbody>
                <!-- Pros label -->
                <tr>
                    <th scope="row">
                        <label for="amazin_pros_and_cons_box_option_pros_label">Pros label</label>
                    </th>
                    <td>
                        <input type="text" id="amazin_pros_and_cons_box_option_pros_label" name="amazin_pros_and_cons_box_option_pros_label" value="<?php echo get_option('amazin_pros_and_cons_box_option_pros_label'); ?>" />
                        <br/>
                        <span class="description"><?php _e('Examples: "Good stuff", "Love", "Advantages", etc.', 'apcb' ); ?></span>
                    </td>
                </tr>
                <!-- Cons label -->
                <tr>
                    <th scope="row">
                        <label for="amazin_pros_and_cons_box_option_cons_label">Cons label</label>
                    </th>
                    <td>
                        <input type="text" id="amazin_pros_and_cons_box_option_cons_label" name="amazin_pros_and_cons_box_option_cons_label" value="<?php echo get_option('amazin_pros_and_cons_box_option_cons_label'); ?>" />
                        <br/>
                        <span class="description"><?php _e('Examples: "Bad stuff", "Don\'t love", "Disadvantages", etc.', 'apcb' ); ?></span>
                    </td>
                </tr>

                <!-- Open in new tab -->
                <tr>
                    <th scope="row">
                        <label for="amazin_pros_and_cons_box_option_new_tab">Open link in new tab</label>
                    </th>
                    <td>
                        <input type="checkbox" id="amazin_pros_and_cons_box_option_new_tab" name="amazin_pros_and_cons_box_option_new_tab" value="newTab" <?php checked( 'newTab', get_option('amazin_pros_and_cons_box_option_new_tab') ); ?> />
                        <br/>
                        <span class="description"><?php _e('The button link should open in a new browser tab', 'apcb' ); ?></span>
                    </td>
                </tr>
            </tbody>
        </table>
        <?php submit_button(); ?>
    </form>
</div>
