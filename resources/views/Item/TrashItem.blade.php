
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
      <a href="{{ route('Iindex') }}" type="button" name="home"  class="btn btn-success btn-sm">Back to Item</a>
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

<!--restore-->

<div id="restoreModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h2 class="modalitem">Confirmation</h2>
            </div>
            <div class="modal-body">
                <h4 align="center" style="margin:0;">Are you sure you want to restore this data?</h4>
            </div>
            <div class="modal-footer">
             <button type="button" name="confirmbutton" id="confirmbutton" class="btn btn-danger">OK</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>

<!-- delete-->
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
   url: "{{ route('Itrash') }}",
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

var id;

$(document).on('click', '.restore', function(){

 id = $(this).attr('id');
 $('#restoreModal').modal('show');
});

$('#confirmbutton').click(function(){
 $.ajax({
  url:"restore/"+id,
  beforeSend:function(){
   $('#confirmbutton').text('Restoring...');
  },
  success:function(data)
  {
   setTimeout(function(){
    $('#restoreModal').modal('hide');
    $('#item_table').DataTable().ajax.reload();
   }, 2000);
  }
 })
});

});
</script>