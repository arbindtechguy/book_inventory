<style>
.check-box {
    display: inline !important;
    padding-right: 10px;
}
label {
  font-size: 16px;

}
</style>
<h2 class="h2">Download the book information in xml or csv format</h2>
<form class="container mt-5 p-5" style="margin-top:50px;" method="POST" action="{{route('admin.download_books')}}">
@csrf
  <fieldset class="form-group">
    <div class="row">
      <legend class="col-form-label col-sm-2 pt-0">Download Format</legend>
      <div class="col-sm-10">
        <div class="form-check check-box">
          <input class="form-check-input" type="radio" name="export_type" id="export_type_CSV" value="csv" checked>
          <label class="form-check-label" for="export_type_CSV">
            CSV
          </label>
        </div>
        <div class="form-check check-box">
          <input class="form-check-input" type="radio" name="export_type" id="export_type_XML" value="xml">
          <label class="form-check-label" for="export_type_XML">
            XML
          </label>
        </div>
      </div>
    </div>
  </fieldset>
  <div class="form-group row">
    <div class="col-sm-2">Select item for export</div>
    <div class="col-sm-10">
      <div class="form-check">
        <div class="check-box">
          <input class="form-check-input export-check" type="checkbox" id="export_title" name="export_field[]" value="title">
          <label class="form-check-label text-left" for="export_title">
            Title
          </label>
        </div>
        <div class="check-box">
          <input class="form-check-input export-check" type="checkbox" id="export_author" name="export_field[]" value="author">
          <label class="form-check-label" for="export_author">
              Author
          </label>
        </div>
        <div class="check-box">
          <input class="form-check-input export-check" type="checkbox" id="export_genre" name="export_field[]" value="genre">
          <label class="form-check-label" for="export_genre">
              Genre
          </label>
        </div>
      </div>
    </div>
  </div>
  <div class="form-group row">
    <div class="col-sm-10">
      <button type="submit" id="export-books" class="btn btn-primary">Export</button>
    </div>
  </div>
</form>

<script>
  $('#export-books').click(function() {
    export_option_selected = false

    // check if atleast one export options are selected
    $('.export-check').each(function () {
      console.log($(this).prop("checked"));
      if ($(this).prop("checked")) {
        export_option_selected = true
      }
    })

    // if not selected alert the user to select atleast one
    if (!export_option_selected) {
      alert("Please Select atleast one item to export.")
      return false;
    }
    
  })
</script>