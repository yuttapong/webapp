$(".noomy-link-approve").on('click', function (e) {
    var user = $(this).data("user");
    var id = $(this).attr("id");
    var el = $('#' + id);
    var modal = $($(this).data('target'));
    console.log('modal : ', id);
    //modal.find('.modal-body').html('noom');
    /*
     $.ajax({
     type:'post',
     url: '$this->url',
     dataType:'json',
     data:{id:id, status:status},
     success: function(rs) {
     console.log('status : ' , rs.active);
     if(rs.active == 1){
     el.removeClass("label-danger").addClass("label-success");
     el.html("$active");
     el.data("status",rs.active);
     } else {
     el.removeClass("label-success").addClass("label-danger");
     el.html("$inactive");
     el.data("status",rs.active);
     }
     }
     })
     */

});

$(".noomy-btn-approve").on('click', function (e) {
    var key = $(this).data("key");
    var user = $("input[name='approver[" + key + "][id]']").val();
    var status = $("input[name='approver[" + key + "][status]']:checked");
    var remark = $("input[name='approver[" + key + "][remark]']").val();
    console.log('ap : ', user + '/' + status);
    if(! status.val()) {
        alert('โปรดเลือกสถานะ');
        status.focus();
        status.attr('required',true);
        return false;
    }else{
        if(confirm('คุณต้องการบันทึกข้อมูลใช่หรือไม่ ?')) {
            console.log('save success');
        }
    }
    /*
     $.ajax({
     type:'post',
     url: '$this->url',
     dataType:'json',
     data:{id:id, status:status},
     success: function(rs) {
     console.log('status : ' , rs.active);
     if(rs.active == 1){
     el.removeClass("label-danger").addClass("label-success");
     el.html("$active");
     el.data("status",rs.active);
     } else {
     el.removeClass("label-success").addClass("label-danger");
     el.html("$inactive");
     el.data("status",rs.active);
     }
     }
     })
     */

});