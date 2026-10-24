<?php

namespace App\Http\Controllers;

use App\Models\AccountingModel;
use App\Models\FeeReceipt;
use App\Models\Notification;
use App\Models\User;
use App\Notifications\FeeReceiptPendingApproval;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use SimpleSoftwareIO\QrCode\Facades\QrCode;


class AccountingController extends Controller
{
    public function dashboard(Request $request)
    {
        $this->authorizeAccountingAccess();

        $selectedYear = (int)$request->input('year', now()->year);

        // Overall Financial KPIs
        $totalIncome = (float)DB::table('transactions')->where('type', 'profit')->sum('amount');
        $totalExpense = (float)DB::table('transactions')->where('type', 'expense')->sum('amount');
        $netBalance = $totalIncome - $totalExpense;

        // Current Month KPIs
        $currentMonth = now()->month;
        $currentYear = now()->year;
        $monthIncome = (float)DB::table('transactions')
            ->where('type', 'profit')
            ->whereYear('date', $currentYear)
            ->whereMonth('date', $currentMonth)
            ->sum('amount');
        $monthExpense = (float)DB::table('transactions')
            ->where('type', 'expense')
            ->whereYear('date', $currentYear)
            ->whereMonth('date', $currentMonth)
            ->sum('amount');
        $monthNet = $monthIncome - $monthExpense;

        // Purchase Requests KPIs
        $totalPRCount = DB::table('purchase_request')->count();
        $pendingPRCount = DB::table('purchase_request')->where('status', 'pending')->count();
        $pendingPRAmount = (float)DB::table('purchase_request')->where('status', 'pending')->sum('total');
        $approvedPRAmount = (float)DB::table('purchase_request')->where('status', 'approved')->sum('total');

        // Fee Receipts KPIs
        $totalFRCount = DB::table('fee_receipt')->count();
        $pendingFRCount = DB::table('fee_receipt')->where('status', 'pending')->count();
        $pendingFRAmount = (float)DB::table('fee_receipt')->where('status', 'pending')->sum('paid');
        $totalCollectedFees = (float)DB::table('fee_receipt')->where('status', 'approved')->sum('paid');
        $totalOutstandingFees = (float)DB::table('fee_receipt')->sum('remaining_balance');

        // Available years for dropdown
        $availableYears = DB::table('transactions')
            ->selectRaw('YEAR(date) as year')
            ->groupByRaw('YEAR(date)')
            ->orderByDesc('year')
            ->pluck('year')
            ->toArray();
        if (empty($availableYears)) {
            $availableYears = [now()->year];
        }
        if (!in_array(now()->year, $availableYears)) {
            $availableYears[] = now()->year;
            rsort($availableYears);
        }

        // Monthly trends for selectedYear
        $monthlyIncomeMap = DB::table('transactions')
            ->select(DB::raw('MONTH(date) as month'), DB::raw('SUM(amount) as total'))
            ->where('type', 'profit')
            ->whereYear('date', $selectedYear)
            ->groupBy(DB::raw('MONTH(date)'))
            ->pluck('total', 'month')
            ->toArray();

        $monthlyExpenseMap = DB::table('transactions')
            ->select(DB::raw('MONTH(date) as month'), DB::raw('SUM(amount) as total'))
            ->where('type', 'expense')
            ->whereYear('date', $selectedYear)
            ->groupBy(DB::raw('MONTH(date)'))
            ->pluck('total', 'month')
            ->toArray();

        $monthlyIncomeData = [];
        $monthlyExpenseData = [];
        $monthlyNetData = [];
        $monthNames = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        for ($m = 1; $m <= 12; $m++) {
            $inc = (float)($monthlyIncomeMap[$m] ?? 0);
            $exp = (float)($monthlyExpenseMap[$m] ?? 0);
            $monthlyIncomeData[] = round($inc, 2);
            $monthlyExpenseData[] = round($exp, 2);
            $monthlyNetData[] = round($inc - $exp, 2);
        }

        // Category breakdowns for selectedYear
        $expenseCategories = DB::table('transactions')
            ->select('category', DB::raw('SUM(amount) as total'))
            ->where('type', 'expense')
            ->whereYear('date', $selectedYear)
            ->groupBy('category')
            ->orderByDesc('total')
            ->limit(6)
            ->get();

        $incomeCategories = DB::table('transactions')
            ->select('category', DB::raw('SUM(amount) as total'))
            ->where('type', 'profit')
            ->whereYear('date', $selectedYear)
            ->groupBy('category')
            ->orderByDesc('total')
            ->limit(6)
            ->get();

        // Pending items requiring action
        $pendingPurchaseRequests = DB::table('purchase_request')
            ->where('status', 'pending')
            ->orderBy('created_at', 'desc')
            ->limit(6)
            ->get();

        $pendingFeeReceipts = DB::table('fee_receipt as fr')
            ->leftJoin('student_classes as sc', 'fr.student_class_id', '=', 'sc.id')
            ->leftJoin('student as s', 'sc.student_id', '=', 's.student_id')
            ->leftJoin('class as c', 'sc.class_id', '=', 'c.class_id')
            ->select('fr.*', 's.name as student_name', 'c.name as class_name')
            ->where('fr.status', 'pending')
            ->orderBy('fr.created_at', 'desc')
            ->limit(6)
            ->get();

        // Recent Purchase Requests
        $recentPurchaseRequests = DB::table('purchase_request')
            ->orderBy('id', 'desc')
            ->limit(6)
            ->get();

        // Recent Fee Receipts
        $recentFeeReceipts = DB::table('fee_receipt as fr')
            ->leftJoin('student_classes as sc', 'fr.student_class_id', '=', 'sc.id')
            ->leftJoin('student as s', 'sc.student_id', '=', 's.student_id')
            ->leftJoin('class as c', 'sc.class_id', '=', 'c.class_id')
            ->select('fr.*', 's.name as student_name', 'c.name as class_name')
            ->orderBy('fr.id', 'desc')
            ->limit(6)
            ->get();

        // Recent Transactions
        $recentTransactions = DB::table('transactions')
            ->orderBy('date', 'desc')
            ->orderBy('id', 'desc')
            ->limit(8)
            ->get();

        return view('accounting.index', compact(
            'totalIncome',
            'totalExpense',
            'netBalance',
            'monthIncome',
            'monthExpense',
            'monthNet',
            'totalPRCount',
            'pendingPRCount',
            'pendingPRAmount',
            'approvedPRAmount',
            'totalFRCount',
            'pendingFRCount',
            'pendingFRAmount',
            'totalCollectedFees',
            'totalOutstandingFees',
            'selectedYear',
            'availableYears',
            'monthNames',
            'monthlyIncomeData',
            'monthlyExpenseData',
            'monthlyNetData',
            'expenseCategories',
            'incomeCategories',
            'pendingPurchaseRequests',
            'pendingFeeReceipts',
            'recentPurchaseRequests',
            'recentFeeReceipts',
            'recentTransactions'
        ));
    }

