<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('en_EN');
        $faker->addProvider(new \Faker\Provider\Fakecar($faker));

        DB::table('users')->insert([
            'name' => 'Kristina',
            'email' => 'crislayn@yahoo.com',
            'password' => Hash::make('kriste22')
        ]);

        $mechCount = 20;
        foreach(range(1, $mechCount) as $_) {
            DB::table('mechanics')->insert([
                'name' => $faker->firstName(),
                'surname' => $faker->lastName()
            ]);
        }

        $minYear = Carbon::now()->subYears(40)->format('Y');
        $currYear = Carbon::now()->format('Y');
        $makers = ['Tesla', 'Toyota', 'Porsche', 'Volkswagen', 'Mersedes-Benz', 'BMW', 'Ferrari', 'Ford', 'Honda', 'Hyundai', 'Kia', 'Suzuki Motor', 'Nissan', 'Volvo Car', 'Subaru', 'Renault', 'Isuzu', 'Polaris', 'Mitsubishi Motors', 'Mazda'];

        foreach(range(1, 200) as $_) {
            DB::table('trucks')->insert([
                'maker' => $makers[rand(0, count($makers)-1)],
                'plate' => $faker->vehicleRegistration,
                'make_year' => $faker->numberBetween($minYear, $currYear),
                'mechanic_notices' => $faker->realText(rand(50, 100)),
                'mechanic_id' => rand(1, $mechCount)
            ]);
        }

        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
