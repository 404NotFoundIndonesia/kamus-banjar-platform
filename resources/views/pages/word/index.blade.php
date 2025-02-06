@extends('layouts.dashboard')

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <h5>{{ __('menu.word') }}</h5>
            <div>
                <a href="{{ route('word.create') }}" class="btn btn-primary">{{ __('button.new_feature', ['feature' => __('menu.word')]) }}</a>
                <div class="btn-group" role="group">
                    <button id="importWordButton" type="button" class="btn btn-info dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        {{ __('button.import_feature', ['feature' => __('menu.word')]) }}
                    </button>
                    <div class="dropdown-menu" aria-labelledby="importWordButton" style="">
                        <a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#importWordUrlModal">
                            {{ __('label.import_from_url') }}
                        </a>
                        <a class="dropdown-item" href="javascript:void(0);">
                            {{ __('label.import_file') }}
                        </a>
                    </div>
                </div>

                <div class="modal fade" id="importWordUrlModal" tabindex="-1" style="display: none;" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel1">{{ __('label.import_from_url') }}</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col mb-6">
                                        <x-forms.input name="url" />
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">{{ __('button.cancel') }}</button>
                                <button type="button" class="btn btn-primary">{{ __('button.submit') }}</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="table-responsive text-nowrap">
            <table class="table">
                <thead>
                <tr>
                    <th>{{ __('field.letter') }}</th>
                    <th>{{ __('field.word') }}</th>
                    <th>{{ __('field.source') }}</th>
                    <th style="width: 50px"></th>
                </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                @foreach($items as $item)
                    <tr>
                        <td class="text-capitalize fw-bold">{{ $item->letter }}</td>
                        <td>
                            <a href="{{ route('word.show', $item->word) }}">{{ $item->word }}</a>
                        </td>
                        <td>
                            <span>{{ $item->word_source }}</span>
                            <i class='bx bxs-badge-check {{ $item->verified ? 'text-primary' : '' }}'></i>
                        </td>
                        <td>
                            <div class="dropdown">
                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="bx bx-dots-vertical-rounded"></i></button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="{{ route('word.edit', $item->word) }}"><i class="bx bx-edit-alt me-1"></i> Edit</a>
                                    <form action="{{ route('word.destroy', $item->word) }}" method="post">
                                        @csrf
                                        @method('DELETE')
                                        <button class="dropdown-item" type="submit"><i class="bx bx-trash me-1"></i> Delete</button>
                                    </form>
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
