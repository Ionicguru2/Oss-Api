<?php

use Illuminate\Database\Seeder;

use App\Models\Region;
use App\Models\Country;
use App\Models\ProductStatus;
use App\Models\ProductFlag;
use App\Models\Category;
use App\Models\Role;
use App\Models\ReportType;
use App\Models\DocType;
use App\Models\NotificationType;
use App\Models\Permission;
use App\Models\ContractType;
use App\Models\TransactionStage;


class Setup extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(){

        /**
         * Region seeders.
         */
        $north_america = Region::create(['name' => 'North America']);
        $central_america = Region::create(['name' => 'Central America']);
        $south_america = Region::create(['name' => 'Caribbean/ South America']);
        $europe = Region::create(['name' => 'Europe']);
        $africa = Region::create(['name' => 'Africa']);
        $russia = Region::create(['name' => 'Russia']);
        $middle_east = Region::create(['name' => 'Middle East']);
        $asia = Region::create(['name' => 'Asia']);
        $australia = Region::create(['name' => 'Australia/ South Pacific']);


        /**
         * Country seeders.
         */
        Country::create(['name' => "Afghanistan" , 'region_id' => $asia->id]);
        Country::create(['name' => "Albania" , 'region_id' => $europe->id]);
        Country::create(['name' => "Algeria" , 'region_id' => $africa->id]);
        Country::create(['name' => "American Samoa" , 'region_id' => $australia->id]);
        Country::create(['name' => "Andorra" , 'region_id' => $europe->id]);
        Country::create(['name' => "Angola" , 'region_id' => $africa->id]);
        Country::create(['name' => "Anguilla" , 'region_id' => $south_america->id]);
        Country::create(['name' => "Antigua & Barbuda" , 'region_id' => $south_america->id]);
        Country::create(['name' => "Argentina" , 'region_id' => $south_america->id]);
        Country::create(['name' => "Armenia" , 'region_id' => $asia->id]);
        Country::create(['name' => "Aruba" , 'region_id' => $south_america->id]);
        Country::create(['name' => "Australia" , 'region_id' => $australia->id]);
        Country::create(['name' => "Austria" , 'region_id' => $europe->id]);
        Country::create(['name' => "Azerbaijan" , 'region_id' => $asia->id]);
        Country::create(['name' => "Bahamas, The" , 'region_id' => $south_america->id]);
        Country::create(['name' => "Bahrain" , 'region_id' => $middle_east->id]);
        Country::create(['name' => "Bangladesh" , 'region_id' => $asia->id]);
        Country::create(['name' => "Barbados" , 'region_id' => $south_america->id]);
        Country::create(['name' => "Belarus" , 'region_id' => $asia->id]);
        Country::create(['name' => "Belgium" , 'region_id' => $europe->id]);
        Country::create(['name' => "Belize" , 'region_id' => $south_america->id]);
        Country::create(['name' => "Benin" , 'region_id' => $africa->id]);
        Country::create(['name' => "Bermuda" , 'region_id' => $north_america->id]);
        Country::create(['name' => "Bhutan" , 'region_id' => $asia->id]);
        Country::create(['name' => "Bolivia" , 'region_id' => $south_america->id]);
        Country::create(['name' => "Bosnia & Herzegovina" , 'region_id' => $europe->id]);
        Country::create(['name' => "Botswana" , 'region_id' => $africa->id]);
        Country::create(['name' => "Brazil" , 'region_id' => $south_america->id]);
        Country::create(['name' => "British Virgin Is." , 'region_id' => $south_america->id]);
        Country::create(['name' => "Brunei" , 'region_id' => $asia->id]);
        Country::create(['name' => "Bulgaria" , 'region_id' => $europe->id]);
        Country::create(['name' => "Burkina Faso" , 'region_id' => $africa->id]);
        Country::create(['name' => "Burma" , 'region_id' => $asia->id]);
        Country::create(['name' => "Burundi" , 'region_id' => $africa->id]);
        Country::create(['name' => "Cambodia" , 'region_id' => $asia->id]);
        Country::create(['name' => "Cameroon" , 'region_id' => $africa->id]);
        Country::create(['name' => "Canada" , 'region_id' => $north_america->id]);
        Country::create(['name' => "Cape Verde" , 'region_id' => $africa->id]);
        Country::create(['name' => "Cayman Islands" , 'region_id' => $south_america->id]);
        Country::create(['name' => "Central $africa->idn Rep." , 'region_id' => $africa->id]);
        Country::create(['name' => "Chad" , 'region_id' => $africa->id]);
        Country::create(['name' => "Chile" , 'region_id' => $south_america->id]);
        Country::create(['name' => "China" , 'region_id' => $asia->id]);
        Country::create(['name' => "Colombia" , 'region_id' => $south_america->id]);
        Country::create(['name' => "Comoros" , 'region_id' => $africa->id]);
        Country::create(['name' => "Congo, Dem. Rep." , 'region_id' => $africa->id]);
        Country::create(['name' => "Congo, Repub. of the" , 'region_id' => $africa->id]);
        Country::create(['name' => "Cook Islands" , 'region_id' => $australia->id]);
        Country::create(['name' => "Costa Rica" , 'region_id' => $south_america->id]);
        Country::create(['name' => "Cote d'Ivoire" , 'region_id' => $africa->id]);
        Country::create(['name' => "Croatia" , 'region_id' => $europe->id]);
        Country::create(['name' => "Cuba" , 'region_id' => $south_america->id]);
        Country::create(['name' => "Cyprus" , 'region_id' => $asia->id]);
        Country::create(['name' => "Czech Republic" , 'region_id' => $europe->id]);
        Country::create(['name' => "Denmark" , 'region_id' => $europe->id]);
        Country::create(['name' => "Djibouti" , 'region_id' => $africa->id]);
        Country::create(['name' => "Dominica" , 'region_id' => $south_america->id]);
        Country::create(['name' => "Dominican Republic" , 'region_id' => $south_america->id]);
        Country::create(['name' => "East Timor" , 'region_id' => $asia->id]);
        Country::create(['name' => "Ecuador" , 'region_id' => $south_america->id]);
        Country::create(['name' => "Egypt" , 'region_id' => $middle_east->id]);
        Country::create(['name' => "El Salvador" , 'region_id' => $south_america->id]);
        Country::create(['name' => "Equatorial Guinea" , 'region_id' => $africa->id]);
        Country::create(['name' => "Eritrea" , 'region_id' => $africa->id]);
        Country::create(['name' => "Estonia" , 'region_id' => $europe->id]);
        Country::create(['name' => "Ethiopia" , 'region_id' => $africa->id]);
        Country::create(['name' => "Faroe Islands" , 'region_id' => $europe->id]);
        Country::create(['name' => "Fiji" , 'region_id' => $australia->id]);
        Country::create(['name' => "Finland" , 'region_id' => $europe->id]);
        Country::create(['name' => "France" , 'region_id' => $europe->id]);
        Country::create(['name' => "French Guiana" , 'region_id' => $south_america->id]);
        Country::create(['name' => "French Polynesia" , 'region_id' => $australia->id]);
        Country::create(['name' => "Gabon" , 'region_id' => $africa->id]);
        Country::create(['name' => "Gambia, The" , 'region_id' => $africa->id]);
        Country::create(['name' => "Georgia" , 'region_id' => $europe->id]);
        Country::create(['name' => "Germany" , 'region_id' => $europe->id]);
        Country::create(['name' => "Ghana" , 'region_id' => $africa->id]);
        Country::create(['name' => "Gibraltar" , 'region_id' => $europe->id]);
        Country::create(['name' => "Greece" , 'region_id' => $europe->id]);
        Country::create(['name' => "Greenland" , 'region_id' => $north_america->id]);
        Country::create(['name' => "Grenada" , 'region_id' => $south_america->id]);
        Country::create(['name' => "Guadeloupe" , 'region_id' => $south_america->id]);
        Country::create(['name' => "Guam" , 'region_id' => $australia->id]);
        Country::create(['name' => "Guatemala" , 'region_id' => $south_america->id]);
        Country::create(['name' => "Guernsey" , 'region_id' => $europe->id]);
        Country::create(['name' => "Guinea" , 'region_id' => $africa->id]);
        Country::create(['name' => "Guinea-Bissau" , 'region_id' => $africa->id]);
        Country::create(['name' => "Guyana" , 'region_id' => $south_america->id]);
        Country::create(['name' => "Haiti" , 'region_id' => $south_america->id]);
        Country::create(['name' => "Honduras" , 'region_id' => $south_america->id]);
        Country::create(['name' => "Hong Kong" , 'region_id' => $asia->id]);
        Country::create(['name' => "Hungary" , 'region_id' => $europe->id]);
        Country::create(['name' => "Iceland" , 'region_id' => $europe->id]);
        Country::create(['name' => "India" , 'region_id' => $asia->id]);
        Country::create(['name' => "Indonesia" , 'region_id' => $asia->id]);
        Country::create(['name' => "Iran" , 'region_id' => $middle_east->id]);
        Country::create(['name' => "Iraq" , 'region_id' => $middle_east->id]);
        Country::create(['name' => "Ireland" , 'region_id' => $europe->id]);
        Country::create(['name' => "Isle of Man" , 'region_id' => $europe->id]);
        Country::create(['name' => "Israel" , 'region_id' => $middle_east->id]);
        Country::create(['name' => "Italy" , 'region_id' => $europe->id]);
        Country::create(['name' => "Jamaica" , 'region_id' => $south_america->id]);
        Country::create(['name' => "Japan" , 'region_id' => $asia->id]);
        Country::create(['name' => "Jersey" , 'region_id' => $europe->id]);
        Country::create(['name' => "Jordan" , 'region_id' => $middle_east->id]);
        Country::create(['name' => "Kazakhstan" , 'region_id' => $asia->id]);
        Country::create(['name' => "Kenya" , 'region_id' => $africa->id]);
        Country::create(['name' => "Kiribati" , 'region_id' => $australia->id]);
        Country::create(['name' => "Korea, North" , 'region_id' => $asia->id]);
        Country::create(['name' => "Korea, South" , 'region_id' => $asia->id]);
        Country::create(['name' => "Kuwait" , 'region_id' => $middle_east->id]);
        Country::create(['name' => "Kyrgyzstan" , 'region_id' => $asia->id]);
        Country::create(['name' => "Laos" , 'region_id' => $asia->id]);
        Country::create(['name' => "Latvia" , 'region_id' => $europe->id]);
        Country::create(['name' => "Lebanon" , 'region_id' => $middle_east->id]);
        Country::create(['name' => "Lesotho" , 'region_id' => $africa->id]);
        Country::create(['name' => "Liberia" , 'region_id' => $africa->id]);
        Country::create(['name' => "Libya" , 'region_id' => $africa->id]);
        Country::create(['name' => "Liechtenstein" , 'region_id' => $europe->id]);
        Country::create(['name' => "Lithuania" , 'region_id' => $europe->id]);
        Country::create(['name' => "Luxembourg" , 'region_id' => $europe->id]);
        Country::create(['name' => "Macau" , 'region_id' => $asia->id]);
        Country::create(['name' => "Macedonia" , 'region_id' => $europe->id]);
        Country::create(['name' => "Madagascar" , 'region_id' => $africa->id]);
        Country::create(['name' => "Malawi" , 'region_id' => $africa->id]);
        Country::create(['name' => "Malaysia" , 'region_id' => $asia->id]);
        Country::create(['name' => "Maldives" , 'region_id' => $asia->id]);
        Country::create(['name' => "Mali" , 'region_id' => $africa->id]);
        Country::create(['name' => "Malta" , 'region_id' => $europe->id]);
        Country::create(['name' => "Marshall Islands" , 'region_id' => $australia->id]);
        Country::create(['name' => "Martinique" , 'region_id' => $south_america->id]);
        Country::create(['name' => "Mauritania" , 'region_id' => $africa->id]);
        Country::create(['name' => "Mauritius" , 'region_id' => $africa->id]);
        Country::create(['name' => "Mayotte" , 'region_id' => $africa->id]);
        Country::create(['name' => "Mexico" , 'region_id' => $south_america->id]);
        Country::create(['name' => "Micronesia, Fed. St." , 'region_id' => $australia->id]);
        Country::create(['name' => "Moldova" , 'region_id' => $europe->id]);
        Country::create(['name' => "Monaco" , 'region_id' => $europe->id]);
        Country::create(['name' => "Mongolia" , 'region_id' => $asia->id]);
        Country::create(['name' => "Montserrat" , 'region_id' => $south_america->id]);
        Country::create(['name' => "Morocco" , 'region_id' => $africa->id]);
        Country::create(['name' => "Mozambique" , 'region_id' => $africa->id]);
        Country::create(['name' => "Namibia" , 'region_id' => $africa->id]);
        Country::create(['name' => "Nauru" , 'region_id' => $australia->id]);
        Country::create(['name' => "Nepal" , 'region_id' => $asia->id]);
        Country::create(['name' => "Netherlands" , 'region_id' => $europe->id]);
        Country::create(['name' => "Netherlands Antilles" , 'region_id' => $south_america->id]);
        Country::create(['name' => "New Caledonia" , 'region_id' => $australia->id]);
        Country::create(['name' => "New Zealand" , 'region_id' => $australia->id]);
        Country::create(['name' => "Nicaragua" , 'region_id' => $south_america->id]);
        Country::create(['name' => "Niger" , 'region_id' => $africa->id]);
        Country::create(['name' => "Nigeria" , 'region_id' => $africa->id]);
        Country::create(['name' => "N. Mariana Islands" , 'region_id' => $australia->id]);
        Country::create(['name' => "Norway" , 'region_id' => $europe->id]);
        Country::create(['name' => "Oman" , 'region_id' => $middle_east->id]);
        Country::create(['name' => "Pakistan" , 'region_id' => $middle_east->id]);
        Country::create(['name' => "Palau" , 'region_id' => $australia->id]);
        Country::create(['name' => "Panama" , 'region_id' => $south_america->id]);
        Country::create(['name' => "Papua New Guinea" , 'region_id' => $australia->id]);
        Country::create(['name' => "Paraguay" , 'region_id' => $south_america->id]);
        Country::create(['name' => "Peru" , 'region_id' => $south_america->id]);
        Country::create(['name' => "Philippines" , 'region_id' => $asia->id]);
        Country::create(['name' => "Poland" , 'region_id' => $europe->id]);
        Country::create(['name' => "Portugal" , 'region_id' => $europe->id]);
        Country::create(['name' => "Puerto Rico" , 'region_id' => $south_america->id]);
        Country::create(['name' => "Qatar" , 'region_id' => $middle_east->id]);
        Country::create(['name' => "Reunion" , 'region_id' => $africa->id]);
        Country::create(['name' => "Romania" , 'region_id' => $europe->id]);
        Country::create(['name' => "Russia" , 'region_id' => $russia->id]);
        Country::create(['name' => "Rwanda" , 'region_id' => $africa->id]);
        Country::create(['name' => "Saint Helena" , 'region_id' => $africa->id]);
        Country::create(['name' => "Saint Kitts & Nevis" , 'region_id' => $south_america->id]);
        Country::create(['name' => "Saint Lucia" , 'region_id' => $south_america->id]);
        Country::create(['name' => "St Pierre & Miquelon" , 'region_id' => $north_america->id]);
        Country::create(['name' => "Saint Vincent and the Grenadines" , 'region_id' => $south_america->id]);
        Country::create(['name' => "Samoa" , 'region_id' => $australia->id]);
        Country::create(['name' => "San Marino" , 'region_id' => $europe->id]);
        Country::create(['name' => "Sao Tome & Principe" , 'region_id' => $africa->id]);
        Country::create(['name' => "Saudi Arabia" , 'region_id' => $middle_east->id]);
        Country::create(['name' => "Senegal" , 'region_id' => $africa->id]);
        Country::create(['name' => "Serbia" , 'region_id' => $europe->id]);
        Country::create(['name' => "Seychelles" , 'region_id' => $africa->id]);
        Country::create(['name' => "Sierra Leone" , 'region_id' => $africa->id]);
        Country::create(['name' => "Singapore" , 'region_id' => $asia->id]);
        Country::create(['name' => "Slovakia" , 'region_id' => $europe->id]);
        Country::create(['name' => "Slovenia" , 'region_id' => $europe->id]);
        Country::create(['name' => "Solomon Islands" , 'region_id' => $australia->id]);
        Country::create(['name' => "Somalia" , 'region_id' => $africa->id]);
        Country::create(['name' => "South $africa->id" , 'region_id' => $africa->id]);
        Country::create(['name' => "Spain" , 'region_id' => $europe->id]);
        Country::create(['name' => "Sri Lanka" , 'region_id' => $asia->id]);
        Country::create(['name' => "Sudan" , 'region_id' => $africa->id]);
        Country::create(['name' => "Suriname" , 'region_id' => $south_america->id]);
        Country::create(['name' => "Swaziland" , 'region_id' => $africa->id]);
        Country::create(['name' => "Sweden" , 'region_id' => $europe->id]);
        Country::create(['name' => "Switzerland" , 'region_id' => $europe->id]);
        Country::create(['name' => "Syria" , 'region_id' => $middle_east->id]);
        Country::create(['name' => "Taiwan" , 'region_id' => $asia->id]);
        Country::create(['name' => "Tajikistan" , 'region_id' => $middle_east->id]);
        Country::create(['name' => "Tanzania" , 'region_id' => $africa->id]);
        Country::create(['name' => "Thailand" , 'region_id' => $asia->id]);
        Country::create(['name' => "Togo" , 'region_id' => $africa->id]);
        Country::create(['name' => "Tonga" , 'region_id' => $australia->id]);
        Country::create(['name' => "Trinidad & Tobago" , 'region_id' => $south_america->id]);
        Country::create(['name' => "Tunisia" , 'region_id' => $africa->id]);
        Country::create(['name' => "Turkey" , 'region_id' => $middle_east->id]);
        Country::create(['name' => "Turkmenistan" , 'region_id' => $middle_east->id]);
        Country::create(['name' => "Turks & Caicos Is" , 'region_id' => $south_america->id]);
        Country::create(['name' => "Tuvalu" , 'region_id' => $australia->id]);
        Country::create(['name' => "Uganda" , 'region_id' => $africa->id]);
        Country::create(['name' => "Ukraine" , 'region_id' => $europe->id]);
        Country::create(['name' => "United Arab Emirates" , 'region_id' => $middle_east->id]);
        Country::create(['name' => "United Kingdom" , 'region_id' => $europe->id]);
        Country::create(['name' => "United States" , 'region_id' => $north_america->id]);
        Country::create(['name' => "Uruguay" , 'region_id' => $south_america->id]);
        Country::create(['name' => "Uzbekistan" , 'region_id' => $asia->id]);
        Country::create(['name' => "Vanuatu" , 'region_id' => $australia->id]);
        Country::create(['name' => "Venezuela" , 'region_id' => $south_america->id]);
        Country::create(['name' => "Vietnam" , 'region_id' => $asia->id]);
        Country::create(['name' => "Virgin Islands" , 'region_id' => $south_america->id]);
        Country::create(['name' => "Wallis and Futuna" , 'region_id' => $australia->id]);
        Country::create(['name' => "West Bank" , 'region_id' => $middle_east->id]);
        Country::create(['name' => "Western Sahara" , 'region_id' => $africa->id]);
        Country::create(['name' => "Yemen" , 'region_id' => $middle_east->id]);
        Country::create(['name' => "Zambia" , 'region_id' => $africa->id]);
        Country::create(['name' => "Zimbabwe" , 'region_id' => $africa->id]);
        Country::create(['name' => "Belize" , 'region_id' => $central_america->id]); 
        Country::create(['name' => "Costa Rica" , 'region_id' => $central_america->id]); 
        Country::create(['name' => "El Salvador" , 'region_id' => $central_america->id]); 
        Country::create(['name' => "Guatemala" , 'region_id' => $central_america->id]); 
        Country::create(['name' => "Honduras" , 'region_id' => $central_america->id]); 
        Country::create(['name' => "Nicaragua" , 'region_id' => $central_america->id]); 
        Country::create(['name' => "Panama" , 'region_id' => $central_america->id]); 


