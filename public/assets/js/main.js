$(function () {

    $('#startOrder').on('click', function() {

        alert('Hello');

        form = $("#startOrtderForm")[0];

        var url = $(this).attr("startOrderUrl");

        alert(url);

        $.ajax({
            url: url,
            type: "post",
            dataType: "json",
            data: new FormData(form),
            processData: false,
            contentType: false,
            success: function(data) {
                console.log(data);
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
               console.log(XMLHttpRequest);
            }
        });
    });

});