@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Data Tables</div>
                <div class="card-body">
                    <table class="table table-bordered data-table" id="plan-id">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Cost</th>
                                <th>Description</th>

                            </tr>
                        </thead>
                        <tbody>
                            @foreach($plans as $key => $plan)
                            <tr>

                                <td>{{ $plan->name }}</td>
                                <td>{{ $plan->cost }}</td>
                                <td>{{ $plan->description }}</td>

                                <!-- we will also add show, edit, and delete buttons -->
                                {{-- <td>

                                    <!-- show the nerd (uses the show method found at GET /nerds/{id} -->
                                    <a class="btn btn-small btn-success" href="{{ URL::to('employee/' . $emp->id) }}">Show</a>

                                    <!-- edit this nerd (uses the edit method found at GET /nerds/{id}/edit -->
                                    <a class="btn btn-small btn-info" href="{{ URL::to('employee/' . $emp->id . '/edit')}}">Edit</a>

                                </td> --}}
                            </tr>
                         @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<script
  src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
  integrity="sha256-4+XzXVhsDmqanXGHaHvgh1gMQKX40OUvDEBTu8JcmNs="
  crossorigin="anonymous"></script>
<link href="//cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css" type="css">
<script src="//cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
<script>
    $(function() {
      $('#plan-id').DataTable();
    });
   </script>
@endsection
