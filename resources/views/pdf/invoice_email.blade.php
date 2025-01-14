@extends('include.master')

@section('content')
<div style="max-width: 900px; margin: 20px auto; padding: 30px; background-color: #ffffff; border-radius: 10px; border: 1px solid #ddd; font-family: Arial, sans-serif; color: #333;">
    <!-- Header Section -->
    <!-- Header Section -->
    <div style="border-bottom: 2px solid #eee; padding-bottom: 10px; margin-bottom: 20px;">
        <table style="width: 100%; border-collapse: collapse;">
            <tr>
                <!-- Company Details -->
                <td style="vertical-align: top; width: 50%; padding-right: 20px;">
                    <img src="https://crm.visetech.org/Images/logo.png" style="width: 150px; margin-bottom: 10px;" alt="Vise Tech">
                    <p style="margin: 5px 0; line-height: 1.5;"><strong>Email:</strong> vise.tech1@gmail.com</p>
                    <p style="margin: 5px 0; line-height: 1.5;"><strong>Phone:</strong> +92 3004257361</p>
                    <p style="margin: 5px 0; line-height: 1.5;">
                        <strong>Location:</strong> Cavalry Ground, Lahore, Punjab, Pakistan
                    </p>
                </td>
                <!-- Client Details -->
                <td style="vertical-align: top; width: 50%;">
                    <h2 style="margin: 0 0 10px; font-size: 2rem;">Client Details</h2>
                    <p style="margin: 5px 0; line-height: 1.5;"><strong>Client Name:</strong> {{ $task['client_name'] }}</p>
                    <p style="margin: 5px 0; line-height: 1.5;"><strong>Client Email:</strong> {{ $task['email'] }}</p>
                    <p style="margin: 5px 0; line-height: 1.5;"><strong>Client Phone:</strong> {{ $task['phone'] }}</p>
                </td>
            </tr>
        </table>
    </div>


    <!-- Service Details -->
    <div style="margin-bottom: 20px;">
        <h2 style="font-size: 18px; color: #333; padding-bottom: 5px;">Service Details</h2>
        <table style="width: 100%; border-collapse: collapse; margin-top: 10px;">
            <thead>
                <tr>
                    <th style="padding: 10px; background-color: #f5f5f5; border: 1px solid #ddd; text-align: left;">Service Field</th>
                    <th style="padding: 10px; background-color: #f5f5f5; border: 1px solid #ddd; text-align: left;">Service Value</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td style="padding: 10px; border: 1px solid #ddd;">Service</td>
                    <td style="padding: 10px; border: 1px solid #ddd;">{{ $task['service'] }}</td>
                </tr>
                <tr>
                    <td style="padding: 10px; border: 1px solid #ddd;">Package</td>
                    <td style="padding: 10px; border: 1px solid #ddd;">{{ $task['package'] }}</td>
                </tr>
                <tr>
                    <td style="padding: 10px; border: 1px solid #ddd;">Total Payment</td>
                    <td style="padding: 10px; border: 1px solid #ddd;">{{ $task['total_payment'] }}$</td>
                </tr>
                <tr>
                    <td style="padding: 10px; border: 1px solid #ddd;">Initial Payment</td>
                    <td style="padding: 10px; border: 1px solid #ddd;">{{ $task['initial_payment'] }}$</td>
                </tr>
                <tr>
                    <td style="padding: 10px; border: 1px solid #ddd;">Remaining Payment</td>
                    <td style="padding: 10px; border: 1px solid #ddd;">{{ $task['remaining_payment'] }}$</td>
                </tr>
                <tr>
                    <td style="padding: 10px; border: 1px solid #ddd;">Payment Status</td>
                    <td style="padding: 10px; border: 1px solid #ddd;">{{ $task['payment_status'] }}</td>
                </tr>
                <tr>
                    <td style="padding: 10px; border: 1px solid #ddd;">Start Date</td>
                    <td style="padding: 10px; border: 1px solid #ddd;">{{ $task['starting_date'] }}</td>
                </tr>
                <tr>
                    <td style="padding: 10px; border: 1px solid #ddd;">End Date</td>
                    <td style="padding: 10px; border: 1px solid #ddd;">{{ $task['ending_date'] }}</td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Footer Section -->
    <div style="text-align: center; font-size: 14px; color: #777; padding-top: 10px; margin-top: 20px;">
        Thank you for your business!
    </div>
</div>
@endsection