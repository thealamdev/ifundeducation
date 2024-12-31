<table>
    <thead>
        <tr>
            <th><strong>Id</strong></th>
            <th><strong>Author</strong></th>
            <th><strong>Status</strong></th>
            <th><strong>Request Date</strong></th>
            <th><strong>Transaction Id</strong></th>
            <th><strong>Destination</strong></th>
            <th><strong>Currency</strong></th>
            <th><strong>Transfer Date</strong></th>
            <th><strong>Amount</strong></th>
        </tr>
    </thead>
    <tbody>
        @foreach ($payouts as $payout)
            <tr>
                <td>{{ $payout->id }}</td>
                <td>{{ $payout->user->first_name . ' ' . $payout->user->last_name . '-' . $payout->user->email }}
                </td>
                <td>{{ @$payout->status }}</td>
                <td>{{ $payout->created_at->format('M d, Y H:i:s') }}</td>
                <td>{{ $payout->balance_transaction }}</td>
                <td>{{ $payout->destination }}</td>
                <td>{{ $payout->currency }}</td>
                <td>{{ $payout->transaction_time ? $payout->transaction_time->format('M d, Y H:i:s') : '-' }}</td>
                <td>{{ '$' . number_format($payout->amount, 2) }}</td>

            </tr>
        @endforeach
    </tbody>
</table>
