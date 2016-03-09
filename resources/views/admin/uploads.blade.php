@extends('layouts.admin')

@section('title', 'AdminCP - Uploads')

@section('content')
    @if($uploads->count())
        <div class="text-center">
            <h2>{{ $user->name }}'{{ ends_with($user->name, 's') ?: 's' }} Uploads</h2>
            <p>Total: {{ $uploads->count() }} ({{ Helpers::formatBytes($uploads->sum('size')) }})</p>
        </div>
        <hr>
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>Name</th>
                    <th>URL</th>
                    <th>Size</th>
                    <th>SHA1</th>
                    <th>Uploaded</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach($uploads as $upload)
                    <tr>
                        <td>{{ $upload->original_name }}</td>
                        <td>
                            <a href="{{ config('upste.upload_url') . $upload->name }}">{{ config('upste.upload_url') . $upload->name }}</a>
                        </td>
                        <td>{{ Helpers::formatBytes($upload->size) }}</td>
                        <td>{{ $upload->hash }}</td>
                        <td>{{ $upload->updated_at }}</td>
                        <td>
                            <ul class="list-unstyled list-inline list-noborder">
                                <li>
                                    <form action="{{ route('admin.uploads.delete', ['id' => $upload->id]) }}"
                                          method="POST">
                                        <button type="submit" class="btn btn-xs btn-danger">Delete</button>
                                        {!! csrf_field() !!}
                                    </form>
                                </li>
                            </ul>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <div class="text-center">
            {!! $uploads->render() !!}
        </div>
    @else
        <div class="message-area">
            <div class="alert alert-warning alert-important">{{ $user->name }} doesn't have any uploads!</div>
        </div>
    @endif
@stop