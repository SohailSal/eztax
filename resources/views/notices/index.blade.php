@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="m-2">
            <div class="p-2">
                <h2>Notices</h2>
            </div>
            <div class="p-2">
                <a class="btn btn-primary" href="{{ route('notices.create') }}">Create New Notice</a>

                <form method="get" action="{{ route('notices') }}">
                @csrf
                <div class="float-right btn-group">
                    <input type="text" class="form-control" name="search" value="{{$search}}"/>
                    <button class="btn btn-sm btn-primary search">Search</button>
                </div>
                </form>
            </div>
        </div>
    </div>

    @if ($message = session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ $message }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <table class="table table-hover">
        <tr>
            <th width="10%">S.no.</th>
            <th>Client</th>
            <th>Tax Authority</th>
            <th>Receiving Date</th>
            <th width="20%">Actions</th>
        </tr>
        <?php $i = 0; ?>
        @foreach ($notices as $notice)
        <tr>
            <td>{{ ++$i }}</td>
            <td>{{ $notice->client_id }}</td>
            <td>{{ $notice->tax_authority }}</td>
            <td>{{ $notice->notice_path }}</td>
            <td class="d-flex justify-content-around">
                <a class="btn btn-secondary" href="{{ route('notices.edit', $notice->id) }}">Edit</a>
                <form action="{{ route('notices.destroy', $notice->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </table>
  
@endsection