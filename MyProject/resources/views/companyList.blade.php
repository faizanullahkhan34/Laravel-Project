@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Company List</h2> 
    <table class="table table-striped yajra-datatable">
      <thead>
        <tr>
          <th>S.No</th>  
          <th> Name</th>
          <th>Employee Name</th>
          <th>  Email</th>
          <th> Phone</th>
          <th> Website</th>
          <th> Logo</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
          
      </tbody>
    </table>
  </div>

   
@endsection
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>  
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>
<script type="text/javascript">
   $(document).ready(function() {
      
      var table = $('.yajra-datatable').DataTable({
          processing: true,
          serverSide: true,
          ajax: "{{ url('companyList') }}",
          columns: [
              {data: 'DT_RowIndex', name: 'DT_RowIndex'},
              {data: 'c_name', name: 'c_name'},
              {data: function (data, type, dataToSet) {
        return data.first_name + "<br/>" + data.last_name;
    }},
              {data: 'c_email', name: 'c_email'},
              {data: 'c_phone', name: 'c_phone'},
              {data: 'c_website', name: 'c_website'},
              {data: 'c_logo', name: 'c_logo'}, 
              {
                  data: 'action', 
                  name: 'action', 
                  orderable: true, 
                  searchable: true
              },
          ]
      });
      
      
    });
  </script>