        /**
         * Product status seeders
         */
        ProductStatus::create(['name' => 'created', 'description' => 'When user creates a new post']);
        ProductStatus::create(['name' => 'approved1', 'description' => 'When the post is moved into the create state, the application will query the database to verify the user privileges. If the user is authorized to create the post, the states will be changed to "approved1"']);
        ProductStatus::create(['name' => 'posted', 'description' => 'Right after post status change from approved1']);
        ProductStatus::create(['name' => 'offer', 'description' => 'A customer shows interest and initiates into the post']);
        ProductStatus::create(['name' => 'approved2', 'description' => 'Any changes made to the original post details then this is required']);
        ProductStatus::create(['name' => 'sold', 'description' => 'Immediately after successfully changed to approved2 state']);
        ProductStatus::create(['name' => 'completed', 'description' => 'When Post creator mark complete']);
        ProductStatus::create(['name' => 'rated', 'description' => 'Both parties have successfully completed the review process']);
        ProductStatus::create(['name' => 'archived', 'description' => 'A post only available by external super-users']);
        ProductStatus::create(['name' => 'expired', 'description' => 'A date listed has arrived with out changing from a "posted" state']);


        /**
         * Product flag seeders
         */
        ProductFlag::create(['name' => 'Onsale', 'identifier' => 'onsale']);
        ProductFlag::create(['name' => 'Offerspending', 'identifier' => 'offerspending']);
        ProductFlag::create(['name' => 'Price Negotiable,', 'identifier' => 'price_negotiable']);
        ProductFlag::create(['name' => 'Expiring Soon', 'identifier' => 'expiring_soon']);
        ProductFlag::create(['name' => 'Discounted', 'identifier' => 'discounted']);


