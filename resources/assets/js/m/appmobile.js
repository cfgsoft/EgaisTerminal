// Write your JavaScript code.

function setFocus() {
    //var el = document.querySelector('#InputBarCode');
    var el = document.getElementById('InputBarCode');
    if (el !== null)
    {
        el.focus();

        el.onblur = function () {
            setTimeout(function () {
                el.focus();
            });
        };
    }
    //document.getElementById("test").innerHTML="11111111111";
}

function setPasteInputBarCode() {    
    setTimeout(function () {
        var frm = document.getElementById('formInputBarCode');
        if (frm.onsubmit === null) {
            frm.submit();
        } else {
            frm.onsubmit();
        }

    }, 1); // 1ms should be enough
}