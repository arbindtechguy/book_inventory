@include('common.search_bar')
<link rel="stylesheet" href="{{ asset('assets/css/dashboard.css') }}?{{ env('VERSION') }}">

<script>
    $(document).ready(function () {
        // Activate tooltip
        $('[data-toggle="tooltip"]').tooltip();

        // Select/Deselect checkboxes
        var checkbox = $('table tbody input[type="checkbox"]');
        $("#selectAll").click(function () {
            if (this.checked) {
                checkbox.each(function () {
                    this.checked = true;
                });
            } else {
                checkbox.each(function () {
                    this.checked = false;
                });
            }
        });
        checkbox.click(function () {
            if (!this.checked) {
                $("#selectAll").prop("checked", false);
            }
        });
    });

</script>
<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">

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

<div class="container">
    <div class="container-fluid">
        <a type="button" data-toggle="modal" href="#exportBookModal" class="btn btn-outline-primary">
        </i>Export All Books</a>
    </div>
    <div class="table col-12">
        <div class="table-wrapper">
            <div class="table-title">
                <div class="row">
                    <div class="col-sm-6">
                        <h2>Manage <b>Books</b></h2>
                    </div>
                    <div class="col-sm-6">
                        <a href="#addBookModal" class="btn btn-success" data-toggle="modal"><i
                                class="material-icons"></i> <span>Add New Book</span></a>
                        <form method="post" action="{{ route('admin.delete_books') }}">
                            @csrf
                            <input type="hidden" name="books_id" id="books_id" value="">
                            <button id="deleteMultipleBooks" class="btn btn-danger hide"><i
                                class="material-icons"></i> <span>Delete</span></button>
                        </form>
                    </div>
                </div>
            </div>
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>
                            <span class="checkbox-master">
                                <input type="checkbox" id="selectAll">
                                <label for="selectAll"></label>
                            </span>
                        </th>

                        @foreach ($sort_by as $key => $col)
                        <th>
                            <a href="{{route('admin.index')}}?sort={{ $key }}&order={{ $col['order'] }}&k={{$query}}">
                                {{ $col['name'] }}
                                <!-- sort icons -->
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-caret-down" viewBox="0 0 16 16">
                                    @if (!$col['active'])
                                    <path d="M3.204 5h9.592L8 10.481 3.204 5zm-.753.659 4.796 5.48a1 1 0 0 0 1.506 0l4.796-5.48c.566-.647.106-1.659-.753-1.659H3.204a1 1 0 0 0-.753 1.659z"/>
                                    @elseif ($col['active'] && $col['order'] == 'asc')
                                    <path d="M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z"/>
                                    @else
                                    <path d="m7.247 4.86-4.796 5.481c-.566.647-.106 1.659.753 1.659h9.592a1 1 0 0 0 .753-1.659l-4.796-5.48a1 1 0 0 0-1.506 0z"/>
                                    @endif
                                </svg>
                            </a></th>
                        @endforeach
                            
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($books as $book)
                    <tr>
                        <td>
                            <span class="checkbox-master">
                                <input class="book-check" type="checkbox" id="checkbox-{{ $book->id }}" name="options[]"
                                    value="{{ $book->id }}">
                                <label for="checkbox-{{$book->id}}"></label>
                            </span>
                        </td>
                        <td><span class="d-md-none">Title : </span>{{ $book->title }}</td>
                        <td><span class="d-md-none">Author : </span>{{ $book->author }}</td>
                        <td><span class="d-md-none">Genre : </span>{{ $book->genre }}</td>
                        <td><span class="d-md-none">Publisher : </span>{{ $book->publisher }}</td>
                        <td><span class="d-md-none">Last updated : </span>{{ $book->updated_at }}</td>
                        <td>
                            <a href="{{ route('admin.form_edit_book', ['id' => $book->id]) }}" class="edit"
                                data-toggle="modal"><i class="material-icons" data-toggle="tooltip"
                                    data-original-title="Edit"></i></a>

                            <a href="{{ route('admin.delete_book', ['id' => $book->id, 'title' => $book->title ]) }}"
                                data-title="{{ $book->title }}" class="delete confirm-delete" data-toggle="modal"><i
                                    class="material-icons" data-toggle="tooltip" title=""
                                    data-original-title="Delete"></i></a>
                        </td>
                    </tr>

                    @endforeach


                </tbody>
            </table>
            <div class="clearfix">
                <div class="hint-text">Showing <b>{{ count($books) }}</b> out of <b>{{ $books->total() }}</b> entries
                </div>
                {{$books->appends($_GET)->links() }}
            </div>
        </div>
    </div>
</div>


<!-- Edit Modal HTML -->
<div id="addBookModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            @include('admin.register_book')
        </div>
    </div>
</div>

<!-- Export Modal HTML -->
<div id="exportBookModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            @include('common.export')
        </div>
    </div>
</div>


<script>
    // delete confirmation
    $('.confirm-delete').click(function () {
        title = $(this).data('title')
        if (!confirm("Book: [" + title + "] will be deleted ?")) {
            return false;
        }
    })

    // book check event handle
    $('.book-check').click(function() {
        update_multi_delete_visibility(false)
    })
    $('#selectAll').click(function() {
        update_multi_delete_visibility(!$(this).prop('checked'))
    })

    // multiple delte book click handle
    $('#deleteMultipleBooks').click(function () {
        book_checked_count = get_book_checked_count()

        // alert if books are not seleted
        if (book_checked_count === 0) {
            alert('Please select books to delete')
            return false
        }

        if (confirm('Total: ' + book_checked_count + ' book will be deleted, Are you sure?')) {
            return true
        }
        return false
        
    })

    // get selected book count and update input value 
    // parameters if all selected master checkbox
    function get_book_checked_count() {
        books_id_to_delete = []
        $('.book-check').each(function() {
            if ($(this).prop('checked')) {
                books_id_to_delete.push($(this).val())
            }
        })

        // update the value of id for form input
        $('#books_id').val(books_id_to_delete)

        return books_id_to_delete.length
    }

    function update_multi_delete_visibility(all_checked) {
        books_id_to_delete = []
        $('.book-check').each(function() {
            if ($('#selectAll').prop('checked')) {
                books_id_to_delete.push($(this).val())
            }
            else if ($(this).prop('checked') && !all_checked) {
                books_id_to_delete.push($(this).val())
            }
        })

        // update the value of id for form input
        $('#books_id').val(books_id_to_delete)
        // update multiple delete button visibiity
        if (books_id_to_delete.length < 1) {
            $('#deleteMultipleBooks').addClass('hide')
        }
        else {
            $('#deleteMultipleBooks').removeClass('hide')
        }
    }

</script>
