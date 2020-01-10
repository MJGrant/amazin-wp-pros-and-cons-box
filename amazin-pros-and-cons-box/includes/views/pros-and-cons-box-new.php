<?php
defined( 'ABSPATH' ) OR exit;
?>

<div class="wrap">
    <h1><?php _e( 'Add new Pros and Cons Box', 'apcb' ); ?></h1>

    <form action="" method="post">

        <table class="form-table">
            <tbody>
                <!-- label is edited globally in plugin settings -->

                <!-- Enter a name for this product (optional) -->
                <!-- Leave blank to hide field --> 
                <tr class="row-productName">
                    <th scope="row">
                        <label for="Product-Name"><?php _e( 'Product name', 'apcb' ); ?></label>
                    </th>
                    <td>
                        <input type="text" name="Product-Name" id="Product-Name" class="regular-text" placeholder="<?php echo esc_attr( '', 'apcb' ); ?>" value="" />
                        <br/>
                        <span class="description"><?php _e('Product name, model, etc. (Leave blank and no title will display on your pros and cons box.)', 'apcb' ); ?></span>
                    </td>
                </tr>

                <!-- Description of product (optional) -->
                <tr class="row-description">
                    <th scope="row">
                        <label for="Description"><?php _e( 'Description', 'apcb' ); ?></label>
                    </th>
                    <td>
                        <textarea name="Description" id="Description"placeholder="<?php echo esc_attr( '', 'apcb' ); ?>" rows="6" cols="46"></textarea>
                        <br/>
                        <span class="description"><?php _e('A summary of the product. Leave blank to hide.', 'apcb' ); ?></span>
                    </td>
                </tr>

               <!-- Pros -->
               <!-- Supports up to 6, leave blank any that aren't needed and they won't display -->
               <tr class="row-pros">
                    <th scope="row">
                        <label for="Pro-Input-1"><?php _e( 'Product "pros"', 'apcb' ); ?></label>
                    </th>
                    <td>
                        <input type="text" name="Pro-Input-1" id="Pro-Input-1" class="regular-text" placeholder="<?php echo esc_attr( '', 'apcb' ); ?>" value=""/>
                        <br/>
                        <br/>

                        <input type="text" name="Pro-Input-2" id="Pro-Input-2" class="regular-text" placeholder="<?php echo esc_attr( '', 'apcb' ); ?>" value=""/>
                        <br/>
                        <br/>

                        <input type="text" name="Pro-Input-3" id="Pro-Input-3" class="regular-text" placeholder="<?php echo esc_attr( '', 'apcb' ); ?>" value=""/>
                        <br/>
                        <br/>

                        <input type="text" name="Pro-Input-4" id="Pro-Input-4" class="regular-text" placeholder="<?php echo esc_attr( '', 'apcb' ); ?>" value=""/>
                        <br/>
                        <br/>

                        <input type="text" name="Pro-Input-5" id="Pro-Input-5" class="regular-text" placeholder="<?php echo esc_attr( '', 'apcb' ); ?>" value=""/>
                        <br/>
                        <br/>

                        <input type="text" name="Pro-Input-6" id="Pro-Input-6" class="regular-text" placeholder="<?php echo esc_attr( '', 'apcb' ); ?>" value=""/>
                        <br/>
                        <span class="description"><?php _e('Add up to 6 pros, leaving blank any you don\'t want to display', 'apcb' ); ?></span>
                        <br/>

                    </td>
                </tr>


            <!-- Cons -->
            <!-- Supports up to 6, leave blank any that aren't needed and they won't display -->
               <tr class="row-cons">
                    <th scope="row">
                        <label for="Con-Input-1"><?php _e( 'Product "cons"', 'apcb' ); ?></label>
                    </th>
                    <td>
                        <input type="text" name="Con-Input-1" id="Con-Input-1" class="regular-text" placeholder="<?php echo esc_attr( '', 'apcb' ); ?>" value=""/>
                        <br/>
                        <br/>

                        <input type="text" name="Con-Input-2" id="Con-Input-2" class="regular-text" placeholder="<?php echo esc_attr( '', 'apcb' ); ?>" value=""/>
                        <br/>
                        <br/>

                        <input type="text" name="Con-Input-3" id="Con-Input-3" class="regular-text" placeholder="<?php echo esc_attr( '', 'apcb' ); ?>" value=""/>
                        <br/>
                        <br/>

                        <input type="text" name="Con-Input-4" id="Con-Input-4" class="regular-text" placeholder="<?php echo esc_attr( '', 'apcb' ); ?>" value=""/>
                        <br/>
                        <br/>

                        <input type="text" name="Con-Input-5" id="Con-Input-5" class="regular-text" placeholder="<?php echo esc_attr( '', 'apcb' ); ?>" value=""/>
                        <br/>
                        <br/>

                        <input type="text" name="Con-Input-6" id="Con-Input-6" class="regular-text" placeholder="<?php echo esc_attr( '', 'apcb' ); ?>" value=""/>
                        <br/>
                        <span class="description"><?php _e('Add up to 6 cons, leaving blank any you don\'t want to display', 'apcb' ); ?></span>
                        <br/>

                    </td>
                </tr>
                
                <!-- Button text -->
                <tr class="row-buttonText">
                    <th scope="row">
                        <label for="Button-Text"><?php _e( 'Button text', 'apcb' ); ?></label>
                    </th>
                    <td>
                        <input type="text" name="Button-Text" id="Button-Text" class="regular-text" placeholder="<?php echo esc_attr( '', 'apcb' ); ?>" value=""/>
                        <br/>
                        <span class="description"><?php _e('Button text, or leave blank to hide the button', 'apcb' ); ?></span>
                    </td>
                </tr>

                 <tr class="row-URL">
                    <th scope="row">
                        <label for="URL"><?php _e( 'URL', 'apcb' ); ?></label>
                    </th>
                    <td>
                        <input type="text" name="URL" id="URL" class="regular-text" placeholder="<?php echo esc_attr( '', 'apcb' ); ?>" value=""/>
                        <br/>
                        <span class="description"><?php _e('Button link (likely a product affiliate link, including https://)', 'apcb' ); ?></span>
                    </td>
                </tr>
                
             </tbody>
        </table>

        <input type="hidden" name="field_id" value="0">

        <?php wp_nonce_field( '' ); ?>
        <?php submit_button( __( 'Add new Pros and Cons Box', 'apcb' ), 'primary', 'submit_pros_and_cons_box' ); ?>

    </form>
</div>
