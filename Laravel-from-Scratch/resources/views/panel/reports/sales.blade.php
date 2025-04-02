@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Sales Report - {{ ucfirst($filter) }}</h2>

        @if ($salesData->isEmpty())
            <p>No sales data available.</p>
        @else
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Orders</th>
                        <th>Sales</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($salesData as $data)
                        <tr>
                            <td>{{ $data->date }}</td>
                            <td>{{ $data->orders }}</td>
                            <td>${{ number_format($data->sales, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
@endsection