        /**
         * Category seeders
         */
        // All category
        $cat1 = Category::create(['name' => 'All Categories', 'identifier' => 'all', 'parent_id' => null ]);

        // Main categories
        $cat2 = Category::create(['name' => 'Vessels', 'identifier' => 'vessels', 'parent_id' => $cat1->id ]);
        $cat3 = Category::create(['name' => 'Inventory', 'identifier' => 'inventory', 'parent_id' => $cat1->id ]);
        $cat4 = Category::create(['name' => 'Trucks', 'identifier' => 'trucks', 'parent_id' => $cat1->id ]);
        $cat5 = Category::create(['name' => 'Helicopters', 'identifier' => 'helicopters', 'parent_id' => $cat1->id ]);
        $cat6 = Category::create(['name' => 'Spare Labour Resources', 'identifier' => 'spare_labour_resources', 'parent_id' => $cat1->id ]);
        $cat7 = Category::create(['name' => 'Consultancy / Recruitment', 'identifier' => 'consultancy_recruitment', 'parent_id' => $cat1->id ]);
        $cat8 = Category::create(['name' => 'Shore Base', 'identifier' => 'shore_base', 'parent_id' => $cat1->id ]);
        $cat9 = Category::create(['name' => 'Pipe Yard', 'identifier' => 'pipe_yard', 'parent_id' => $cat1->id ]);
        $cat10 = Category::create(['name' => 'Heavy Equipment', 'identifier' => 'heavy_equipment', 'parent_id' => $cat1->id ]);
        $cat11 = Category::create(['name' => 'Office Space', 'identifier' => 'office_space', 'parent_id' => $cat1->id ]);
        $cat12 = Category::create(['name' => 'Infrastructure Optimisation', 'identifier' => 'infrastructure_optimisation', 'parent_id' => $cat1->id ]);
        $cat13 = Category::create(['name' => 'Rig Optimization', 'identifier' => 'rig_optimization', 'parent_id' => $cat1->id ]);

