@extends('layouts.dashboard')

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <h5>{{ __('menu.word') }}</h5>
            <div>
                <a href="{{ route('word.index') }}"
                   class="btn btn-outline-secondary">{{ __('button.back') }}</a>
            </div>
        </div>
        <div class="card-body">
            {{ $item->word }}
        </div>
    </div>
@endsection
