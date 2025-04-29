@extends('layouts.app')

@section('content')

<div class="card m-4">
  <div class="card-header">
    <h4>Create Client</h4>
  </div>
  <div class="card-body">
    @if ($errors->any())
      <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
        </ul>
      </div>
    @endif
    <form method="post" action="{{ route('notices.store') }}" class="prevent-multi">
        @csrf
        <div class="form-group">
            <label for="client_id">Client</label>
            <input type="text" class="form-control" name="client_id"/>
        </div>
        <div class="form-group">
            <label for="tax_authority">Tax Authority</label>
            <input type="text" class="form-control" name="tax_authority"/>
        </div>
        <div class="form-group">
            <label for="tax_office">Tax Office</label>
            <input type="text" class="form-control" name="tax_office"/>
        </div>
        <div class="form-group">
            <label for="notice_heading">Notice Heading</label>
            <input type="text" class="form-control" name="notice_heading"/>
        </div>
        <div class="form-group">
            <label for="tax_year">Tax Year</label>
            <input type="text" class="form-control" name="tax_year"/>
        </div>
        <div class="form-group">
            <label for="receiving_date">Receiving Date</label>
            <input type="text" class="form-control" name="receiving_date"/>
        </div>
        <button type="submit" class="btn btn-secondary m-2 prevent-multi-submit">Add Notice</button>
    </form>
  </div>
</div>

@endsection

@section('script')
<script>
$(document).ready(function() {
    $(document).on("keydown", ":input:not(textarea):not(:submit)", function(event) {
    if(event.keyCode == 13) {
        event.preventDefault();
        return false;
        }
    });
    $('.prevent-multi').on('submit', function(){
        $('.prevent-multi-submit').attr('disabled','true');
        return true;
    });
});
</script>
@endsection