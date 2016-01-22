@extends('layout')
@section('content')
<div class="row">
        <div class="col-md-3">
            <h1>{!! $flyer->street !!} </h1>
            <h1> {!! $flyer->price !!} </h1>

            <hr>
            <div class="description"> {!! nl2br($flyer->description)  !!} </div>
        </div>

        <div class="col-md-9">
            @foreach($flyer->photos as $photo)
                <form method="POST" action="/photos/{{$photo->id}}">
                    {!! csrf_field() !!}

                    <input type="hidden" name="_method" value="DELETE">
                    <button type="submit">Delete</button>

                </form>
                <a href="/{{ $photo->path }}"  data-lity>
               <img src="/{{ ($photo->thumbnail_path)  }}" alt="">
                </a>
            @endforeach

                <hr>
                {{--@if ($user && $user->owns($flyer))--}}
                <form id="addPhotosForm" action="{{ route('store_photo_path',[$flyer->zip, $flyer->street]) }}" method="POST" class="dropzone">
                    {{ csrf_field() }}
                </form>
                {{--@endif--}}
        </div>
    </div>


@stop
@section('scripts.footer')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/4.2.0/dropzone.js"></script>
    <script>
        Dropzone.options.addPhotosForm = {
            paramName    :'photo',
            maxFilesize  :3,
            acceptedFiles: '.jpg, .png, .jpeg, .bmp'
        }
    </script>
@stop