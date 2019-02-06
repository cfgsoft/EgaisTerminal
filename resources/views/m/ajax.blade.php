@extends('layouts.mobile')

@section('content')
    <p>
        Терминал ajax
    </p>

    <p id="test">
        Терминал ajax1
    </p>
    <p id="test1">
        Терминал ajax1
    </p>

    <button onclick="someFuncSync()">AJAX</button>

    <form action="{{ action('m\HomeController@submitbarcode') }}" id="formInputBarCode" method="post"">
        <input id="InputBarCode" name="BarCode" title="Barcode" size="22" />
        <input type="hidden" name="_token" value="{{ csrf_token() }}" >
        <input type="submit" value=".." />
    </form>

    <form action="{{ action('m\HomeController@submitbarcode') }}" id="formInputBarCode1" method="post">
        <input id="InputBarCode" name="BarCode" title="Barcode" size="22" />
        <input type="hidden" name="_token" value="{{ csrf_token() }}" >
        <input type="submit" value=".." />
    </form>

    <h2>Добро пожаловать в мир jQuery</h2>
    <button id="btn1">jQuery</button>
    <button id="btn2" onclick="alert('Мир JavaScript'); ">JavaScript</button>

    <button>Загрузить</button>
    <div id="news"><h3>Нет новостей</h3></div>
    <script type="text/javascript">
      $(function(){
        $('button').click(function(){
          $('#news').load('/m/ajaxresult');
        });
      });
    </script>

@endsection

@section('scripts')

    $(function(){
        $("#btn1").click(function(){
            $(this).css('background-color', 'red');
            alert('Мир jQuery');
        });
    });

    //IE 5 не подерживает addEventListener
    //inputForm.addEventListener('submit', function(e) {
    //    e.preventDefault();

    function someFuncSubmit(e)
    {
        e.preventDefault();
        return false;
    }

    var inputForm = document.getElementById("formInputBarCode1");
    inputForm.onsubmit = function(e){
        //e.preventDefault();//IE не работает, необходимо return false
        inputForm.reset();

        document.getElementById("test1").innerHTML = 'new444';

        return false;
    }


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

        //console.log(2);

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

            var localResult = JSON.parse(xmlhttp.responseText);

            document.getElementById("test").innerHTML = xmlhttp.responseText;

            document.getElementById("test").innerHTML = localResult.id;

            /*создаем новую запись*/
            var h6 = document.createElement('h6');
            h6.innerHTML = localResult.barcode;
            document.body.appendChild(h6);

            h6.appendChild(document.createTextNode('111111111111111'));
        }
    }

@endsection