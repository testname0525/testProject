<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Company;
use Illuminate\Support\Facades\DB;

class CreateCompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('companies')->insert([
            
            'company_name' => 'サントリーホールディングス',
            'street_address' => 'JAPAN',
            'representative_name' => 'something',
        ]);

        DB::table('companies')->insert([
            
            'company_name' => 'コカ・コーラボトラーズジャパンホールディングス',
            'street_address' => 'AMERICA',
            'representative_name' => 'something',
        ]);

        DB::table('companies')->insert([
            
            'company_name' => 'アサヒグループホールディングス',
            'street_address' => 'JAPAN',
            'representative_name' => 'something',
        ]);

        DB::table('companies')->insert([
            
            'company_name' => '伊藤園',
            'street_address' => 'JAPAN',
            'representative_name' => 'something',
        ]);

        DB::table('companies')->insert([
            
            'company_name' => 'ヤクルト',
            'street_address' => 'JAPAN',
            'representative_name' => 'something',
        ]);

        DB::table('companies')->insert([
            
            'company_name' => '大塚ホールディングス',
            'street_address' => 'JAPAN',
            'representative_name' => 'something',
        ]);

        DB::table('companies')->insert([
            
            'company_name' => 'キリンホールディングス',
            'street_address' => 'JAPAN',
            'representative_name' => 'something',
        ]);

        DB::table('companies')->insert([
            
            'company_name' => 'ダイドーグループホールディングス',
            'street_address' => 'JAPAN',
            'representative_name' => 'something',
        ]);

        DB::table('companies')->insert([
            
            'company_name' => 'サッポロホールディングス',
            'street_address' => 'JAPAN',
            'representative_name' => 'something',
        ]);

        DB::table('companies')->insert([
            
            'company_name' => 'カゴメ',
            'street_address' => 'JAPAN',
            'representative_name' => 'something',
        ]);

        DB::table('companies')->insert([
            
            'company_name' => 'etc',
            'street_address' => 'JAPAN',
            'representative_name' => 'something',
        ]);
    }
}
