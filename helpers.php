<?php 
/**
 * @package Bears Import Demo
 * @author Bearsthemes 
 * 
 */

/**
 * include import heplers
 */
require_once __DIR__ . '/import-helpers.php';

if(! function_exists('bears_import_demo_ajax_request_step_func')) {
    /**
     * @since 1.0.0
     * 
     */
    function bears_import_demo_ajax_request_step_func() {
        extract( $_POST );
        
        $steps = bears_import_demo_import_steps();
        $current_step_num = isset( $params['current_step_num'] ) ? $params['current_step_num'] : 0;
        
        // set current step for $params
        if( !isset( $params['current_step_num'] ) ) {
            $params['current_step_num'] = $current_step_num;
        }
        
        $pass_all_steps = $current_step_num > (count( $steps ) - 1);
        if( true == $pass_all_steps ) {
            wp_send_json_success( array(
                'message' => __( 'Import demo successful and return home page now, Thank you so much ✌!', 'fw' ),
                'success' => true,
                'pass_all_step' => true,
                'action' => array(
                    'type' => 'redirect_url',
                    'url' => get_home_url(),
                )
            ) );
        }
       
        $current_step_handle = $steps[$current_step_num];
        $result = array();
        if( function_exists( $current_step_handle['handle'] ) ) {
            $result = call_user_func( $current_step_handle['handle'], $params );
        } else {
            $result = array(
                'message' => __( 'Error: Step handle not exist!' ),
                'success' => false,
                'pass_all_step' => false,
            );
        }

        wp_send_json_success( $result );
        exit();
    }
    add_action( 'wp_ajax_bears_import_demo_ajax_request_step_func', 'bears_import_demo_ajax_request_step_func' );
    add_action( 'wp_ajax_nopriv_bears_import_demo_ajax_request_step_func', 'bears_import_demo_ajax_request_step_func' );   
}

if(! function_exists('bears_import_demo_import_steps')) {
    /**
     * @since 1.0.0
     * 
     */
    function bears_import_demo_import_steps() {
        $steps = apply_filters( 'bears_import_demo_import_steps_filter', array(
            array(
                'name' => __( 'Backup current database & media', 'fw' ),
                'handle' => 'bears_import_demo_step_backup_func',
                'desc' => '',
            ),
            array(
                'name' => __( 'Download package', 'fw' ),
                'handle' => 'bears_import_demo_step_download_package_func',
                'desc' => '',
            ),
            array(
                'name' => __( 'Extract package', 'fw' ),
                'handle' => 'bears_import_demo_step_extract_package_func',
                'desc' => '',
            ),
            array(
                'name' => __( 'Restore database', 'fw' ),
                'handle' => 'bears_import_demo_step_replace_database_func',
                'desc' => '',
            ),
        ));

        return $steps;
    }
}

if(! function_exists('bears_import_demo_step_backup_func')) {
    /**
     * @since 1.0.0
     * 
     */
    function bears_import_demo_step_backup_func( $params = array() ) {
        $backup_process = isset( $params['backup_process'] ) ? $params['backup_process'] : 'backup_database';
        if( ! isset( $params['backup_process'] ) ) {
            $params['backup_process'] = $backup_process;
        }

        $result = array();
        switch( $backup_process ) {
            case 'backup_database':
                // backup_database
                $backup_result = BBACKUP_Backup_Database( array(), '' );

                if( $backup_result['success'] == true ) {
                    $result = array(
                        'message' => sprintf( __( 'Backup — %s', 'jayla' ),  $backup_result['message'] ),
                        'bk_folder_name' => $backup_result['bk_folder_name'],
                        'backup_process' => 'backup_create_file_config',
                    );
                } else {
                    $result = array(
                        'message' => sprintf( __( 'Backup — %s', 'jayla' ),  $backup_result['message'] ),
                    );
                }
                break;

            case 'backup_create_file_config': 
                $backup_params = array(
                    'bk_folder_name' => $params['bk_folder_name'],
                );

                $backup_result = BBACKUP_Create_File_Config($backup_params, '');
                if( $backup_result['success'] == true ) {
                    $result = array(
                        'message' => sprintf( __( 'Backup — %s', 'fw' ),  $backup_result['message'] ),
                        'backup_process' => 'backup_backup_folder_upload',
                    );
                } else {
                    $result = array(
                        'message' => sprintf( __( 'Backup — %s', 'fw' ),  $backup_result['message'] ),
                    );
                }
                break;

            case 'backup_backup_folder_upload': 
                $backup_params = array(
                    'bk_folder_name' => $params['bk_folder_name'],
                );

                $backup_result = BBACKUP_Backup_Folder_Upload($backup_params, '');
                if( $backup_result['success'] == true ) {
                    $result = array(
                        'message' => __('Backup database and media successful, Next step...', 'fw'),
                        'current_step_num' => $params['current_step_num'] + 1,
                    );
                } else {
                    $result = array(
                        'message' => sprintf( __( 'Backup — %s', 'fw' ),  $backup_result['message'] )
                    );
                }
                break;
        }

        return wp_parse_args( $result, $params );
    }
}

