@extends('include.master')

@section('content')
<div class="invoice-container">
    <!-- Header Section -->
    <div class="header">
        <div class="header-left">
            <img src="{{ asset('Images/logo.png') }}" class="logo" alt="Vise Tech">
            <p class="commonClass"><strong>Email:</strong> mailto:vise.tech1@gmail.com</p>
            <p class="commonClass"><strong>Phone:</strong> +92 3004257361</p>
            <p class="commonClass"><strong>Location:</strong> Cavalry Ground, Lahore, Punjab, Pakistan</p>
        </div>
    </div>

    <!-- Client Details -->
    <div class="client-details">
        <h2>Client Details:</h2>
        <p><strong>Client Name:</strong> {{ $client_name }}</p>
        <p><strong>Client Email:</strong> {{ $email }}</p>
        <p><strong>Client Phone:</strong> {{ $phone }}</p>
    </div>

    <!-- Service Details -->
    <div class="service-details">
        <h2>Service Details</h2>
        <table>
            <thead>
                <tr>
                    <th>Service Field</th>
                    <th>Service Value</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Service</td>
                    <td>{{ $service }}</td>
                </tr>
                <tr>
                    <td>Package</td>
                    <td>{{ $package }}</td>
                </tr>
                <tr>
                    <td>Total Payment</td>
                    <td>{{ $total_payment }}</td>
                </tr>
                <tr>
                    <td>Initial Payment</td>
                    <td>{{ $initial_payment }}</td>
                </tr>
                <tr>
                    <td>Remaining Payment</td>
                    <td>{{ $remaining_payment }}</td>
                </tr>
                <tr>
                    <td>Payment Status</td>
                    <td>{{ $payment_status }}</td>
                </tr>
                <tr>
                    <td>Start Date</td>
                    <td>{{ $starting_date }}</td>
                </tr>
                <tr>
                    <td>End Date</td>
                    <td>{{ $ending_date }}</td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Payment Summary -->
    <div class="total-summary">
        <p><strong>Total Payment:</strong> ${{ $total_payment }}</p>
        <p><strong>Initial Payment:</strong> ${{ $initial_payment }}</p>
        <p><strong>Remaining Payment:</strong> ${{ $remaining_payment }}</p>
    </div>

    <!-- Footer Section -->
    <div class="footer">
        <div class="text-center">Thank you for your business!</div>
        <p>If you have any questions about this invoice, feel free to contact us at <a href="mailto:vise.tech1@gmail.com">vise.tech1@gmail.com</a></p>
    </div>
</div>
@endsection


@push('style')
<style>
    body {
        font-family: 'Arial', sans-serif;
        margin: 0;
        padding: 0;
        background-color: #f4f7fb;
    }

    .invoice-container {
        max-width: 900px;
        margin: 2rem auto;
        padding: 30px;
        background-color: #ffffff;
        border-radius: 10px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        border: 1px solid #ddd;
    }

    .logo {
        width: 150px;
        margin-right: 20px;
    }

    h1,
    h2 {
        color: #333;
        font-weight: bold;
    }

    .header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-bottom: 2px solid #eee;
        padding-bottom: 10px;
        margin-bottom: 10px;
    }

    .header-left {
        display: flex;
        flex-direction: column;
    }

    .header-left h2 {
        color: #99519e;
    }

    .header-right {
        text-align: right;
    }

    .client-details,
    .invoice-details {
        margin-bottom: 20px;
    }

    .client-details p,
    .invoice-details p {
        margin: 5px 0;
        font-size: 14px;
    }

    .client-details p strong,
    .invoice-details p strong {
        color: #333;
    }

    .service-details table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 20px;
    }

    .service-details th,
    .service-details td {
        padding: 12px;
        text-align: left;
        border: 1px solid #ddd;
    }

    .service-details th {
        background-color: #f5f5f5;
    }

    .service-details td {
        background-color: #fafafa;
    }

    .total-summary {
        margin-top: 30px;
        text-align: right;
    }

    .total-summary p {
        font-size: 16px;
        font-weight: bold;
    }

    .footer {
        text-align: center;
        margin-top: 40px;
        font-size: 14px;
        color: #777;
        padding: 20px;
        border-top: 1px solid #ddd;
    }

    button {
        padding: 12px 20px;
        background-color: #007bff;
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-size: 16px;
        transition: background-color 0.3s;
    }

    button:hover {
        background-color: #0056b3;
    }

    .commonClass {
        margin: 0;
        margin-bottom: 15px;
    }

    @media (max-width: 768px) {
        .header {
            flex-direction: column;
            text-align: center;
        }

        .header-left {
            align-items: center;
            margin-bottom: 20px;
        }

        .header-right {
            text-align: center;
            margin-top: 20px;
        }

        .service-details table {
            font-size: 12px;
        }

        .service-details th,
        .service-details td {
            padding: 10px;
        }

        .footer {
            font-size: 12px;
            padding: 15px;
        }

        .logo {
            width: 120px;
        }

        .total-summary {
            text-align: left;
            margin-top: 20px;
        }
    }

    @media (max-width: 480px) {
        .invoice-container {
            padding: 20px;
        }

        h1,
        h2 {
            font-size: 18px;
        }

        .header-left h2 {
            font-size: 20px;
        }

        .service-details table {
            font-size: 10px;
        }

        .service-details th,
        .service-details td {
            padding: 8px;
        }

        .footer {
            font-size: 10px;
            padding: 10px;
        }

        .logo {
            width: 100px;
        }
    }
</style>
@endpush