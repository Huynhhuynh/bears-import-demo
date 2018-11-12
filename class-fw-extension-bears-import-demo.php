<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}

class FW_Extension_Bears_Import_Demo extends FW_Extension {
	/**
     * @internal
     */
    protected function _init() {
        // ...
        $this->hooks();
    }

    public function hooks() {
        add_action( 'admin_menu', array( $this, 'import_demo_register_ref_page' ) );
    }

    public function import_demo_register_ref_page() {
        add_submenu_page(
            'tools.php',
            __( 'Import Demo', 'educlever' ),
            __( 'Import Demo', 'educlever' ),
            'manage_options',
            'import-demo-page',
            array( $this, 'import_demo_page_callback' ) );
    }

    public function import_demo_page_callback() {
        ?>
        Hello
        <?php
    }
}
