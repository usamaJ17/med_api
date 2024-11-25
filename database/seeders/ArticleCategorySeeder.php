<?php

namespace Database\Seeders;

use App\Models\ArticleCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ArticleCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        ArticleCategory::create([
            "name" => "Biopic"
        ]);

        ArticleCategory::create([
            "name" => "Classics"
        ]);

        ArticleCategory::create([
            "name" => "Science"
        ]);
    }
}
