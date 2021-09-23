(function( $ ) {
 
    $( '#uep-booking-start-date' ).datepicker({
        dateFormat: 'MM dd, yy',
        onClose: function( selectedDate ){
            $( '#uep-booking-end-date' ).datepicker( 'option', 'minDate', selectedDate );
        }
    });
    $( '#uep-booking-end-date' ).datepicker({
        dateFormat: 'MM dd, yy',
        onClose: function( selectedDate ){
            $( '#uep-booking-start-date' ).datepicker( 'option', 'maxDate', selectedDate );
        }
    });
 
})( jQuery );