        // Sub categories - Vessels
        $sub_cat1 = Category::create(['name' => 'PSVs', 'identifier' => 'psvs', 'parent_id' => $cat2->id ]);
        $sub_cat2 = Category::create(['name' => 'Crew / Personnel', 'identifier' => 'crew_personnel', 'parent_id' => $cat2->id ]);
        $sub_cat3 = Category::create(['name' => 'Anchor Handler', 'identifier' => 'anchor_handler', 'parent_id' => $cat2->id ]);
        $sub_cat4 = Category::create(['name' => 'Tug', 'identifier' => 'tug', 'parent_id' => $cat2->id ]);
        $sub_cat5 = Category::create(['name' => 'Diving & ROV', 'identifier' => 'diving_&_row', 'parent_id' => $cat2->id ]);
        $sub_cat6 = Category::create(['name' => 'Pipe Laying', 'identifier' => 'pipe_laying', 'parent_id' => $cat2->id ]);
        $sub_cat7 = Category::create(['name' => 'Heavy Lift', 'identifier' => 'heavy_lift', 'parent_id' => $cat2->id ]);
        $sub_cat8 = Category::create(['name' => 'Cable Laying', 'identifier' => 'cable_laying', 'parent_id' => $cat2->id ]);
        $sub_cat9 = Category::create(['name' => 'Barge', 'identifier' => 'barge', 'parent_id' => $cat2->id ]);

