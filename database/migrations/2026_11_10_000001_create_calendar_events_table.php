<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasTable('calendar_events')) {
            Schema::create('calendar_events', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('user_id')->nullable()->index();
                $table->string('title');
                $table->text('description')->nullable();
                $table->string('category')->default('activity'); // exam, holiday, academic, meeting, activity, personal
                $table->dateTime('start_date');
                $table->dateTime('end_date')->nullable();
                $table->boolean('all_day')->default(true);
                $table->string('bg_color', 30)->default('#3b82f6');
                $table->string('border_color', 30)->default('#2563eb');
                $table->string('text_color', 30)->default('#ffffff');
                $table->string('url')->nullable();
                $table->timestamps();
            });
        }

        // Seed key school calendar milestones & national events for current/upcoming terms
        if (DB::table('calendar_events')->count() === 0) {
            $year = date('Y');
            $initialEvents = [
                [
                    'title'       => 'Academic Year Opening & Orientation',
                    'description' => 'Orientation for all students, parents, and faculty staff.',
                    'category'    => 'academic',
                    'start_date'  => "{$year}-01-05 08:00:00",
                    'end_date'    => "{$year}-01-05 16:30:00",
                    'all_day'     => true,
                    'bg_color'    => '#6366f1',
                    'border_color'=> '#4f46e5',
                    'text_color'  => '#ffffff',
                    'created_at'  => now(),
                    'updated_at'  => now(),
                ],
                [
                    'title'       => 'Victory Day over Genocide (National Holiday)',
                    'description' => 'National public holiday commemorating Victory Day.',
                    'category'    => 'holiday',
                    'start_date'  => "{$year}-01-07 00:00:00",
                    'end_date'    => "{$year}-01-07 23:59:59",
                    'all_day'     => true,
                    'bg_color'    => '#10b981',
                    'border_color'=> '#059669',
                    'text_color'  => '#ffffff',
                    'created_at'  => now(),
                    'updated_at'  => now(),
                ],
                [
                    'title'       => 'International Women\'s Day',
                    'description' => 'Public Holiday celebrating International Women\'s Day.',
                    'category'    => 'holiday',
                    'start_date'  => "{$year}-03-08 00:00:00",
                    'end_date'    => "{$year}-03-08 23:59:59",
                    'all_day'     => true,
                    'bg_color'    => '#ec4899',
                    'border_color'=> '#db2777',
                    'text_color'  => '#ffffff',
                    'created_at'  => now(),
                    'updated_at'  => now(),
                ],
                [
                    'title'       => 'Khmer New Year Celebration (Moha Sangkranta)',
                    'description' => 'Traditional Cambodian New Year public holiday celebrations.',
                    'category'    => 'holiday',
                    'start_date'  => "{$year}-04-13 00:00:00",
                    'end_date'    => "{$year}-04-16 23:59:59",
                    'all_day'     => true,
                    'bg_color'    => '#f59e0b',
                    'border_color'=> '#d97706',
                    'text_color'  => '#ffffff',
                    'created_at'  => now(),
                    'updated_at'  => now(),
                ],
                [
                    'title'       => 'King Norodom Sihamoni\'s Birthday',
                    'description' => 'Official national holiday honoring His Majesty King Norodom Sihamoni.',
                    'category'    => 'holiday',
                    'start_date'  => "{$year}-05-14 00:00:00",
                    'end_date'    => "{$year}-05-14 23:59:59",
                    'all_day'     => true,
                    'bg_color'    => '#10b981',
                    'border_color'=> '#059669',
                    'text_color'  => '#ffffff',
                    'created_at'  => now(),
                    'updated_at'  => now(),
                ],
                [
                    'title'       => 'Parent-Teacher Conference Day',
                    'description' => 'Term 1 progress report discussion between teachers and parents.',
                    'category'    => 'meeting',
                    'start_date'  => "{$year}-06-12 09:00:00",
                    'end_date'    => "{$year}-06-12 17:00:00",
                    'all_day'     => false,
                    'bg_color'    => '#0ea5e9',
                    'border_color'=> '#0284c7',
                    'text_color'  => '#ffffff',
                    'created_at'  => now(),
                    'updated_at'  => now(),
                ],
                [
                    'title'       => 'Mid-Term Examinations Term 1',
                    'description' => 'Mid-term written and practical examinations for all classes.',
                    'category'    => 'exam',
                    'start_date'  => "{$year}-07-20 08:00:00",
                    'end_date'    => "{$year}-07-24 16:30:00",
                    'all_day'     => true,
                    'bg_color'    => '#ef4444',
                    'border_color'=> '#dc2626',
                    'text_color'  => '#ffffff',
                    'created_at'  => now(),
                    'updated_at'  => now(),
                ],
                [
                    'title'       => 'Annual School Sports & Cultural Festival',
                    'description' => 'Inter-class athletics, football tournament, and cultural showcase.',
                    'category'    => 'activity',
                    'start_date'  => "{$year}-09-10 07:30:00",
                    'end_date'    => "{$year}-09-11 17:00:00",
                    'all_day'     => true,
                    'bg_color'    => '#8b5cf6',
                    'border_color'=> '#7c3aed',
                    'text_color'  => '#ffffff',
                    'created_at'  => now(),
                    'updated_at'  => now(),
                ],
                [
                    'title'       => 'Constitutional Day',
                    'description' => 'National holiday commemorating the adoption of the Constitution.',
                    'category'    => 'holiday',
                    'start_date'  => "{$year}-09-24 00:00:00",
                    'end_date'    => "{$year}-09-24 23:59:59",
                    'all_day'     => true,
                    'bg_color'    => '#10b981',
                    'border_color'=> '#059669',
                    'text_color'  => '#ffffff',
                    'created_at'  => now(),
                    'updated_at'  => now(),
                ],
                [
                    'title'       => 'Pchum Ben Festival (Ancestors\' Day)',
                    'description' => 'Traditional Cambodian festival dedicated to honoring ancestors.',
                    'category'    => 'holiday',
                    'start_date'  => "{$year}-10-01 00:00:00",
                    'end_date'    => "{$year}-10-03 23:59:59",
                    'all_day'     => true,
                    'bg_color'    => '#f59e0b',
                    'border_color'=> '#d97706',
                    'text_color'  => '#ffffff',
                    'created_at'  => now(),
                    'updated_at'  => now(),
                ],
                [
                    'title'       => 'National Independence Day',
                    'description' => 'Commemorating Cambodia\'s 1953 independence from France.',
                    'category'    => 'holiday',
                    'start_date'  => "{$year}-11-09 00:00:00",
                    'end_date'    => "{$year}-11-09 23:59:59",
                    'all_day'     => true,
                    'bg_color'    => '#10b981',
                    'border_color'=> '#059669',
                    'text_color'  => '#ffffff',
                    'created_at'  => now(),
                    'updated_at'  => now(),
                ],
                [
                    'title'       => 'Water and Moon Festival (Bon Om Touk)',
                    'description' => 'Annual boat racing and illuminated flotilla festival on Tonle Sap.',
                    'category'    => 'holiday',
                    'start_date'  => "{$year}-11-26 00:00:00",
                    'end_date'    => "{$year}-11-28 23:59:59",
                    'all_day'     => true,
                    'bg_color'    => '#06b6d4',
                    'border_color'=> '#0891b2',
                    'text_color'  => '#ffffff',
                    'created_at'  => now(),
                    'updated_at'  => now(),
                ],
                [
                    'title'       => 'Final Semester Examinations',
                    'description' => 'End of year comprehensive assessment across all departments.',
                    'category'    => 'exam',
                    'start_date'  => "{$year}-12-14 08:00:00",
                    'end_date'    => "{$year}-12-18 16:30:00",
                    'all_day'     => true,
                    'bg_color'    => '#dc2626',
                    'border_color'=> '#b91c1c',
                    'text_color'  => '#ffffff',
                    'created_at'  => now(),
                    'updated_at'  => now(),
                ],
            ];

            foreach ($initialEvents as &$event) {
                $event['all_day'] = $event['all_day'] ? DB::raw('true') : DB::raw('false');
            }
            unset($event);

            DB::table('calendar_events')->insert($initialEvents);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('calendar_events');
    }
};

