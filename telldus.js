//För mytelldus

$(document).ready(function(){

	var rowCount = 1;
	$(function(){
		$("#addRow").click(function () {
			$('#topTable').append('<tr><td'id='rowCount' + rowCount><input type='textbox'/input> </td></tr>');
			rowCount++;
		});
	});
 });



