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
    /*
     var approve_id = $("input[name='approver[" + key + "][approve_id]']")
     var document = $("input[name='approver[" + key + "][document]']")
     var user = $("input[name='approver[" + key + "][id]']");
     var remark = $("input[name='approver[" + key + "][remark]']");
     var position = $("input[name='approver[" + key + "][position]']");
     */

    var status = $("input[name='approver[" + key + "][status]']:checked");
    var url = $("input[name='approver[" + key + "][url]']");
    var data = $("#form-approve-" + key).serialize();
    console.log(status);


    if (!status.val()) {
        alert('โปรดเลือกสถานะ');
        status.focus();
        status.attr('required', true);
        return false;
    } else {
        if (confirm('คุณต้องการบันทึกข้อมูลใช่หรือไม่ ?')) {
            $.ajax({
                type: 'post',
                url: url.val(),
                dataType: 'json',
                data: data,
                success: function (rs) {
                    console.log(rs);
                    if (rs.success == 1) {
                        location.reload();
                    }
                }
            })

        }
    }


});