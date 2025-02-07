<?php

namespace App\Jobs\Word;

use App\Models\Word;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Storage;

class Import implements ShouldQueue
{
    use Queueable;

    private string $alphabet;

    /**
     * Create a new job instance.
     */
    public function __construct(public string $path)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            $contents = json_decode(file_get_contents($this->path), true);
            foreach ($contents as $word) {
                $this->store($word);
            }

            if (! filter_var($this->path, FILTER_VALIDATE_URL)) {
                Storage::delete($this->path);
            }
        } catch (\Throwable $exception) {
            echo $exception->getMessage().PHP_EOL;
        }
    }

    private function store(array $word): void
    {
        if (isset($word['alphabet'])) {
            $this->alphabet = $word['alphabet'];
        }

        $word = $this->transformWord($word);

        $w = Word::query()->create([
            'word' => $word['word'],
            'letter' => $word['alphabet'] ?? $this->alphabet,
            'verified' => true,
            'data' => $word,
        ]);

        // TODO: Extract derivative words and store it to another table.

    }

    private function transformWord(array $data): array
    {
        // TODO: If needed, transform to another form.
        return $data;
    }
}
