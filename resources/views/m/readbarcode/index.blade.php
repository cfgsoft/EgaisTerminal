@extends('layouts.mobile')

@section('content')
    <h1>Отсканируйте штрих код</h1>
    <h6><a href="{{ route('m.home.index') }}" >0-Выход</a></h6>

    <form action="{{ action('m\ReadBarCodeController@submitbarcode') }}" id="formInputBarCode" method="post">
        <input id="InputBarCode" name="BarCode" title="Barcode" size="22" />
        <input type="hidden" name="_token" value="{{ csrf_token() }}" >
        <input type="submit" value=".." />
    </form>

    <div id="list">
    @foreach ($barcode as $item)
        <h6> {{ $item->barcode }} </h6>
        @isset($item->f2regid)
            <h5> {{ $item->f2regid }} </h5>
        @endisset
        <h6> {{ $item->created_at }} </h6>
        <hr>
    @endforeach
    </div>

@endsection

@section('scripts')

    function addBarcode(data) {
        var listElement = document.getElementById("list");

        var elhr = document.createElement('hr');
        listElement.insertBefore(elhr, listElement.firstChild);

        var elCreateAt = document.createElement('h6');
        elCreateAt.innerHTML = data.created_at;
        listElement.insertBefore(elCreateAt, listElement.firstChild);

        if (data.f2regid !== undefined ) {
            var elF2 = document.createElement('h5');
            elF2.innerHTML = data.f2regid;
            listElement.insertBefore(elF2, listElement.firstChild);
        }

        var elBarcode = document.createElement('h6');
        elBarcode.innerHTML = data.barcode;
        listElement.insertBefore(elBarcode, listElement.firstChild);
    }

    var inputForm = document.getElementById("formInputBarCode");
    inputForm.onsubmit = function(){
        var keyBarCode = inputForm.elements["BarCode"].value;
        if (keyBarCode === "") {
            return false;
        }
        if (keyBarCode === "0") {
            return true;
        }
        var keyToken = inputForm.elements["_token"].value;

        inputForm.reset();

        var xmlhttp;
        if (window.XMLHttpRequest)
        {
            xmlhttp=new XMLHttpRequest();
        }
        else
        {
            xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
        }

        xmlhttp.open("POST","/m/readbarcode/submitbarcodeajax",true);
        xmlhttp.setRequestHeader('Content-Type', "application/json; charset=utf-8");
        xmlhttp.setRequestHeader('X-CSRF-TOKEN', keyToken);

        var json = JSON.stringify({
            BarCode: keyBarCode
        });

        xmlhttp.send(json);

        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState != 4) return false;

            if (xmlhttp.status != 201) {
                // обработать ошибку
                //document.getElementById("test").innerHTML = 'ошибка: ' + (xmlhttp.status ? xmlhttp.statusText : 'запрос не удался');
                //console.log('ошибка: ' + xmlhttp.status);
                //console.log(xmlhttp);
                return false;
            }

            var localResult = JSON.parse(xmlhttp.responseText);
            addBarcode(localResult);
        }

        return false;
    };

@endsection

