@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">About header</div>

                <div id="about" class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    About body!
                </div>

            </div>

            <button type="button" class="btn btn-secondary" onclick="click1()">Button1</button>
            <button type="button" class="btn btn-secondary" onclick="click2()">Button2</button>
            <button type="button" class="btn btn-secondary" onclick="click3()">Button3</button>

        </div>
    </div>
</div>

<script type="text/javascript">

  var externalForm = null;
  var timer = null;
  var counter = 0;

  function click1() {
    var aboutElement = document.getElementById("about");
    aboutElement.innerHTML = "click1 " + counter++;

    //externalForm.МетодВызываемыйИзJavaScript("Значение переменной conunter: " + counter++);
  }

  function click2() {
    var aboutElement = document.getElementById("about");
    aboutElement.innerHTML = "click2";
  }

  function click3() {
    var aboutElement = document.getElementById("about");
    aboutElement.innerHTML = "click3";

    externalForm = null;
  }

  function startTimer()
  {
    //alert(externalForm.ПеременнаяМодуля);

    timer = setInterval(function()
    {
      counter++;
      //externalForm.МетодВызываемыйИзJavaScript("Значение переменной conunter: " + counter++);
    }, 1000);
  }

  function stopTimer()
  {
    clearInterval(timer);
  }

</script>

@endsection