if(! function_exists('bears_import_demo_step_download_package_func')) {
    /**
     * @since 1.0.0
     * 
     */
    function bears_import_demo_step_download_package_func( $params = array() ) {
        extract($params);

        $position_download = 0;
        $path_file_package = '';
        $download_package_success = false;
        $total = '0.0Mb';

        if( isset( $params['x_position'] ) ) {
            $position_download = $params['x_position'];
            $path_file_package = $params['path_file_package'];
            $total = $params['total'];
        }

        $result = bears_import_demo__step_package_download_step($package_name, $position_download, $path_file_package, $total);

        if( isset( $result['download_package_success'] ) && $result['download_package_success'] == true ) {
            $params['current_step_num'] = $params['current_step_num'] + 1;
        }

        return wp_parse_args( $result, $params );
    }   
}

if(! function_exists('bears_import_demo_step_extract_package_func')) {
    /**
     * @since 1.0.0
     * 
     */
    function bears_import_demo_step_extract_package_func( $params ) {

        global $Bears_Backup;
        $backup_path = $Bears_Backup->upload_path();
        $extract_to = $backup_path . '/' . sprintf( 'package-install__%s', $params['package_name'] );
        $result = array();

        if ( ! wp_mkdir_p( $extract_to ) ) {
            $result = array(
                'message' => __('Extract package demo fail.', 'fw'),
                'extract_package_success' => false,
            );
        }

        if( isset( $params['path_file_package'] ) ) {
            $zipFile = new \PhpZip\ZipFile();
            $zipFile
            ->openFile( $params['path_file_package'] )
            ->extractTo( $extract_to )
            ->close();

            // remove zip file
            wp_delete_file( $params['path_file_package'] );

            $result = array(
                'message' => __('Extract package demo successful. Next step...', 'fw'),
                'package_demo_path' => $extract_to,
                'extract_package_success' => true,
            );
            $params['current_step_num'] = $params['current_step_num'] + 1;

        } else {
            $result = array(
                'message' => __('Not found package demo ⚠️, please reload browser and try install again. Thank you!', 'fw'),
                'extract_package_success' => false,
            );
        }

        return wp_parse_args( $result, $params );
    }
}

if(! function_exists('bears_import_demo_step_replace_database_func')) {
    /**
     * @since 1.0.0
     * 
     */
    function bears_import_demo_step_replace_database_func( $params ) {

        $args = array(
            'name' => basename($params['package_demo_path']),
            'backup_path_file' => $params['package_demo_path'],
        );
        $restore_data = BBACKUP_Restore_Data( $args, '' );
        $result = array();

        global $wp_filesystem;
        if (empty($wp_filesystem)) {
            require_once (ABSPATH . '/wp-admin/includes/file.php');
            WP_Filesystem();
        }
        // delete package folder
        $wp_filesystem->delete( $params['package_demo_path'] , true );

        if( isset($restore_data['success']) && $restore_data['success'] == true ) {
            $result = apply_filters( 'bears_import_demo_step_replace_database_success_result_data_filter', 
            array(
                'message' => __('Install package demo successful and return home page now, Thank you so much 👌!', 'fw'),
                'restore_database_success' => true,
                'current_step_num' => $params['current_step_num'] + 1,
                'action' => array(
                    'type' => 'redirect_url',
                    'url' => get_home_url(), )
                )
            );
        } else {
            $result = array(
                'message' => __('Install package demo false 😢! Please try again in a few minutes or contact our support team. Thank you!', 'fw'),
                'restore_database_success' => false,
                // 'extra_params' => $result,
            );
        }

        return wp_parse_args( $result, $params );
    }
}   
