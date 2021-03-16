@if(session()->has('success'))
    <div class="alert alert-success mb-2 alert-dismissible fade show" role="alert">
        <strong>{{session()->get('success')}}</strong>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <ion-icon name="close-outline"></ion-icon>
        </button>
    </div>
@endif
@if(session()->has('error'))
    <div class="alert alert-danger mb-2 alert-dismissible fade show" role="alert">
        <strong>{{session()->get('error')}}</strong>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <ion-icon name="close-outline"></ion-icon>
        </button>
    </div>
@endif