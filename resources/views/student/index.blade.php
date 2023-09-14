@extends('layouts.app')

@push('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">

<style>
   img {
      border: 4px solid white;
   }
</style>
@endpush

@section('content')
<div class="container-fluid">
   <div class="row justify-content-center">
      <div class="col-md-10">
         <div class="card">
            <div class="card-header d-flex" style="justify-content: space-between; align-items: center;">
               <h4 style="margin-bottom: 0px !important;"><b>Student List</b></h4>
               <a href="{{ route('student.create') }}" class="btn btn-primary">Add Data</a>
            </div>

            <div class="card-body">
               @if (Session::has('success'))
               <div class="alert alert-primary alert-dismissible fade show" role="alert">
                  <strong>{{ Session::get('success') }}</strong>
                  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
               </div>
               @elseif (Session::has('error'))
               <div class="alert alert-warning alert-dismissible fade show" role="alert">
                  <strong>{{ Session::get('error') }}</strong>
                  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
               </div>
               @endif
               <table id="example" class="table table-striped" style="width:100%">
                  <thead>
                     <tr>
                        <th>
                           <center>No.</center>
                        </th>
                        <th>
                           <center>Photo</center>
                        </th>
                        <th>Birth Date</th>
                        <th>Birth Place</th>
                        <th>Gender</th>
                        <th>Address</th>
                        <th>
                           <center>Action</center>
                        </th>
                     </tr>
                  </thead>
                  <tbody>
                     @foreach ($students as $item)
                     <tr>
                        <td align="center" valign="middle">{{ $loop->iteration }}</td>
                        <td align="center" valign="middle"><img width="100px" src="{{ Storage::url($item->photo) }}"
                              alt=""></td>
                        <td valign="middle">
                           {{ \Carbon\Carbon::parse($item->birth_date)->isoFormat('D MMMM Y') }}
                        </td>
                        <td valign="middle">{{ $item->birth_place }}</td>
                        <td valign="middle">{{ $item->gender == 0 ? 'Wanita' : 'Pria' }}</td>
                        <td valign="middle">{{ $item->address }}</td>
                        <td valign="middle">
                           <div class="d-flex justify-content-center">
                              <a href="{{ route('student.edit', $item->id) }}" class="btn btn-warning"
                                 style="margin-right: 8px;"><b>Edit</b></a>
                              <form action="{{ route('student.destroy', $item->id) }}" method="post">
                                 @csrf
                                 @method('DELETE')
                                 <button class="btn btn-danger" type="submit"><b>Delete</b></button>
                              </form>
                           </div>
                        </td>
                     </tr>
                     @endforeach
                  </tbody>
               </table>
            </div>
         </div>
      </div>
   </div>
</div>
@endsection

@push('js')
<script src="https://code.jquery.com/jquery-3.7.0.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

<script>
   new DataTable('#example');
</script>
@endpush