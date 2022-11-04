window.init = function () {

    window.dataGlobal = {
        dom: '<"html5buttons"B>lTfgitp',
        responsive: false,
        paging: true,
        iDisplayLength: 25,
        language: {
            buttons: {
                pdf: '<i class="fa fa-file-pdf-o"></i>',
                excel: '<i class="fa fa-file-excel-o"></i>',
                csv: 'CSV',
                print: '<i class="fa fa-print"></i>',
                copy: '<i class="fa fa-keyboard-o"></i>',
                copySuccess: {
                    1: "კოპირებულია ერთი ველი კლავიატურაზე",
                    _: "კოპირებულია %d ველი კლავიატურაზე"
                },
                copyTitle: '',
                copyKeys: 'გამოიყენე კლავიატურა'
            },
            processing:     "მუშავდება...",
            search:         "ძებნა&nbsp;:",
            lengthMenu:    "გამოჩნდეს _MENU_ ველი",
            info:           " _START_ - _END_  სულ _TOTAL_ ",
            infoEmpty:      "ინფორმაცია ვერ მოიძებნა",
            infoFiltered:   "(გადილტრულია _MAX_ ელემენტი)",
            infoPostFix:    "",
            loadingRecords: "ძებნა...",
            zeroRecords:    "ჩანაწერი ვერ მოიძებნა",
            emptyTable:     "ცარიელია",
            paginate: {
                first:      "პირველი",
                previous:   "წინა",
                next:       "შემდეგი",
                last:       "ბოლო"
            },
            aria: {
                sortAscending:  ": ზრდადობით დალაგება",
                sortDescending: ": კლებადობით დალაგება"
            },
        },

        buttons:
            [
                { extend: 'copy'},
                {extend: 'csv'},
                {extend: 'excel', title: 'Admin'},
                {extend: 'pdf', title: 'Admin'},
                {
                    extend: 'print',
                    customize: function (win)
                    {
                        $(win.document.body).addClass('white-bg');
                        $(win.document.body).css('font-size', '10px');

                        $(win.document.body).find('table')
                            .addClass('compact')
                            .css('font-size', 'inherit');
                    }
                }
            ],
        'columnDefs': [{
            'targets': 0,
            'className': 'dt-body-center',
            'render': function (data, type, full, meta){
                return '<input type="checkbox" class="onCheck" name="id[]" value="' + $('<div/>').text(data).html() + '">';
            }
        },
            {
                'targets': 'no-sort',
                'searchable':false,
                'orderable':false,
            }
        ],
        'order': [[1, 'desc']],

    };

    $('.sidebar-menu').tree();

    $('#example2').DataTable({
        'paging'      : true,
        'lengthChange': false,
        'searching'   : false,
        'ordering'    : true,
        'info'        : true,
        'autoWidth'   : false
    });

    $(document).on('expanded.pushMenu', triggerResize);
    $(document).on('collapsed.pushMenu', triggerResize);

    function triggerResize() {
        setTimeout(()=>{
            $(window).trigger("resize");  
        },110);
    }

};