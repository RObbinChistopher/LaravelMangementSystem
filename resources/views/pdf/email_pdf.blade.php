@extends('include.master')

@section('content')
<div style="padding: 20px;">
    <div style="margin: 0 auto; padding: 30px; border-radius: 8px;">
        <p style="font-size: 16px; color: #34495e;">Dear <strong>{{ $task['userName'] }},</strong></p>

        <p style="font-size: 16px; color: #34495e;">
            I hope this message finds you well. I am submitting the details of the task. The task is 
            <strong>{{ $task['name'] }}</strong>, and modular <strong>{{ $task['milestoneId'] }}</strong> 
            and deadline is <strong>{{ $task['deadline'] }}</strong>. 
            The current status of the task is <strong>{{ $task['status'] }}</strong> 
            and priority <strong>{{ $task['priority'] }}</strong>.
        </p>

        <p style="font-size: 16px; color: #34495e; margin-bottom: 0;">
            <strong>Tasks information:.</strong><strong>{!! $task['description'] !!}</strong> 
            Please let me know if you need any further information or if any changes are required.
        </p>

        <div style="margin-top: 30px; font-size: 14px; color: #95a5a6; text-align: left;">
            <p style="margin: 2px 0;">Best regards,</p>
            <p style="margin: 2px 0;">{{ $task['userName'] }}</p>
            <p style="margin: 2px 0;">{{ $task['position'] }}</p>
            <p style="margin: 2px 0;">Vice Tech</p>
        </div>
    </div>
</div>
@endsection
