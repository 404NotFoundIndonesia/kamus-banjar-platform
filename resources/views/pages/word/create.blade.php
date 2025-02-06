@extends('layouts.dashboard')

@section('content')
    <div class="card">
        <form action="{{ route('word.store') }}" method="POST">
            @csrf
            <div class="card-header d-flex justify-content-between">
                <h5>{{ __('menu.word') }}</h5>
                <div>
                    <a href="{{ route('word.index') }}"
                       class="btn btn-outline-secondary">{{ __('button.back') }}</a>
                    <button type="submit" class="btn btn-primary">{{ __('button.submit') }}</button>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="mb-3 col-md-12">
                        <x-forms.input-select2 name="letter" :options="$letters"/>
                    </div>
                    <div class="mb-3 col-md-12">
                        <x-forms.input name="word" autofocus="autofocus" />
                    </div>
                </div>
            </div>
        </form>
        <!-- /Account -->
    </div>
@endsection
