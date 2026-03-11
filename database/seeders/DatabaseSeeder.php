<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Vehicle;
use App\Models\ServiceRequest;
use App\Models\Diagnostic;
use App\Models\Repair;
use App\Models\RepairPart;
use App\Models\Part;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Korisnici
        $klijent1 = User::create([
            'name'     => 'Jovan',
            'surname'  => 'Petrović',
            'email'    => 'klijent@tahoservis.com',
            'password' => Hash::make('password123'),
            'phone'    => '+381 60 111 2233',
            'role'     => 'klijent',
        ]);

        $klijent2 = User::create([
            'name'     => 'Ana',
            'surname'  => 'Ković',
            'email'    => 'ana@tahoservis.com',
            'password' => Hash::make('password123'),
            'phone'    => '+381 60 222 3344',
            'role'     => 'klijent',
        ]);

        $serviser = User::create([
            'name'     => 'Marko',
            'surname'  => 'Nikolić',
            'email'    => 'serviser@tahoservis.com',
            'password' => Hash::make('password123'),
            'phone'    => '+381 60 333 4455',
            'role'     => 'serviser',
        ]);

        $serviser = User::create([
            'name'     => 'Dimitrije',
            'surname'  => 'Riznic',
            'email'    => 'dimi@gmail.com',
            'password' => Hash::make('password123'),
            'phone'    => '+381 233 5592',
            'role'     => 'serviser',
        ]);

        User::create([
            'name'     => 'Admin',
            'surname'  => 'Tahoshop',
            'email'    => 'admin@tahoservis.com',
            'password' => Hash::make('password123'),
            'phone'    => '+381 60 999 8877',
            'role'     => 'administrator',
        ]);

        // Vozila
        $vozilo1 = Vehicle::create([
            'user_id'      => $klijent1->id,
            'registration' => 'BG-123-AB',
            'brand'        => 'Volkswagen',
            'model'        => 'Transporter',
        ]);

        $vozilo2 = Vehicle::create([
            'user_id'      => $klijent1->id,
            'registration' => 'NS-456-CD',
            'brand'        => 'Mercedes',
            'model'        => 'Sprinter',
        ]);

        $vozilo3 = Vehicle::create([
            'user_id'      => $klijent2->id,
            'registration' => 'BG-789-EF',
            'brand'        => 'Ford',
            'model'        => 'Transit',
        ]);

        $vozilo4 = Vehicle::create([
            'user_id'      => $klijent2->id,
            'registration' => 'KG-321-GH',
            'brand'        => 'Iveco',
            'model'        => 'Daily',
        ]);

        // Delovi
        $deo1 = Part::create(['name' => 'Senzor brzine',      'code' => 'SB-001', 'supplier' => 'VDO',        'quantity' => 8]);
        $deo2 = Part::create(['name' => 'Plomba tahografa',   'code' => 'PT-002', 'supplier' => 'Siemens',    'quantity' => 25]);
        $deo3 = Part::create(['name' => 'Konektor tahografa', 'code' => 'KT-003', 'supplier' => 'VDO',        'quantity' => 2]);
        $deo4 = Part::create(['name' => 'Baterija tahografa', 'code' => 'BT-004', 'supplier' => 'Bosch',      'quantity' => 5]);
        $deo5 = Part::create(['name' => 'Štampač tahografa',  'code' => 'ST-005', 'supplier' => 'Stoneridge', 'quantity' => 1]);

        // STATUS: zakazano
        ServiceRequest::create([
            'user_id'         => $klijent1->id,
            'vehicle_id'      => $vozilo1->id,
            'serviser_id'     => null,
            'tachograph_type' => 'digitalni',
            'description'     => 'Tahograf ne beleži brzinu ispravno.',
            'desired_date'    => now()->addDays(3),
            'phone'           => '+381 60 111 2233',
            'status'          => 'zakazano',
        ]);

        ServiceRequest::create([
            'user_id'         => $klijent2->id,
            'vehicle_id'      => $vozilo3->id,
            'serviser_id'     => null,
            'tachograph_type' => 'analogni',
            'description'     => 'Redovna kalibracija tahografa.',
            'desired_date'    => now()->addDays(5),
            'phone'           => '+381 60 222 3344',
            'status'          => 'zakazano',
        ]);

        // STATUS: zavrsena_dijagnostika
        $sr3 = ServiceRequest::create([
            'user_id'         => $klijent1->id,
            'vehicle_id'      => $vozilo2->id,
            'serviser_id'     => $serviser->id,
            'tachograph_type' => 'digitalni',
            'description'     => 'Istek kalibracije tahografa.',
            'desired_date'    => now()->subDays(1),
            'phone'           => '+381 60 111 2233',
            'status'          => 'zavrsena_dijagnostika',
        ]);

        Diagnostic::create([
            'service_request_id'  => $sr3->id,
            'problem_description' => 'Tahograf nije kalibrisan u poslednjih 2 godine.',
            'diagnostic_results'  => 'Senzor brzine pokazuje odstupanja od 5%.',
            'recommended_work'    => 'Zamena senzora brzine i kalibracija.',
        ]);

        // STATUS: zavrsena_dijagnostika
        $sr4 = ServiceRequest::create([
            'user_id'         => $klijent2->id,
            'vehicle_id'      => $vozilo4->id,
            'serviser_id'     => $serviser->id,
            'tachograph_type' => 'analogni',
            'description'     => 'Štampač ne štampa ispravno.',
            'desired_date'    => now()->subDays(2),
            'phone'           => '+381 60 222 3344',
            'status'          => 'zavrsena_dijagnostika',
        ]);

        Diagnostic::create([
            'service_request_id'  => $sr4->id,
            'problem_description' => 'Papirna traka se zaglavljivala tokom štampanja.',
            'diagnostic_results'  => 'Štampač tahografa oštećen.',
            'recommended_work'    => 'Zamena štampača tahografa.',
        ]);

        // STATUS: zavrseno
        $sr5 = ServiceRequest::create([
            'user_id'         => $klijent1->id,
            'vehicle_id'      => $vozilo1->id,
            'serviser_id'     => $serviser->id,
            'tachograph_type' => 'digitalni',
            'description'     => 'Zamena konektora tahografa.',
            'desired_date'    => now()->subDays(10),
            'phone'           => '+381 60 111 2233',
            'status'          => 'zavrseno',
        ]);

        Diagnostic::create([
            'service_request_id'  => $sr5->id,
            'problem_description' => 'Konektor tahografa fizički oštećen.',
            'diagnostic_results'  => 'Potvrđena neispravnost konektora.',
            'recommended_work'    => 'Zamena konektora tahografa.',
        ]);

        $repair1 = Repair::create([
            'service_request_id' => $sr5->id,
            'work_done'          => 'Zamenjen konektor tahografa. Izvršena kalibracija i testiranje.',
            'seal_number'        => 'PL-2026-00101',
        ]);

        RepairPart::create([
            'repair_id'     => $repair1->id,
            'part_id'       => $deo3->id,
            'quantity_used' => 1,
        ]);

        // STATUS: zavrseno
        $sr6 = ServiceRequest::create([
            'user_id'         => $klijent2->id,
            'vehicle_id'      => $vozilo3->id,
            'serviser_id'     => $serviser->id,
            'tachograph_type' => 'analogni',
            'description'     => 'Redovni servis i plombiranje.',
            'desired_date'    => now()->subDays(15),
            'phone'           => '+381 60 222 3344',
            'status'          => 'zavrseno',
        ]);

        Diagnostic::create([
            'service_request_id'  => $sr6->id,
            'problem_description' => 'Redovni pregled po zahtevu klijenta.',
            'diagnostic_results'  => 'Sve u ispravnom stanju, potrebno samo plombiranje.',
            'recommended_work'    => 'Plombiranje tahografa.',
        ]);

        $repair2 = Repair::create([
            'service_request_id' => $sr6->id,
            'work_done'          => 'Izvršeno plombiranje tahografa. Zamenjena baterija.',
            'seal_number'        => 'PL-2026-00102',
        ]);

        RepairPart::create([
            'repair_id'     => $repair2->id,
            'part_id'       => $deo2->id,
            'quantity_used' => 2,
        ]);

        RepairPart::create([
            'repair_id'     => $repair2->id,
            'part_id'       => $deo4->id,
            'quantity_used' => 1,
        ]);
    }
}