        // Sub categories - Inventory
        $sub_cat10 = Category::create(['name' => 'Casing/ Tubing', 'identifier' => 'casing_tubing', 'parent_id' => $cat3->id ]);
        $sub_cat11 = Category::create(['name' => 'Rope, Soap & Dope', 'identifier' => 'rope_soap_&_dope', 'parent_id' => $cat3->id ]);

        // Sub categories - Heavy Equipments
        $sub_cat11 = Category::create(['name' => 'Cranes', 'identifier' => 'cranes', 'parent_id' => $cat10->id ]);
        $sub_cat11 = Category::create(['name' => 'Fork Lifts', 'identifier' => 'fork_lifts', 'parent_id' => $cat10->id ]);


        /**
         * User Role seeders
         */
        $basic = Role::create(['name' => 'Basic User', 'identifier' => 'basic']);
        $csr = Role::create(['name' => 'Customer Support Representative', 'identifier' => 'csr']);
        $power = Role::create(['name' => 'Power User', 'identifier' => 'power']);
        $admin = Role::create(['name' => 'Admin', 'identifier' => 'admin']);


        /**
         * Report type seeders
         */
        ReportType::create(['type' => 'spam']);
        ReportType::create(['type' => 'broken']);
        ReportType::create(['type' => 'feedback']);


        /**
         * Doc type seeders
         */
        DocType::create(['name' => 'tnc']);
        DocType::create(['name' => 'privacy_policy']);
        DocType::create(['name' => 'legal_notes']);


        /**
         * Notification type seeders
         */
        NotificationType::create(['name' => 'Send me a message',                'identifier' => 'send_message']);
        NotificationType::create(['name' => 'Made an offer on your post',       'identifier' => 'made_offer']);
        NotificationType::create(['name' => 'Denied your offer',                'identifier' => 'denied_offer']);
        NotificationType::create(['name' => 'Approved your offer',              'identifier' => 'approved_offer']);
        NotificationType::create(['name' => 'Has confirmed your transaction',   'identifier' => 'confirmed_transaction']);
        NotificationType::create(['name' => 'Has canceled your transaction',    'identifier' => 'canceled_transaction']);
        NotificationType::create(['name' => 'A transaction started',            'identifier' => 'transaction_start']);
        NotificationType::create(['name' => 'A transaction Ended',              'identifier' => 'end_transaction']);


        /**
         * Permission seeders
         */
        // Login Permissions
        $pr1 = Permission::create(['name' =>'Access Front-end',    'identifier' => 'access_front_end',   'description'   => 'A user can access or login from Front-end']);
        $pr2 = Permission::create(['name' =>'Access Admin',        'identifier' => 'access_admin',   'description'   => 'A user can access or login from Admin']);

