<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * spatie/laravel-schedule-monitor v2+ requires a nullable `timezone`
     * column on the `monitored_scheduled_tasks` table.
     */
    public function up(): void
    {
        if (Schema::hasColumn('monitored_scheduled_tasks', 'timezone')) {
            return;
        }

        Schema::table('monitored_scheduled_tasks', function (Blueprint $table) {
            $table->string('timezone')->nullable()->after('cron_expression');
        });
    }
};
