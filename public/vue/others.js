//LOAD LIB EXTERNE
// $('#editor').trumbowyg();
// $('#datepicker-1').datepicker({
//   format : 'yyyy-mm-dd'
// });
// $('#datepicker-2').datepicker({
//     format : 'yyyy-mm-dd'
// });
//
// $('#datepicker-1').on('changeDate', function() {
//     $('#val-date-1').val(
//         $('#datepicker-1').datepicker('getFormattedDate')
//     );
// });
// $('#datepicker-2').on('changeDate', function() {
//     $('#val-date-2').val(
//         $('#datepicker-2').datepicker('getFormattedDate')
//     );
// });
var i = $('#user').val();
var d = $('#depot_user').val();
localStorage.setItem("u",i);
localStorage.setItem("dp",d);
// alert(i);



// <div id="datepicker" data-date="12/03/2012"></div>
// <input type="hidden" id="my_hidden_input">
//
// $('#datepicker').datepicker();
// $('#datepicker').on('changeDate', function() {
//     $('#my_hidden_input').val(
//         $('#datepicker').datepicker('getFormattedDate')
//     );
// });
