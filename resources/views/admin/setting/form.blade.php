@extends('layouts.app')

@section('scripts')
    <script src="{{ asset('js/jquery.dform-1.1.0.js') }}" defer></script>
@endsection

@section('title')
    Settings
@endsection


@section('content')
    <form method="post" action="{{$setting->id ? url('admin/setting/' . $setting->id) : url('admin/setting')}}" enctype="multipart/form-data">
        @csrf
        @if ($setting->id)
            @method('PATCH')
        @else
            @method('POST')
        @endif
        <div class="form-group">
            <label for="title">Publishing Form Email</label>
            <input type="text"
                   class="form-control"
                   name="publishing_form_email"
                   placeholder="Title"
                   value="{{$setting->data['publishing_form_email']}}"
            >
            {{--<small id="nameHelp" class="form-text text-muted">Name of game category</small>--}}
        </div>
        <div class="form-group">
            <label for="title">Contact Us Form Email</label>
            <input type="text"
                   class="form-control"
                   name="contact_us_email"
                   placeholder="Title"
                   value="{{$setting->data['contact_us_email']}}"
            >
            {{--<small id="nameHelp" class="form-text text-muted">Name of game category</small>--}}
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
@endsection