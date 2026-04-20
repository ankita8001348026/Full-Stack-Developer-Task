/***********************************************Print Validation Messages Start*****************************************************/
function hide_error_msg(formId, key) {
    var checkID = document.getElementById(key + "_err");

    if (checkID) {
        // document.getElementById(`${formId} ${key}_err`).innerHTML = "";
        $(`#${formId} #${key}_err`).html("");
    }
}
/***********************************************Print Validation Messages End*****************************************************/

/***********************************************Validate Number Key Start*****************************************************/
function validateNumberKey(event) {
    return event.charCode >= 48 && event.charCode <= 57;
}
/***********************************************Validate Number Key End*****************************************************/

/***********************************************Print Validation Messages Start*****************************************************/
function printErrorMsg(formId, msg) {
    $.each(msg, function (key, value) {
        // document.getElementById(`${formId} ${key}_err`).innerHTML = value;
        $(`#${formId} #${key}_err`).html(value);
    });
}
/***********************************************Print Validation Messages End*****************************************************/
function successMessage(message) {
    Swal.fire({
        title: "Success",
        text: message,
        icon: "success",
    });
}

function errorMessage(message) {
    Swal.fire({
        icon: "error",
        title: "Oops...",
        text: message,
    });
}
