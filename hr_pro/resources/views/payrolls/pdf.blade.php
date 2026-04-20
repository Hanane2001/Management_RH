<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Payroll Slip - {{ $payroll->employee->first_name }} {{ $payroll->employee->last_name }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
        }
        .company-name {
            font-size: 24px;
            font-weight: bold;
            color: #1D4ED8;
        }
        .document-title {
            font-size: 18px;
            margin-top: 10px;
        }
        .info-section {
            margin-bottom: 20px;
            padding: 10px;
            background: #f5f5f5;
        }
        .info-row {
            margin-bottom: 5px;
        }
        .info-label {
            font-weight: bold;
            display: inline-block;
            width: 150px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #1D4ED8;
            color: white;
        }
        .total-row {
            font-weight: bold;
            background-color: #e8f4f8;
        }
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 12px;
            color: #666;
            border-top: 1px solid #ccc;
            padding-top: 10px;
        }
        .amount {
            text-align: right;
        }
        .net-pay {
            font-size: 18px;
            font-weight: bold;
            color: #10B981;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="company-name">HR_PRO</div>
        <div class="document-title">PAYROLL SLIP</div>
    </div>
    
    <div class="info-section">
        <div class="info-row">
            <span class="info-label">Employee:</span>
            <span>{{ $payroll->employee->first_name }} {{ $payroll->employee->last_name }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Department:</span>
            <span>{{ $payroll->employee->department->name ?? 'N/A' }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Period:</span>
            <span>{{ $payroll->getMonthName() }} {{ $payroll->year }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Status:</span>
            <span>{{ ucfirst($payroll->status) }}</span>
        </div>
    </div>
    
    <table>
        <thead>
            <tr>
                <th>Description</th>
                <th class="amount">Amount (DH)</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Base Salary</td>
                <td class="amount">{{ number_format($payroll->base_salary, 2) }}</td>
            </tr>
            <tr>
                <td>Overtime ({{ $payroll->overtime_hours }} hours)</td>
                <td class="amount">{{ number_format($payroll->overtime_hours * 0, 2) }}</td>
            </tr>
            <tr>
                <td>Bonuses</td>
                <td class="amount">{{ number_format($payroll->bonuses, 2) }}</td>
            </tr>
            <tr>
                <td>Allowances</td>
                <td class="amount">{{ number_format($payroll->allowances, 2) }}</td>
            </tr>
            <tr class="total-row">
                <td>Total Earnings</td>
                <td class="amount">{{ number_format($payroll->getTotalSalary(), 2) }}</td>
            </tr>
            <tr>
                <td>Deductions</td>
                <td class="amount">{{ number_format($payroll->deductions, 2) }}</td>
            </tr>
            <tr class="total-row">
                <td><strong>NET PAY</strong></td>
                <td class="amount net-pay">{{ number_format($payroll->net_pay, 2) }}</td>
            </tr>
        </tbody>
    </table>
    
    <div class="footer">
        <p>This is a computer-generated document. No signature required.</p>
        <p>Generated on: {{ now()->format('d/m/Y H:i:s') }}</p>
    </div>
</body>
</html>