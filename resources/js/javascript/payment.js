
function createPayment() {

    let _url = `payments/subscribe`;
    var form = $("#payment-form");

    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: _url,
        method:'post',
        data: form.serialize(),
        dataType:'json',
        success: function(data) {
          console.log(data)


      }


    })
}


$('#search').click(function(){
    $('#search').off();
    $(this).addClass('spinner spinner-white spinner-right');
});
