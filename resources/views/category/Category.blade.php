
<html>
 <head>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>UNIVERSITY OF BAGUIO</title>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
  <script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>  
  <link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css" />
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
 </head>
 <body>
  <div class="container">    
     <br />
     <h3 align="center">Category</h3>
     
     <br />
     <div align="right">
      <button type="button" name="CreateCategory" id="CreateCategory" class="btn btn-success btn-sm">Create Record</button>
      <a href="{{ route('home') }}" type="button" name="home"  class="btn btn-success btn-sm">Back to home</a>
      <a href="{{ route('Ctrash') }}" type="button" name="home"  class="btn btn-success btn-sm">Trash</a>

     </div>
     <br />
   <div class="table-responsive">
    <table class="table table-bordered table-striped" id="category_table">
           <thead>
            <tr>
                <th width="35%">Category Name</th>
                <th width="35%">Category Description</th>
                <th width="30%">Action</th>
            </tr>
           </thead>
       </table>
   </div>
   <br />
   <br />
  </div>
 </body>
</html>

<div id="CategoryFormModal" class="modal fade" role="dialog">
 <div class="modal-dialog">
  <div class="modal-content">
   <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modalcategory">Add New Record</h4>
         
        </div>
        <div class="modal-body">
         <span id="FormCategory"></span>
         <form method="post" id="CategoryForm" class="form-horizontal" enctype="multipart/form-data">
          @csrf
          <div class="form-group">
            <label class="control-label col-md-4" >Category Name : </label>
            <div class="col-md-8">
             <input type="text" name="category_name" id="category_name" class="form-control" />
            </div>
           </div>
           <div class="form-group">
            <label class="control-label col-md-4">Category Description : </label>
            <div class="col-md-8">
             <input type="text" name="category_desc" id="category_desc" class="form-control" />
            </div>
           </div>
           
           <br />
           <div class="form-group" align="center">
            <input type="hidden" name="action" id="action" />
            <input type="hidden" name="hidden_id" id="hidden_id" />
            <input type="submit" name="action_button" id="action_button" class="btn btn-warning" value="Add" />
           </div>
         </form>
        </div>
     </div>
    </div>
</div>

<div id="confirmModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h2 class="modalitem">Confirmation</h2>
            </div>
            <div class="modal-body">
                <h4 align="center" style="margin:0;">Are you sure you want to remove this data?</h4>
            </div>
            <div class="modal-footer">
             <button type="button" name="ok_button" id="ok_button" class="btn btn-danger">OK</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>



<script>
$(document).ready(function(){

 $('#category_table').DataTable({
  processing: true,
  serverSide: true,
  ajax:{
   url: "{{ route('Cindex') }}",
  },
  columns:[
   
   {
    data: 'category_name',
    name: 'category_name'
   },
   {
    data: 'category_desc',
    name: 'category_desc'
   },
   {
    data: 'action',
    name: 'action',
    orderable: false
   }
  ]
 });

 $('#CreateCategory').click(function(){
  $('.modalcategory').text("Add New Category");
  $('.home').text("Add New Category2");
     $('#action_button').val("Add");
     $('#action').val("Add");
     $('#CategoryFormModal').modal('show');
 });

 $('#CategoryForm').on('submit', function(event){
  event.preventDefault();
  if($('#action').val() == 'Add')
  {
   $.ajax({
    url:"{{ route('Cstore') }}",
    method:"POST",
    data: new FormData(this),
    contentType: false,
    cache:false,
    processData: false,
    dataType:"json",
    success:function(data)
    {
     var html = '';
     if(data.errors)
     {
      html = '<div class="alert alert-danger">';
      for(var count = 0; count < data.errors.length; count++)
      {
       html += '<p>' + data.errors[count] + '</p>';
      }
      html += '</div>';
     }
     if(data.success)
     {
      html = '<div class="alert alert-success">' + data.success + '</div>';
      $('#CategoryForm')[0].reset();
      $('#category_table').DataTable().ajax.reload();
     }
     $('#FormCategory').html(html);
    }
   })
  }

  if($('#action').val() == "Edit")
  {
   $.ajax({
    url:"{{ route('categoryupdate') }}",
    method:"POST",
    data:new FormData(this),
    contentType: false,
    cache: false,
    processData: false,
    dataType:"json",
    success:function(data)
    {
     var html = '';
     if(data.errors)
     {
      html = '<div class="alert alert-danger">';
      for(var count = 0; count < data.errors.length; count++)
      {
       html += '<p>' + data.errors[count] + '</p>';
      }
      html += '</div>';
     }
     if(data.success)
     {
      html = '<div class="alert alert-success">' + data.success + '</div>';
      $('#CategoryForm')[0].reset();
      $('#store_image').html('');
      $('#category_table').DataTable().ajax.reload();
     }
     $('#FormCategory').html(html);
    }
   });
  }
 });

 $(document).on('click', '.edit', function(){
  var id = $(this).attr('id');
  $('#FormCategory').html('');
  $.ajax({
   url:"/category/Category/"+id+"/edit",
   dataType:"json",
   success:function(html){
    $('#category_name').val(html.data.category_name);
    $('#category_desc').val(html.data.category_desc);
    $('#store_image').html("<img src={{ URL::to('/') }}/images/" + html.data.image + " width='70' class='img-thumbnail' />");
    $('#store_image').append("<input type='hidden' name='hidden_image' value='"+html.data.image+"' />");
    $('#hidden_id').val(html.data.id);
    $('.modalcategory').text("Edit New Record");
    $('#action_button').val("Edit");
    $('#action').val("Edit");
    $('#CategoryFormModal').modal('show');
   }
  })
 });

 var id;

$(document).on('click', '.delete', function(){

 id = $(this).attr('id');
 $('#confirmModal').modal('show');
});

$('#ok_button').click(function(){
 $.ajax({
  url:"destroy/"+id,
  beforeSend:function(){
   $('#ok_button').text('Deleting...');
  },
  success:function(data)
  {
   setTimeout(function(){
    $('#confirmModal').modal('hide');
    $('#category_table').DataTable().ajax.reload();
   }, 2000);
  }
 })
});

});
</script>