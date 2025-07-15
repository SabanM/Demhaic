<?php

namespace App\Jobs;

use App\Models\Insight;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class TranslateInsightsToSpanish implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected int $userId;

    public function __construct(int $userId)
    {
        $this->userId = $userId;
    }


    public function handle(): void
    {
        // Get the last 5 insights without Spanish translation
        $insight = Insight::whereNull('insight_es')
            ->where('user_id',  $this->userId)
            ->orderBy('created_at', 'desc')
            ->first();

        
        // Translate each field (simplified — you might want to batch or handle errors)
        $insight->insight_es = $this->translateToSpanish($insight->insight);
        $insight->daily_progress_es = $this->translateToSpanish($insight->daily_progress);
        $insight->weekly_progress_es = $this->translateToSpanish($insight->weekly_progress);
        $insight->regression_tree_es = $this->translateToSpanish($insight->regression_tree);
        $insight->factor_predictors_es = $this->translateToSpanish($insight->factor_predictors);
        $insight->save();
        
        Log::info("Insights translated and saved into DB for user {$this->userId}.");
    }

    private function translateToSpanish(?string $text): ?string
    {
        if (!$text) return null;

        $prompt = "Translate the following text into Spanish. Preserve the exact format and structure (including bullet points, line breaks, and paragraphs). Output only the translated content with no explanations or introductory phrases:\n\n" . $text;

        try {
            $response = Http::post('http://ares.gsic.uva.es:11434/api/generate', [
                'model' => 'llama3.2',
                'prompt' => $prompt,
                'stream' => false
            ]);

            return $response->json()['response'] ?? null;
        } catch (\Throwable $e) {
            Log::error("Translation failed: " . $e->getMessage());
            return null;
        }
    }
}
