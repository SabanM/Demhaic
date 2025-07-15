<?php 

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Models\Entry;
use App\Models\Insight;
use App\Models\Question;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\EntriesExport;
use Maatwebsite\Excel\Excel as ExcelFormat;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Http;
use App\Jobs\TranslateInsightsToSpanish;

class GenerateInsights implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $userId;

    public function __construct($userId)
    {
        $this->userId = $userId;
    }

    public function handle()
    {
        Log::info("🚀 Starting new GenerateInsights job for the user {$this->userId}");

        $lock = Cache::lock("insights_lock_user_{$this->userId}", 30); // or use $this->timeout if declared

    if (!$lock->get()) {
        Log::info("⛔ Insights already running for user {$this->userId}");
        return;
    }

    try {
        //$entries = Entry::where('user_id', $this->userId)->get();
        $entries = Entry::where('user_id', $this->userId)->whereHas('dform', function ($query) {
            $query->where('type', 'Diary')->latest();
        })->get();

            if ($entries->count() >= 6) {
                $questions = Question::all();
                $fileName = "temp_data_{$this->userId}.xlsx";
                
                Log::info("Exporting " . $entries->count() . " entries for user {$this->userId}");
                Excel::store(new EntriesExport($entries, $questions), $fileName, 'public');
                $tempFile = storage_path("/app/public/{$fileName}");
                
                $python = escapeshellcmd('/usr/bin/python3');
                $script = base_path('storage/app/public/prueba.py');
                $command = "$python " . escapeshellarg($script)
                    . " --input " . escapeshellarg($tempFile)
                    . " --user " . escapeshellarg($this->userId) . " 2>&1";

                Log::info("Running command: " . $command);
                $output = shell_exec($command);
                //Log::info("Python output: " . $output);
                //unlink($tempFile);

            
                Log::info("📥 Python output: $output");

                preg_match('/\{.*\}$/s', $output, $matches);
                $cleanedJson = $matches[0] ?? null;

                if (isset($jc->error)) {
                    Log::warning("⚠️ Python script returned an error: " . $jc->error);
                    return; // STOP HERE
                }

                if ($cleanedJson) {
                    $jc = json_decode($cleanedJson);
                    Log::info("✅ Decoded output: ", (array) $jc);

                    $charts = [
                        'daily_progress'    => $jc->progress_over_time ?? null,
                        'weekly_progress'   => $jc->progress_by_week ?? null,
                        'regression_tree'   => $jc->decision_tree ?? null,
                        'factor_predictors' => $jc->forest_plot ?? null,
                    ];

                    Log::info("✅ Charts array: " . json_encode($charts));

                   
    
                    $controller = app(\App\Http\Controllers\DformController::class);
                    $insightSummaries = [];
    
                    foreach ($charts as $key => $chartData) {
                        $response = $controller->generateResponse($key, $chartData); //  pass both type and data
                        $responseData = method_exists($response, 'getData') ? (array)$response->getData(true) : null;
                        $insightSummaries[$key] = $responseData['response'] ?? 'failed';
                    }

                    $summary = $controller->generateSummary($insightSummaries);
                    $summaryData = method_exists($summary, 'getData') ? (array)$summary->getData(true) : null;
                    $insightsresume = $summaryData['response'] ?? 'Insight generation failed.';

                    Insight::create([
                        'user_id'           => $this->userId,
                        'daily_progress'    => $insightSummaries['daily_progress'],
                        'weekly_progress'   => $insightSummaries['weekly_progress'],
                        'regression_tree'   => $insightSummaries['regression_tree'],
                        'factor_predictors' => $insightSummaries['factor_predictors'],
                        'chartsDataJson'    => json_encode($charts),
                        'insight'           => $insightsresume,
                    ]);

                    Log::info("Insight saved into DB");
                    TranslateInsightsToSpanish::dispatch($this->userId);

                    if (file_exists($tempFile)) {
                       unlink($tempFile);
                    }
                    
                    
                } else {
                    Log::error("❌ Failed to extract JSON from Python output.");
                }


               
            } else {
                Log::info("ℹ️ Not enough entries for user {$this->userId}");
            }
        } catch (\Exception $e) {
            Log::error("❌ Error generating insights for user {$this->userId}: " . $e->getMessage());
        } finally {
            $lock->release();
        }


            Log::info("✅ GenerateInsights job finished for user {$this->userId}");
        }



}
