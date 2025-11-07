<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use App\Models\{User, Team, TeamMember, Race, RaceCheckpoint, RaceLog};

class DemoSeeder extends Seeder
{
    public function run(): void
    {
        DB::transaction(function () {

            // optional but useful for repeatable seeding during dev
            DB::statement('SET FOREIGN_KEY_CHECKS=0');
            RaceLog::truncate();
            RaceCheckpoint::truncate();
            TeamMember::truncate();
            Team::truncate();
            Race::truncate();
            User::truncate();
            DB::statement('SET FOREIGN_KEY_CHECKS=1');

            // ===== Users (use known passwords) =====
            User::create([
                'name' => 'Admin',
                'email' => 'admin@domain.com',
                'password' => Hash::make('password'),
                'is_admin' => true,
            ]);

            User::create([
                'name' => 'User',
                'email' => 'user@domain.com',
                'password' => Hash::make('password'),
                'is_admin' => false,
            ]);

            User::create([
                'name' => 'Shoheb Kazi',
                'email' => 'shohebkazi456@gmail.com',
                'password' => Hash::make('shoheb123'), 
                'is_admin' => false,
            ]);

            // ===== Races + Checkpoints =====
            $races = [];

            $races['Monsoon Trek'] = Race::create([
                'race_name' => 'Monsoon Trek',
                'description' => 'Trek across hills and rivers',
            ]);
            $this->cps($races['Monsoon Trek'], [
                [1, 'Start'],
                [2, 'Hill Base'],
                [3, 'River Crossing'],
                [4, 'Summit (End)'],
            ]);

            $races['City Marathon 2025'] = Race::create([
                'race_name' => 'City Marathon 2025',
                'description' => 'Full-city endurance race',
            ]);
            $this->cps($races['City Marathon 2025'], [
                [1, 'Start Line'],
                [2, 'Checkpoint A'],
                [3, 'Bridge Crossing'],
                [4, 'Finish Line'],
            ]);

            $races['Night Adventure Race'] = Race::create([
                'race_name' => 'Night Adventure Race',
                'description' => 'Race held overnight with checkpoints',
            ]);
            $this->cps($races['Night Adventure Race'], [
                [1, 'Start Line'],
                [2, 'Medical Tent'],
                [3, 'Mid-Race Hub'],
                [4, 'Finish Line'],
            ]);

            // ===== Teams =====
            $teams = [];
            foreach (['Alpha','Bravo','Gama','Beta','Test Team'] as $tname) {
                $teams[$tname] = Team::create(['team_name' => $tname]);
            }

            // ===== Members (team -> member -> race) =====
            // From your SQL dump mapping
            $members = [];

            $members['Aarav']  = TeamMember::create(['team_id'=>$teams['Alpha']->id,'member_name'=>'Aarav',  'race_id'=>$races['Monsoon Trek']->id]);
            $members['Isha']   = TeamMember::create(['team_id'=>$teams['Alpha']->id,'member_name'=>'Isha',   'race_id'=>$races['Monsoon Trek']->id]);
            $members['Kabir']  = TeamMember::create(['team_id'=>$teams['Bravo']->id,'member_name'=>'Kabir',  'race_id'=>$races['Monsoon Trek']->id]);

            $members['Shahid'] = TeamMember::create(['team_id'=>$teams['Beta']->id, 'member_name'=>'Shahid', 'race_id'=>$races['Monsoon Trek']->id]);
            $members['Jack']   = TeamMember::create(['team_id'=>$teams['Beta']->id, 'member_name'=>'Jack',   'race_id'=>$races['City Marathon 2025']->id]);

            $members['Rohit']  = TeamMember::create(['team_id'=>$teams['Beta']->id, 'member_name'=>'Rohit',  'race_id'=>$races['Night Adventure Race']->id]);
            $members['Meera']  = TeamMember::create(['team_id'=>$teams['Gama']->id, 'member_name'=>'Meera',  'race_id'=>$races['Night Adventure Race']->id]);

            $members['Salman'] = TeamMember::create(['team_id'=>$teams['Alpha']->id,'member_name'=>'Salman', 'race_id'=>$races['City Marathon 2025']->id]);
            $members['Farhan'] = TeamMember::create(['team_id'=>$teams['Test Team']->id, 'member_name'=>'Farhan', 'race_id'=>$races['Night Adventure Race']->id]);

            // ===== Sample Race Logs (dates from your dump) =====
            // Helpers to resolve checkpoint by order
            $cp = fn(Race $race, int $order) => RaceCheckpoint::where('race_id',$race->id)->where('order_no',$order)->firstOrFail();

            // City Marathon 2025 — Jack completes
            $this->log($races['City Marathon 2025'], $members['Jack'], 1, '2025-11-07 06:01:00', $cp);
            $this->log($races['City Marathon 2025'], $members['Jack'], 2, '2025-11-07 06:04:00', $cp);
            $this->log($races['City Marathon 2025'], $members['Jack'], 3, '2025-11-07 06:10:00', $cp);
            $this->log($races['City Marathon 2025'], $members['Jack'], 4, '2025-11-07 06:31:00', $cp);

            // Monsoon Trek — Aarav completes
            $this->log($races['Monsoon Trek'], $members['Aarav'], 1, '2025-11-07 07:12:00', $cp);
            $this->log($races['Monsoon Trek'], $members['Aarav'], 2, '2025-11-07 07:16:00', $cp);
            $this->log($races['Monsoon Trek'], $members['Aarav'], 3, '2025-11-07 07:28:00', $cp);
            $this->log($races['Monsoon Trek'], $members['Aarav'], 4, '2025-11-07 07:30:00', $cp);

            // Night Adventure Race — Rohit starts
            $this->log($races['Night Adventure Race'], $members['Rohit'], 1, '2025-11-07 08:55:00', $cp);

            // Night Adventure Race — Meera completes
            $this->log($races['Night Adventure Race'], $members['Meera'], 1, '2025-11-07 06:32:00', $cp);
            $this->log($races['Night Adventure Race'], $members['Meera'], 2, '2025-11-07 07:29:00', $cp);
            $this->log($races['Night Adventure Race'], $members['Meera'], 3, '2025-11-07 07:30:00', $cp);
            $this->log($races['Night Adventure Race'], $members['Meera'], 4, '2025-11-07 07:39:00', $cp);

            // Monsoon Trek — Isha completes
            $this->log($races['Monsoon Trek'], $members['Isha'], 1, '2025-11-07 03:31:00', $cp);
            $this->log($races['Monsoon Trek'], $members['Isha'], 2, '2025-11-07 04:32:00', $cp);
            $this->log($races['Monsoon Trek'], $members['Isha'], 3, '2025-11-07 05:01:00', $cp);
            $this->log($races['Monsoon Trek'], $members['Isha'], 4, '2025-11-07 05:32:00', $cp);
        });
    }

    private function cps(Race $race, array $items): void
    {
        foreach ($items as [$order, $name]) {
            $race->checkpoints()->create([
                'checkpoint_name' => $name,
                'order_no' => $order,
            ]);
        }
    }

    private function log(Race $race, TeamMember $member, int $order, string $reachedAt, callable $cpResolver): void
    {
        $cp = $cpResolver($race, $order);
        RaceLog::create([
            'race_id' => $race->id,
            'member_id' => $member->id,
            'checkpoint_id' => $cp->id,
            'reached_at' => Carbon::parse($reachedAt),
        ]);
    }
}