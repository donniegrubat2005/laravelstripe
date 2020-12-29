@extends('layouts.app')
@section('content')
<div class="container">
    <div class="card" style="width:24rem;margin:auto;">
        <div class="card-body">
            <form action="/plans/{{ $plan->id }}" method="post">
                {{method_field('PUT')}}
                @csrf
                <div class="form-group">
                    <label for="plan name">Plan Name:</label>
                <input type="text" class="form-control" name="name" value="{{ $plan->name }}" placeholder="Enter Plan Name">
                </div>
                <div class="form-group">
                    <label for="cost">Cost:</label>
                    <input type="text" class="form-control" name="cost" value="{{ $plan->cost }}" placeholder="Enter Cost">
                </div>
                <div class="form-group">
                    <label for="cost">Plan Description:</label>
                    <input type="text" class="form-control" name="description" value="{{ $plan->description }}" placeholder="Enter Description">
                </div>
                <div class="form-group">
                    <label for="cost">Plan Type:</label>
                    <select class="form-control" name="plan_type">
                        <option value="Monthly">Monthly</option>
                        <option value="Yearly">Yearly</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
</div>
@endsection
