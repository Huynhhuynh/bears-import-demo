/**
 * Bears Import Demo script
 * 
 * @package Bears Import Demo
 * @version 1.0.0
 * @author Bearsthemes
 */

import bears_import_demo_swal from 'sweetalert';

!(function(w, $, swal) {
    'use strict';
    var $body = $('body');
    var package_name = "";

    var import_request = function( params, success_callback, error_callback ) {
        $.ajax({
            method: 'POST',
            url: ajax_bears_import_deno_object.ajax_url,
            data: {action: 'bears_import_demo_ajax_request_step_func', params: params},
            success ( res ) {
                // console.log( res );
                if( success_callback ) success_callback.call( params, res );
                if( true == res.success ) {
                    if( res.data.action ) {
                        switch( res.data.action.type ) {
                            case 'redirect_url':
                                w.location.href = res.data.action.url;
                                break;
                        }
                    } else {
                        import_request( res.data, success_callback, error_callback );
                    }
                } else {
                    // import_request( params, success_callback, error_callback );
                    var error_res = JSON.stringify( res );
                    var $html_message = $('<div>', {
                        html: `
                        <pre>${error_res}</pre>
                        Please try again or contact with our support team! <a href="https://bearsthemes.ticksy.com" target="_blank">Open ticket</a>`,
                    });
                    swal({
                        title: 'Internal Error!',
                        content: $html_message[0],
                        icon: 'error',
                        buttons: false,
                    });
                }
            },
            error ( e ) {
                // console.log( e );
                if( error_callback ) error_callback.call( params, e );
                
                var $html_message = $('<div>', {
                    html: `Please try again or contact with our support team! <a href="https://bearsthemes.ticksy.com" target="_blank">Open ticket</a>`,
                });
                swal({
                    title: 'Internal Error!',
                    content: $html_message[0],
                    icon: 'error',
                    buttons: false,
                });
            }
        })
    }

    $body.on({
        '__import.bears_import_demo' (e, package_name) {
            var $content_import_modal = $(`<div>`, { 
                class: 'content-import-modal-notice',
                html: `Import demo...`,
            });

            $content_import_modal.on({
                '__update_content.bears_import_demo' (e, content) {
                    $(this).empty().html(content);
                }
            })
            
            var import_modal_status = swal({
                content: $content_import_modal[0],
                buttons: false,
                closeOnClickOutside: false,
                closeOnEsc: false,
            });

            import_request({
                package_name: package_name,
            }, function( res ) {
                console.log( res );
                if( true == res.success ) {
                    $content_import_modal.trigger( '__update_content.bears_import_demo', [res.data.message] );
                }
            })
        }
    });

    var import_func = function() {
        
        $body.on('click', '[bears-import-demo]', function(e) {
            e.preventDefault();
            package_name = $(this).data( 'import-name' );

            var $content_modal = $(`<div class="warning-content-before-import">
                <span class="important-tag tag-warning">Important:</span> 
                Installing this demo content will <u><b>delete the content you currently have on your website</b></u>. However, we create a backup of your current content in <u><b>(Dashboad > Backup)</b></u>. You can restore the backup from there at any time in the future.
            </div>`);

            swal({
                title: "Are you sure?",
                content: $content_modal[0],
                // icon: "warning",
                buttons: {
                    cancel: true,
                    confirm: {
                        text: "Yes!",
                        value: true,
                        visible: true,
                        className: "btn-primary",
                        closeModal: true
                    }
                }
            }).then((value) => {
                if( ! value ) return;
                $body.trigger( '__import.bears_import_demo', [package_name] );
            });
        })

    }

    $(function() {
        import_func();
    })
})(window, jQuery, bears_import_demo_swal)