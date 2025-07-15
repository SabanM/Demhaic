<?php

namespace App\Exports;

use App\Models\Entry;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;

class EntriesExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    protected $entries;
    protected $questions;

    public function __construct($entries, $questions)
    {
        $this->entries = $entries;
        $this->questions = $questions;
    }

    public function view(): View
    {
        return view('entries.export', [
            'entries' => $this->entries,
            'questions' => $this->questions
        ]);
    }
}
