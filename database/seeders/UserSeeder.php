<?php

namespace Database\Seeders;

use App\Models\Image;
use App\Models\User;
use App\Models\Tag;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Carbon;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $image = Image::create([
            'image' => '/media/user.jpg',
        ]);
        $image_id = $image->id;

        $image2 = Image::create([
            'image' => '/media/user.jpg',
        ]);
        $image2_id = $image2->id;

        $user = User::create([
            'username' => '2',
            'one_time' => '2',
            'first_name' => 'Joe',
            'infix' => 'van der',
            'last_name' => 'Biden',
            'dob' => '2000-03-04',
            'address' => 'asdfadsfsad',
            'country' => 'America',
            'street_nr' => 11,
            'city' => 'California',
            'zipcode' => '4568ER',
            'email' => 'admin@admin',
            'password' => Hash::make('2'),
            'is_enterprise' => 0,
            'is_admin' => 0,
            'images_id' => $image_id
        ]);

        $user2 = User::create([
            'username' => '1',
            'one_time' => '1',
            'first_name' => 'Dion',
            'infix' => 'van der',
            'last_name' => 'Biden',
            'dob' => '2000-03-04',
            'address' => 'asdfadsfsad',
            'country' => 'America',
            'street_nr' => 11,
            'city' => 'California',
            'zipcode' => '4568ER',
            'email' => 'dion@admin',
            'password' => Hash::make('2'),
            'is_enterprise' => 0,
            'is_admin' => 0,
            'images_id' => $image2_id
        ]);

        $user3 = User::create([
            'username' => 'test',
            'one_time' => '1',
            'first_name' => 'Dion',
            'infix' => 'van der',
            'last_name' => 'Biden',
            'dob' => '2000-03-04',
            'address' => 'asdfadsfsad',
            'country' => 'America',
            'street_nr' => 11,
            'city' => 'California',
            'zipcode' => '4568ER',
            'email' => 'diona@admin',
            'password' => Hash::make('2'),
            'is_enterprise' => 0,
            'is_admin' => 0,
            'images_id' => $image2_id
        ]);

        $user4 = User::create([
            'username' => 'user',
            'one_time' => '1',
            'first_name' => 'User',
            'infix' => 'van der',
            'last_name' => 'Biden',
            'dob' => '2000-03-04',
            'address' => 'asdfadsfsad',
            'country' => 'America',
            'street_nr' => 11,
            'city' => 'California',
            'zipcode' => '4568ER',
            'email' => 'user@admin',
            'password' => Hash::make('2'),
            'is_enterprise' => 0,
            'is_admin' => 0,
            'images_id' => $image2_id
        ]);

        $tag = Tag::create([
            'name'  => 'dj'
        ]);

        $tag2 = Tag::create([
            'name'  => 'test'
        ]);

        $tag3 = Tag::create([
            'name'  => 'voetbal'
        ]);

        $tag4 = Tag::create([
            'name'  => 'lezen'
        ]);

        $tag5 = Tag::create([
            'name'  => 'gym'
        ]);

        $tag6 = Tag::create([
            'name'  => 'game'
        ]);
    }
}
