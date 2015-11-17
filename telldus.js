//För mytelldus

$(document).ready(function(){

	var rowCount = 1;
	$(function(){
		$("#addRow").click(function () {
			var createRowText = "<tr align=center>"
			createRowText += '<td><input type="textbox" id="deviceID_" +rowCount value="" name="deviceId" /></td>';
			createRowText += '<td><input type="textbox" id="deviceName" +rowCount value="" name="deviceName" /></td>';


			createRowText +="</tr>";

			$('#topTable').append(createRowText);
			rowCount++;
		});
	});
 });



