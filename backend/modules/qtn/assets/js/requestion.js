/**
 * Created by Yuttapong Napikun on 9/7/2559.
 */

$(document).ready(function () {
    checkReasonRequestType();
    $(".reason-request").on('click',function () {
        checkReasonRequestType();
    });

    function checkReasonRequestType() {
        var resonText = $("#reason-request-text");
        var reason = $("input:radio[name='RcmAppManpower[reason_request]']:checked");
        resonText.prop('disabled', true);
        if (reason.val() == 100) {
            resonText.prop('disabled', false);
        } else {
            resonText.prop('disabled', true);
        }
    }

})




/***************************************
 * Responsibility - หน้าที่รับผิดชอบ
 */
function removeItem(vals){
	  //if (confirm("ต้องการลบรายการนี้ใชหรือไม่ ?")) {
	        $('#'+vals).val('del');
	        $('#d'+vals).remove();
	   // }
}
function  addItem (key,table){//QuestionChoice  //QuestionGroupChoice
	  var title = $("#"+key+"-text"); 
	   var row=parseInt($('#'+key+'-line').val())+1;
	    var li = '<li class="row"><p>';
	    li += '<div class="col-xs-7">';
	    li +='<input type="hidden" id="'+key+'_check_'+row+'" name="'+key+'-check['+row+']" value="add">';
	    li += '<input type="hidden" name="'+table+'[question_message_id]['+row+']" class="form-control" value="0">';
	    li += '<input type="text" name="'+table+'[name]['+row+']" class="form-control" style="color:green;" value="' + title.val() + '" required>';
	    li += '</div>';
	    li += '<div class="col-xs-2">';
	    li += '<input type="text" name="'+table+'[score]['+row+']" class="form-control" style="color:green;" value="0" required>';
	    li += '</div>';
	    li += '<div class="col-xs-2">';
	    li += '<select name="'+table+'[type]['+row+']" class="form-control" >';
		li += "<option value=\"choice\">choice</option>";
		li += "<option value=\"another\">อื่นๆ ระบบ..</option>";
		 li += "</select>";
	    li += '</div>';
	    li += '<div class="col-xs-1">';
	    li += '<button type="button" class="remove-res btn btn-danger btn-xs" onclick="if(confirm(\'ต้องการลบรายการนี้ใชหรือไม่  ?\')){$(this).parent().parent().remove();}">x</button>';
	    li + '</div>';
	    li += '</p></li>';
	    if (title.val() !='') { 
	    	$('#'+key+'-line').val(row);
	    	console.log('add :', title);
	        $(li).appendTo("#list-responsibility");
	        title.val("");
	    }
}

$(".add-question").on('click', function () {
	
    var title = $("#res-question");
    
   var row=parseInt($('#que-line').val())+1;
    var li = '<li class="row"><p>';
    li += '<div class="col-xs-7">';
    li +='<input type="hidden" id="que_check_'+row+'" name="que-check['+row+']" value="add">';

    li += '<input type="text" name="Question[name]['+row+']" class="form-control" style="color:green;" value="" required>';
    li += '</div>';
    li += '<div class="col-xs-4">';
    li += '<textarea rows="1" cols="50"  name="Question[content]['+row+']" class="form-control" >';
    li += '</textarea>';
    li += '</div>';
    li += '<div class="col-xs-1">';
    li += '<button type="button" class="remove-res btn btn-danger btn-xs" onclick="if(confirm(\'ต้องการลบรายการนี้ใชหรือไม่  ?\')){$(this).parent().parent().remove();}">x</button>';
    li + '</div>';
    li += '</p></li>';
   
    	$('#que-line').val(row);
    	console.log('add :', title);
        $(li).appendTo("#list-question");
        title.val("");
    

});
