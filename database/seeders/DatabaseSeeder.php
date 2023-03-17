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
        $faker->addProvider(new \Mmo\Faker\PicsumProvider($faker));
        $faker->addProvider(new \Mmo\Faker\LoremSpaceProvider($faker));
        $faker->addProvider(new \Smknstd\FakerPicsumImages\FakerPicsumImagesProvider($faker));
        $faker->addProvider(new \Xvladqt\Faker\LoremFlickrProvider($faker));

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
        
        foreach(range(1, 200) as $k => $_) {
            $maker = $makers[rand(0, count($makers)-1)];
            // $photo = $faker->imageUrl(200, 300, rand(1, 200));
            // $photo = $faker->picsumUrl(200, 300);
            // $photo = $faker->picsumStaticRandomUrl(200, 300);
            // $photo = $faker->loremSpaceUrl($category='car', 200, 300);
            $photo = $faker->imageUrl(300, 200, ['trucks'], false);
        
            DB::table('trucks')->insert([
                'maker' => $maker,
                'plate' => $faker->vehicleRegistration,
                'make_year' => $faker->numberBetween($minYear, $currYear),
                'photo' => rand(0, 3) ? $photo : null, 
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
