<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Task;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class CheckTaskDeadlines extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'task:check-deadlines';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check for tasks that are 30 minutes away from their deadline and notify the user if not completed';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        // Ambil waktu 30 menit dari sekarang
        $timeNow = Carbon::now();
        $timeThreshold = $timeNow->addMinutes(30);

        // Ambil task yang deadline-nya mendekati 30 menit dan statusnya belum selesai
        $tasks = Task::where('status', '!=', 'complete')
                     ->whereBetween('deadline', [$timeNow, $timeThreshold])
                     ->get();

        // Periksa setiap task
        foreach ($tasks as $task) {
            // Notifikasi via log
            Log::info("Reminder: Task '{$task->title}' will expire in 30 minutes. Deadline: {$task->deadline}");

            // (Opsional) Jika Anda ingin mengirimkan email, Anda bisa menggunakan notifikasi email
            // \Mail::to($task->createdBy->email)->send(new TaskReminder($task));
        }
    }
}
