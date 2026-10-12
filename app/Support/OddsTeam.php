<?php

namespace App\Support;

class OddsTeam
{
    public static function members(): array
    {

        return [
            [
                'name' => 'Jerico Sanchez',
                'handle' => '3c0-exe',
                'github' => 'https://github.com/3c0-exe',
                'pfp' => 'https://api.dicebear.com/10.x/pixelbot/svg?seed=3c0-exe',
                'real_photo' => asset('storage/odds/team/Jerico_Sanchez.jpg'),
                'quip' => 'asleep or yearning.. probably both',
                'positions' => ['Co-Founder', 'Software Developer'],
                'awards' => ['Cum Laude', 'Best in Capstone (Lead Dev)'],
            ],
            [
                'name' => 'Jherald Vibar',
                'handle' => 'Jherald-Vibar',
                'github' => 'https://github.com/Jherald-Vibar',
                'pfp' => 'https://api.dicebear.com/10.x/pixelbot/svg?seed=Jherald-Vibar',
                'is_mystery' => true,
                'quip' => 'the most technical person really has no photos',
                'positions' => ['Co-Founder', 'Software / Database Dev'],
                'awards' => ['Magna Cum Laude', 'Outstanding System Developer'],
            ],
            [
                'name' => 'Robert Santiago',
                'handle' => 'Robert-1hash',
                'github' => 'https://github.com/Robert-1hash',
                'pfp' => 'https://api.dicebear.com/10.x/pixelbot/svg?seed=Robert-1hash',
                'real_photo' => asset('storage/odds/team/Robert_Santiago.jpeg'),
                'quip' => 'might break a couple of PCBs, but gets the job done',
                'positions' => ['Developer', 'Hardware Specialist'],
                'awards' => ['Magna Cum Laude', 'Best in Capstone'],
            ],
            [
                'name' => 'Brix Jorie Cura',
                'handle' => 'ixDev018',
                'github' => 'https://github.com/ixDev018',
                'pfp' => 'https://api.dicebear.com/10.x/pixelbot/svg?seed=ixDev018',
                'real_photo' => asset('storage/odds/team/Brix_Cura.jpeg'),
                'quip' => "i-jira natin 'to",
                'positions' => ['Co-Founder, Lead Designer', 'CMO, Web Developer'],
                'awards' => ['Magna Cum Laude', 'Best in Capstone (Dev)'],
            ],
            [
                'name' => 'Jazam Laranio',
                'handle' => '',
                'github' => null,
                'pfp' => 'https://api.dicebear.com/10.x/pixelbot/svg?seed=JazamLaranio',
                'real_photo' => asset('storage/odds/team/Jazam_Laranio.jpeg'),
                'quip' => 'hates commuting',
                'positions' => ['Developer', 'Lead Gen Specialist'],
                'awards' => ['Cum Laude', 'Outstanding System Developer'],
            ],
            [
                'name' => 'Mark Paulo Franco',
                'handle' => 'itsFrancss619',
                'github' => 'https://github.com/itsFrancss619',
                'pfp' => 'https://api.dicebear.com/10.x/pixelbot/svg?seed=itsFrancss619',
                'real_photo' => asset('storage/odds/team/Mark_Paulo_Franco.jpeg'),
                'quip' => 'cocoooo!',
                'positions' => ['Developer', 'Field Logistics Coord.'],
                'awards' => ['Best in Capstone'],
            ],
            [
                'name' => 'John Cedric Abaloyan',
                'handle' => 'Ggwepq',
                'github' => 'https://github.com/Ggwepq',
                'pfp' => 'https://api.dicebear.com/10.x/pixelbot/svg?seed=Ggwepq',
                'real_photo' => asset('storage/odds/team/John_Cedric_Abaloyan.jpeg'),
                'quip' => 'matchaa 🤤🤤🤤',
                'positions' => ['Lead Developer'],
                'awards' => ['Best in Capstone'],
            ],
            [
                'name' => 'Sherwin Ramirez',
                'handle' => 'sheerwiiin',
                'github' => 'https://github.com/sheerwiiin',
                'pfp' => 'https://api.dicebear.com/10.x/pixelbot/svg?seed=sheerwiiin',
                'real_photo' => asset('storage/odds/team/Sherwin_Ramirez.jpeg'),
                'photo_position' => 'center 40%',
                'quip' => 'wanted to have the same shirt as jerico',
                'positions' => ['QA Specialist', 'Web Developer'],
                'awards' => ['Top 1 (Rank 1)', 'Best in Capstone'],
            ],
        ];

    }
}
