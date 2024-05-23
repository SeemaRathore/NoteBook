<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Note;
use Carbon\Carbon;

class UpdateTagEnd extends Command
{
    protected $signature = 'notes:update-tag-end';

    protected $description = 'Update tag_end column for the last added note before the end of the current date';

    /*public function handle()
    {
        // Get the current timestamp
        $currentTime = Carbon::now();

        // Get the latest note added before the end of the current date
        $latestNote = Note::whereDate('created_at', '<=', $currentTime)
            ->latest()
            ->first();

        if ($latestNote) {
            // Update the tag_end column for the latest note with the current timestamp
            if ($latestNote->update(['tag_end' => $currentTime])) {
                $this->info('Tag_end column updated for the latest note added before the end of the day.');
            } else {
                $this->error('Failed to update tag_end column.');
            }
        } else {
            $this->info('No notes found to update tag_end column.');
        }

    }*/

    public function handle()
    {
        // Get the latest note added before the end of the current date
        $latestNote = Note::whereDate('created_at', '<=', Carbon::now()->endOfDay())
            ->latest()
            ->first();

        if ($latestNote) {
            // Update the tag_end column for the latest note
            $latestNote->update(['tag_end' => Carbon::now()]);
            $this->info('Tag_end column updated for the latest note added before the end of the day.');
        } else {
            $this->info('No notes found to update tag_end column.');
        }
    }
}
