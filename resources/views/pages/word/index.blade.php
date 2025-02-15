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
                        <a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#importWordFileModal">
                            {{ __('label.import_file') }}
                        </a>
                    </div>
                </div>

                <div class="modal fade" id="importWordUrlModal" tabindex="-1" style="display: none;" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <form action="{{ route('word.import') }}" method="post">
                            @csrf
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
                                    <button type="submit" class="btn btn-primary">{{ __('button.submit') }}</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="modal fade" id="importWordFileModal" tabindex="-1" style="display: none;" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <form action="{{ route('word.import') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel1">{{ __('label.import_from_url') }}</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col mb-6">
                                            <div>
                                                <label for="formFile" class="form-label">{{ __('field.file') }} (.json)</label>
                                                <input class="form-control @error('file') is-invalid @enderror" type="file" name="file" accept=".json,application/json">
                                                <span class="error invalid-feedback">{{ $errors->first('file') }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">{{ __('button.cancel') }}</button>
                                    <button type="submit" class="btn btn-primary">{{ __('button.submit') }}</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
        <div class="table-responsive text-nowrap">
            <table class="table">
                <thead>
                <tr>
                    <th style="width: 50px">
                        <input
                            class="form-check-input"
                            type="checkbox" id="select-all-checkbox">
                    </th>
                    <th>{{ __('field.letter') }}</th>
                    <th>{{ __('field.word') }}</th>
                    <th>{{ __('field.source') }}</th>
                    <th style="width: 50px"></th>
                </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                @foreach($items as $item)
                    <tr>
                        <td>
                            <input
                                class="form-check-input row-checkbox"
                                data-id="{{ $item->id }}" type="checkbox"
                                value="{{ $item->word }}">
                        </td>
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
                                    <a class="dropdown-item" href="{{ route('word.edit', $item->word) }}"><i class="bx bx-edit-alt me-1"></i>
                                        {{ __('button.edit') }}</a>
                                    <form action="{{ route('word.destroy', $item->word) }}" method="post">
                                        @csrf
                                        @method('DELETE')
                                        <button class="dropdown-item" type="submit"><i class="bx bx-trash me-1"></i>
                                            {{ __('button.delete') }}</button>
                                    </form>
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

        <div class="card-body">
            {!! $items->links() !!}
        </div>
    </div>

    <div class="card position-fixed bottom-0 start-50 translate-middle-x mb-3 w-50" id="bulk-action-card" style="display: none">
        <form action="{{ route('word.destroy.bulk') }}" method="post" id="destroy-bulk-form">
            @method('DELETE')
            @csrf
            <div class="px-4 py-3 d-flex justify-content-between">
                <div>
                    <span id="how-much-selected"></span> {{ __('label.selected') }}
                </div>
                <div>
                    <input type="hidden" name="id" value="0">
                    <button class="btn btn-sm btn-outline-danger" type="submit">{{ __('button.delete') }}</button>
                </div>
            </div>
        </form>
    </div>
@endsection

@push('script')
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const checkboxes = document.querySelectorAll(".row-checkbox");
            const selectAll = document.getElementById("select-all-checkbox");
            const actionCard = document.getElementById('bulk-action-card');
            const selectedLength = document.getElementById('how-much-selected');
            const bulkDeleteForm = document.getElementById('destroy-bulk-form');

            function updateSelect () {
                const anyChecked = Array.from(checkboxes).some(checkbox => checkbox.checked);
                actionCard.style.display = anyChecked ? "block" : "none";
                if (anyChecked) {
                    selectedLength.innerText = Array.from(checkboxes).filter(checkbox => checkbox.checked).length?.toString();
                }
            }

            checkboxes.forEach(checkbox => {
                checkbox.addEventListener("change", updateSelect);
            });

            selectAll.addEventListener("change", function () {
                checkboxes.forEach(checkbox => checkbox.checked = selectAll.checked);
                updateSelect();
            });

            bulkDeleteForm.addEventListener('submit', function (e) {
                const ids = Array.from(checkboxes).filter(checkbox => checkbox.checked).map(c => c.dataset.id);
                this.querySelector('input[name=id]').value = ids.join(',');
            });
        });
    </script>
@endpush
