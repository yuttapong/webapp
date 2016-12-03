/***************************************
 *  ตอบแบบสอบถาม
 */
$(".removeItemOther").on('click', function () {
    if (confirm("ต้องการลบรายการนี้ใชหรือไม่ ?")) {
        console.log('remove');
        $(this).parent().parent().remove();
    }
});
$(".addItemOther").on('click', function () {
    var title = $("#other-text");
    console.log('add :', title);
    var li = '<li class="row"><p>';
    li += '<div class="col-xs-11">';
    li += '<input type="hidden" name="other[other_id][]" class="form-control" value="0">';
    li += '<input type="text" name="other[response][]" class="form-control" style="color:green;" value="' + title.val() + '">';
    li += '</div>';
    li += '<div class="col-xs-1">';
    li += '<button type="button" class="remove-res btn btn-danger btn-xs" onclick="if(confirm(\'ต้องการลบรายการนี้ใชหรือไม่  ?\')){$(this).parent().parent().remove();}">x</button>';
    li + '</div>';
    li += '</p></li>';
    if (title.val()) {
        $(li).appendTo("#list-other");
        title.val("");
    }

});
/*
$('.choice-radio').on('click', function(el) {
    if (this.previous) {
        this.checked = false;
    }
    this.previous = this.checked;
});
*/
