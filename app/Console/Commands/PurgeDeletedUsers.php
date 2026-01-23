<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Carbon\Carbon;

class PurgeDeletedUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'users:purge';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Hapus User Permanen Setelah 30 Hari';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $count = User::onlyTrashed()->where('deleted_at', '<=', now()->subDays(30))->forceDelete();

        $this ->info("{$count} user dihapus permanen.");
    }
}
