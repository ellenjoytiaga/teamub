
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
      <button type="button" name="CreateItem" id="CreateItem" class="btn btn-success btn-sm">Create Record</button>
      <a href="{{ route('home') }}" type="button" name="home"  class="btn btn-success btn-sm">Back to home</a>
            <a href="{{ route('Itrash') }}" type="button" name="home"  class="btn btn-success btn-sm">Trash</a>

     </div>
     <br />
   <div class="table-responsive">
    <table class="table table-bordered table-striped" id="item_table">
           <thead>
            <tr>
                <th width="35%">Item Name</th>
                <th width="35%">Item Description</th>
                <th width="35%">Item Quantity</th>
                <th width="35%">Category Type</th>
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

<div id="ItemFormModal" class="modal fade" role="dialog">
 <div class="modal-dialog">
  <div class="modal-content">
   <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modalitem">Add New Record</h4>
         
        </div>
        <div class="modal-body">
         <span id="FormCategory"></span>
         <form method="post" id="ItemForm" class="form-horizontal" enctype="multipart/form-data">
          @csrf
          <div class="form-group">
            <label class="control-label col-md-4" >Category Name : </label>
            <div class="col-md-8">
             <input type="text" name="item_name" id="item_name" class="form-control" />
            </div>
           </div>
           <div class="form-group">
            <label class="control-label col-md-4">Category Description : </label>
            <div class="col-md-8">
             <input type="text" name="item_desc" id="item_desc" class="form-control" />
            </div>
           </div>
           
           <div class="form-group">
            <label class="control-label col-md-4">Category Quantity : </label>
            <div class="col-md-8">
             <input type="text" name="item_qty" id="item_qty" class="form-control" />
            </div>
           </div>
           
           <div class="form-group">
            <label class="control-label col-md-4">Type of Category : </label>
            <div class="col-md-8">
            <select type="text" name="category_name" id="category_name" class="form-control" >
       
         @foreach($categories as $cat)
  <option>{{$cat->category_name}}</option>
  @endforeach
</select>
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

 $('#item_table').DataTable({
  processing: true,
  serverSide: true,
  ajax:{
    url: "{{ route('Iindex') }}",
},
  columns:[
   
   {
    data: 'item_name',
    name: 'item_name'
   },
   {
    data: 'item_desc',
    name: 'item_desc'
   },
   {
    data: 'item_qty',
    name: 'item_qty'
   },
   {
    data: 'category_name',
    name: 'category_name'
   },
   {
    data: 'action',
    name: 'action',
    orderable: false
   }
  ]
 });

 $('#CreateItem').click(function(){
  $('.modalitem').text("Add New Item");

     $('#action_button').val("Add");
     $('#action').val("Add");
     $('#ItemFormModal').modal('show');
 });

 $('#ItemForm').on('submit', function(event){
  event.preventDefault();
  if($('#action').val() == 'Add')
  {
   $.ajax({
    url:"{{ route('Istore') }}",
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
      $('#ItemForm')[0].reset();
      $('#item_table').DataTable().ajax.reload();
     }
     $('#FormCategory').html(html);
    }
   })
  }

  if($('#action').val() == "Edit")
  {
   $.ajax({
    url:"{{ route('Iupdate') }}",
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
      $('#ItemForm')[0].reset();
      $('#store_image').html('');
      $('#item_table').DataTable().ajax.reload();
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
   url:"/Item/Item/"+id+"/edit",
   dataType:"json",
   success:function(html){
    $('#item_name').val(html.data.item_name);
    $('#item_desc').val(html.data.item_desc);
    $('#item_qty').val(html.data.item_qty);
    $('#category_name').val(html.data.category_name);
    $('#store_image').html("<img src={{ URL::to('/') }}/images/" + html.data.image + " width='70' class='img-thumbnail' />");
    $('#store_image').append("<input type='hidden' name='hidden_image' value='"+html.data.image+"' />");
    $('#hidden_id').val(html.data.id);
    $('.modalitem').text("Edit New Record");
    $('#action_button').val("Edit");
    $('#action').val("Edit");
    $('#ItemFormModal').modal('show');
   }
  })
 });

 var id
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
    $('#item_table').DataTable().ajax.reload();
   }, 2000);
  }
 })
});

});
</script>