<div class="col-sm-12">
    <div class="card">
        <div class="card-body">
            <h4>Cargo Details</h4>
            <table class="table table-boarded">
                <tbody>
                <tr>
                    <td><strong>Cargo Description :</strong> {{ ucfirst($cargo->desc) }}</td>
                    <td><strong>Cargo Type :</strong> {{ $type->name }}</td>
                    <td><strong>Cargo Weight :</strong> {{ ucfirst($cargo->cargo_weight) }}</td>
                </tr>
                <tr>
                    <td><strong>Cargo Quantity :</strong> {{ $cargo->cargo_quantity }}</td>
                    <td><strong>Pick up point :</strong> {{ ucfirst($cargo->start) }}</td>
                    <td><strong>Destination :</strong> {{ ucfirst($cargo->destination) }}</td>
                </tr>
                <tr>
                    <td><strong>Distance :</strong> {{ $cargo->distance }} KM</td>
                    <td><strong>Remarks :</strong> {{ ucfirst($cargo->remarks) }}</td>
                    <td><strong>Added On :</strong> {{ \Carbon\Carbon::parse($cargo->created_at)->format('d-M-y H:m')}}</td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>