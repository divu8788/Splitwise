<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Expense;
class ExpenseController extends Controller
{
    public function store(Request $request, $groupId)
    {
        $expense = new Expense();
        $expense->description = $request->description;
        $expense->total_amount = $request->total_amount;
        $expense->payer_id = $request->payer_id;
        $expense->group_id = $groupId;
        $expense->save();

        $totalSplitAmount = array_sum($request->split);

        foreach($request->split as $userId => $splitAmount)
        {
            $expense->users()->attach($userId, [
                'split_amount' => $splitAmount,
                'share' => $splitAmount / $totalSplitAmount * 100
            ]);
        }

        return response()->json([
            'message' => 'Expense created successfully',
            'expense' => $expense
        ], 201);
    }

    public function index($groupId)
    {
        $expenses = Expense::where('group_id', $groupId)->get();

        return response()->json([
            'expenses' => $expenses
        ]);
    }

    public function getGroupSummary($groupId, $userId)
    {
        $group = Group::findOrFail($groupId);
        $user = User::findOrFail($userId);

        $totalSpending = $group->expenses()->sum('total_amount');
        $totalPaid = $user->expenses()->where('group_id', $groupId)->sum('total_amount');
        $totalShare = $user->expenses()->where('group_id', $groupId)->sum('split_amount');

        return response()->   json([
        'total_spending' => $totalSpending,
        'total_paid' => $totalPaid,
        'total_share' => $totalShare
    ]);
}

public function getGroupBalances($groupId)
{
    $balances = [];
    $group = Group::findOrFail($groupId);

    foreach($group->users as $user) 
    {
        $totalShare = $user->expenses()->where('group_id', $groupId)->sum('split_amount');
        $totalPaid = $user->expenses()->where('group_id', $groupId)->sum('total_amount');

        $balances[$user->name] = $totalShare - $totalPaid;
    }

    return response()->json([
        'balances' => $balances
    ]);
}

}
