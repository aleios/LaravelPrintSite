<table class="table table-bordered table-striped table-condensed">
    <!-- Table header -->
    <thead>
        <tr>
            <th>Name</th>
            <th>Client</th>
            <th>Company</th>
            <th>Status</th>
            <th>Price</th>
        </tr>
    </thead>

    <tbody id="resultbody">
    <!-- Results populated at page load -->

    @foreach($jobs as $value)

        <tr data-toggle="collapse" data-target="#jobdetails{{ $loop->index }}" class="clickable">
            <td>{{ $value->jobname }}</td>
            <td>{{ $value->clientname." ".$value->clientsurname }}</td>
            <td>{{ $value->companyname }}</td>
            <td>{{ $value->statusname }}</td>
            <td>{{ $value->price }}</td>
        </tr>

        <tr class="detail-panel">
            <td class="detail-panel" colspan="5">
                <div id="jobdetails{{ $loop->index}}" class="collapse">
                    Creation Date/Time: {{ $value->created_at }}<br />
                    Total Jobs: {{ $counts[$value->clientid] }}
                </div>
            </td>
        </tr>

    @endforeach
    </tbody>
</table>

<div>
{{ $jobs->links() }}
</div>