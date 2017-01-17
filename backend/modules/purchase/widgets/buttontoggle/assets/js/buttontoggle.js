$(".noomy-buttontoggle-item").on('click', function (e) {
    var id =  $(this).data("id");
    var status = $(this).data("status");
    var target = $(this).attr("id");
    if(status==0){
        $(this).removeClass("label-danger").addClass("label-success");
        $(this).text("Active");
        $(this).data("status",1);
    }
    if(status==1){
        $(this).removeClass("label-success").addClass("label-danger");
        $(this).text("Inactive");
        $(this).data("status",0);
    }
});