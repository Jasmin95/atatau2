$(document).ready(function () {

    $("#form-registrazione").on("submit", function () {
    var data = $(this).serialize();
    $.ajax({
        type: "POST",
        url: "/manager/register.php",
        data: data,
        dataType: "html",
        success: function (esito) {
            alert(esito);
            window.location.href = "board.php";
        },
        error: function (xhr, status, error) {
            alert("male");
        }

    });
    return false;
});
});