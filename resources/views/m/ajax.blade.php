@extends('layouts.mobile')

@section('content')
    <p>
        Терминал ajax
    </p>

    <p id="test">
        Терминал ajax1
    </p>

    <button onclick="someFuncSync()">AJAX</button>

    <form action="{{ action('m\HomeController@submitbarcode') }}" id="formInputBarCode" method="post">
        <input id="InputBarCode" name="BarCode" title="Barcode" size="23" />
        <input type="hidden" name="_token" value="{{ csrf_token() }}" >
        <input type="submit" value=".." />
    </form>
@endsection

@section('scripts')

    var inputForm = document.getElementById("formInputBarCode");
    inputForm.addEventListener('submit', function(e) {
        e.preventDefault();

        inputForm.reset();
        //var keyBarCode = inputForm.elements["BarCode"].value;
        //
        //if (keyBarCode == "") {
        //    return false;
        //}

        //var currentDate = new Date();
        //var barcode = {"barcode": keyBarCode,"date": currentDate};

        var xmlhttp;
        if (window.XMLHttpRequest)
        {
            xmlhttp=new XMLHttpRequest();
        }
        else
        {
            xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
        }

        xmlhttp.open("POST","/m/ajaxpostresult",true);
        xmlhttp.send("123456789");

        console.log(2);

        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState != 4)
                return false;

            if (xmlhttp.status != 200) {
                // обработать ошибку
                document.getElementById("test").innerHTML = 'ошибка: ' + (xmlhttp.status ? xmlhttp.statusText : 'запрос не удался');
                return;
            }
            document.getElementById("test").innerHTML = xmlhttp.responseText;
        }

        return false;
    });

    function someFunc(){
        //var p = document.getElementById("test");
        //p.innerHTML = "qwerqwrqwr";

        var xmlhttp;
        if (window.XMLHttpRequest)
            {// код для IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp=new XMLHttpRequest();
        }
        else
        {// код для IE6, IE5
            xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.open("GET","/m/ajaxresult",false); // false - используем СИНХРОННУЮ передачу
        xmlhttp.send();
        //document.getElementById("test").innerHTML=xmlhttp.responseText;
        document.getElementById("test").innerHTML=xmlhttp.responseText;
    }

    function someFuncSync(){
        var xmlhttp;
        if (window.XMLHttpRequest)
        {// код для IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp=new XMLHttpRequest();
        }
        else
        {// код для IE6, IE5
            xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.open("GET","/m/ajaxresult",true);
        xmlhttp.send();

        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState != 4) return;

            if (xmlhttp.status != 200) {
                // обработать ошибку
                document.getElementById("test").innerHTML = 'ошибка: ' + (xmlhttp.status ? xmlhttp.statusText : 'запрос не удался');
                return;
            }
            document.getElementById("test").innerHTML = xmlhttp.responseText;
        }
    }

@endsection