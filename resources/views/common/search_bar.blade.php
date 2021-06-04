<style>
body {
  font-family: Arial;
}



form.search input[type=text] {
  padding: 10px;
  font-size: 17px;
  border: 1px solid grey;
  float: left;
  background: #f1f1f1;
  min-width: 80%;
}

form.search button {
  float: left;
  width: 20%;
  padding: 10px;
  background: #2196F3;
  color: white;
  font-size: 17px;
  border: 1px solid grey;
  border-left: none;
  cursor: pointer;
}

form.search button:hover {
  background: #0b7dda;
}

form.search::after {
  content: "";
  clear: both;
  display: table;
}
form.search {
    width: 64%;
    margin: auto;
    padding: 10px;
}
section.search {
  display: contents;
  margin-bottom: 50px;
}

@media only screen and (max-width: 760px) {
  form.search {
    width: 100%;
    margin: auto;
  }
}
</style>

<section class="col-sm-12 m-auto search">
@if(isset($public_page))
    <form class="search m-auto" action="{{route('search_books')}}" id="search-form">
@endisset
    <form class="search m-auto" action="{{route('admin.search_books')}}" id="search-form">
        <input type="text" required placeholder="Search for a book by title or author..." name="k" id="query" 
          @isset($query) value="{{ $query }}" @endisset
        >
        <button type="submit"><i class="fa fa-search"></i></button>
    </form>
</section>