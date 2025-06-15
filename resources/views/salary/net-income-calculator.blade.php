{{-- resources/views/salary/net-income-calculator.blade.php --}}
@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        {{-- PAGE HEADING --}}
        <div class="row">
            <div class="col-12">
                <h4 class="mb-2 mt-1">Net Income Calculator – Previous Month</h4>
            </div>
        </div>

        {{-- ========== INCOME SECTION ========== --}}
        <div class="row">
            <div class="col-12">
                <h4 class="mb-1 mt-2">Incomes</h4>
            </div>
        </div>

        <div class="row">
            {{-- Boosting --}}
            <div class="col-md-3">
                <div class="card border-secondary border">
                    <div class="card-body">
                        <h5 class="card-title">Service Fee</h5>
                        <p class="card-text">Rs. {{ $boostingServiceSum }} /=</p>
                    </div>
                </div>
            </div>

            {{-- Designs --}}
            <div class="col-md-3">
                <div class="card border-primary border">
                    <div class="card-body">
                        <h5 class="card-title text-primary">Design Amount</h5>
                        <p class="card-text">Rs. {{ $designsAmountSum }} /=</p>
                    </div>
                </div>
            </div>

            {{-- Video --}}
            <div class="col-md-3">
                <div class="card border-success border">
                    <div class="card-body">
                        <h5 class="card-title text-success">Video Amount</h5>
                        <p class="card-text">Rs. {{ $videoAmountSum }} /=</p>
                    </div>
                </div>
            </div>

            {{-- Others --}}
            <div class="col-md-3">
                <div class="card border-success border">
                    <div class="card-body">
                        <h5 class="card-title text-success">Other Orders Amount</h5>
                        <p class="card-text">Rs. {{ $othersum }} /=</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- ========== EXPENSE SECTION ========== --}}
        <div class="row mt-1">
            <div class="col-12">
                <h4 class="mb-1 mt-2">Expenses</h4>
            </div>
        </div>

        <div class="row">
            {{-- Salaries --}}
            <div class="col-md-3">
                <div class="card border-secondary border">
                    <div class="card-body">
                        <h5 class="card-title">Salary For Office</h5>
                        <p class="card-text">Rs. {{ $salaries }} /=</p>
                    </div>
                </div>
            </div>

            {{-- Actor payments --}}
            <div class="col-md-3">
                <div class="card border-primary border">
                    <div class="card-body">
                        <h5 class="card-title text-primary">Actors Payments</h5>
                        <p class="card-text">Rs. {{ $actorSalaries }} /=</p>
                    </div>
                </div>
            </div>

            {{-- Designer payments --}}
            <div class="col-md-3">
                <div class="card border-success border">
                    <div class="card-body">
                        <h5 class="card-title text-success">Designers Payment</h5>
                        <p class="card-text">Rs. {{ $designerSalaries }} /=</p>
                    </div>
                </div>
            </div>

            {{-- Video-editor payments --}}
            <div class="col-md-3">
                <div class="card border-success border">
                    <div class="card-body">
                        <h5 class="card-title text-success">Editors Payment</h5>
                        <p class="card-text">Rs. {{ $videoEditorSalaries }} /=</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- ========== OTHER EXPENSES & CALC ========== --}}
        <div class="row mt-1">
            <div class="col-12">
                <h4 class="mb-1 mt-2">Other Expenses</h4>
            </div>
        </div>

        <div class="row">
            {{-- INPUTS & BUTTONS --}}
            <div class="col-md-4">
                <div class="card border-secondary border mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Manual Inputs</h5>

                        {{-- New manual bills --}}
                        <div class="row">
                            <div class="col-md-6">
                                <input type="number" class="form-control mb-1" id="waterBill" placeholder="Water Bill">
                            </div>
                            <div class="col-md-6">
                                <input type="number" class="form-control mb-1" id="ecbBill" placeholder="ECB Bill">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <input type="number" class="form-control mb-1" id="intBill" placeholder="Internet Bill">
                            </div>
                            <div class="col-md-6">
                                <input type="number" class="form-control mb-1" id="rent" placeholder="Rent">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <input type="number" class="form-control mb-1" id="otherBusiness"
                                    placeholder="Other Business Expense">
                            </div>
                            <div class="col-md-6">
                                <input type="number" class="form-control mb-1" id="otherDeductions"
                                    placeholder="Other Deductions">
                            </div>
                        </div>

                        <div class="d-grid gap-2 mt-2">
                            <div class="row">
                                <div class="col-md-4">
                                    <button type="button" class="btn btn-info" id="calculateBtn">Calculate</button>
                                </div>
                                <div class="col-md-4">
                                    <button type="button" class="btn btn-success" id="saveBtn">Save</button>
                                </div>
                                <div class="col-md-4">
                                    <button type="button" class="btn btn-warning" id="resetBtn">Reset</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- NET-INCOME CARD --}}
            <div class="col-md-8">
                <div class="card border-primary border mb-3">
                    <div class="card-body">
                        <h5 class="card-title text-primary">Net Income</h5>
                        <p class="card-text fs-4 fw-bold" id="netIncome">—</p>
                    </div>
                </div>
            </div>
        </div>
    </div> {{-- /.container-fluid --}}

    {{-- ========== SCRIPT ========== --}}
    <script>
        document.addEventListener('DOMContentLoaded', () => {

            /* ---------- 1. Server-side numbers ---------- */
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

            /* ---------- 2. DOM refs ---------- */
            const $ = id => document.getElementById(id);
            const netIncomeP = $('netIncome');
            const btnCalc = $('calculateBtn');
            const btnSave = $('saveBtn');
            const btnReset = $('resetBtn');

            /* ---------- 3. Helpers ---------- */
            const numberFields = [
                'otherDeductions', 'waterBill', 'ecbBill', 'intBill', 'rent', 'otherBusiness'
            ];

            function readInputs() {
                const vals = {};
                numberFields.forEach(f => vals[f] = parseFloat($(f).value) || 0);
                return vals;
            }

            function calcNet() {
                const i = readInputs();
                const totalIncome = incomes.boosting + incomes.design + incomes.video + incomes.otherJobs;
                const totalExpense =
                    expenses.salaries + expenses.actorSalaries + expenses.designerSalaries + expenses.editorSalaries
                    + i.otherDeductions + i.waterBill + i.ecbBill + i.intBill + i.rent + i.otherBusiness;
                return totalIncome - totalExpense;
            }

            function showNet(net) {
                netIncomeP.textContent = `Rs. ${net} /=`;
            }

            /* ---------- 4. Events ---------- */
            btnCalc.addEventListener('click', () => showNet(calcNet()));

            btnReset.addEventListener('click', () => {
                numberFields.forEach(f => $(f).value = '');
                netIncomeP.textContent = '—';
            });

            btnSave.addEventListener('click', () => {
                const input = readInputs();
                const net = calcNet();

                fetch("{{ route('net.income.save') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': "{{ csrf_token() }}",
                    },
                    body: JSON.stringify({
                        month: "{{ \Carbon\Carbon::now()->subMonth()->startOfMonth()->format('Y-m-d') }}",
                        service: incomes.boosting,
                        designs: incomes.design,
                        video: incomes.video,
                        other: incomes.otherJobs,
                        salary: expenses.salaries,
                        act_payment: expenses.actorSalaries,
                        dsg_payment: expenses.designerSalaries,
                        vde_payment: expenses.editorSalaries,
                        water_bill: input.waterBill,
                        ecb_bill: input.ecbBill,
                        int_bill: input.intBill,
                        rent: input.rent,
                        other_business: input.otherBusiness,
                        other_deductions: input.otherDeductions,
                        net_income: net,
                    }),
                })
                    .then(res => res.ok ? res.json() : Promise.reject(res))
                    .then(() => {
                        alert('Net-income record saved!');
                        showNet(net);
                    })
                    .catch(() => alert('Save failed – please retry.'));
            });

        });
    </script>
@endsection