        // Post Permissions
        $pr3 = Permission::create(['name' =>'View a post list', 'identifier' => 'view_post_list',  'description'   => 'Can retrieve a list of posts']);
        $pr4 = Permission::create(['name' =>'View a post',      'identifier' => 'view_post',       'description'   => 'Can view a post']);
        $pr5 = Permission::create(['name' =>'Create a Post',    'identifier' => 'create_post',     'description'   => 'Can create a post']);
        $pr6 = Permission::create(['name' =>'Update a Post',    'identifier' => 'update_post',     'description'   => 'Can update a post']);
        $pr7 = Permission::create(['name' =>'Delete a Post',    'identifier' => 'delete_post',     'description'   => 'Can delete a post']);
        $pr8 = Permission::create(['name' =>'Authorize a Post', 'identifier' => 'authorize_post',  'description'   => 'Can authorize a post to be posted']);
        $pr9 = Permission::create(['name' =>'Add flag',         'identifier' => 'add_flag',        'description'   => 'Can add flags to posts']);
        $pr10 = Permission::create(['name' =>'remove flag',      'identifier' => 'remove_flag',     'description'   => 'Can remove flags from posts']);

        // Posts permissions for super users
        $pr11 = Permission::create(['name' =>'View a post list',        'identifier' => 'super_list_post',      'description'   => 'Can retrieve a list of posts for other users']);
        $pr12 = Permission::create(['name' =>'Remove a post images',    'identifier' => 'super_remove_images',  'description'   => 'Can remove post images of other users']);
        $pr13 = Permission::create(['name' =>'Super remove a post',     'identifier' => 'super_remove_post',    'description'   => 'Can remove post other users']);

        // User Permissions
        $pr14 = Permission::create(['name' =>'View a user list',  'identifier' => 'list_user',              'description'   => 'Can retrieve a list of users']);
        $pr15 = Permission::create(['name' =>'View a user',       'identifier' => 'view_user',              'description'   => 'Can view a user']);
        $pr16 = Permission::create(['name' =>'Create a user',     'identifier' => 'create_user',            'description'   => 'Can create a user']);
        $pr17 = Permission::create(['name' =>'Update a user',     'identifier' => 'update_user',            'description'   => 'Can update a user']);
        $pr18 = Permission::create(['name' =>'Delete a user',     'identifier' => 'Delete_user',            'description'   => 'Can delete a user']);
        $pr19 = Permission::create(['name' =>'Can reset password','identifier' => 'super_password_update',  'description'   => 'Can reset other users passwords']);

        // Category Permissions
        $pr20 = Permission::create(['name' =>'Add Category Image',  'identifier' => 'add_category_image',        'description'   => 'Can add a category image']);
        $pr21 = Permission::create(['name' =>'remove Category Image',  'identifier' => 'remove_category_image',     'description'   => 'Can remove a category image']);

        // Company Permissions
        $pr22 = Permission::create(['name' =>'View a Company List',  'identifier' => 'view_company_list',  'description'   => 'Can retrieve a list of companies']);
        $pr23 = Permission::create(['name' =>'View a Company',       'identifier' => 'view_company',       'description'   => 'Can view a company']);
        $pr24 = Permission::create(['name' =>'Create a Company',     'identifier' => 'create_company',     'description'   => 'Can create a company']);
        $pr25 = Permission::create(['name' =>'Update a Company',     'identifier' => 'update_company',     'description'   => 'Can update a company']);
        $pr26 = Permission::create(['name' =>'Delete a Company',     'identifier' => 'delete_company',     'description'   => 'Can delete a company']);
        $pr27 = Permission::create(['name' =>'Change a Company',     'identifier' => 'change_company',     'description'   => 'Can change a company for the given user']);

        // Product Flag Permissions
        $pr28 = Permission::create(['name' =>'Update a Product Flag',    'identifier' => 'update_flag',     'description'   => 'Can update a flag']);
        $pr29 = Permission::create(['name' =>'Delete a Product Flag',    'identifier' => 'delete_flag',     'description'   => 'Can Delete a flag']);

        // Directory and Document Permissions
        $pr30 = Permission::create(['name' =>'Create a Directory',      'identifier' => 'create_directory',             'description'   => 'Can Create a Directory']);
        $pr31 = Permission::create(['name' =>'View a Directory',        'identifier' => 'view_directory',               'description'   => 'Can View inside a Directory']);
        $pr32 = Permission::create(['name' =>'Delete a Directory',      'identifier' => 'delete_directory',             'description'   => 'Can Delete a Directory']);

        $pr33 = Permission::create(['name' =>'List the Contracts',      'identifier' => 'list_contract',                'description'   => 'Can list all the contracts']);
        $pr34 = Permission::create(['name' =>'Create a Contract',       'identifier' => 'create_contract',              'description'   => 'Can Create a contract']);
        $pr35 = Permission::create(['name' =>'Delete a Contract',       'identifier' => 'delete_contract',              'description'   => 'Can Delete a contract']);
        $pr36 = Permission::create(['name' =>'Move a Contract',         'identifier' => 'move_contract',                'description'   => 'Can Move a contract between the folders']);
        $pr37 = Permission::create(['name' =>'Download a Contract',     'identifier' => 'download_contract',            'description'   => 'Can download a contract']);

        $pr38 = Permission::create(['name' =>'Create a Directory',      'identifier' => 'super_create_directory',       'description'   => 'Can Create a Directory for other users']);
        $pr39 = Permission::create(['name' =>'View a Directory',        'identifier' => 'super_view_directory',         'description'   => 'Can View inside a Directory of another user']);
        $pr40 = Permission::create(['name' =>'Delete a Directory',      'identifier' => 'super_delete_directory',       'description'   => 'Can Delete a Directory for other users']);

        $pr41 = Permission::create(['name' =>'List the Contracts',      'identifier' => 'super_list_contract',          'description'   => 'Can list the contracts for other users']);
        $pr42 = Permission::create(['name' =>'Create a Contract',       'identifier' => 'super_create_contract',        'description'   => 'Can Create a contract for other users']);
        $pr43 = Permission::create(['name' =>'Move a Contract',         'identifier' => 'super_move_contract',          'description'   => 'Can move a contract between the folders for other users']);
        $pr44 = Permission::create(['name' =>'Delete a Contract',       'identifier' => 'super_delete_contract',        'description'   => 'Can Delete a contract for other users']);

