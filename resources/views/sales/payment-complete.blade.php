@extends('layouts.app')

@section('content')
    <div class="container py-5 text-center">
        <h2>Payment Status</h2>
        @if(isset($status))
            @if($status === 'COMPLETED')
                <div class="alert alert-success">Payment successful and verified!</div>
            @elseif($status === 'FAILED')
                <div class="alert alert-danger">Payment failed. Please try again.</div>
            @else
                <div class="alert alert-warning">Payment status: {{ $status }}</div>
            @endif
        @else
            <div class="alert alert-secondary">Payment status could not be verified.</div>
        @endif
        <a href="/pos" class="btn btn-primary mt-3">Back to POS</a>
    </div>
@endsection
