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

	 $('#'+vals).val('del');
	 $('#d'+vals).remove();
}
function  addItem (key,from){//QuestionChoice  //QuestionGroupChoice
	 var title = $("#"+key+"-text"); 
	 var row=parseInt($('#'+key+'-line').val())+1;
	 var li ='';
	 if(key=='pos' || key=='res'){
	    li += '<li class="row"><p>';
	    li += '<div class="col-xs-11">';
	    li +='<input type="hidden" id="'+key+'_check_'+row+'" name="'+key+'-check['+row+']" value="add">';
	    li += '<input type="hidden" name="'+from+'[option_id]['+row+']" class="form-control" value="0">';
	    li += '<input type="text" name="'+from+'[title]['+row+']" class="form-control" style="color:green;" value="' + title.val() + '" required>';
	    li += '</div>';
	    li += '<div class="col-xs-1">';
	    li += '<button type="button" class="remove-res btn btn-danger btn-xs" onclick="if(confirm(\'ต้องการลบรายการนี้ใชหรือไม่  ?\')){$(this).parent().parent().remove();}">x</button>';
	    li + '</div>';
	    li += '</p></li>';
	    if (title.val() !='') { 
	    	$('#'+key+'-line').val(row);
	    	console.log('add :', title);
	        $(li).appendTo("#list-"+key);
	        title.val("");
	    }
	}
}


