<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}

class FW_Extension_Bears_Import_Demo extends FW_Extension {
    static $version = '1.0.0';

	/**
     * @internal
     */
    protected function _init() {
        // ...
        $this->hooks();
    }

    public function hooks() {
        add_action( 'admin_enqueue_scripts', array( $this, 'admin_scripts' ) );
        add_action( 'admin_menu', array( $this, 'import_demo_register_ref_page' ) );   
    }

    public function admin_scripts() {
        wp_enqueue_style( 'bears-import-demo-backend-style', $this->locate_URI( '/dist/css/bears-import-demo-backend.css' ), false, self::$version );
        wp_enqueue_script( 'bears-import-demo-backend-script', $this->locate_URI( '/dist/bears-import-demo-backend.bundle.js' ), array( 'jquery' ), self::$version, true );

        wp_localize_script( 
            'bears-import-demo-backend-script', 
            'ajax_bears_import_deno_object', 
            apply_filters( 
                'ajax_bears_import_deno_object_filter', 
                array(
                    'ajax_url' => admin_url( 'admin-ajax.php' ),
                )
            ) 
        );
    }

    public function import_demo_register_ref_page() {
        add_submenu_page(
            'tools.php',
            __( 'Import Demo', 'fw' ),
            __( 'Import Demo', 'fw' ),
            'manage_options',
            'import-demo-page',
            array( $this, 'import_demo_page_callback' ) );
    }

    public function import_demo_page_callback() {
        ob_start();
        include __DIR__ . '/templates/import-demo-page.php';
        echo apply_filters( 'import_demo_page_callback_filter', ob_get_clean() );
    }
}
