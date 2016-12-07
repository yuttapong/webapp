// address
$(".modal-add-address").on("click", function (e) {
    e.preventDefault();
    var header = $(this).data('header');
    var link = $(this).attr("href");
    console.log('add:', link);
    $("#modal-customer").modal("show").find(".modal-header").html('<h3 class="modal-title"><i class="fa fa-home"></i> ' + header + '</h3>');
    $("#modal-customer").modal("show").find(".modal-body").load(link);
});

$(".modal-edit-address").on("click", function (e) {
    e.preventDefault();
    var header = $(this).data('header');
    var link = $(this).attr("href");
    var body = $("#modal-customer .modal-body").html('กำลังโหลด............');
    console.log('edit: ', link);
    $("#modal-customer").modal("show").find(".modal-header").html('<h3 class="modal-title"><i class="fa fa-home"></i> ' + header + '</h3>');
    $("#modal-customer").modal("show").find(".modal-body").load(link);
});

$('.modal-view-address').on('click', function (e) {
    e.preventDefault();
    var header = $(this).data('header');
    var link = $(this).attr('href');
    var body = $("#modal-customer .modal-body").html('กำลังโหลด............');
    console.log('view-address : ', link);
    $("#modal-customer").modal("show").find(".modal-header").html('<h3 class="modal-title"><i class="fa fa-home"></i> ' + header + '</h3>');
    $('#modal-customer').modal('show').find('.modal-body').load(link);
});


// questionnaire
$('.modal-add-questionnaire').on('click', function (e) {
    e.preventDefault();
    var header = $(this).data('header');
    var link = $(this).attr('href');
    var body = $("#modal-customer .modal-body").html('กำลังโหลด............');
    console.log('add-questionnaire : ', link);
    $('#modal-customer').modal('show').find('.modal-header').html('<h3 class="modal-title"><i class="fa fa-book"></i> ' + header + '</h3>');
    $('#modal-customer').modal('show').find('.modal-body').load(link);
});


// communication
$('.modal-add-communication').on('click', function (e) {
    e.preventDefault();
    var header = $(this).data('header');
    var link = $(this).attr('href');
    var body = $("#modal-customer .modal-body").html('กำลังโหลด............');
    console.log('add-questionnaire : ', link);
    $('#modal-customer').modal('show').find('.modal-header').html('<h3 class="modal-title"><i class="fa fa-commenting"></i> ' + header + '</h3>');
    $('#modal-customer').modal('show').find('.modal-body').load(link);
});

$('.modal-view-communication').on('click', function (e) {
    e.preventDefault();
    var header = $(this).data('header');
    var link = $(this).attr('href');
    var body = $("#modal-customer .modal-body").html('กำลังโหลด............');
    console.log('add-questionnaire : ', link);
    $('#modal-customer').modal('show').find('.modal-header').html('<h3 class="modal-title"><i class="fa fa-commenting"></i> ' + header + '</h3>');
    $('#modal-customer').modal('show').find('.modal-body').load(link);
});



// address
$(".modal-add-personincharge").on("click", function (e) {
    e.preventDefault();
    var header = $(this).data('header');
    var link = $(this).attr("href");
    console.log('add:', link);
    $("#modal-customer").modal("show").find(".modal-header").html('<h3 class="modal-title"><i class="fa fa-home"></i> ' + header + '</h3>');
    $("#modal-customer").modal("show").find(".modal-body").load(link);
});

$(".modal-edit-personincharge").on("click", function (e) {
    e.preventDefault();
    var header = $(this).data('header');
    var link = $(this).attr("href");
    var body = $("#modal-customer .modal-body").html('กำลังโหลด............');
    console.log('edit: ', link);
    $("#modal-customer").modal("show").find(".modal-header").html('<h3 class="modal-title"><i class="fa fa-home"></i> ' + header + '</h3>');
    $("#modal-customer").modal("show").find(".modal-body").load(link);
});

$('.modal-view-personincharge').on('click', function (e) {
    e.preventDefault();
    var header = $(this).data('header');
    var link = $(this).attr('href');
    var body = $("#modal-customer .modal-body").html('กำลังโหลด............');
    console.log('view-address : ', link);
    $("#modal-customer").modal("show").find(".modal-header").html('<h3 class="modal-title"><i class="fa fa-home"></i> ' + header + '</h3>');
    $("#modal-customer").modal("show").find(".modal-body").load(link);
});