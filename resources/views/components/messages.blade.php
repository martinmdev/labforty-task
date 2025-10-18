@if(Session::has('status'))
<div id='message-status-div' class="alert alert-info alert-dismissible">
    {{ Session::get('status') }}

    <button type="button" class="close" data-dismiss="alert" aria-label="Close"
            onclick="document.getElementById('message-status-div').remove()"
    >
        <span aria-hidden="true">&times;</span>
    </button>
</div>
@endif
