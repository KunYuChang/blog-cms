<!-- Button to Open the Modal -->
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">
  Open modal
</button>

<!-- The Modal -->
<div class="modal" id="myModal">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Modal Delete Box</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
        <h2>Are you sure you want to delete this post?</h2>
      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
        <form style="position:absolute; margin-left:425px " action="" method="post">
            <input type="hidden"  class='modal_delete_link' name="delete_item" value=''>
            <input  class="btn btn-danger delete_link" type='submit' name='delete' value='Delete'>
        </form>
        <button  type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
      </div>

    </div>
  </div>
</div>