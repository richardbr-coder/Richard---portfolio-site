/**
 * File customizer-preview.js.
 *
 * Theme Customizer enhancements for a better user experience.
 *
 * Contains handlers to make Theme Customizer preview reload changes asynchronously.
 *
 * @package Elan
 */

( function( $ ) {

	// Site title and description.
	wp.customize( 'blogname', function( value ) {
		value.bind( function( to ) {
			$( '.site-title a' ).text( to );
		} );
	} );

	wp.customize( 'blogdescription', function( value ) {
		value.bind( function( to ) {
			$( '.site-description' ).text( to );
		} );
	} );
} )( jQuery );

! function(t, n) {
    n.sectionConstructor["anchor"] = n.Section.extend({
        attachEvents: function() {},
        isContextuallyActive: function() {
            return !0
        }
    })
}(jQuery, wp.customize);