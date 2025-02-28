<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreExpenseRequest;
use App\Http\Requests\UpdateExpenseRequest;
use App\Models\Expense;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ExpenseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $expenses = Expense::latest()->paginate(10);
        return view('dashboard.expense.index', compact('expenses'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Expense $expense): View
    {
        return view('dashboard.expense.show', compact('expense'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Expense $expense): View
    {
        return view('dashboard.expense.edit', compact('expense'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateExpenseRequest $request, Expense $expense): RedirectResponse
    {
        $validated = $request->validated();

        if ($request->hasFile('receipt_image')) {
            if ($expense->receipt_image) {
                Storage::disk('public')->delete($expense->receipt_image);
            }

            $imagePath = $request->file('receipt_image')->store('company_profile', 'public');
            $validated['receipt_image'] = $imagePath;
        }

        $expense->update($validated);

        return redirect()->route('dashboard.expenses.index', $expense)->with('success', 'Expense updated Successfully');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreExpenseRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        if ($request->hasFile('receipt_image')) {
            $imagePath = $request->file('receipt_image')->store('receipt_image', 'public');
            $validated['receipt_image'] = $imagePath;
        }

        Expense::create($validated);

        return redirect()->route('dashboard.expenses.index')->with('success', 'Expense created successfully.');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('dashboard.expense.create');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Expense $expense): RedirectResponse
    {
        $expense->delete();
        return redirect()->route('dashboard.expense.index')->with('success', 'Expense deleted successfully.');
    }
}
