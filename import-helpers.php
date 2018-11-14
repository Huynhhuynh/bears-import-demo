<?php

if(! function_exists('bears_import_demo__step_package_download_step')) {
    /**
     * @since 1.0.0
     * 
     */
    function bears_import_demo__step_package_download_step($package_name, $position = 0, $path_file_package = '', $total = '')
    {
        $remote_url = bears_import_demo__step_get_url_package_download( $package_name, $position );
        if( !$position ) {
            // step 0 create zip file
            $response = bears_import_demo__step_package_download_step_init( $remote_url, 'package-demo.zip' );
        } else {
            // any step push data
            $response = bears_import_demo__step_push_data( $remote_url, $position, $path_file_package, $total );
        }
        return $response;
    }
}

if(! function_exists('bears_import_demo__step_get_url_package_download')) {
    /**
     * Build url download package demo
     * @since 1.0.0
     *
     */
    function bears_import_demo__step_get_url_package_download($package_name = null, $position = 0, $size = 0)
    {
        $ext = fw()->extensions->get('bears-import-demo');
        $remote_url = $ext->get_config('host_import');

        $size = ( $size ) ? '&size=' . $size : '';
        return sprintf( '%s?id=%s&position=%d' . $size, $remote_url, $package_name, $position );
    }
}

if(! function_exists('bears_import_demo__step_get_remote_file_head'))
    {
        /**
         * Get head request url
         * @since 1.0.0
         *
         */
        function bears_import_demo__step_get_remote_file_head($remote_url)
        {
            $head = array_change_key_case(get_headers($remote_url, TRUE));
            return $head;
        }
    }


if(! function_exists('bears_import_demo__step_package_download_step_init')) {
    /**
     * @since 1.0.0
     * Create package file (.zip)
     *
     */
    function bears_import_demo__step_package_download_step_init( $remote_url, $file_name )
    {
        global $wp_filesystem;
        if (empty($wp_filesystem)) {
            require_once (ABSPATH . '/wp-admin/includes/file.php');
            WP_Filesystem();
        }

        $upload_dir = wp_upload_dir();
        $path = $upload_dir['path'];
        $path_file = $path . '/' . $file_name;

        $head = bears_import_demo__step_get_remote_file_head( $remote_url );
        $content = $wp_filesystem->get_contents($remote_url);

        $mb = 1000 * 1000;
        $download = number_format($head['x-position'] / $mb, 1);
        $total = number_format($head['x-filesize'] / $mb, 1);

        if( $wp_filesystem->put_contents( $path_file, $content ) ) {

            return array(
                'message' => sprintf( __( 'Downloading package — %s Mb / %s Mb (total)', 'fw' ) , $download, $total ),
                'path_file_package' => $path_file,
                'x_position' => $head['x-position'],
                'total' => $total,
            );
        }
    }
}

if(! function_exists('bears_import_demo__step_push_data')) {
    /**
     * @since 1.0.0
     * Push data download package
     * 
     */
    function bears_import_demo__step_push_data( $remote_url, $position, $path_file_package, $total = '' ) {
        global $wp_filesystem;
        if (empty($wp_filesystem)) {
            require_once (ABSPATH . '/wp-admin/includes/file.php');
            WP_Filesystem();
        }

        $head = bears_import_demo__step_get_remote_file_head( $remote_url );
        $content = $wp_filesystem->get_contents($remote_url);

        // if( isset( $head['content-length'] ) && $head['content-length'] == 0 ) {
        if( isset( $head['x-position'] ) && $head['x-position'] == -1 ) {
            return array(
                'download_package_success' => true,
                'message' => __('Download package successful. Next step...', 'fw'),
                'remote_url' => $remote_url,
                'path_file_package' => $path_file_package,
            );
        }

        $mb = 1000 * 1000;
        $download = number_format($head['x-position'] / $mb, 1);

        if( BBACKUP_Helper_Function_File_Appent_Content($path_file_package, $content) ) {
            return array(
                'message' => sprintf( __( 'Downloading package — %s Mb / %s Mb (total)', 'fw' ), $download, $total ),
                'path_file_package' => $path_file_package,
                'remote_url' => $remote_url,
                'x_position' => $head['x-position'],
            );
        }
    }
}