        // Transactions api
        $pr45 = Permission::create(['name' =>'List transactions for others',                'identifier' => 'super_list_transaction',        'description'   => 'Can list transactions for other users']);
        $pr46 = Permission::create(['name' =>'Approve transactions for other parties',      'identifier' => 'super_approve_transaction',     'description'   => 'Can approve the transaction of other users']);
        $pr47 = Permission::create(['name' =>'Deny transactions for other parties',         'identifier' => 'super_deny_transaction',        'description'   => 'Can deny the transaction of other users']);
        $pr48 = Permission::create(['name' =>'Can validate the users validation requests',  'identifier' => 'super_validate',                'description'   => 'Can validate the transaction of other users, Super admin role']);


        // Contract Types
        ContractType::create(['name' =>'ROOT']);
        ContractType::create(['name' =>'FOLDER']);
        ContractType::create(['name' =>'DOCUMENT']);


        // Transaction stages
        TransactionStage::create(['name' =>'Offer Stage',  'identifier' => 'offer_stage']);
        TransactionStage::create(['name' =>'Buyer/Seller Approved',  'identifier' => 'buyer_seller_approved']);
        TransactionStage::create(['name' =>'Pending Admin Approval',  'identifier' => 'pending_admin_approval']);
        TransactionStage::create(['name' =>'Admin Approved',  'identifier' => 'admin_approved']);
        TransactionStage::create(['name' =>'Ongoing',  'identifier' => 'ongoing']);
        TransactionStage::create(['name' =>'Rating',  'identifier' => 'rating']);
        TransactionStage::create(['name' =>'Expired',  'identifier' => 'expired']);
        TransactionStage::create(['name' =>'Validation Pending',  'identifier' => 'validation_pending']);
        TransactionStage::create(['name' =>'Validation Approved',  'identifier' => 'validation_denied']);

        // attach basic
        $basic->permissions()->attach($pr1->id);
        $basic->permissions()->attach($pr2->id);
        $basic->permissions()->attach($pr3->id);
        $basic->permissions()->attach($pr4->id);
        $basic->permissions()->attach($pr5->id);
        $basic->permissions()->attach($pr6->id);
        $basic->permissions()->attach($pr7->id);
        $basic->permissions()->attach($pr8->id);
        $basic->permissions()->attach($pr9->id);
        $basic->permissions()->attach($pr10->id);
        $basic->permissions()->attach($pr11->id);
        $basic->permissions()->attach($pr12->id);
        $basic->permissions()->attach($pr13->id);
        $basic->permissions()->attach($pr14->id);
        $basic->permissions()->attach($pr15->id);
        $basic->permissions()->attach($pr16->id);
        $basic->permissions()->attach($pr17->id);
        $basic->permissions()->attach($pr18->id);
        $basic->permissions()->attach($pr19->id);
        $basic->permissions()->attach($pr20->id);
        $basic->permissions()->attach($pr21->id);
        $basic->permissions()->attach($pr22->id);
        $basic->permissions()->attach($pr23->id);
        $basic->permissions()->attach($pr24->id);
        $basic->permissions()->attach($pr25->id);
        $basic->permissions()->attach($pr26->id);
        $basic->permissions()->attach($pr27->id);
        $basic->permissions()->attach($pr28->id);
        $basic->permissions()->attach($pr29->id);
        $basic->permissions()->attach($pr30->id);
        $basic->permissions()->attach($pr31->id);
        $basic->permissions()->attach($pr32->id);
        $basic->permissions()->attach($pr33->id);
        $basic->permissions()->attach($pr34->id);
        $basic->permissions()->attach($pr35->id);
        $basic->permissions()->attach($pr36->id);
        $basic->permissions()->attach($pr37->id);
        $basic->permissions()->attach($pr38->id);
        $basic->permissions()->attach($pr39->id);
        $basic->permissions()->attach($pr40->id);
        $basic->permissions()->attach($pr41->id);
        $basic->permissions()->attach($pr42->id);
        $basic->permissions()->attach($pr43->id);
        $basic->permissions()->attach($pr44->id);
        $basic->permissions()->attach($pr45->id);
        $basic->permissions()->attach($pr46->id);
        $basic->permissions()->attach($pr47->id);
        $basic->permissions()->attach($pr48->id);

        // CSR Permissions
        $csr->permissions()->attach($pr1->id);
        $csr->permissions()->attach($pr2->id);
        $csr->permissions()->attach($pr3->id);
        $csr->permissions()->attach($pr4->id);
        $csr->permissions()->attach($pr5->id);
        $csr->permissions()->attach($pr6->id);
        $csr->permissions()->attach($pr7->id);
        $csr->permissions()->attach($pr8->id);
        $csr->permissions()->attach($pr9->id);
        $csr->permissions()->attach($pr10->id);
        $csr->permissions()->attach($pr11->id);
        $csr->permissions()->attach($pr12->id);
        $csr->permissions()->attach($pr13->id);
        $csr->permissions()->attach($pr14->id);
        $csr->permissions()->attach($pr15->id);
        $csr->permissions()->attach($pr16->id);
        $csr->permissions()->attach($pr17->id);
        $csr->permissions()->attach($pr18->id);
        $csr->permissions()->attach($pr19->id);
        $csr->permissions()->attach($pr20->id);
        $csr->permissions()->attach($pr21->id);
        $csr->permissions()->attach($pr22->id);
        $csr->permissions()->attach($pr23->id);
        $csr->permissions()->attach($pr24->id);
        $csr->permissions()->attach($pr25->id);
        $csr->permissions()->attach($pr26->id);
        $csr->permissions()->attach($pr27->id);
        $csr->permissions()->attach($pr28->id);
        $csr->permissions()->attach($pr29->id);
        $csr->permissions()->attach($pr30->id);
        $csr->permissions()->attach($pr31->id);
        $csr->permissions()->attach($pr32->id);
        $csr->permissions()->attach($pr33->id);
        $csr->permissions()->attach($pr34->id);
        $csr->permissions()->attach($pr35->id);
        $csr->permissions()->attach($pr36->id);
        $csr->permissions()->attach($pr37->id);
        $csr->permissions()->attach($pr38->id);
        $csr->permissions()->attach($pr39->id);
        $csr->permissions()->attach($pr40->id);
        $csr->permissions()->attach($pr41->id);
        $csr->permissions()->attach($pr42->id);
        $csr->permissions()->attach($pr43->id);
        $csr->permissions()->attach($pr44->id);
        $csr->permissions()->attach($pr45->id);
        $csr->permissions()->attach($pr46->id);
        $csr->permissions()->attach($pr47->id);
        $csr->permissions()->attach($pr48->id);

