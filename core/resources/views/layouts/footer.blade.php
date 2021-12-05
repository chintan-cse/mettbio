<!-- /.content-wrapper -->
 
<footer class="footer">
            <div class="footer-cs">
              <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">Copyright © 2020 <a href="#" target="_blank">MattBio</a>. All rights reserved.</span>
              <!-- <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center">Hand-crafted &amp; made with <i class="mdi mdi-heart text-danger"></i></span> -->
            </div>
          </footer>


  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->
<!-- Bootstrap 4 -->


<script src="{{ asset('js/moment.min.js') }}"></script>

<script src="{{ asset('js/bootstrap-datetimepicker.min.js') }}"></script>

<script src="{{ asset('css/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- Select2 -->
<script src="{{ asset('css/plugins/select2/js/select2.full.min.js') }}"></script>
<!-- Bootstrap4 Duallistbox -->
<script src="{{ asset('css/plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js') }}"></script>
<!-- InputMask -->
<script src="{{ asset('css/plugins/moment/moment.min.js') }}"></script>
<script src="{{ asset('css/plugins/inputmask/min/jquery.inputmask.bundle.min.js') }}"></script>
<!-- date-range-picker -->
<script src="{{ asset('css/plugins/daterangepicker/daterangepicker.js') }}"></script>
<!-- bootstrap color picker -->
<script src="{{ asset('css/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js') }}"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="{{ asset('css/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
<!-- Bootstrap Switch -->
<script src="{{ asset('css/plugins/bootstrap-switch/js/bootstrap-switch.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('js/adminlte.min.js') }}"></script>
<!-- AdminLTE for demo purposes -->

<!-- <script src="{{ asset('js/demo.js') }}"></script> -->
<script src="{{ asset('js/off-canvas.js') }}"></script>
<script src="{{ asset('js/misc.js') }}"></script>


<script src="{{ asset('js/file-upload.js') }}"></script>
		<!--<script src="{{ asset('js/hoverable-collapse.js') }}"></script>-->
    <script src="{{ asset('js/chart_new.js') }}"></script>

		<script src="{{ asset('js/todo.js') }}"></script>
		<script src="{{ asset('js/todolist.js') }}"></script>
		<script src="{{ asset('js/todolist.js') }}"></script>
		<!-- <script src="{{ asset('js/vendor.bundle.base.js') }}"></script> -->
<script src="{{ asset('css/plugins/summernote/summernote-bs4.min.js') }}"></script>
<!-- Page script -->
<script>
	$( "#createcitizen" ).submit(function() {
		$(".btncreatecitizen").attr('disabled','disabled');
	});
	
	$('#editcitizen').submit(function() {
		$("#btneditcitizen").attr('disabled','disabled');
	});
	
	$( "#createscheme" ).submit(function() {
		$("#btncreatescheme").attr('disabled','disabled');
	});
	
	$('#editscheme').submit(function() {
		$("#btneditscheme").attr('disabled','disabled');
	});
	  
	$('.textarea').summernote()
    //Initialize Select2 Elements
    $('.selectstyle').select2({
		placeholder: "Select Style",
		allowClear: true
	})
    $('.selectdoor').select2({
		placeholder: "Select Door Style",
		allowClear: true
	})

    //Initialize Select2 Elements
    $('.select2bs4').select2({
      theme: 'bootstrap4'
    })

    //Datemask dd/mm/yyyy
    $('#datemask').inputmask('dd/mm/yyyy', { 'placeholder': 'dd/mm/yyyy' })
    //Datemask2 mm/dd/yyyy
    $('#datemask2').inputmask('mm/dd/yyyy', { 'placeholder': 'mm/dd/yyyy' })
    //Money Euro
    $('[data-mask]').inputmask()

    //Date range picker
    $('#reservation').daterangepicker()
    // $('#select-date').datepicker()
    $('.datepicker').datepicker({
            dateFormat: 'mm/dd/yy', 
			changeMonth: true,
            changeYear: true,
        });

      
        

    // $('.dateaddpicker').datepicker();
    $('#due-date').datepicker({
            dateFormat: 'mm/dd/yy',           
        })
    $('#reminder_duedate').datepicker({
            dateFormat: 'mm/dd/yy',           
        })
    $('#visitdate').datepicker({
            dateFormat: 'mm/dd/yy',           
        })
    $('#followupdate').datepicker({
            dateFormat: 'mm/dd/yy',           
        })
    //Date range picker with time picker
    $('#reservationtime').daterangepicker({
      timePicker: true,
      timePickerIncrement: 30,
      locale: {
        format: 'MM/DD/YYYY hh:mm A'
      }
    })
    //Date range as a button
    $('#daterange-btn').daterangepicker(
      {
        ranges   : {
          'Today'       : [moment(), moment()],
          'Yesterday'   : [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
          'Last 7 Days' : [moment().subtract(6, 'days'), moment()],
          'Last 30 Days': [moment().subtract(29, 'days'), moment()],
          'This Month'  : [moment().startOf('month'), moment().endOf('month')],
          'Last Month'  : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        },
        startDate: moment().subtract(29, 'days'),
        endDate  : moment()
      },
      function (start, end) {
        $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'))
      }
    )

    //Timepicker
    $('#timepicker').datetimepicker({
      format: 'LT'
    })

    $('#datetimepicker3').datetimepicker({
                    format: 'LT'
                });

    $('#reminder_time').datetimepicker({
      format: 'LT'
    })
    
    //Bootstrap Duallistbox
    $('.duallistbox').bootstrapDualListbox()




    //Colorpicker
    $('.my-colorpicker1').colorpicker()
    //color picker with addon
    $('.my-colorpicker2').colorpicker()

    $('.my-colorpicker2').on('colorpickerChange', function(event) {
      $('.my-colorpicker2 .fa-square').css('color', event.color.toString());
    });
	
	$("input[data-bootstrap-switch]").each(function(){
		$(this).bootstrapSwitch('state', $(this).prop('checked'));
  });
  

  // $('#datetimepicker3').datetimepicker({
  //                   format: 'LT'
  //               });
                $('#demodatepicker').datepicker({
            dateFormat: 'dd/mm/yy',           
        });


        // document.addEventListener('DOMContentLoaded', function() {
  // var calendarEl = document.getElementById('calendar');

  // // var calendar = new FullCalendar.Calendar(calendarEl, {
    
    // // //NOTE MUST HAVE REFERENCE rrule javascript and plugin 'rrule', not rrPlugin like docs
    // // //if using scripts, not import/build method
    
    // // plugins: [ 'dayGrid','rrule'],
    // // timeZone: 'UTC',
    // // defaultView: 'dayGridMonth',
    // // events: [
    // // {     
      // // title: 'TEST #1 my recurring event',
      // // rrule:'DTSTART:20191111T103000Z\nRRULE:FREQ=WEEKLY;INTERVAL=1;UNTIL=20290601;BYDAY=TU,TH',      
      // // duration: '2:00'
    // // },
    // // {     
     // // title: 'TEST #2 my recurring event',
      // // backgroundColor: 'lime',
     // // rrule: {
        // // freq: 'weekly',
        // // interval: 2,
        // // byweekday: [ 'mo', 'fr' ],
        // // dtstart: '2019-11-11T10:30:00',
        // // until: '2029-06-01'
        // // },      
    // // duration: '01:00'
    // // }
    // // ]
    
    // // //'https://fullcalendar.io/demo-events.json'
  // // });
  
  
  // calendar.render();
// });
</script>