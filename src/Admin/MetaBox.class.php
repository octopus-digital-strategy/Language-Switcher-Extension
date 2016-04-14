<?php


namespace LanguageSwitcherExtension\Admin;


class MetaBox
{

    public function __construct()
    {
        add_meta_box( 'lsex-translation-menu-item', __( 'Translation Item', 'lsex' ), array($this, 'renderMetaBox'), 'nav-menus', 'side', 'default' );
        // Register advanced menu items (columns)
        //add_filter( 'manage_nav-menus_columns', array($this, 'someFunction') );

    }

    public function renderMetaBox()
    {
        global $_nav_menu_placeholder, $nav_menu_selected_id;
        $_nav_menu_placeholder = 0 > $_nav_menu_placeholder ? $_nav_menu_placeholder - 1 : -1;

        ?>
        <div class="customlinkdiv" id="customlinkdiv">
            <input type="hidden" value="custom" name="menu-item[<?php echo $_nav_menu_placeholder; ?>][menu-item-type]" />
            <p id="menu-item-url-wrap" class="wp-clearfix">
                <label class="howto" for="custom-menu-item-url"><?php _e( 'URL' ); ?></label>
                <input id="custom-menu-item-url" name="menu-item[<?php echo $_nav_menu_placeholder; ?>][menu-item-url]" type="text" class="code menu-item-textbox" value="http://" />
            </p>

            <p id="menu-item-name-wrap" class="wp-clearfix">
                <label class="howto" for="custom-menu-item-name"><?php _e( 'Link Text' ); ?></label>
                <input id="custom-menu-item-name" name="menu-item[<?php echo $_nav_menu_placeholder; ?>][menu-item-title]" type="text" class="regular-text menu-item-textbox" />
            </p>

            <p class="button-controls wp-clearfix">
			<span class="add-to-menu">
				<input type="submit"<?php wp_nav_menu_disabled_check( $nav_menu_selected_id ); ?> class="button-secondary submit-add-to-menu right" value="<?php esc_attr_e('Add to Menu'); ?>" name="add-custom-menu-item" id="submit-customlinkdiv" />
				<span class="spinner"></span>
			</span>
            </p>

        </div>
    <?php
    }
    
}