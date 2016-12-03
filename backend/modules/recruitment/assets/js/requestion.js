/**
 * Created by Yuttapong Napikun   on 9/7/2559.
 */

$(document).ready(function () {
    checkReasonRequestType();

    $(".reason-request").on('click', function () {
        checkReasonRequestType();
    });

    function checkReasonRequestType() {
        var resonText = $("#reason-request-text");
        var reason = $("input:radio[name='RcmAppManpower[reason_request]']:checked");
        resonText.prop('disabled', true);
        if (reason.val() == '-1' ) {
            resonText.prop('disabled', false);
        } else {
            resonText.prop('disabled', true);
        }
    }

})


/***************************************
 * Responsibility - หน้าที่รับผิดชอบ
 */
$(".remove-res").on('click', function () {
    if (confirm("ต้องการลบรายการนี้ใชหรือไม่ ?")) {
        console.log('remove');
        $(this).parent().parent().remove();
    }
});
$(".add-res").on('click', function () {
    var title = $("#res-text");
    console.log('add :', title);
    var li = '<li class="row"><p>';
    li += '<div class="col-xs-11">';
    li += '<input type="hidden" name="dataRes[id][]" class="form-control" value="0">';
    li += '<input type="text" name="dataRes[title][]" class="form-control" style="color:green;" value="' + title.val() + '">';
    li += '</div>';
    li += '<div class="col-xs-1">';
    li += '<button type="button" class="remove-res btn btn-danger btn-xs" onclick="if(confirm(\'ต้องการลบรายการนี้ใชหรือไม่  ?\')){$(this).parent().parent().remove();}">x</button>';
    li + '</div>';
    li += '</p></li>';
    if (title.val()) {
        $(li).appendTo("#list-responsibility");
        title.val("");
    }

});

/***************************************
 * Property - คุณสมบัติผู้สมัคร
 */
$(".remove-prop").on('click', function () {
    if (confirm("ต้องการลบรายการนี้ใชหรือไม่ ?")) {
        console.log('remove');
        $(this).parent().parent().remove();
    }
});

$(".add-prop").on('click', function () {
    var title = $("#prop-text");
    console.log('add :', title);
    var li = '<li class="row"><p>';
    li += '<div class="col-xs-11">';
    li += '<input type="hidden" name="dataProp[id][]" class="form-control" value="0">';
    li += '<input type="text" name="dataProp[title][]" class="form-control" style="color:green;" value="' + title.val() + '">';
    li += '</div>';
    li += '<div class="col-xs-1">';
    li += '<button type="button" class="remove-prop btn btn-danger btn-xs" onclick="if(confirm(\'ต้องการลบรายการนี้ใชหรือไม่  ?\')){$(this).parent().parent().remove();}">x</button>';
    li + '</div>';
    li += '<p></li>';
    if (title.val()) {
        $(li).appendTo("#list-property");
        title.val("");
    }

});


/***************************************
 * Benefit - สวัสดิการ
 */
$(".remove-prop").on('click', function () {
    if (confirm("ต้องการลบรายการนี้ใชหรือไม่ ?")) {
        console.log('remove');
        $(this).parent().parent().remove();
    }
});

$(".add-prop").on('click', function () {
    var title = $("#benefit-text");
    console.log('add :', title);
    var li = '<li class="row"><p>';
    li += '<div class="col-xs-11">';
    li += '<input type="hidden" name="dataBenefit[id][]" class="form-control" value="0">';
    li += '<input type="text" name="dataBenefit[title][]" class="form-control" style="color:green;" value="' + title.val() + '">';
    li += '</div>';
    li += '<div class="col-xs-1">';
    li += '<button type="button" class="remove-benefit btn btn-danger btn-xs" onclick="if(confirm(\'ต้องการลบรายการนี้ใชหรือไม่  ?\')){$(this).parent().parent().remove();}">x</button>';
    li + '</div>';
    li += '</p></li>';
    if (title.val()) {
        $(li).appendTo("#list-benefit");
        title.val("");
    }

});