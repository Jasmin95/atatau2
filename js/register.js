$(document).ready(function () {

    $("#form-registrazione").on("submit", function () {
    var data = $(this).serialize();
    $.ajax({
        type: "POST",
        url: "/atatau2/manager/register.php",
        data: data,
        dataType: "html",
        success: function (esito) {
           alert(esito);
            window.location.href = "board.php";
        },
        error: function (xhr, status, error) {
            alert("Impossibile connettersi");
        }

    });
    return false;
});
});