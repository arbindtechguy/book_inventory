<style>

    .modal-content, .modal-dialog {
        min-width: fit-content;
        padding: 20px;
        margin: auto;
    }

    .book-container {
        max-width: 500px;
        margin: 50px auto;
        text-align: left;
        font-family: sans-serif;
    }

    #book-register-form {
        border: 1px solid lightgray;
        background: #ecf5fc;
        padding: 40px 50px 45px;
    }

    .form-control:focus {
        border-color: #000;
        box-shadow: none;
    }

    label {
        font-weight: 600;
    }

    .error {
        color: red;
        font-weight: 400;
        display: block;
        padding: 6px 0;
        font-size: 14px;
    }

    .form-control.error {
        border-color: red;
        padding: .375rem .75rem;
    }
    .required {
        color: red;
    }

</style>


<div class="container mt-5" id="book-container">

    <!-- Success message -->
    @if(Session::has('flash_message'))
    <div class="alert alert-success">
        {{Session::get('flash_message')}}
    </div>
    @endif

    <!-- Error message -->
    @if(Session::has('flash_message_error'))
    <div class="alert alert-error">
        {{Session::get('flash_message_error')}}
    </div>
    @endif

    <h1 class="h3">Fill the book details and click on save button to store a book</h1>
    <form method="post" action="{{ route('admin.store_book') }}" id="book-register-form">

        @csrf

        <div class="form-group">
            <label>Title <span class="required">*</span></label>
            <input type="text" class="form-control {{ $errors->has('title') ? 'error' : '' }}" name="title" id="title"
                @isset($bookInfo) value="{{ $bookInfo->title }}" @endisset 
            >

            <!-- Title Error -->
            @if ($errors->has('title'))
            <div class="error">
                {{ $errors->first('title') }}
            </div>
            @endif
        </div>

        <div class="form-group">
            <label>Author <span class="required">*</span></label>
            <input type="text" class="form-control {{ $errors->has('author') ? 'error' : '' }}" name="author"
                id="author" @isset($bookInfo) value="{{ $bookInfo->author }}" @endisset
            >

            <!-- Author Error -->
            @if ($errors->has('author'))
            <div class="error">
                {{ $errors->first('author') }}
            </div>
            @endif
        </div>

        <div class="form-group">
            <label>Genre</label>
            <input type="text" class="form-control {{ $errors->has('genre') ? 'error' : '' }}" name="genre" id="genre"
                @isset($bookInfo) value="{{ $bookInfo->genre }}" @endisset 
            >

            @if ($errors->has('genre'))
            <div class="error">
                {{ $errors->first('genre') }}
            </div>
            @endif
        </div>

        <div class="form-group">
            <label>Publisher</label>
            <input type="text" class="form-control {{ $errors->has('publisher') ? 'error' : '' }}" name="publisher"
                id="publisher"
                @isset($bookInfo) value="{{ $bookInfo->publisher }}" @endisset
            >

            @if ($errors->has('publisher'))
            <div class="error">
                {{ $errors->first('publisher') }}
            </div>
            @endif
        </div>
        <p class="text-info">Field with (</Fieldset><span class="required"> * </span>) marks are required.</p> 
        <div class="col-6 text-right">
            <input type="submit" name="send" value="Save" class="btn btn-info">
            <input type="button" name="cancel" value="Cancel" class="btn btn-danger">

            <!-- hidden input for update check-->
            @isset($bookInfo)
                <input type="hidden" name="update" value="1">
                <input type="hidden" name="book_id" value="{{$bookInfo->id}}">
            @endisset
        </div>

    </form>
</div>

<script>
    $('input[name="cancel"]').click(function () {
        if (confirm("Do you want to cancel?")) {
            window.location.replace("/admin");
        }
    })

</script>
