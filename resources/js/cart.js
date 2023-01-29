
    $('.item-quantity').on('change', function (e) {
   console.log(66);
        $.ajax({
            url: "/cart/" + $(this).data('id'), //data-id
            method: 'put',
            data: {
                quantity: $(this).val(),
                _token: csrf_token
            }
        });
    });
