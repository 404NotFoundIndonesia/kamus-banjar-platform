@extends('layouts.dashboard')

@section('content')
    <div class="card">
        <form action="{{ route('word.update', $item->word) }}" method="POST">
            @csrf
            @method('PUT')
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
                        <x-forms.input-select2 name="letter" :options="$letters" :value="$item->letter"/>
                    </div>
                    <div class="mb-3 col-md-12">
                        <x-forms.input name="word" autofocus="autofocus" :value="$item->word" />
                    </div>
                </div>
            </div>
        </form>
        <!-- /Account -->
    </div>
@endsection
