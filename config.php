<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}

$cfg = array();

$cfg['host_import'] = apply_filters( 'host_import_filter', 'http://package.bearsthemespremium.com/educlever/' );
$cfg['packages'] = apply_filters( 'package_import_data_filter', array(
    /*
    'educlever-main' => array(
        'title' => __( 'Educlever Main Demo', 'fw' ),
        'preview_image' => 'http://package.bearsthemespremium.com/educlever/educlever-main/screenshot.jpg',
        'link_demo' => 'http://bearsthemespremium.com/theme/educlever/',
    ),
    */
) );