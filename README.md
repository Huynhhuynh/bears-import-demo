# bears-import-demo
Unyson helpers import demo content ( Unyson extension )

# Hooks
```php

/**
 * Hook host_import_filter
 * Filter hosting import url
 * 
 */
function yourtheme_filter_host_import_uri( $url ) {
    return 'http://package.bearsthemespremium.com/educlever/';
}
apply_filters( 'host_import_filter', 'yourtheme_filter_host_import_uri' );

/**
 * Filter import demo data
 * 
 */
function yourtheme_filter_demo_import_data( $data = array() ) {
    return array(
        'educlever-main' => array(
            'title' => __( 'Educlever Main Demo', 'educlever' ),
            'preview_image' => 'http://package.bearsthemespremium.com/educlever/educlever-main/screenshot.jpg',
            'link_demo' => 'http://bearsthemespremium.com/theme/educlever/',
        ),
    );
}

add_filter( 'package_import_data_filter', 'yourtheme_filter_demo_import_data' );
```