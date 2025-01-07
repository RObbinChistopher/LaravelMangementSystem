@extends('include.master')

@section('content')
<div class="email-wrapper">
    <table class="email-content" align="center">
        <!-- Header -->
        <tr>
            <td class="email-header">
                <h1>Welcome to Vise Tech</h1>
            </td>
        </tr>

        <!-- Body -->
        <tr>
            <td class="email-body">
                <h3>{{ $subject }}</h3>
                <!-- Render HTML content from message -->
                <div>{!! $messageContent !!}</div>
            </td>
        </tr>
    </table>
</div>
@endsection