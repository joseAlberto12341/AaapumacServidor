(function($) {
  'use strict';
  $(function() {
    // $('#order-listing thead tr')
    //   .clone(true)
    //   .addClass('filters')
    //   .appendTo('#order-listing thead');
    
    var table = $('#order-listing').DataTable({
      orderCellsTop: true,
      fixedHeader: true,
      "aLengthMenu": [
        [5, 10, 15, -1],
        [5, 10, 15, "Todos"]
      ],
      "iDisplayLength": 10,
      // initComplete: function() {
      //   var api = this.api();

      //   api
      //     .columns()
      //     .eq(0)
      //     .each(function(colIdx) {
      //       var cell = $('.filters th').eq(
      //         $(api.column(colIdx).header()).index()
      //       );
      //       var title = $(cell).text();
      //       $(cell).html('<input type="text" placeholder="'+ title + '" />');

      //       $(
      //         'input',
      //         $('.filters th').eq($(api.column(colIdx).header()).index())
      //       )
      //         .off('keyup change')
      //         .on('change', function(e) {

      //           $this.attr('title', $this.val());
      //           var regexr = '({search})'; //$(this).parents('th').find('input').val();

      //           var cursorPosition = this.selectionStart;

      //           api
      //             .column(colIdx)
      //             .search(
      //               this.value != ''
      //                 ? regexr.replace('{search}', '(((' + this.value + ')))')
      //                 : '',
      //               this.value != '',
      //               this.value == ''
      //             )
      //             .draw();
      //         })
      //         .on('keyup', function(e) {
      //           e.stopPropagation();

      //           $(this).trigger('change');
      //           $(this)
      //             .focus()
      //             .setSelectionRange(cursorPosition, cursorPosition);
      //         });
      //     });
      // },
      "language": {
        url: '//cdn.datatables.net/plug-ins/2.0.1/i18n/es-ES.json',
        search: ""
      }
    });
    // $('#order-listing').each(function() {
    //   var datatable = $(this);
    //   // SEARCH - Add the placeholder for Search and Turn this into in-line form control
    //   var search_input = datatable.closest('.dataTables_wrapper').find('div[id$=_filter] input');
    //   search_input.attr('placeholder', 'Buscar');
    //   search_input.removeClass('form-control-sm');
    //   // LENGTH - Inline-Form control
    //   var length_sel = datatable.closest('.dataTables_wrapper').find('div[id$=_length] select');
    //   length_sel.removeClass('form-control-sm');
    // });
  });
})(jQuery);