@extends('layouts.app')

@section('content')

    <div class="row">
        <div class="col-12">
            <h4 class="mb-2 mt-1">Net Income Calculator Previous Month</h4>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <h4 class="mb-1 mt-2">Incomes</h4>
        </div>
    </div>

    <div class="row">
        <div class="col-md-3">
            <div class="card border-secondary border">
                <div class="card-body">
                    <h5 class="card-title">Service Fee</h5>
                    <p class="card-text">Rs. {{ $boostingServiceSum }} /=</p>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-primary border">
                <div class="card-body">
                    <h5 class="card-title text-primary">Design Amount</h5>
                    <p class="card-text">Rs. {{ $designsAmountSum }} /=</p>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-success border">
                <div class="card-body">
                    <h5 class="card-title text-success">Video Amount</h5>
                    <p class="card-text">Rs. {{ $videoAmountSum }} /=</p>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-success border">
                <div class="card-body">
                    <h5 class="card-title text-success">Other Orders Amount</h5>
                    <p class="card-text">Rs. {{ $othersum }} /=</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-1">
        <div class="col-12">
            <h4 class="mb-1 mt-2">Expenses</h4>
        </div>
    </div>

    <div class="row">
        <div class="col-md-3">
            <div class="card border-secondary border">
                <div class="card-body">
                    <h5 class="card-title">Salary For Office</h5>
                    <p class="card-text">Rs. {{ $salaries }} /=</p>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-primary border">
                <div class="card-body">
                    <h5 class="card-title text-primary">Actors Payments</h5>
                    <p class="card-text">Rs. {{ $actorSalaries }} /=</p>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-success border">
                <div class="card-body">
                    <h5 class="card-title text-success">Designers Payment</h5>
                    <p class="card-text">Rs. {{ $designerSalaries }} /=</p>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-success border">
                <div class="card-body">
                    <h5 class="card-title text-success">Editors Payment</h5>
                    <p class="card-text">Rs. {{ $videoEditorSalaries }} /=</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-1">
        <div class="col-12">
            <h4 class="mb-1 mt-2">Other Expenses</h4>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="card border-secondary border">
                <div class="card-body">
                    <h5 class="card-title">Other Deductions</h5>
                    <input type="number" class="form-control" id="otherDeductions" placeholder="Other Deductions">
                    <button type="button" class="btn btn-info mt-2" id="calculateBtn">Calculate</button>
                    <button type="button" class="btn btn-warning mt-2" id="resetBtn">Reset</button>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card border-primary border">
                <div class="card-body">
                    <h5 class="card-title text-primary">Net Income</h5>
                    <p class="card-text" id="netIncome"></p>
                </div>
            </div>
        </div>
    </div>



    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // 1) Server‐side values
            const incomes = {
                boosting: parseFloat(@json($boostingServiceSum)) || 0,
                design: parseFloat(@json($designsAmountSum)) || 0,
                video: parseFloat(@json($videoAmountSum)) || 0,
                otherJobs: parseFloat(@json($othersum)) || 0,
            };
            const expenses = {
                salaries: parseFloat(@json($salaries)) || 0,
                actorSalaries: parseFloat(@json($actorSalaries)) || 0,
                designerSalaries: parseFloat(@json($designerSalaries)) || 0,
                editorSalaries: parseFloat(@json($videoEditorSalaries)) || 0,
            };

            // 2) DOM refs
            const otherDedInput = document.getElementById('otherDeductions');
            const netIncomeP = document.getElementById('netIncome');
            const btnCalc = document.getElementById('calculateBtn');
            const btnReset = document.getElementById('resetBtn');

            // 3) Load from localStorage
            const savedDed = localStorage.getItem('otherDeductions');
            if (savedDed !== null) otherDedInput.value = savedDed;
            const savedNet = localStorage.getItem('netIncome');
            if (savedNet !== null) netIncomeP.textContent = `Rs. ${savedNet}/=`;

            // 4a) Calculate & save
            btnCalc.addEventListener('click', () => {
                const otherDed = parseFloat(otherDedInput.value) || 0;
                const totalIncome = incomes.boosting + incomes.design + incomes.video + incomes.otherJobs;
                const totalExpense = expenses.salaries + expenses.actorSalaries + expenses.designerSalaries + expenses.editorSalaries + otherDed;
                const net = totalIncome - totalExpense;

                netIncomeP.textContent = `Rs. ${net}/=`;
                localStorage.setItem('otherDeductions', otherDed);
                localStorage.setItem('netIncome', net);
            });

            // 4b) Reset & clear
            btnReset.addEventListener('click', () => {
                otherDedInput.value = '';
                netIncomeP.textContent = '';
                localStorage.removeItem('otherDeductions');
                localStorage.removeItem('netIncome');
            });
        });
    </script>
@endsection