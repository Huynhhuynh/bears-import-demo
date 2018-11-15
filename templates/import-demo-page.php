<?php
/**
 * Import demo page template
 * 
 * @package Bears iport demo
 * @version 1.0.0
 * 
 */
$ext = fw()->extensions->get('bears-import-demo');
$packages = $ext->get_config('packages');
?>
<div class="wrap bears-import-demo-main-classes">
    
    <h1><?php echo apply_filters( 'import_demo_heading_text_filter', __( 'Import Demo', 'fw' ) ); ?></h1>
    
    <?php do_action( 'import_demo_before_content_hook' ); ?>
    
    <div class="import-container">
        <div class="b-row">
            <?php 
            if( count( $packages ) > 0 ) {
            foreach( $packages as $key => $package ) { ?>
                <div class="b-col-3">
                    <div class="package-item">
                        <div class="thumbnail">
                            <img src="<?php echo esc_attr( $package['preview_image'] ); ?>" alt="<?php echo esc_attr( $package['title'] ); ?>">
                            <div class="group-buttons">
                                <a class="link-preview" href="<?php echo esc_url( $package['link_demo'] ); ?>" target="_blank">
                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 456.795 456.795" style="enable-background:new 0 0 456.795 456.795;" xml:space="preserve"> <g> <g> <path d="M448.947,218.475c-0.922-1.168-23.055-28.933-61-56.81c-50.705-37.253-105.877-56.944-159.551-56.944 c-53.672,0-108.844,19.691-159.551,56.944c-37.944,27.876-60.077,55.642-61,56.81L0,228.397l7.846,9.923 c0.923,1.168,23.056,28.934,61,56.811c50.707,37.252,105.879,56.943,159.551,56.943c53.673,0,108.845-19.691,159.55-56.943 c37.945-27.877,60.078-55.643,61-56.811l7.848-9.923L448.947,218.475z M228.396,315.039c-47.774,0-86.642-38.867-86.642-86.642 c0-7.485,0.954-14.751,2.747-21.684l-19.781-3.329c-1.938,8.025-2.966,16.401-2.966,25.013c0,30.86,13.182,58.696,34.204,78.187 c-27.061-9.996-50.072-24.023-67.439-36.709c-21.516-15.715-37.641-31.609-46.834-41.478c9.197-9.872,25.32-25.764,46.834-41.478 c17.367-12.686,40.379-26.713,67.439-36.71l13.27,14.958c15.498-14.512,36.312-23.412,59.168-23.412 c47.774,0,86.641,38.867,86.641,86.642C315.037,276.172,276.17,315.039,228.396,315.039z M368.273,269.875 c-17.369,12.686-40.379,26.713-67.439,36.709c21.021-19.49,34.203-47.326,34.203-78.188s-13.182-58.697-34.203-78.188 c27.061,9.997,50.07,24.024,67.439,36.71c21.516,15.715,37.641,31.609,46.834,41.477 C405.91,238.269,389.787,254.162,368.273,269.875z"/> <path d="M173.261,211.555c-1.626,5.329-2.507,10.982-2.507,16.843c0,31.834,25.807,57.642,57.642,57.642 c31.834,0,57.641-25.807,57.641-57.642s-25.807-57.642-57.641-57.642c-15.506,0-29.571,6.134-39.932,16.094l28.432,32.048 L173.261,211.555z"/> </g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> </svg>
                                    <span><?php _e( 'Preview', 'fw' ) ?></span>
                                </a>
                                <a class="btn-import" href="#" bears-import-demo data-import-name="<?php echo esc_attr( $key ); ?>">
                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 471.2 471.2" style="enable-background:new 0 0 471.2 471.2;" xml:space="preserve"> <g> <g> <path d="M457.7,230.15c-7.5,0-13.5,6-13.5,13.5v122.8c0,33.4-27.2,60.5-60.5,60.5H87.5c-33.4,0-60.5-27.2-60.5-60.5v-124.8 c0-7.5-6-13.5-13.5-13.5s-13.5,6-13.5,13.5v124.8c0,48.3,39.3,87.5,87.5,87.5h296.2c48.3,0,87.5-39.3,87.5-87.5v-122.8 C471.2,236.25,465.2,230.15,457.7,230.15z"/> <path d="M226.1,346.75c2.6,2.6,6.1,4,9.5,4s6.9-1.3,9.5-4l85.8-85.8c5.3-5.3,5.3-13.8,0-19.1c-5.3-5.3-13.8-5.3-19.1,0l-62.7,62.8 V30.75c0-7.5-6-13.5-13.5-13.5s-13.5,6-13.5,13.5v273.9l-62.8-62.8c-5.3-5.3-13.8-5.3-19.1,0c-5.3,5.3-5.3,13.8,0,19.1 L226.1,346.75z"/> </g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> </svg>
                                    <span><?php _e( 'Import', 'fw' ); ?></span>
                                </a>
                            </div>
                        </div>
                        <div class="title">
                            <?php echo "{$package['title']}"; ?>
                        </div>
                    </div>
                </div>
            <?php 
                } 
            } else {
                _e( 'Empty demo!', 'fw' );
            } ?>
        </div>
    </div>
    
    <?php do_action( 'import_demo_after_content_hook' ); ?>

</div>