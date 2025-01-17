<?php

namespace App\Http\Controllers;

use App\Services\InvestmentService;
use App\Services\PaymentScheduleService;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Investment;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class InvestmentController extends Controller
{
    use AuthorizesRequests;

    public function __construct(
        private InvestmentService $investmentService,
        private PaymentScheduleService $paymentScheduleService
    ) {}

    // Fetch all investments for the authenticated user
    public function index()
    {
        try {
            $investments = Investment::with('paymentSchedules')
                ->where('user_id', auth()->id())
                ->orderBy('created_at', 'desc')
                ->get();
                
            return response()->json([
                'success' => true,
                'data' => $investments,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch investments.',
            ], 500);
        }
    }

    public function store(Request $request)
    {
        
        $validated = $request->validate([
            'amount' => 'required|numeric|min:0.01', 
        ]);
 
        try {
            $userId = auth()->id();
            if (!$userId) {
                return response()->json([
                    'success' => false,
                    'message' => 'User not authenticated'
                ], 401);
            }

            $investment = $this->investmentService->createInvestment(
                $validated['amount'],
                Carbon::now(),
                $userId
            );

            $this->paymentScheduleService->generateSchedule($investment);
            
            return response()->json([
                'success' => true,
                'data' => $investment,
                'message' => 'Investment created successfully.',
            ], 201);
        } catch (\Exception $e) {            
            return response()->json([
                'success' => false,
                'message' => 'Failed to create investment.',
                'debug_message' => $e->getMessage()
            ], 500);
        }
    }

    public function show(Investment $investment)
    {
        try {
            $this->authorize('view', $investment);

            $investment->load('paymentSchedules');

            return response()->json([
                'success' => true,
                'data' => $investment,
            ], 200);
        } catch (\Illuminate\Auth\Access\AuthorizationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'You are not authorized to view this investment.',
            ], 403);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch the investment.',
            ], 500);
        }
    }

    // Delete an investment
    public function destroy(Investment $investment)
    {
        try {
            $this->authorize('delete', $investment);
            $investment->delete();

            return response()->json([
                'success' => true,
                'message' => 'Investment deleted successfully.',
            ], 200);
        } catch (\Illuminate\Auth\Access\AuthorizationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'You are not authorized to delete this investment.',
            ], 403);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete the investment.',
            ], 500);
        }
    }
}
