@extends('template')
@section('content')
<style>
.modal-dialog {
    min-width: fit-content;
    padding: 25px;
}
.model-content {
    padding: 20px;
}
</style>
<div class="container">
    <div class="container-fluid">
        <a type="button" data-toggle="modal" href="#exportBookModal" class="btn btn-outline-primary"><i
                class="far fa-file-export"></i>Export All Books</a>
    </div>
    <h1 class="h3 text-center"> {{ $title }} </h1>
    <div class="table col-12">

        <div class="table-wrapper">
            <div class="table-title">
                <div class="row">
                    <div class="col-sm-6">
                        <h2>Books <b>List</b></h2>
                    </div>
                </div>
            </div>

            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                    @foreach ($sort_by as $key => $col)
                        <th>
                            <a href="{{route(Route::currentRouteName())}}?sort={{ $key }}&order={{ $col['order'] }}&k={{$query}}">
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
                            </a>
                        </th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach($books as $book)
                    <tr>
                        <td style="white-space:nowrap"><span class="d-md-none">Title : </span>{{ $book->title }}</td>
                        <td><span class="d-md-none">Author : </span>{{ $book->author }}</td>
                        <td style="white-space:nowrap"><span class="d-md-none">Genre : </span>{{ $book->genre }}</td>
                        <td><span class="d-md-none">Publisher : </span>{{ $book->publisher }}</td>
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

<!-- Export Modal HTML -->
<div id="exportBookModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            @include('common.export')
        </div>
    </div>
</div>
@endsection