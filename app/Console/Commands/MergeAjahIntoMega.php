<?php

namespace App\Console\Commands;

use App\Models\{Attendance, Church, User};
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class MergeAjahIntoMega extends Command
{
    protected $signature = 'churches:merge-ajah {--dry-run : Show what would happen without saving anything}';
    protected $description = 'Move all CE Ajah members, attendance and admins into CE Ajah Mega Church';

    public function handle(): int
    {
        $from = Church::where('slug', 'ajah')->first();
        $to = Church::where('slug', 'ajah-mega')->first();

        if (! $from || ! $to) {
            $this->error('Both the "ajah" and "ajah-mega" churches must exist. Has the merge already been run?');
            return self::FAILURE;
        }

        $dry = (bool) $this->option('dry-run');
        $moved = $merged = $attMoved = $attDropped = $admins = 0;

        DB::beginTransaction();

        try {
            foreach ($from->members()->get() as $m) {
                // Is the same person already in the Mega Church (same email or phone)?
                $dup = $to->members()
                    ->where(fn ($q) => $q->where('email', $m->email)->orWhere('phone_key', $m->phone_key))
                    ->first();

                if ($dup) {
                    foreach (Attendance::where('member_id', $m->id)->get() as $a) {
                        $clash = Attendance::where('member_id', $dup->id)
                            ->where('service_date', $a->service_date)
                            ->exists();

                        if ($clash) {
                            $a->delete();       // same Sunday already recorded for this person
                            $attDropped++;
                        } else {
                            $a->update(['member_id' => $dup->id, 'church_id' => $to->id]);
                            $attMoved++;
                        }
                    }
                    $m->delete();
                    $merged++;
                    continue;
                }

                $m->update(['church_id' => $to->id]);
                $attMoved += Attendance::where('member_id', $m->id)->update(['church_id' => $to->id]);
                $moved++;
            }

            // Ajah admins become admins of the merged church.
            $admins = User::where('church_id', $from->id)->update(['church_id' => $to->id]);

            $from->delete();

            $dry ? DB::rollBack() : DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            $this->error('Merge failed and was rolled back: '.$e->getMessage());
            return self::FAILURE;
        }

        $this->table(['Result', 'Count'], [
            ['Members moved', $moved],
            ['Duplicate members merged', $merged],
            ['Attendance records moved', $attMoved],
            ['Attendance records dropped (same Sunday twice)', $attDropped],
            ['Admin accounts moved', $admins],
        ]);

        $this->info($dry
            ? 'Dry run only. Nothing was saved.'
            : 'Done. CE Ajah has been merged into CE Ajah Mega Church.');

        return self::SUCCESS;
    }
}