        // Power Permissions
        $power->permissions()->attach($pr1->id);
        $power->permissions()->attach($pr2->id);
        $power->permissions()->attach($pr3->id);
        $power->permissions()->attach($pr4->id);
        $power->permissions()->attach($pr5->id);
        $power->permissions()->attach($pr6->id);
        $power->permissions()->attach($pr7->id);
        $power->permissions()->attach($pr8->id);
        $power->permissions()->attach($pr9->id);
        $power->permissions()->attach($pr10->id);
        $power->permissions()->attach($pr11->id);
        $power->permissions()->attach($pr12->id);
        $power->permissions()->attach($pr13->id);
        $power->permissions()->attach($pr14->id);
        $power->permissions()->attach($pr15->id);
        $power->permissions()->attach($pr16->id);
        $power->permissions()->attach($pr17->id);
        $power->permissions()->attach($pr18->id);
        $power->permissions()->attach($pr19->id);
        $power->permissions()->attach($pr20->id);
        $power->permissions()->attach($pr21->id);
        $power->permissions()->attach($pr22->id);
        $power->permissions()->attach($pr23->id);
        $power->permissions()->attach($pr24->id);
        $power->permissions()->attach($pr25->id);
        $power->permissions()->attach($pr26->id);
        $power->permissions()->attach($pr27->id);
        $power->permissions()->attach($pr28->id);
        $power->permissions()->attach($pr29->id);
        $power->permissions()->attach($pr30->id);
        $power->permissions()->attach($pr31->id);
        $power->permissions()->attach($pr32->id);
        $power->permissions()->attach($pr33->id);
        $power->permissions()->attach($pr34->id);
        $power->permissions()->attach($pr35->id);
        $power->permissions()->attach($pr36->id);
        $power->permissions()->attach($pr37->id);
        $power->permissions()->attach($pr38->id);
        $power->permissions()->attach($pr39->id);
        $power->permissions()->attach($pr40->id);
        $power->permissions()->attach($pr41->id);
        $power->permissions()->attach($pr42->id);
        $power->permissions()->attach($pr43->id);
        $power->permissions()->attach($pr44->id);
        $power->permissions()->attach($pr45->id);
        $power->permissions()->attach($pr46->id);
        $power->permissions()->attach($pr47->id);
        $power->permissions()->attach($pr48->id);

        // Admin permissions
        $admin->permissions()->attach($pr1->id);
        $admin->permissions()->attach($pr2->id);
        $admin->permissions()->attach($pr3->id);
        $admin->permissions()->attach($pr4->id);
        $admin->permissions()->attach($pr5->id);
        $admin->permissions()->attach($pr6->id);
        $admin->permissions()->attach($pr7->id);
        $admin->permissions()->attach($pr8->id);
        $admin->permissions()->attach($pr9->id);
        $admin->permissions()->attach($pr10->id);
        $admin->permissions()->attach($pr11->id);
        $admin->permissions()->attach($pr12->id);
        $admin->permissions()->attach($pr13->id);
        $admin->permissions()->attach($pr14->id);
        $admin->permissions()->attach($pr15->id);
        $admin->permissions()->attach($pr16->id);
        $admin->permissions()->attach($pr17->id);
        $admin->permissions()->attach($pr18->id);
        $admin->permissions()->attach($pr19->id);
        $admin->permissions()->attach($pr20->id);
        $admin->permissions()->attach($pr21->id);
        $admin->permissions()->attach($pr22->id);
        $admin->permissions()->attach($pr23->id);
        $admin->permissions()->attach($pr24->id);
        $admin->permissions()->attach($pr25->id);
        $admin->permissions()->attach($pr26->id);
        $admin->permissions()->attach($pr27->id);
        $admin->permissions()->attach($pr28->id);
        $admin->permissions()->attach($pr29->id);
        $admin->permissions()->attach($pr30->id);
        $admin->permissions()->attach($pr31->id);
        $admin->permissions()->attach($pr32->id);
        $admin->permissions()->attach($pr33->id);
        $admin->permissions()->attach($pr34->id);
        $admin->permissions()->attach($pr35->id);
        $admin->permissions()->attach($pr36->id);
        $admin->permissions()->attach($pr37->id);
        $admin->permissions()->attach($pr38->id);
        $admin->permissions()->attach($pr39->id);
        $admin->permissions()->attach($pr40->id);
        $admin->permissions()->attach($pr41->id);
        $admin->permissions()->attach($pr42->id);
        $admin->permissions()->attach($pr43->id);
        $admin->permissions()->attach($pr44->id);
        $admin->permissions()->attach($pr45->id);
        $admin->permissions()->attach($pr46->id);
        $admin->permissions()->attach($pr47->id);
        $admin->permissions()->attach($pr48->id);
    }

}
