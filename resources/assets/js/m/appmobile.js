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
        //var el = document.getElementById('InputBarCode');
        //console.log(el.value);

        var frm = document.getElementById('formInputBarCode');
        frm.submit();    

    }, 1); // 1ms should be enough
}