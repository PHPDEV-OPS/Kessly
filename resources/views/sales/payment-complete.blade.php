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

        @if(!empty($details) && is_array($details))
            <div class="mt-3 text-start d-inline-block">
                <h6>Details</h6>
                <ul class="list-unstyled mb-0">
                    @foreach($details as $key => $value)
                        <li><strong>{{ ucfirst(str_replace('_', ' ', $key)) }}:</strong> {{ is_array($value) ? json_encode($value) : $value }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <a href="/pos" class="btn btn-primary mt-3">Back to POS</a>
    </div>
@endsection
