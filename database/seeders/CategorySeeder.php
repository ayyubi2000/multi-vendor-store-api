<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create the root category
        $rootCategory = Category::factory()->create();

        // Create a subcategory under the root category
        $subCategory = Category::factory()->create();

        // Use the append method to establish the parent-child relationship
        $rootCategory->appendNode($subCategory); // This sets the subcategory under the root category

        // Create a child category under the subcategory
        $childCategory = Category::factory()->create();

        // Append the child category to the subcategory
        $subCategory->appendNode($childCategory); // This sets the child category under the subcategory
    }
}
