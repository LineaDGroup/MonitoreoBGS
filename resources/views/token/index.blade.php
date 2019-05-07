@extends("crudbooster::admin_template")
@section("content")

<h3> Su token es: </h3>
<div class="col-xs-12 row">
    <div class="col-xs-6" style="display: inline-block; vertical-align: middle; float: none; padding-left: 0px; ;padding-right: 10px;"> 
        <input id="token" style="width: 100%;" class="form-control disabled" type="text" value="{{ $token }}" disabled> </div>
    <div style="display: inline-block; vertical-align: middle; float: none;"> 
        <button id="copyToken" class="btn btn-primary" title="Copiar"> Copiar </button> 
    </div>
</div> 

@endsection

<script>

document.addEventListener("DOMContentLoaded", function(event) { 
  
    document.getElementById('copyToken').addEventListener('click',function() {
        var copyText = document.getElementById("token").value;
        if (!navigator.clipboard) {
            // fallbackCopyTextToClipboard(copyText);
            return;
        }
        navigator.clipboard.writeText(copyText).then(function() {
            // console.log('Copied!');
            document.getElementById('copyToken').innerText = 'Token Copiado!';
        }, function(err) {
            // console.error('Async: Could not copy text: ', err);
        });
    })

  });
</script>
