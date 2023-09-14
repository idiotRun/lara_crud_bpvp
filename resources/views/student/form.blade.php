@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header d-flex" style="justify-content: space-between; align-items: center;">
                        <h4 style="margin-bottom: 0px !important;"><b>{{ isset($data) ? 'Student Update' : 'Student Add' }}</b></h4>
                        <a href="{{ route('student.index') }}" class="btn btn-primary">Back to Index</a>
                    </div>

                    <div class="card-body">
                        @if ($errors->any())
                            <div class="alert alert-warning mb-3">
                                <h4 align="center"><b>Pesan Error!</b></h4>
                                <ul class="list-group" style="margin-bottom: 0px !important;">
                                    @foreach ($errors->all() as $error)
                                        <li class="list-group-item">{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ isset($data) ? route('student.update', $data->id) : route('student.store') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            @method(isset($data) ? 'PUT' : 'POST')
                            <div class="mb-3">
                                <label for="name" class="form-label">Name Student</label>
                                <input type="text" name="name" value="{{ isset($data) ? $data->name : old('name') }}"  class="form-control" id="name">
                            </div>
                            <div class="mb-3">
                                <label for="photo" class="form-label">Photo {{ isset($data) ? '(Opsional)' : '(Wajib)' }}</label>
                                <input type="file" name="photo" class="form-control" id="photo">
                            </div>
                            <div class="mb-3">
                                <label for="date" class="form-label">Birth Date</label>
                                <input type="date" name="birth_date" value="{{ isset($data) ? $data->birth_date : old('birth_date') }}" class="form-control" id="date">
                            </div>
                            <div class="mb-3">
                                <label for="place" class="form-label">Birth Place</label>
                                <input type="text" name="birth_place" value="{{ isset($data) ? $data->birth_place : old('birth_place') }}" class="form-control" id="place">
                            </div>
                            <div class="mb-3">
                              <label for="gender" class="form-label">Gender</label>
                              <select name="gender"class="form-select" id="gender">
                                  <option value="">-- Pick Sex --</option>
                                  <option value="0" {{ (isset($data) ? $data->gender : old('gender')) == 0 ? 'selected' : '' }}>Woman</option>
                                  <option value="1" {{ (isset($data) ? $data->gender : old('gender')) == 1 ? 'selected' : '' }}>Man</option>
                              </select>
                          </div>
                          <div class="mb-3">
                              <label for="address" class="form-label">Address</label>
                              <textarea name="address" class="form-control" id="address" rows="4">{{ isset($data) ? $data->address : old('address') }}</textarea>
                          </div>

                            <div class="mb-5">
                                <button class="btn btn-success w-100" type="submit">{{ isset($data) ? 'Update Data' : 'Submit Data' }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
