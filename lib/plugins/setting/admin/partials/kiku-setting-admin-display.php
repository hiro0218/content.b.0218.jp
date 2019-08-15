<div class='wrap'>
    <h2><?php _e('Setting', 'kiku'); ?></h2>
    <?php settings_errors(); ?>
    <form method="post" action="options.php">
        <?php
        settings_fields('kiku-settings-group');
        do_settings_sections('kiku-settings-group');
        ?>
        <table class="form-table">
            <tbody>
                <tr>
                    <th><label><?php _e('Amazon Product Advertising API', 'kiku'); ?></label></th>
                    <td>
                        <label><input type="text" name="kiku_amazon_api_key" class="regular-text" value="<?php echo get_option(
                          'kiku_amazon_api_key'
                        ); ?>" placeholder="access key id" /></label>
                        <label><input type="text" name="kiku_amazon_secret_key" class="regular-text" value="<?php echo get_option(
                          'kiku_amazon_secret_key'
                        ); ?>" placeholder="secret access key" /></label>
                        <label><input type="text" name="kiku_amazon_associate_tag" class="regular-text" value="<?php echo get_option(
                          'kiku_amazon_associate_tag'
                        ); ?>" placeholder="associate tag" /></label>
                    </td>
                </tr>
            </tbody>
        </table>
        <?php submit_button(); ?>
    </form>
</div>
