<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Service;
use Illuminate\Support\Str;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Categories
        $taxCategory = Service::create([
            'name' => 'TAX, CORPORATE AND BUDGET CONSULTANCY',
            'slug' => Str::slug('TAX, CORPORATE AND BUDGET CONSULTANCY'),
            'description' => 'Comprehensive tax and corporate consulting services',
            'status' => 'active',
            'type' => 'category',
            'parent_id' => null,
            'sort_order' => 1,
            'is_expanded' => false
        ]);

        $legalCategory = Service::create([
            'name' => 'LEGAL CONSULTANCY',
            'slug' => Str::slug('LEGAL CONSULTANCY'),
            'description' => 'Professional legal consulting services',
            'status' => 'active',
            'type' => 'category',
            'parent_id' => null,
            'sort_order' => 2,
            'is_expanded' => false
        ]);

        // Create Titles under Tax Category
        $budgetTitle = Service::create([
            'name' => 'DRAFTING OF THE BUDGET',
            'slug' => Str::slug('DRAFTING OF THE BUDGET'),
            'description' => 'Professional budget drafting services',
            'status' => 'active',
            'type' => 'title',
            'parent_id' => $taxCategory->id,
            'sort_order' => 1,
            'is_expanded' => true
        ]);

        $taxReturnsTitle = Service::create([
            'name' => 'TAX RETURNS',
            'slug' => Str::slug('TAX RETURNS'),
            'description' => 'Comprehensive tax return services',
            'status' => 'active',
            'type' => 'title',
            'parent_id' => $taxCategory->id,
            'sort_order' => 2,
            'is_expanded' => false
        ]);

        $startupTitle = Service::create([
            'name' => 'BUSINESS STARTUP CONSULTING',
            'slug' => Str::slug('BUSINESS STARTUP CONSULTING'),
            'description' => 'Complete business startup consulting',
            'status' => 'active',
            'type' => 'title',
            'parent_id' => $taxCategory->id,
            'sort_order' => 3,
            'is_expanded' => false
        ]);

        // Create Points under Budget Title
        Service::create([
            'name' => 'Consulting for depreciation, provisions and valuations',
            'slug' => Str::slug('Consulting for depreciation, provisions and valuations'),
            'description' => 'Expert consulting on depreciation methods, provisions, and asset valuations',
            'status' => 'active',
            'type' => 'point',
            'parent_id' => $budgetTitle->id,
            'sort_order' => 1,
            'is_expanded' => false
        ]);

        Service::create([
            'name' => 'Consultancy for the preparation and recording of year-end adjustment entries',
            'slug' => Str::slug('Consultancy for the preparation and recording of year-end adjustment entries'),
            'description' => 'Professional assistance with year-end accounting adjustments',
            'status' => 'active',
            'type' => 'point',
            'parent_id' => $budgetTitle->id,
            'sort_order' => 2,
            'is_expanded' => false
        ]);

        Service::create([
            'name' => 'Preparation of the financial statement complete with explanatory notes reclassified as per Legislative Decree 197/91 and following, Management Report',
            'slug' => Str::slug('Preparation of the financial statement complete with explanatory notes reclassified as per Legislative Decree 197/91 and following, Management Report'),
            'description' => 'Complete financial statement preparation with regulatory compliance',
            'status' => 'active',
            'type' => 'point',
            'parent_id' => $budgetTitle->id,
            'sort_order' => 3,
            'is_expanded' => false
        ]);

        // Create Points under Tax Returns Title
        Service::create([
            'name' => 'Personal Income Tax Returns (IRPEF)',
            'slug' => Str::slug('Personal Income Tax Returns IRPEF'),
            'description' => 'Complete personal income tax return preparation and filing',
            'status' => 'active',
            'type' => 'point',
            'parent_id' => $taxReturnsTitle->id,
            'sort_order' => 1,
            'is_expanded' => false
        ]);

        Service::create([
            'name' => 'Corporate Tax Returns (IRES)',
            'slug' => Str::slug('Corporate Tax Returns IRES'),
            'description' => 'Corporate income tax return preparation and filing',
            'status' => 'active',
            'type' => 'point',
            'parent_id' => $taxReturnsTitle->id,
            'sort_order' => 2,
            'is_expanded' => false
        ]);

        Service::create([
            'name' => 'VAT Returns and Declarations',
            'slug' => Str::slug('VAT Returns and Declarations'),
            'description' => 'VAT return preparation and periodic declarations',
            'status' => 'active',
            'type' => 'point',
            'parent_id' => $taxReturnsTitle->id,
            'sort_order' => 3,
            'is_expanded' => false
        ]);

        // Create Points under Business Startup Title
        Service::create([
            'name' => 'Company Registration and Setup',
            'slug' => Str::slug('Company Registration and Setup'),
            'description' => 'Complete company registration and initial setup services',
            'status' => 'active',
            'type' => 'point',
            'parent_id' => $startupTitle->id,
            'sort_order' => 1,
            'is_expanded' => false
        ]);

        Service::create([
            'name' => 'Business Plan Development',
            'slug' => Str::slug('Business Plan Development'),
            'description' => 'Professional business plan creation and development',
            'status' => 'active',
            'type' => 'point',
            'parent_id' => $startupTitle->id,
            'sort_order' => 2,
            'is_expanded' => false
        ]);

        Service::create([
            'name' => 'Initial Accounting Setup',
            'slug' => Str::slug('Initial Accounting Setup'),
            'description' => 'Setting up accounting systems and initial bookkeeping',
            'status' => 'active',
            'type' => 'point',
            'parent_id' => $startupTitle->id,
            'sort_order' => 3,
            'is_expanded' => false
        ]);

        // Create Titles under Legal Category
        $contractTitle = Service::create([
            'name' => 'CONTRACT DRAFTING',
            'slug' => Str::slug('CONTRACT DRAFTING'),
            'description' => 'Professional contract drafting and review services',
            'status' => 'active',
            'type' => 'title',
            'parent_id' => $legalCategory->id,
            'sort_order' => 1,
            'is_expanded' => false
        ]);

        // Create Points under Contract Title
        Service::create([
            'name' => 'Commercial Contracts',
            'slug' => Str::slug('Commercial Contracts'),
            'description' => 'Drafting and review of commercial agreements',
            'status' => 'active',
            'type' => 'point',
            'parent_id' => $contractTitle->id,
            'sort_order' => 1,
            'is_expanded' => false
        ]);

        Service::create([
            'name' => 'Employment Contracts',
            'slug' => Str::slug('Employment Contracts'),
            'description' => 'Employment agreement drafting and compliance',
            'status' => 'active',
            'type' => 'point',
            'parent_id' => $contractTitle->id,
            'sort_order' => 2,
            'is_expanded' => false
        ]);
    }
}