// address
$(".modal-add-address").on("click", function(e) {
    e.preventDefault();
    var header = $(this).data('header');
    var link = $(this).attr("href");
    console.log('add:', link);
    showModalCustomer(header, link)
});

$(".modal-edit-address").on("click", function(e) {
    e.preventDefault();
    var header = $(this).data('header');
    var link = $(this).attr("href");
    console.log('edit: ', link);
    showModalCustomer(header, link)
});

$('.modal-view-address').on('click', function(e) {
    e.preventDefault();
    var header = $(this).data('header');
    var link = $(this).attr('href');
    console.log('view-address : ', link);
    showModalCustomer(header, link)
});


// questionnaire
$('.modal-add-questionnaire').on('click', function(e) {
    e.preventDefault();
    var header = $(this).data('header');
    var link = $(this).attr('href');
    console.log('add-questionnaire : ', link);
    showModalCustomer(header, link)
});

// communication
$('.modal-add-communication').on('click', function(e) {
    e.preventDefault();
    var header = $(this).data('header');
    var link = $(this).attr('href');
    console.log('add-questionnaire : ', link);
    showModalCommunication(header, link)
});

$('.modal-edit-communication').on('click', function(e) {
    e.preventDefault();
    var header = $(this).data('header');
    var link = $(this).attr('href');
    console.log('add-questionnaire : ', link);
    showModalCommunication(header, link)
});

$('.modal-view-communication').on('click', function(e) {
    e.preventDefault();
    var header = $(this).data('header');
    var link = $(this).attr('href');
    console.log('add-questionnaire : ', link);
    showModalCommunication(header, link)
});

// person in charge
$(".modal-add-personincharge").on("click", function(e) {
    e.preventDefault();
    var header = $(this).data('header');
    var link = $(this).attr("href");
    console.log('add:', link);
    showModalPersonInCharge(header, link)

});

$(".modal-edit-personincharge").on("click", function(e) {
    e.preventDefault();
    var header = $(this).data('header');
    var link = $(this).attr("href");
    console.log('edit: ', link);
    showModalPersonInCharge(header, link);
});

$('.modal-view-personincharge').on('click', function(e) {
    e.preventDefault();
    var header = $(this).data('header');
    var link = $(this).attr('href');
    console.log('view-address : ', link);
    showModalPersonInCharge(header, link)
});

$('.yn-popup-link').on('click', function(e) {
    e.preventDefault();
    var h = $(this).data('height');
    var w = $(this).data('width');
    newwindow = window.open($(this).attr('href'), '', 'height=' + h + ',width=' + w);
    if (window.focus) { newwindow.focus() }
});


function showModalCustomer(header, link) {
    $('#modal-customer .modal-body').html('<i class="fa fa-refresh fa-spin fa-2x"></i> Loading...');
    $("#modal-customer .modal-header").html('<h3 class="modal-title"><i class="fa fa-home"></i> ' + header + '</h3>');
    $('#modal-customer .modal-body').load(link);
    $('#modal-customer').modal('show');
}


function showModalPersonInCharge(header, link) {
    $('#modal-personincharge .modal-body').html('<i class="fa fa-refresh fa-spin fa-2x"></i> Loading...');
    $("#modal-personincharge .modal-header").html('<h3 class="modal-title"><i class="fa fa-home"></i> ' + header + '</h3>');
    $('#modal-personincharge .modal-body').load(link);
    $('#modal-personincharge').modal('show');
}

function showModalCommunication(header, link) {
    $('#modal-communication .modal-body').html('<i class="fa fa-refresh fa-spin fa-2x"></i> Loading...');
    $("#modal-communication .modal-header").html('<h3 class="modal-title"><i class="fa fa-home"></i> ' + header + '</h3>');
    $('#modal-communication .modal-body').load(link);
    $('#modal-communication').modal('show');
}