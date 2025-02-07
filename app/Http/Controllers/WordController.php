<?php

namespace App\Http\Controllers;

use App\Enum\PartOfSpeech;
use App\Http\Requests\ImportWordRequest;
use App\Http\Requests\StoreWordRequest;
use App\Http\Requests\UpdateWordRequest;
use App\Jobs\Word\Import;
use App\Models\Letter;
use App\Models\Word;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class WordController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        return view('pages.word.index', [
            'items' => Word::query()
                ->render($request->query('size')),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): View
    {
        return view('pages.word.create', [
            'letters' => Letter::all()->map(fn ($item) => [$item->letter, $item->letter]),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreWordRequest $request): RedirectResponse
    {
        try {
            $input = $request->validated();
            $input['verified'] = true;

            Word::query()->create($input);

            return redirect()->route('word.index')
                ->with('notification', $this->successNotification('notification.success_create', 'menu.word'));
        } catch (\Throwable $throwable) {
            Log::error($throwable->getMessage());

            return back()
                ->with('notification', $this->failNotification('notification.fail_create', 'menu.word'));
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Word $word): View
    {
        return view('pages.word.show', [
            'item' => $word,
            'partOfSpeech' => PartOfSpeech::abbreviation(),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Word $word): View
    {
        return view('pages.word.edit', [
            'letters' => Letter::all()->map(fn ($item) => [$item->letter, $item->letter]),
            'item' => $word,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateWordRequest $request, Word $word): RedirectResponse
    {
        try {
            $input = $request->validated();

            $word->update($input);

            return redirect()->route('word.edit', $word->word)
                ->with('notification', $this->successNotification('notification.success_create', 'menu.word'));
        } catch (\Throwable $throwable) {
            Log::error($throwable->getMessage());

            return back()
                ->with('notification', $this->failNotification('notification.fail_create', 'menu.word'));
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Word $word): RedirectResponse
    {
        try {
            $word->delete();

            return redirect()->route('word.index')
                ->with('notification', $this->successNotification('notification.success_create', 'menu.word'));
        } catch (\Throwable $throwable) {
            Log::error($throwable->getMessage());

            return redirect()->route('word.index')
                ->with('notification', $this->failNotification('notification.fail_create', 'menu.word'));
        }
    }

    public function import(ImportWordRequest $request): RedirectResponse
    {
        try {
            $input = $request->validated();
            $path = isset($input['file']) ? Storage::path($input['file']->store('temp')) : $input['url'];

            Import::dispatch($path);

            return redirect()->route('word.index')
                ->with('notification', $this->successNotification('notification.success_create', 'menu.word'));
        } catch (\Throwable $throwable) {
            Log::error($throwable->getMessage());

            return redirect()->route('word.index')
                ->with('notification', $this->failNotification('notification.fail_create', 'menu.word'));
        }
    }
}
