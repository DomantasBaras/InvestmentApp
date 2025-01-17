<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Investment - Investment App</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="max-w-4xl mx-auto p-4 sm:p-6 lg:p-8">
        <div class="bg-white shadow rounded-lg p-6">
            <h2 class="text-2xl font-bold mb-4">Investment Details</h2>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <p class="font-semibold">Original Amount:</p>
                    <p>€{{ number_format($investment->amount, 2) }}</p>
                </div>
                <div>
                    <p class="font-semibold">Rounded Amount:</p>
                    <p>€{{ number_format($investment->rounded_amount, 2) }}</p>
                </div>
                <div>
                    <p class="font-semibold">Interest Rate:</p>
                    <p>{{ $investment->interest_rate }}%</p>
                </div>
            </div>

            <h3 class="text-xl font-bold mt-8 mb-4">Payment Schedule</h3>
            <table class="min-w-full">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Type</th>
                        <th>Amount</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($paymentSchedule as $payment)
                    <tr>
                        <td>{{ $payment->payment_date->format('Y-m-d') }}</td>
                        <td>{{ ucfirst($payment->payment_type) }}</td>
                        <td>€{{ number_format($payment->interest_amount, 2) }}</td>
                        <td>{{ $payment->is_paid ? 'Paid' : 'Pending' }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>