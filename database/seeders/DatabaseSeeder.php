<?php

namespace Database\Seeders;

use App\Models\Room;
use App\Models\RoomInfo;
use App\Models\User;
use App\Models\UserProfile;
use App\Models\UserRoom;
use Carbon\Carbon;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $user = User::create([
            'name' => 'testuser_1',
            'password' => 'password',
            'is_temp' => true,
            'email' => 'test@example.com',
        ]);

        UserProfile::create([
            'user_id' => $user->id,
            'profile_name' => 'leeroyjenkins',
            'comment' => 'My name is Jeff.',
            'color_primary' => 'FFFFFF',
            'color_secondary' => '000000',
        ]);

        $room_info = RoomInfo::create([
            'admin_uid' => User::first()->value('id'),
        ]);

        Room::create([
            'room_id' => Room::count(),
            'room_name' => 'testroom_1',
            'password' => '',
            'is_private' => false,
        ]);

        UserRoom::create([
            'user_id' => User::first()->value('id'),
            'room_id' => Room::first()->value('id'),
        ]);
    }
}
