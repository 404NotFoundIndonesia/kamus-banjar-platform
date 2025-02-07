@extends('layouts.dashboard')

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <div class="d-flex flex-column">
                <h5 class="mb-0 fw-bold">{{ $item->word }}</h5>
                <div>
                    <span class="fst-italic" id="syllable">{{ $item->data['syllables'] ?? $item->word }}</span>
                    <button type="button" class="ms-2 btn rounded-pill btn-icon btn-xs btn-outline-primary">
                        <span class="tf-icons bx bx-volume-full bx-xs"></span>
                    </button>
                </div>
            </div>
            <div>
                <a href="{{ route('word.index') }}"
                   class="btn btn-outline-secondary">{{ __('button.back') }}</a>
            </div>
        </div>
        <div class="card-body">
            @foreach($item->data['meanings'] as $meaning)
                @foreach($meaning['definitions'] as $definition)
                    @if($loop->first)
                        <abbr class="fst-italic text-danger cursor-pointer me-2" data-bs-toggle="tooltip"
                              data-bs-offset="0,4" data-bs-placement="top"
                              data-bs-html="true" title="{{ $partOfSpeech[$definition['partOfSpeech'] ?? 'n'] ?? '' }}">
                            {{ $definition['partOfSpeech'] ?? 'n' }}
                        </abbr>
                    @endif
                    <span class="me-2">
                        @if(count($meaning['definitions']) > 1)
                            <span class="badge badge-center rounded-pill bg-label-primary">
                                {{ $loop->iteration }}
                            </span>
                        @endif
                        {{ $definition['definition'] ?? $item->word }}
                        @isset($definition['examples'])
                            ;
                            @foreach($definition['examples'] as $example)
                                <u class="fst-italic text-warning cursor-pointer me-1" data-bs-toggle="tooltip"
                                   data-bs-offset="0,4" data-bs-placement="top"
                                   data-bs-html="true" title="{{ $example['id'] ?? '' }}">
                                    {{ $example['bjn'] }}
                                </u>
                            @endforeach
                        @endisset
                    </span>
                @endforeach
                <br>
            @endforeach

            @isset($item->data['derivatives'])
                <div class="mt-3 d-flex align-items-center">
                    <div style="width: 25px"><hr></div>
                    <h6 class="my-0 text-secondary">{{ __('field.derivative') }}</h6>
                    <div class="flex-grow-1"><hr></div>
                </div>
                <div class="d-flex flex-column">
                    @foreach($item->data['derivatives'] as $word)
                        <div class="row">
                            <div class="col-12 col-sm-6 col-md-2 fw-semibold d-flex flex-column">
                                @if(str_contains($word['word'], ' '))
                                    <span class="text-success">{{ str_replace($item->word, '--', $word['word']) }}</span>
                                @else
                                    <div>{{ $word['word'] }}</div>
                                    <small class="fw-normal fst-italic">{{ $word['syllables'] ?? $word['word'] }}</small>
                                @endif
                            </div>
                            <div class="col">
                                @foreach($word['definitions'] as $definition)
                                    @if($loop->first)
                                        <abbr class="fst-italic text-danger cursor-pointer me-2" data-bs-toggle="tooltip"
                                              data-bs-offset="0,4" data-bs-placement="top"
                                              data-bs-html="true" title="{{ $partOfSpeech[$definition['partOfSpeech'] ?? 'n'] ?? '' }}">
                                            {{ $definition['partOfSpeech'] ?? 'n' }}
                                        </abbr>
                                    @endif
                                    <span class="me-2">
                                        @if(count($word['definitions']) > 1)
                                            <span class="badge badge-center rounded-pill bg-label-primary">{{ $loop->iteration }}</span>
                                        @endif
                                        {{ $definition['definition'] ?? $item->word }}
                                        @isset($definition['examples'])
                                            ;
                                            @foreach($definition['examples'] as $example)
                                                <u class="fst-italic text-warning cursor-pointer me-1" data-bs-toggle="tooltip"
                                                   data-bs-offset="0,4" data-bs-placement="top"
                                                   data-bs-html="true" title="{{ $example['id'] ?? '' }}">
                                                    {{ $example['bjn'] }}
                                                </u>
                                            @endforeach
                                        @endisset
                                    </span>
                                @endforeach
                                <br> <br>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endisset
        </div>
    </div>
@endsection

@push('script')
    <script>
        const syllableElement = document.getElementById('syllable');
        const voiceButton = syllableElement.nextElementSibling;

        const speech = new SpeechSynthesisUtterance(syllableElement.innerText);
        speech.rate = 0.5;
        window.speechSynthesis.onvoiceschanged = function () {
            const voices = speechSynthesis.getVoices();
            speech.voice = voices.find(v => v.lang === "id-ID");
        };

        voiceButton.addEventListener('click', () => speechSynthesis.speak(speech));
    </script>
@endpush
