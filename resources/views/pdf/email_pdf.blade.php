@extends('include.master')

@section('content')
<div class="email-container">
    <p>Dear [Recipient's Name],</p>

    <p>I hope this message finds you well. I am submitting the details of the task. The
        task is titled <strong>[Task Name]</strong>, and it involves <strong>[Task Explanation]</strong>. It began
        on <strong>[Starting Date]</strong> and is scheduled to be completed by <strong>[End Date]</strong>. The
        current status of the task is <strong>[Status]</strong>.</p>

    <p>If there are any additional notes or considerations, they are as follows: <strong>[Optional
            Comments]</strong>. Please let me know if you need any further information or if any changes are
        required.</p>

    <p>Thank you for your attention to this task. We appreciate your time and effort in reviewing the details.</p>


    <div class="footer">
        <p>Best regards,</p>
        <p>[Your Name]</p>
        <p>[Your Position]</p>
        <p>[Your Company]</p>
    </div>
</div>

@endsection
<style :scope>
    body {
        font-family: 'Arial', sans-serif;
        background-color: #f4f7fc;
        margin: 0;
        padding: 20px;
    }

    .email-container {
        background-color: #ffffff;
        max-width: 600px;
        margin: 0 auto;
        padding: 30px;
        border-radius: 8px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }

    p {
        font-size: 16px;
        line-height: 1.6;
        color: #34495e;
        margin: 10px 0;
    }

    .footer {
        display: flex;
        flex-direction: column;
        justify-content: flex-start;
        align-items: flex-start;
        font-size: 14px;
        color: #95a5a6;
        text-align: center;
        margin-top: 30px;
    }

    .footer p {
        margin: 2px 0;
    }
</style>