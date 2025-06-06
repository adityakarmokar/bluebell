"use strict";
$(function () {
    var a = $(".datatables-ajax"),
        t = $(".dt-column-search"),
        n = $(".dt-advanced-search"),
        e = $(".dt-responsive"),
        d = $(".start_date"),
        c = $(".end_date"),
        o = $(".flatpickr-range");
    function l(a, t) {
        var e, l, o, s, r;
        5 == a
            ? ((e = d.val()),
              (l = c.val()),
              "" !== e &&
                  "" !== l &&
                  (($.fn.dataTableExt.afnFiltering.length = 0),
                  n.dataTable().fnDraw(),
                  (o = a),
                  (s = e),
                  (r = l),
                  $.fn.dataTableExt.afnFiltering.push(function (a, t, e) {
                      var t = i(t[o]),
                          l = i(s),
                          n = i(r);
                      return (l <= t && t <= n) || (l <= t && "" === n && "" !== l) || (t <= n && "" === l && "" !== n);
                  })),
              n.dataTable().fnDraw())
            : n.DataTable().column(a).search(t, !1, !0).draw();
    }
    o.length &&
        o.flatpickr({
            mode: "range",
            dateFormat: "m/d/Y",
            orientation: isRtl ? "auto right" : "auto left",
            locale: { format: "MM/DD/YYYY" },
            onClose: function (a, t, e) {
                var l;
                new Date();
                null != a[0] && ((l = moment(a[0]).format("MM/DD/YYYY")), d.val(l)), null != a[1] && ((l = moment(a[1]).format("MM/DD/YYYY")), c.val(l)), $(o).trigger("change").trigger("keyup");
            },
        }),
        ($.fn.dataTableExt.afnFiltering.length = 0);
    var s,
        i = function (a) {
            a = new Date(a);
            return a.getFullYear() + "" + ("0" + (a.getMonth() + 1)).slice(-2) + ("0" + a.getDate()).slice(-2);
        };
    a.length &&
        a.dataTable({
            processing: !0,
            ajax: assetsPath + "json/ajax.php",
            dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6 d-flex justify-content-center justify-content-md-end"f>><"table-responsive"t><"row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
        }),
        t.length &&
            ($(".dt-column-search thead tr").clone(!0).appendTo(".dt-column-search thead"),
            $(".dt-column-search thead tr:eq(1) th").each(function (a) {
                var t = $(this).text();
                $(this).html('<input type="text" class="form-control" placeholder="Search ' + t + '" />'),
                    $("input", this).on("keyup change", function () {
                        s.column(a).search() !== this.value && s.column(a).search(this.value).draw();
                    });
            }),
            (s = t.DataTable({
                ajax: assetsPath + "json/table-datatable.json",
                columns: [{ data: "full_name" }, { data: "email" }, { data: "post" }, { data: "city" }, { data: "start_date" }, { data: "salary" }],
                orderCellsTop: !0,
                dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6 d-flex justify-content-center justify-content-md-end"f>><"table-responsive"t><"row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
            }))),
        n.length &&
            n.DataTable({
                dom: "<'row'<'col-sm-12'tr>><'row'<'col-sm-12 col-md-6'i><'col-sm-12 col-md-6 dataTables_pager'p>>",
                ajax: assetsPath + "json/table-datatable.json",
                columns: [{ data: "" }, { data: "full_name" }, { data: "email" }, { data: "post" }, { data: "city" }, { data: "start_date" }, { data: "salary" }],
                columnDefs: [
                    {
                        className: "control",
                        orderable: !1,
                        targets: 0,
                        render: function (a, t, e, l) {
                            return "";
                        },
                    },
                ],
                orderCellsTop: !0,
                responsive: {
                    details: {
                        display: $.fn.dataTable.Responsive.display.modal({
                            header: function (a) {
                                return "Details of " + a.data().full_name;
                            },
                        }),
                        type: "column",
                        renderer: function (a, t, e) {
                            e = $.map(e, function (a, t) {
                                return "" !== a.title ? '<tr data-dt-row="' + a.rowIndex + '" data-dt-column="' + a.columnIndex + '"><td>' + a.title + ":</td> <td>" + a.data + "</td></tr>" : "";
                            }).join("");
                            return !!e && $('<table class="table"/><tbody />').append(e);
                        },
                    },
                },
            }),
        $("input.dt-input").on("keyup", function () {
            l($(this).attr("data-column"), $(this).val());
        }),
        e.length &&
            e.DataTable({
                ajax: assetsPath + "json/table-datatable.json",
                columns: [{ data: "" }, { data: "full_name" }, { data: "email" }, { data: "post" }, { data: "city" }, { data: "start_date" }, { data: "salary" }, { data: "age" }, { data: "experience" }, { data: "status" }],
                columnDefs: [
                    {
                        className: "control",
                        orderable: !1,
                        targets: 0,
                        searchable: !1,
                        render: function (a, t, e, l) {
                            return "";
                        },
                    },
                    {
                        targets: -1,
                        render: function (a, t, e, l) {
                            var e = e.status,
                                n = {
                                    1: { title: "Current", class: "bg-label-primary" },
                                    2: { title: "Professional", class: " bg-label-success" },
                                    3: { title: "Rejected", class: " bg-label-danger" },
                                    4: { title: "Resigned", class: " bg-label-warning" },
                                    5: { title: "Applied", class: " bg-label-info" },
                                };
                            return void 0 === n[e] ? a : '<span class="badge ' + n[e].class + '">' + n[e].title + "</span>";
                        },
                    },
                ],
                destroy: !0,
                dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6 d-flex justify-content-center justify-content-md-end"f>>t<"row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
                responsive: {
                    details: {
                        display: $.fn.dataTable.Responsive.display.modal({
                            header: function (a) {
                                return "Details of " + a.data().full_name;
                            },
                        }),
                        type: "column",
                        renderer: function (a, t, e) {
                            e = $.map(e, function (a, t) {
                                return "" !== a.title ? '<tr data-dt-row="' + a.rowIndex + '" data-dt-column="' + a.columnIndex + '"><td>' + a.title + ":</td> <td>" + a.data + "</td></tr>" : "";
                            }).join("");
                            return !!e && $('<table class="table"/><tbody />').append(e);
                        },
                    },
                },
            }),
        setTimeout(() => {
            $(".dataTables_filter .form-control").removeClass("form-control-sm"), $(".dataTables_length .form-select").removeClass("form-select-sm");
        }, 200);
});