    public function transactions(){
        // Get unique years for the dropdown
        $this->authorizeAccountingAccess();
        $years = DB::table('transactions')
            ->selectRaw('YEAR(date) as year')
            ->groupByRaw('YEAR(date)')
            ->orderByDesc('year')
            ->pluck('year');

        return view('accounting.profit', compact('years'));
    }

    public function transactionData(Request $request)
    {
        $this->authorizeAccountingAccess();
        $year = $request->input('year', now()->year);

        $transactions = DB::table('transactions')
            ->whereYear('date', $year)
            ->orderBy('date', 'asc')
            ->get();

        return response()->json([
            'transactions' => $transactions,
        ]);
    }

    public function transactionStore(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|in:profit,expense',
            'category' => 'required|string|max:255',
            'date' => 'required|date',
            'amount' => 'required|numeric',
            'note' => 'nullable|string',
        ]);

        DB::table('transactions')->insert([
            'type' => $validated['type'],
            'category' => $validated['category'],
            'date' => $validated['date'],
            'amount' => $validated['amount'],
            'note' => $validated['note'],
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->back()->with('success', 'Transaction added successfully.');
    }

    public function transactionUpdate(Request $request, $id)
    {
        DB::table('transactions')
            ->where('id', $id)
            ->update([
                'type' => $request->input('type'),
                'category' => $request->input('category'),
                'date' => $request->input('date'),
                'amount' => $request->input('amount'),
                'note' => $request->input('note'),
            ]);

        return redirect()->back()->with('success', 'Transaction updated successfully.');
    }

    public function transactionDelete($id)
    {
        $this->authorizeAccountingAccess();

        DB::table('transactions')->where('id', $id)->delete();

        return redirect()->back()->with('success', 'Transaction entry deleted successfully!');
    }


    // fee control
    protected function authorizeAccountingAccess()
    {
        if (!in_array(Auth::user()->role, [0, 3, 4])) {
            abort(403);
        }
    }

    protected function sectionDurationExpression(): string
    {
        return DB::getDriverName() === 'sqlite'
            ? "CAST(((strftime('%Y', sec.end_date) - strftime('%Y', sec.start_date)) * 12 + (strftime('%m', sec.end_date) - strftime('%m', sec.start_date))) AS INTEGER) as section_duration_months"
            : "TIMESTAMPDIFF(MONTH, sec.start_date, sec.end_date) as section_duration_months";
    }

    public function getStudentFee()
    {
        $this->authorizeAccountingAccess();

        $fees = DB::table('fee_receipt as fr')
            ->join('student_classes as sc', 'fr.student_class_id', '=', 'sc.id')
            ->join('student as s', 'sc.student_id', '=', 's.student_id')
            ->join('class as c', 'sc.class_id', '=', 'c.class_id')
            ->join('section as sec', 'sc.section_id', '=', 'sec.section_id')
            ->select(
                'fr.id as receipt_id',
                'sc.id as student_class_id',
                's.name as student_name',
                's.sex',
                'sc.roll',
                'c.name as class_name',
                'sec.name as section_name',
                DB::raw($this->sectionDurationExpression()),
                'fr.receipt_no',
//                'fr.paid',
//                'fr.previous_balance',
//                'fr.remaining_balance',
                'fr.paid_via',
                'fr.date as receipt_date',
                'fr.status',
                'sec.start_date'
            )
            ->get();

        $students = DB::table('student_classes as sc')
            ->join('student as s', 'sc.student_id', '=', 's.student_id')
            ->join('class as c', 'sc.class_id', '=', 'c.class_id')
            ->join('section as sec', 'sc.section_id', '=', 'sec.section_id')
            ->select(
                'sc.id as student_class_id',  // Ensure this ID is fetched
                's.name as student_name',
                's.sex',
                'sc.roll',
                'c.name as class_name',
                'sec.name as section_name',
                DB::raw($this->sectionDurationExpression()),
                'sec.start_date'
            )
            ->get();

        // Debug the result
        //dd($students);

        return view('accounting.fee_receipt', compact('fees','students'));
    }

    public function getStudentDetails($id)
    {

        // Get the last recorded fee receipt for the student

        $lastReceipt = DB::table('fee_receipt')
            ->where('student_class_id', $id)
            ->orderBy('id', 'desc')
            ->first();

        $student = DB::table('student_classes as sc')
            ->leftjoin('student as s', 'sc.student_id', '=', 's.student_id')
            ->leftjoin('class as c', 'sc.class_id', '=', 'c.class_id')
            ->leftjoin('section as sec', 'sc.section_id', '=', 'sec.section_id')
            ->select(
                's.name as student_name',
                's.sex',
                'sc.roll',
                'c.name as class_name',
                'sec.name as section_name',
                DB::raw($this->sectionDurationExpression()),
                'sec.start_date'
            )
            ->where('sc.id', $id)
            ->first();

        // Append the previous balance
        //$student->remaining_balance = $lastReceipt ? $lastReceipt->remaining_balance : 0;
        $student->previous_balance = $lastReceipt ?$lastReceipt->previous_balance : 0;

        return response()->json($student);
    }

    public function storeFeeReceipt(Request $request)
    {
        $this->authorizeAccountingAccess();

        $lastReceipt = DB::table('fee_receipt')
            ->where('student_class_id', $request->student_class_id)
            ->orderBy('id', 'desc')
            ->first();

        // Calculate the grand total by summing up all item totals
        $grandTotal = 0;
        foreach ($request->items as $item) {
            $total = ($item['qty'] ?? 0) * ($item['price'] ?? 0); // Ensure values are set
            $grandTotal += $total;
        }

        // Calculate the previous_balance
        $previousBalance = 0;

        if ($lastReceipt) {
            // If there is a last receipt, calculate the previous_balance based on its values
            $previousBalance = $lastReceipt->previous_balance - ($request->paid ?? 0);
        } else {
            // If there is no last receipt, calculate the previous_balance as grand_total - paid
            $previousBalance = $grandTotal - ($request->paid ?? 0);
        }

        $receiptId = DB::table('fee_receipt')->insertGetId([
            'student_class_id' => $request->student_class_id,
            'date' => $request->date,
            'receipt_no' => $request->receipt_no,
            'grand_total' => $grandTotal,
            'previous_balance' => $previousBalance, // Store previous balance
            'paid' => $request->paid ?? 0,
            'paid_via' => $request->paid_via,
            'remaining_balance' => $request->previous_balance,
            'status' => 'pending', // Set status to pending
            'user_id' => Auth::id()
        ]);

        // Insert fee receipt items
        foreach ($request->items as $item) {
            $total = ($item['qty'] ?? 0) * ($item['price'] ?? 0);

            DB::table('fee_receipt_items')->insert([
                'fee_receipt_id' => $receiptId,
                'description' => $item['description'],
                'qty' => $item['qty'] ?? 0,
                'price' => $item['price'] ?? 0,
                'discount' => $item['discount'] ?? 0,
                'duration' => $item['duration'] ?? '',
                'total' => $total,
            ]);
        }

        $student = DB::table('student_classes')
            ->join('student', 'student_classes.student_id', '=', 'student.id')
            ->where('student_classes.id', $request->student_class_id)
            ->select('student.name')
            ->first();
        $studentName = $student->name ?? 'Student';

        Notification::notifyAdmins([
            'type' => 'Fee Request',
            'target_id' => $receiptId,
            'target_type' => 'fee_receipt',
            'action_url' => route('fee_receipt.show', $receiptId),
            'status' => 'pending',
            'message' => "New fee receipt request for {$studentName} ($" . number_format($request->paid ?? 0, 2) . ") from {$userName}. Requires approval.",
            'data' => [
                'receipt_no' => $request->receipt_no,
                'student_name' => $studentName,
                'paid' => $request->paid ?? 0,
                'paid_via' => $request->paid_via,
                'grand_total' => $grandTotal,
            ],
        ]);

        return redirect()->route('fee_receipt.index')->with('success', 'Fee receipt created successfully. Waiting for admin approval.');
    }

    public function fee_update(Request $request, $id)
    {
        $this->authorizeAccountingAccess();

        try {
            DB::beginTransaction();

            // Fetch the existing receipt to update
            $feeReceipt = DB::table('fee_receipt')->where('id', $id)->first();

            if (!$feeReceipt) {
                return response()->json(['error' => 'Fee receipt not found.'], 404);
            }

            // Get the last receipt before this one
            $previousReceipt = DB::table('fee_receipt')
                ->where('student_class_id', $feeReceipt->student_class_id)
                ->where('id', '<', $id) // Get only previous receipts
                ->orderBy('id', 'desc')
                ->first();

            // Calculate grand total
            $grandTotal = 0;
            foreach ($request->items as $item) {
                $total = $item['qty'] * $item['price'];
                $grandTotal += $total;
            }

            // Calculate the previous_balance
            $previousBalance = 0;

            if ($previousReceipt) {
                // If there is a last receipt, calculate the previous_balance based on its values
                $previousBalance = $previousReceipt->previous_balance - $request->paid ?? 0;
            } else {
                // If there is no last receipt, calculate the previous_balance as grand_total - paid
                $previousBalance = $grandTotal - ($request->paid ?? 0);
            }
            // Update fee receipt
            DB::table('fee_receipt')
                ->where('id', $id)
                ->update([
                    'student_class_id' => $request->student_class_id,
                    'date' => $request->date,
                    'grand_total' => $grandTotal,
                    'previous_balance' => $previousBalance,
                    'paid' => $request->paid,
                    'paid_via' => $request->paid_via,
                    'remaining_balance' => $request->previous_balance,
//                    'status' => 'pending', // Reset status for admin review
                ]);

            // Retrieve existing item IDs for this purchase request
            $existingItems = DB::table('fee_receipt_items')
                ->where('fee_receipt_id', $id)
                ->pluck('id')
                ->toArray();

            $submittedItemIds = [];


            foreach ($request->items as $item) {
                if (isset($item['id']) && in_array($item['id'], $existingItems)) {
                    // Update existing item
                    DB::table('fee_receipt_items')->where('id', $item['id'])->update([
                        'description' => $item['description'],
                        'qty' => $item['qty'],
                        'price' => $item['price'],
                        'discount' => $item['discount'] ?? 0,
                        'duration' => $item['duration'] ?? null,
                        'total' => $item['qty'] * $item['price'],
                    ]);
                    $submittedItemIds[] = $item['id'];
                } else {
                    // Insert new item
                    $newItemId = DB::table('fee_receipt_items')->insertGetId([
                        'fee_receipt_id' => $id,
                        'description' => $item['description'],
                        'qty' => $item['qty'],
                        'price' => $item['price'],
                        'discount' => $item['discount'] ?? 0,
                        'duration' => $item['duration'] ?? null,
                        'total' => $item['qty'] * $item['price'],
                    ]);
                    $submittedItemIds[] = $newItemId;
                }
            }
            // Delete removed items (items not in submitted data)
            DB::table('fee_receipt_items')
                ->where('fee_receipt_id', $id)
                ->whereNotIn('id', $submittedItemIds)
                ->delete();

            DB::table('transactions')
                ->where('from_id', $id)
                ->update(['amount' => $request->paid]);

            DB::commit();

            return response()->json(['success' => 'Fee receipt updated successfully.']);

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error("Fee Receipt Update Error: " . $e->getMessage());
            return response()->json(['error' => 'Failed to update fee receipt.'], 500);
        }
    }

    public function fee_edit_data($id)
    {

        // Fetch the fee receipt details
        $fee = DB::table('fee_receipt as fr')
            ->join('student_classes as sc', 'fr.student_class_id', '=', 'sc.id')
            ->join('student as s', 'sc.student_id', '=', 's.student_id')
            ->join('class as c', 'sc.class_id', '=', 'c.class_id')
            ->join('section as sec', 'sc.section_id', '=', 'sec.section_id')
            ->select(
                'fr.id as receipt_id',
                'fr.student_class_id',
                's.name as student_name',
                's.sex',
                'sc.roll',
                'c.name as class_name',
                'sec.name as section_name',
                DB::raw($this->sectionDurationExpression()),
                'fr.receipt_no',
                'fr.date as receipt_date',
                'fr.paid',
                'fr.paid_via',
                'fr.previous_balance',
                'fr.remaining_balance',
                'sec.start_date'
            )
            ->where('fr.id', $id)
            ->first();

        // Check if the fee receipt exists
        if (!$fee) {
            return redirect()->route('fee_receipt.index')->with('error', 'Fee receipt not found!');
        }

        // Fetch all items related to this fee receipt
        $items = DB::table('fee_receipt_items')
            ->where('fee_receipt_id', $id)
            ->get();

        // Fetch all students for dropdown (only active students)
        $students = DB::table('student_classes as sc')
            ->join('student as s', 'sc.student_id', '=', 's.student_id')
            ->join('class as c', 'sc.class_id', '=', 'c.class_id')
            ->join('section as sec', 'sc.section_id', '=', 'sec.section_id')
            ->select(
                'sc.id as student_class_id',
                's.name as student_name',
                'sc.roll'
            )
            ->get();

        return response()->json([
            'fee' => $fee,
            'items' => $items,
            'students' => $students,
        ]);
    }

    public function fee_show($id)
    {
        $this->authorizeAccountingAccess();

        // Fetch the main fee receipt details
        $fees = DB::table('fee_receipt as fr')
            ->leftjoin('student_classes as sc', 'fr.student_class_id', '=', 'sc.id')
            ->leftjoin('student as s', 'sc.student_id', '=', 's.student_id')
            ->leftjoin('class as c', 'sc.class_id', '=', 'c.class_id')
            ->leftjoin('section as sec', 'sc.section_id', '=', 'sec.section_id')
            ->leftjoin('parent as p', 's.parent_id', '=', 'p.parent_id')
            ->select(
                'fr.id as receipt_id',
                'sc.id as student_class_id',
                's.name as student_name',
                'p.name as parent_name',
                's.sex',
                'sc.roll',
                'c.name as class_name',
                'sec.name as section_name',
                DB::raw($this->sectionDurationExpression()),
                'fr.receipt_no',
                'fr.paid',
                'fr.grand_total',
                'fr.previous_balance',
                'fr.remaining_balance',
                'fr.paid_via',
                'fr.date as receipt_date',
                'sec.start_date'
            )
            ->where('fr.id', $id)
            ->first();

        // Check if the fee receipt exists
        if (!$fees) {
            return redirect()->route('fee_receipt.index')->with('error', 'Fee receipt not found!');
        }

        // Fetch all items related to this fee receipt
        $items = DB::table('fee_receipt_items')
            ->where('fee_receipt_id', $id)
            ->get();

        return view('accounting.fee_receipt_show', compact('fees', 'items'));
    }
    public function generateFeePDF($id)
    {
        $this->authorizeAccountingAccess();

        // Fetch the main fee receipt details
        $fees = DB::table('fee_receipt as fr')
            ->leftjoin('student_classes as sc', 'fr.student_class_id', '=', 'sc.id')
            ->leftjoin('student as s', 'sc.student_id', '=', 's.student_id')
            ->leftjoin('class as c', 'sc.class_id', '=', 'c.class_id')
            ->leftjoin('section as sec', 'sc.section_id', '=', 'sec.section_id')
            ->leftjoin('parent as p', 's.parent_id', '=', 'p.parent_id')
            ->select(
                'fr.id as receipt_id',
                'sc.id as student_class_id',
                's.name as student_name',
                'p.name as parent_name',
                's.sex',
                'sc.roll',
                'c.name as class_name',
                'sec.name as section_name',
                DB::raw($this->sectionDurationExpression()),
                'fr.receipt_no',
                'fr.paid',
                'fr.grand_total',
                'fr.previous_balance',
                'fr.remaining_balance',
                'fr.paid_via',
                'fr.date as receipt_date',
                'sec.start_date'
            )
            ->where('fr.id', $id)
            ->first();

        // Check if the fee receipt exists
        if (!$fees) {
            return redirect()->route('fee_receipt.index')->with('error', 'Fee receipt not found!');
        }

        // Fetch all items related to this fee receipt
        $items = DB::table('fee_receipt_items')
            ->where('fee_receipt_id', $id)
            ->get();

        $qrCode = QrCode::format('png')
            ->size(100)
            ->generate("
        Student Name: {$fees->student_name}
        Course: {$fees->class_name}
        Shift: {$fees->section_name}
        Start Date: {$fees->start_date}
        Total Fee: \${$fees->grand_total}
        Paid Fee: \${$fees->paid}
        Previous Balance: \${$fees->remaining_balance}
        Remaining Balance: \${$fees->previous_balance}
        Paid On: {$fees->receipt_date}
        School: Mawarid Tech Academy
    ");

        $qrCodeBase64 = 'data:image/png;base64,' . base64_encode($qrCode);

        $pdf = PDF::loadView('accounting.fee_receipt_pdf', compact('fees', 'items', 'qrCodeBase64'));

        return $pdf->stream('fee_receipt.pdf');
    }
    public function getFeeItems($id)
    {
        $this->authorizeAccountingAccess();

        // Fetch items related to the purchase request
        $items = DB::table('fee_receipt_items')->where('fee_receipt_id', $id)->get();

        // Check if items exist
        if ($items->isEmpty()) {
            return response()->json(['message' => 'No items found'], 404);
        }

        return response()->json($items);
    }
    public function fee_destroy($id)
    {
        $this->authorizeAccountingAccess();

        DB::table('fee_receipt')->where('id', $id)->delete();

        DB::table('transactions')->where('from_id', $id)->delete();

        return redirect()->route('fee_receipt.index')->with('success', 'Fee Receipt deleted successfully!');
    }

    public function Feeapprove($id)
    {
        $this->authorizeAccountingAccess();
        // Find the request
        $adminId=Auth::id();

        $feeRequest = DB::table('fee_receipt')
            ->where('id', $id)->first();

        if (!$feeRequest) {
            return redirect()->back()->with('error', 'Request not found.');
        }

        DB::table('fee_receipt')
            ->where('id', $id)
            ->update([
                'status' => 'approved',
                'approved_by' => $adminId,
            ]);


        // Update notification status and notify user
        Notification::updateTargetStatus('fee_receipt', $id, 'approved');
        Notification::notifyUser($feeRequest->user_id, [
            'type' => 'Fee Approval',
            'target_id' => $id,
            'target_type' => 'fee_receipt',
            'action_url' => route('fee_receipt.show', $id),
            'status' => 'approved',
            'message' => 'Your fee receipt request #' . ($feeRequest->receipt_no ?? $id) . ' has been approved!',
            'data' => [
                'receipt_no' => $feeRequest->receipt_no ?? $id,
                'paid' => $feeRequest->paid ?? 0,
            ],
        ]);

        DB::table('transactions')->insert([
            'from_id'=> $id,
            'date' => $feeRequest->date,
            'type' => 'profit',
            'category' => 'Fee Receipt',
            'amount' => $feeRequest->paid,
            'note' => $feeRequest->paid_via,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return response()->json(['success' => 'Fee receipt approved successfully.']);
    }
    public function Feereject($id)
    {
        $this->authorizeAccountingAccess();

        // Find the request
        $feeRequest = DB::table('fee_receipt')
            ->where('id', $id)->first();

        if (!$feeRequest) {
            return redirect()->back()->with('error', 'Request not found.');
        }

        DB::table('fee_receipt')
            ->where('id', $id)->update(['status' => 'rejected']);

        // Update notification status and notify user
        Notification::updateTargetStatus('fee_receipt', $id, 'rejected');
        Notification::notifyUser($feeRequest->user_id, [
            'type' => 'Fee Rejected',
            'target_id' => $id,
            'target_type' => 'fee_receipt',
            'action_url' => route('fee_receipt.show', $id),
            'status' => 'rejected',
            'message' => 'Your fee receipt request #' . ($feeRequest->receipt_no ?? $id) . ' has been rejected!',
            'data' => [
                'receipt_no' => $feeRequest->receipt_no ?? $id,
            ],
        ]);

        return response()->json(['success' => 'Fee receipt rejected.']);
        //return redirect()->back()->with('success', 'Fee receipt rejected!');
    }




    //purchase request control
    public function index()
    {
        $this->authorizeAccountingAccess();

        $purchases = DB::table('purchase_request')->get();

        $staffs = DB::table('staff')
            ->leftJoin('department', 'department.id', '=', 'staff.department_id')
            ->select('staff.*', 'department.name as department_name')
            ->get();
        return view("accounting.purchase_req", compact("purchases","staffs"));
    }

    public function getDepartment($name)
    {
        $staff = DB::table('staff')
            ->leftJoin('department', 'department.id', '=', 'staff.department_id')
            ->where('staff.name', $name)
            ->select('department.name as department_name')
            ->first();

        return response()->json(['department' => $staff->department_name ?? '']);
    }

    public function getItems($id)
    {
        // Fetch items related to the purchase request
        $items = DB::table('purchase_request_items')->where('purchase_request_id', $id)->get();

        // Check if items exist
        if ($items->isEmpty()) {
            return response()->json(['message' => 'No items found'], 404);
        }

        return response()->json($items);
    }

    public function purchase_store(Request $request)
    {
        $this->authorizeAccountingAccess();

        $request->validate([
            'requisitioner' => 'required|string|max:255',
            'department' => 'required|string|max:255',
            'purpose' => 'nullable|string',
            'vendor' => 'nullable|string',
            'request_no' => 'required|string|unique:purchase_request,request_no|max:50',
            'date_prepared' => 'required|date',
            'date_needed' => 'nullable|date|after_or_equal:date_prepared',
            'items.*.description' => 'required|string',
//            'items.*.asset_class' => 'nullable|string|max:255',
            'items.*.qty' => 'required|integer|min:1',
            'items.*.unit' => 'nullable|string|max:50',
            'items.*.unit_price' => 'required|numeric|min:0',
        ]);
        // Ensure unique request_no (in case the form didn't generate one)
        $request_no = $request->request_no ?? 'REQ-' . substr(uniqid(), -6);

        // Calculate grand total first
        $grandTotal = 0;
        foreach ($request->items as $item) {
            $grandTotal += $item['qty'] * $item['unit_price'];
        }
        // Store Purchase Request (Parent)
        $purchaseRequestId = DB::table('purchase_request')->insertGetId([
            'requisitioner' => $request->requisitioner,
            'department' => $request->department,
            'purpose' => $request->purpose,
            'vendor' => $request->vendor,
            'request_no' => $request_no,
            'date_prepared' => $request->date_prepared,
            'date_needed' => $request->date_needed,
            'total' =>$grandTotal,
            'status' => 'pending',
            'user_id' => Auth::id()
        ]);

        // Store Items (Child)
        foreach ($request->items as $item) {
            DB::table('purchase_request_items')->insert([
                'purchase_request_id' => $purchaseRequestId,
                'description' => $item['description'],
//                'asset_class' => $item['asset_class'],
                'qty' => $item['qty'],
                'unit' => $item['unit'],
                'unit_price' => $item['unit_price'],
                'total_price' => $item['qty'] * $item['unit_price'],
            ]);
        }


        Notification::notifyAdmins([
            'type' => 'Purchase Request',
            'target_id' => $purchaseRequestId,
            'target_type' => 'purchase_request',
            'action_url' => route('purchase_req.show', $purchaseRequestId),
            'status' => 'pending',
            'message' => "New purchase request from {$request->requisitioner} for $" . number_format($grandTotal, 2) . ". Requires approval.",
            'data' => [
                'requisitioner' => $request->requisitioner,
                'department' => $request->department,
                'total' => $grandTotal,
                'purpose' => $request->purpose,
                'vendor' => $request->vendor,
            ],
        ]);

        return redirect()->route('purchase_req.index')->with('success', 'Purchase request added successfully!');
    }

    public function purchase_update(Request $request, $id)
    {
        $request->validate([
            'requisitioner' => 'required|string|max:255',
            'department' => 'required|string|max:255',
            'purpose' => 'nullable|string',
            'vendor' => 'nullable|string',
            'date_prepared' => 'required|date',
            'date_needed' => 'nullable|date|after_or_equal:date_prepared',
            'items' => 'required|array',
        ]);

        // Start a database transaction
        DB::beginTransaction();
        try {
            // Update Main Purchase Request
            DB::table('purchase_request')->where('id', $id)->update([
                'requisitioner' => $request->requisitioner,
                'department' => $request->department,
                'purpose' => $request->purpose,
                'vendor' => $request->vendor,
                'date_prepared' => $request->date_prepared,
                'date_needed' => $request->date_needed,
            ]);

            // Retrieve existing item IDs for this purchase request
            $existingItems = DB::table('purchase_request_items')
                ->where('purchase_request_id', $id)
                ->pluck('id')
                ->toArray();

            $submittedItemIds = [];
            $totalAmount = 0; // Initialize total amount

            foreach ($request->items as $item) {
                $itemTotal = $item['qty'] * $item['unit_price'];
                $totalAmount += $itemTotal; // Accumulate to total amount

                if (!empty($item['id']) && in_array($item['id'], $existingItems)) {
                    // Update existing item
                    DB::table('purchase_request_items')
                        ->where('id', $item['id'])
                        ->update([
                            'description' => $item['description'],
                            'qty' => $item['qty'],
                            'unit' => $item['unit'],
                            'unit_price' => $item['unit_price'],
                            'total_price' => $itemTotal,
                        ]);
                    $submittedItemIds[] = $item['id'];
                } else {
                    // Insert new item and store the new ID
                    $newItemId = DB::table('purchase_request_items')->insertGetId([
                        'purchase_request_id' => $id,
                        'description' => $item['description'],
                        'qty' => $item['qty'],
                        'unit' => $item['unit'],
                        'unit_price' => $item['unit_price'],
                        'total_price' => $itemTotal,
                    ]);
                    $submittedItemIds[] = $newItemId;
                }
            }

            // **Fix: Ensure only non-submitted items get deleted**
            DB::table('purchase_request_items')
                ->where('purchase_request_id', $id)
                ->whereNotIn('id', $submittedItemIds)
                ->delete();

            // Update the total amount in the main purchase request
            DB::table('purchase_request')
                ->where('id', $id)
                ->update(['total' => $totalAmount]);

            DB::table('transactions')
                ->where('from_id', $id)
                ->update(['amount' => $totalAmount]);

            DB::commit(); // Commit transaction

            return redirect()->route('purchase_req.index')->with('success', 'Purchase request updated successfully!');
        } catch (\Exception $e) {
            DB::rollBack(); // Rollback in case of error
            return redirect()->route('purchase_req.index')->with('error', 'Error updating purchase request: ' . $e->getMessage());
        }
    }

    public function purchase_destroy($id)
    {
        $this->authorizeAccountingAccess();

        DB::table('purchase_request')->where('id', $id)->delete();
        DB::table('transactions')->where('from_id', $id)->delete();

        return redirect()->route('purchase_req.index')->with('success', 'Purchase request deleted successfully!');
    }

    public function purchase_show($id)
    {
        $this->authorizeAccountingAccess();

        // Fetch the main purchase request details
        $purchase = DB::table('purchase_request')
            ->leftJoin('users', 'purchase_request.approved_by', '=', 'users.id')
            ->select('purchase_request.*', 'users.name as approver_name')
            ->where('purchase_request.id', $id)->first();

        // Check if the purchase request exists
        if (!$purchase) {
            return redirect()->route('purchase_req.index')->with('error', 'Purchase Request not found!');
        }

        // Fetch all items related to this purchase request
        $items = DB::table('purchase_request_items')
            ->where('purchase_request_id', $id)
            ->get();

        return view('accounting.purchase_req_show', compact('purchase', 'items'));
    }

    public function Purchaseapprove($id)
    {
        $this->authorizeAccountingAccess();

        // Find the request
        $adminId = Auth::id();

        $purchaseRequest = DB::table('purchase_request')
            ->where('id', $id)->first();

        if (!$purchaseRequest) {
            return redirect()->back()->with('error', 'Request not found.');
        }

        // Update status and store approver ID
        DB::table('purchase_request')
            ->where('id', $id)->update([
                'status' => 'approved',
                'approved_by' => $adminId, // Store approver's ID
            ]);
        // Update pending notification and notify requesting user
        Notification::updateTargetStatus('purchase_request', $id, 'approved');
        Notification::notifyUser($purchaseRequest->user_id, [
            'type' => 'Purchase Approval',
            'target_id' => $id,
            'target_type' => 'purchase_request',
            'action_url' => route('purchase_req.show', $id),
            'status' => 'approved',
            'message' => 'Your purchase request for ' . ($purchaseRequest->department ?? 'General') . ' ($' . number_format($purchaseRequest->total ?? 0, 2) . ') has been approved!',
            'data' => [
                'requisitioner' => $purchaseRequest->requisitioner ?? '',
                'total' => $purchaseRequest->total ?? 0,
            ],
        ]);

        // Update status and store approver ID
        DB::table('purchase_request')->where('id', $id)->update([
            'status' => 'approved',
            'approved_by' => $adminId, // Store approver's ID
        ]);

        $note=implode(', ',array_filter([
            $purchaseRequest->requisitioner ?? '',
            $purchaseRequest->purpose ?? '',
            $purchaseRequest->vendor ?? '',
        ]));

        DB::table('transactions')->insert([
            'from_id'=> $id,
            'date' => $purchaseRequest->date_prepared,
            'type' => 'expense',
            'category' => 'Purchase Request',
            'amount' => $purchaseRequest->total,
            'note' => $note,
            'created_at' => now(),
            'updated_at' => now(),
        ]);


        return response()->json(['success' => 'purchase request approved successfully.']);
    }
    public function Purchasereject($id)
    {
        $this->authorizeAccountingAccess();

        // Find the request
        $purchaseRequest = DB::table('purchase_request')->where('id', $id)->first();

        if (!$purchaseRequest) {
            return redirect()->back()->with('error', 'Request not found.');
        }

        DB::table('purchase_request')
            ->where('id', $id)
            ->update(['status' => 'rejected']);

        // Update pending notification and notify requesting user
        Notification::updateTargetStatus('purchase_request', $id, 'rejected');
        Notification::notifyUser($purchaseRequest->user_id, [
            'type' => 'Purchase Rejected',
            'target_id' => $id,
            'target_type' => 'purchase_request',
            'action_url' => route('purchase_req.show', $id),
            'status' => 'rejected',
            'message' => 'Your purchase request for ' . ($purchaseRequest->department ?? 'General') . ' has been rejected.',
            'data' => [
                'requisitioner' => $purchaseRequest->requisitioner ?? '',
            ],
        ]);

        return response()->json(['success' => 'purchase request rejected.']);
        //return redirect()->back()->with('success', 'Fee receipt rejected!');
    }

    public function edit(AccountingModel $accountingModel)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, AccountingModel $accountingModel)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AccountingModel $accountingModel)
    {
        //
    }
}
