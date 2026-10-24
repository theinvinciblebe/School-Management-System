<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AccountingSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Transactions across 2026
        DB::table('transactions')->truncate();

        $transactions = [
            // Income
            ['date' => '2026-01-15', 'type' => 'profit', 'category' => 'Tuition Fees', 'amount' => 12450.00, 'note' => 'Q1 Academic Term Tuition Fees'],
            ['date' => '2026-01-22', 'type' => 'profit', 'category' => 'Admission Fees', 'amount' => 2800.00, 'note' => 'New Student Registrations'],
            ['date' => '2026-02-10', 'type' => 'profit', 'category' => 'Laboratory & Facilities', 'amount' => 3200.00, 'note' => 'STEM Lab and Computer Usage Fees'],
            ['date' => '2026-03-05', 'type' => 'profit', 'category' => 'Library Subscriptions', 'amount' => 1450.00, 'note' => 'Digital Library & Book Rental Access'],
            ['date' => '2026-04-18', 'type' => 'profit', 'category' => 'Tuition Fees', 'amount' => 14800.00, 'note' => 'Q2 Academic Term Tuition Fees'],
            ['date' => '2026-05-12', 'type' => 'profit', 'category' => 'Sports & Cultural Fund', 'amount' => 2100.00, 'note' => 'Annual Inter-school Tournament Fees'],
            ['date' => '2026-06-20', 'type' => 'profit', 'category' => 'Summer Programs', 'amount' => 3750.00, 'note' => 'Summer Camp & Robotics Workshops'],
            ['date' => '2026-07-15', 'type' => 'profit', 'category' => 'Tuition Fees', 'amount' => 15200.00, 'note' => 'Q3 Academic Term Tuition Fees'],
            ['date' => '2026-08-22', 'type' => 'profit', 'category' => 'Uniform & Merchandise', 'amount' => 2890.00, 'note' => 'School Uniforms & Physical Kits'],
            ['date' => '2026-09-10', 'type' => 'profit', 'category' => 'Examination Fees', 'amount' => 4300.00, 'note' => 'Midterm Assessment & Certifications'],
            ['date' => '2026-10-05', 'type' => 'profit', 'category' => 'Tuition Fees', 'amount' => 16500.00, 'note' => 'Q4 Academic Term Tuition Fees'],
            ['date' => '2026-10-18', 'type' => 'profit', 'category' => 'Transportation Fees', 'amount' => 3100.00, 'note' => 'Monthly School Bus Services'],

            // Expenses
            ['date' => '2026-01-28', 'type' => 'expense', 'category' => 'Staff Salaries', 'amount' => 8500.00, 'note' => 'January Faculty & Staff Payroll'],
            ['date' => '2026-02-15', 'type' => 'expense', 'category' => 'Electricity & Utilities', 'amount' => 1350.00, 'note' => 'Campus Electricity & Water Bills'],
            ['date' => '2026-02-28', 'type' => 'expense', 'category' => 'Staff Salaries', 'amount' => 8500.00, 'note' => 'February Faculty & Staff Payroll'],
            ['date' => '2026-03-20', 'type' => 'expense', 'category' => 'Lab Consumables', 'amount' => 2400.00, 'note' => 'Physics & Chemistry Consumables'],
            ['date' => '2026-03-31', 'type' => 'expense', 'category' => 'Staff Salaries', 'amount' => 8700.00, 'note' => 'March Faculty & Staff Payroll'],
            ['date' => '2026-04-15', 'type' => 'expense', 'category' => 'Building Maintenance', 'amount' => 1850.00, 'note' => 'HVAC Servicing & Roof Repairs'],
            ['date' => '2026-04-30', 'type' => 'expense', 'category' => 'Staff Salaries', 'amount' => 8700.00, 'note' => 'April Faculty & Staff Payroll'],
            ['date' => '2026-05-25', 'type' => 'expense', 'category' => 'Software & Subscriptions', 'amount' => 950.00, 'note' => 'LMS & Google Workspace Annual Licenses'],
            ['date' => '2026-05-31', 'type' => 'expense', 'category' => 'Staff Salaries', 'amount' => 8700.00, 'note' => 'May Faculty & Staff Payroll'],
            ['date' => '2026-06-30', 'type' => 'expense', 'category' => 'Staff Salaries', 'amount' => 8700.00, 'note' => 'June Faculty & Staff Payroll'],
            ['date' => '2026-07-10', 'type' => 'expense', 'category' => 'Security & Sanitation', 'amount' => 1200.00, 'note' => 'Monthly Campus Security Contractor'],
            ['date' => '2026-07-31', 'type' => 'expense', 'category' => 'Staff Salaries', 'amount' => 8900.00, 'note' => 'July Faculty & Staff Payroll'],
            ['date' => '2026-08-18', 'type' => 'expense', 'category' => 'Sports Equipment', 'amount' => 1420.00, 'note' => 'Football, Volleyball & Track Upgrades'],
            ['date' => '2026-08-31', 'type' => 'expense', 'category' => 'Staff Salaries', 'amount' => 8900.00, 'note' => 'August Faculty & Staff Payroll'],
            ['date' => '2026-09-25', 'type' => 'expense', 'category' => 'Internet & Telecommunications', 'amount' => 780.00, 'note' => 'Campus Dedicated Fiber Optical Line'],
            ['date' => '2026-09-30', 'type' => 'expense', 'category' => 'Staff Salaries', 'amount' => 8900.00, 'note' => 'September Faculty & Staff Payroll'],
            ['date' => '2026-10-15', 'type' => 'expense', 'category' => 'IT Infrastructure', 'amount' => 1450.00, 'note' => 'Computer Lab Network Switches Upgrade'],
            ['date' => '2026-10-22', 'type' => 'expense', 'category' => 'Office Supplies', 'amount' => 480.00, 'note' => 'Paper, Toners, Printer Cartridges'],
        ];

        foreach ($transactions as $t) {
            DB::table('transactions')->insert([
                'date' => $t['date'],
                'type' => $t['type'],
                'category' => $t['category'],
                'amount' => $t['amount'],
                'note' => $t['note'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // 2. Purchase Requests
        DB::table('purchase_request')->truncate();
        DB::table('purchase_request_items')->truncate();

        $pr1 = DB::table('purchase_request')->insertGetId([
            'requisitioner' => 'School Administrator',
            'department' => 'Administrative',
            'purpose' => 'Computer Lab Network Equipment Upgrade',
            'request_no' => 'PR-2026-001',
            'total' => 1450.00,
            'vendor' => 'TechZone Sol.',
            'date_prepared' => '2026-10-10',
            'date_needed' => '2026-10-20',
            'user_id' => 1,
            'approved_by' => 1,
            'status' => 'approved',
            'created_at' => now()->subDays(14),
            'updated_at' => now()->subDays(10),
        ]);
        DB::table('purchase_request_items')->insert([
            ['purchase_request_id' => $pr1, 'description' => 'Gigabit Managed Switches 24-Port', 'asset_class' => 'IT Equipment', 'qty' => 3, 'unit' => 'pcs', 'unit_price' => 250.00, 'total_price' => 750.00, 'created_at' => now(), 'updated_at' => now()],
            ['purchase_request_id' => $pr1, 'description' => 'Cat6 Ethernet Cable Reels (305m)', 'asset_class' => 'Consumables', 'qty' => 4, 'unit' => 'reels', 'unit_price' => 100.00, 'total_price' => 400.00, 'created_at' => now(), 'updated_at' => now()],
            ['purchase_request_id' => $pr1, 'description' => 'Wall-mount Server Cabinet 9U', 'asset_class' => 'Furniture', 'qty' => 2, 'unit' => 'units', 'unit_price' => 150.00, 'total_price' => 300.00, 'created_at' => now(), 'updated_at' => now()],
        ]);

        $pr2 = DB::table('purchase_request')->insertGetId([
            'requisitioner' => 'phy',
            'department' => 'Accounting & Finance',
            'purpose' => 'Annual External Financial Audit Service',
            'request_no' => 'PR-2026-002',
            'total' => 850.00,
            'vendor' => 'KPMG Advisory Group',
            'date_prepared' => '2026-10-12',
            'date_needed' => '2026-10-25',
            'user_id' => 5,
            'approved_by' => 1,
            'status' => 'approved',
            'created_at' => now()->subDays(12),
            'updated_at' => now()->subDays(8),
        ]);
        DB::table('purchase_request_items')->insert([
            ['purchase_request_id' => $pr2, 'description' => 'External Financial Compliance Audit', 'asset_class' => 'Professional Services', 'qty' => 1, 'unit' => 'service', 'unit_price' => 850.00, 'total_price' => 850.00, 'created_at' => now(), 'updated_at' => now()],
        ]);

        $pr3 = DB::table('purchase_request')->insertGetId([
            'requisitioner' => 'TeacherTest',
            'department' => 'Science & Mathematics',
            'purpose' => 'Chemistry Laboratory Glassware & Safety Goggles',
            'request_no' => 'PR-2026-003',
            'total' => 620.00,
            'vendor' => 'Apex Scientific Supplies',
            'date_prepared' => '2026-10-22',
            'date_needed' => '2026-10-30',
            'user_id' => 3,
            'approved_by' => null,
            'status' => 'pending',
            'created_at' => now()->subDays(2),
            'updated_at' => now()->subDays(2),
        ]);
        DB::table('purchase_request_items')->insert([
            ['purchase_request_id' => $pr3, 'description' => 'Borosilicate Beaker Sets (250ml/500ml)', 'asset_class' => 'Lab Consumable', 'qty' => 20, 'unit' => 'sets', 'unit_price' => 16.00, 'total_price' => 320.00, 'created_at' => now(), 'updated_at' => now()],
            ['purchase_request_id' => $pr3, 'description' => 'ANSI Certified Student Safety Goggles', 'asset_class' => 'Safety Gear', 'qty' => 60, 'unit' => 'pcs', 'unit_price' => 5.00, 'total_price' => 300.00, 'created_at' => now(), 'updated_at' => now()],
        ]);

        $pr4 = DB::table('purchase_request')->insertGetId([
            'requisitioner' => 'ReceptionistTest',
            'department' => 'Reception & Admissions',
            'purpose' => '2027 Admission Prospectus & Welcome Packets',
            'request_no' => 'PR-2026-004',
            'total' => 340.00,
            'vendor' => 'Phnom Penh Printing Press',
            'date_prepared' => '2026-10-23',
            'date_needed' => '2026-11-05',
            'user_id' => 6,
            'approved_by' => null,
            'status' => 'pending',
            'created_at' => now()->subDay(),
            'updated_at' => now()->subDay(),
        ]);
        DB::table('purchase_request_items')->insert([
            ['purchase_request_id' => $pr4, 'description' => 'Glossy Full-Color Admission Folders', 'asset_class' => 'Marketing', 'qty' => 500, 'unit' => 'copies', 'unit_price' => 0.68, 'total_price' => 340.00, 'created_at' => now(), 'updated_at' => now()],
        ]);

        $pr5 = DB::table('purchase_request')->insertGetId([
            'requisitioner' => 'TeacherTest',
            'department' => 'Science & Mathematics',
            'purpose' => 'Personal Office Recliner Chair',
            'request_no' => 'PR-2026-005',
            'total' => 280.00,
            'vendor' => 'Comfort Furniture',
            'date_prepared' => '2026-10-15',
            'date_needed' => '2026-10-22',
            'user_id' => 3,
            'approved_by' => 1,
            'status' => 'rejected',
            'created_at' => now()->subDays(9),
            'updated_at' => now()->subDays(7),
        ]);
        DB::table('purchase_request_items')->insert([
            ['purchase_request_id' => $pr5, 'description' => 'Executive Reclining Office Chair', 'asset_class' => 'Furniture', 'qty' => 1, 'unit' => 'unit', 'unit_price' => 280.00, 'total_price' => 280.00, 'created_at' => now(), 'updated_at' => now()],
        ]);

        // 3. Fee Receipts
        DB::table('fee_receipt')->truncate();
        DB::table('fee_receipt_items')->truncate();

        $fr1 = DB::table('fee_receipt')->insertGetId([
            'student_class_id' => 1,
            'date' => '2026-10-01',
            'receipt_no' => 'REC-2026-001',
            'grand_total' => 650.00,
            'previous_balance' => 0.00,
            'paid' => 400.00,
            'paid_via' => 'Bank Transfer (ABA)',
            'remaining_balance' => 250.00,
            'status' => 'approved',
            'user_id' => 1,
            'approved_by' => 1,
            'created_at' => now()->subDays(23),
            'updated_at' => now()->subDays(23),
        ]);
        DB::table('fee_receipt_items')->insert([
            ['fee_receipt_id' => $fr1, 'description' => 'Tuition Fee - Term 4', 'qty' => 1, 'price' => 500.00, 'discount' => 0, 'duration' => 'Term 4 (3 Months)', 'total' => 500.00, 'created_at' => now(), 'updated_at' => now()],
            ['fee_receipt_id' => $fr1, 'description' => 'Computer & Lab Fee', 'qty' => 1, 'price' => 100.00, 'discount' => 0, 'duration' => 'Term 4', 'total' => 100.00, 'created_at' => now(), 'updated_at' => now()],
            ['fee_receipt_id' => $fr1, 'description' => 'Library Pass & Security Deposit', 'qty' => 1, 'price' => 50.00, 'discount' => 0, 'duration' => 'Annual', 'total' => 50.00, 'created_at' => now(), 'updated_at' => now()],
        ]);

        $fr2 = DB::table('fee_receipt')->insertGetId([
            'student_class_id' => 1,
            'date' => '2026-10-18',
            'receipt_no' => 'REC-2026-002',
            'grand_total' => 250.00,
            'previous_balance' => 250.00,
            'paid' => 250.00,
            'paid_via' => 'Cash',
            'remaining_balance' => 0.00,
            'status' => 'approved',
            'user_id' => 1,
            'approved_by' => 1,
            'created_at' => now()->subDays(6),
            'updated_at' => now()->subDays(6),
        ]);
        DB::table('fee_receipt_items')->insert([
            ['fee_receipt_id' => $fr2, 'description' => 'Remaining Balance Clearance - Term 4', 'qty' => 1, 'price' => 250.00, 'discount' => 0, 'duration' => 'Clearance', 'total' => 250.00, 'created_at' => now(), 'updated_at' => now()],
        ]);

        $fr3 = DB::table('fee_receipt')->insertGetId([
            'student_class_id' => 1,
            'date' => '2026-10-23',
            'receipt_no' => 'REC-2026-003',
            'grand_total' => 120.00,
            'previous_balance' => 0.00,
            'paid' => 120.00,
            'paid_via' => 'ABA Payway',
            'remaining_balance' => 0.00,
            'status' => 'pending',
            'user_id' => 6,
            'approved_by' => null,
            'created_at' => now()->subDay(),
            'updated_at' => now()->subDay(),
        ]);
        DB::table('fee_receipt_items')->insert([
            ['fee_receipt_id' => $fr3, 'description' => 'Cambridge English Examination Registration', 'qty' => 1, 'price' => 120.00, 'discount' => 0, 'duration' => 'Fall Exam', 'total' => 120.00, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
