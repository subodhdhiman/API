<?php

namespace Database\Seeders;


use App\Models\Kbcentral;
use App\Models\User;
use App\Models\UserCallingDetails;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::factory()->create(
            [
                'email' => 'vikas1@gmail.com',
                'name' => 'Vikas Deep',
            ]
        );
        $user = User::factory(5)
            ->sequence(fn ($sequence) => ['name' => 'Person' . $sequence->index + 2])
            ->create();
        UserCallingDetails::factory(10)->create();
        Kbcentral::factory(4)->create(
            [
                'message' => 'KBCENTRAL Messsage ',
            ]
        );

        // UserCallingDetails::factory(8)->create();
        // foreach (range(1, 5) as $user_id) {
        //     foreach (range(1, 5) as $user_id2) {
        //         User::find($user_id2)->userCallingDetails()->attach(User::find($user_id2));
        //     }
        // }
        // foreach (range(1, 5) as $user_id) {
        //     User::find($user_id)->userCalls()->attach(User::find($user_id));
        // }
    }
}
