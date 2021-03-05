/*!
 Project   : Elan WordPress Theme
 Purpose   : Meta Box Area Js
 Author    : precisethemes
 Theme URI : https://precisethemes.com/
 */
/**
 * File metabox-script.js.
 *
 * Theme Post/Page Meta Box enhancements for a better user experience.
 *
 * @package Elan
 */

( function( $ ) {

    "use strict";

    // Welcome Page Tabs
    $('ul.metabox-tab-nav li').on( 'click', function (e) {
        window.localStorage.setItem('active_metabox_tab', $(e.target).data('tab'));
        var tab_id = $(this).data('tab');
        $('ul.metabox-tab-nav li').removeClass('active');
        $('.setting-tab').removeClass('active');

        $(this).addClass('active');
        $("#" + tab_id).addClass('active');
    });

    // Store tab data value in local storage
    var active_metabox_tab = window.localStorage.getItem('active_metabox_tab');

    // Add Active Class in both tab and content with browser refresh
    if (active_metabox_tab) {
        $('ul.metabox-tab-nav li').removeClass('active');
        $('.setting-tab').removeClass('active');
        $('ul.metabox-tab-nav li[data-tab="'+active_metabox_tab+'"]').addClass('active');
        $("#"+active_metabox_tab).addClass('active');
        localStorage.removeItem('active_metabox_tab');
    } else {
        $('ul.metabox-tab-nav li[data-tab="setting-tab-2"]').addClass('active');
        $("#setting-tab-2").addClass('active');
    }

    // Reset post meta settings
    $( 'div#post_meta_fields div.metabox-reset-settings a.metabox-reset-btn' ).click( function() {
        var $reset = $(this).data('reset');
        var $cancel = $(this).data('cancel');
        var $confirm = $( 'div.metabox-reset-settings div.metabox-reset-checkbox' ),
            $text   = $confirm.is(':visible') ? $reset : $cancel;
        $( this ).text( $text );
        $( 'div.metabox-reset-settings div.metabox-reset-checkbox input' ).attr('checked', false);
        $confirm.toggle();
    });

} ) ( jQuery );
