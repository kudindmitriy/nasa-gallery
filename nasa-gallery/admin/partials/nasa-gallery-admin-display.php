<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://github.com/kudindmitriy
 * @since      1.0.0
 *
 * @package    Nasa_Gallery
 * @subpackage Nasa_Gallery/admin/partials
 */
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->

<form method="post" name="my_options" action="options.php">

    <?php

    // Get plugin options from DB
    $options = get_option($this->plugin_name);

    // Displays hidden form fields on the settings page
    settings_fields( $this->plugin_name );
    do_settings_sections( $this->plugin_name );

    ?>

    <h2><?php echo esc_html( get_admin_page_title() ); ?></h2>

    <fieldset>
        <legend class="screen-reader-text"><span><?php _e('NASA API key', $this->plugin_name);?></span></legend>
        <label for="<?php echo $this->plugin_name;?>-api_key">
            <span><?php esc_attr_e('NASA API key', $this->plugin_name);?></span>
        </label>
        <input type="text"
               class="regular-text" id="<?php echo $this->plugin_name;?>-api_key"
               name="<?php echo $this->plugin_name;?>[api_key]"
               value="<?php if(!empty($options['api_key'])) esc_attr_e($options['api_key'], $this->plugin_name);?>"
               placeholder="<?php esc_attr_e('NASA API key', $this->plugin_name);?>"
        />
    </fieldset>

    <?php submit_button(__('Save all changes', $this->plugin_name), 'primary','submit', TRUE); ?>

</form>