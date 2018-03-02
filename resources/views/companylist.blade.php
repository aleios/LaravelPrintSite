@extends('layouts.app')

@section('content')
    <h2>Company List</h2>

    <div id="results">
        <table class="table table-bordered table-striped table-condensed">
            <thead>
                <th>Name</th>
                <th>Total Price</th>
            </thead>

            <tbody id="resultbody">
                @foreach($companies as $c)
                    <tr>
                        <td>{{ $c->cname }}</td>
                        <td>
                            @if($c->prices != "")
                                ${{ $c->prices }}
                            @else
                                $0.00
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div id="pagination">
    {{ $companies->links() }}
    </div>
@endsection