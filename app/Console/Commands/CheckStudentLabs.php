<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Student;

class CheckStudentLabs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:student-labs {id : Student ID}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Show student courses and lab requirement flags as JSON';

    public function handle()
    {
        $id = $this->argument('id');
        $s = Student::with(['mention', 'yearLevel'])->find($id);
        if (!$s) {
            $this->line(json_encode(['error' => 'Student not found', 'id' => $id]));
            return 1;
        }

        $courses = $s->courses()->wherePivot('deleted_at', null)->get()->map(function($c) {
            return [
                'id' => $c->id,
                'sigle' => $c->sigle,
                'nom' => $c->nom ?? null,
                'labo_info' => $c->labo_info ? 1 : 0,
                'labo_comm' => $c->labo_comm ? 1 : 0,
                'labo_langue' => $c->labo_langue ? 1 : 0,
            ];
        })->values();

        $out = [
            'student' => [
                'id' => $s->id,
                'mention_id' => $s->mention_id,
                'mention_nom' => $s->mention->nom ?? null,
                'year_level_id' => $s->year_level_id,
                'year_level_label' => $s->yearLevel->label ?? null,
            ],
            'courses' => $courses,
        ];

        $this->line(json_encode($out, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
        return 0;
    }
}
