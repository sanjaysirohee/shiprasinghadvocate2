 <footer class="footer">Copyright © 2025 Veloxn Private Limited. All Rights Reserved.</footer>
 </div>

 <script src="assets/node_modules/jquery/jquery-3.2.1.min.js"></script>
 <script src="assets/node_modules/popper/popper.min.js"></script>
 <script src="assets/node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
 <script src="dist/js/perfect-scrollbar.jquery.min.js"></script>
 <script src="dist/js/waves.js"></script>
 <script src="dist/js/sidebarmenu.js"></script>
 <script src="dist/js/custom.min.js"></script>
 <script src="assets/node_modules/raphael/raphael-min.js"></script>
 <script src="assets/node_modules/morrisjs/morris.min.js"></script>
 <script src="assets/node_modules/jquery-sparkline/jquery.sparkline.min.js"></script>
 <script src="assets/node_modules/toast-master/js/jquery.toast.js"></script>
 <script src="assets/node_modules/peity/jquery.peity.min.js"></script>
 <script src="assets/node_modules/peity/jquery.peity.init.js"></script>
 <script src="dist/js/dashboard1.js"></script>
 <script src="assets/node_modules/sticky-kit-master/dist/sticky-kit.min.js"></script>
 <script src="dist/js/pages/custom.min"></script>
 <script src="assets/node_modules/inputmask/dist/min/jquery.inputmask.bundle.min.js"></script>
 <script src="dist/js/pages/mask.init.js"></script>
 <script src="assets/node_modules/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
 <script type="text/javascript">
     // Date Picker
     jQuery('.mydatepicker').datepicker();
 </script>

 <script src="assets/node_modules/datatables.net/js/jquery.dataTables.min.js"></script>
 <script src="cdn.datatables.net/buttons/1.5.1/js/dataTables.buttons.min.js"></script>
 <script src="cdn.datatables.net/buttons/1.5.1/js/buttons.flash.min.js"></script>
 <script src="cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
 <script src="cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/pdfmake.min.js"></script>
 <script src="cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/vfs_fonts.js"></script>
 <script src="cdn.datatables.net/buttons/1.5.1/js/buttons5.min.js"></script>
 <script src="cdn.datatables.net/buttons/1.5.1/js/buttons.print.min.js"></script>
 <!-- end - This is for export functionality only -->

 <script>
     $(function() {
         $('#myTable').DataTable();
         $(function() {
             var table = $('#example').DataTable({
                 "columnDefs": [{
                     "visible": false,
                     "targets": 2
                 }],
                 "order": [
                     [2, 'asc']
                 ],
                 "displayLength": 25,
                 "drawCallback": function(settings) {
                     var api = this.api();
                     var rows = api.rows({
                         page: 'current'
                     }).nodes();
                     var last = null;
                     api.column(2, {
                         page: 'current'
                     }).data().each(function(group, i) {
                         if (last !== group) {
                             $(rows).eq(i).before('<tr class="group"><td colspan="5">' + group + '</td></tr>');
                             last = group;
                         }
                     });
                 }
             });
             // Order by the grouping
             $('#example tbody').on('click', 'tr.group', function() {
                 var currentOrder = table.order()[0];
                 if (currentOrder[0] === 2 && currentOrder[1] === 'asc') {
                     table.order([2, 'desc']).draw();
                 } else {
                     table.order([2, 'asc']).draw();
                 }
             });
         });
     });
     $('#example23').DataTable({
         dom: 'Bfrtip',
         buttons: [
             'copy', 'csv', 'excel', 'pdf', 'print'
         ]
     });
     $('.buttons-copy, .buttons-csv, .buttons-print, .buttons-pdf, .buttons-excel').addClass('btn btn-primary mr-1');
 </script>



 ` n

 <script>
     $(function() {

         $('.summernote').summernote({
             height: 350, // set editor height
             minHeight: null, // set minimum height of editor
             maxHeight: null, // set maximum height of editor
             focus: false // set focus to editable area after initializing summernote
         });

         $('.inline-editor').summernote({
             airMode: true
         });

     });

     window.edit = function() {
             $(".click2edit").summernote()
         },
         window.save = function() {
             $(".click2edit").summernote('destroy');
         }
 </script>
 <script src="https://cdn.ckeditor.com/4.11.1/standard-all/ckeditor.js"></script>
 <!-- <script>
     // We need to turn off the automatic editor creation first.
     CKEDITOR.disableAutoInline = true;

     CKEDITOR.replace('editor1');
 </script> -->

 <script>
 CKEDITOR.config.extraPlugins = 'justify';
 CKEDITOR.replace('editor1', {
  height: 300,
  filebrowserUploadUrl: "/upload.php",
  filebrowserUploadMethod: "form"
 });
</script>
 </body>

 </html>