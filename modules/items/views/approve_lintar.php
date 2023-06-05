<?php echo ajax_modal_template_header($_GET['status_approve']." Permintaan") ?>


<?php echo form_tag('modal_form',url_for('items/change_approve_lintar','path=' . $app_path . '&action=change_parent')) ?>
<div class="modal-body ajax-modal-width-790"> 
   <h4><?=($_GET['status_approve'] == 'Tolak')?"Bisa Berikan alasan kenapa kamu menolak ini?":"Alasan Boleh dikosongi"?></h4>
   
   
   <input type="hidden" name='field_kategori' value='<?=$_GET['field_keterangan']?>'>
   <input type="hidden" name='field_status' value='<?=$_GET['field_status']?>'>
   <input type="hidden" name='entities_parent_id' value='<?=$_GET['from_entities']?>'>
   <input type="hidden" name='parent_item_id' value='<?=$_GET['item_id']?>'>
   <input type="hidden" name='status_approve' value='<?=$_GET['status_approve']?>'>
   <input type="hidden" name='app_path' value='<?=$_GET['path']?>'>
   

   <?php 
        echo textarea_tag('description','',array('class'=>'form-control autofocus '.$setujui.' editor-auto-focus ')); 
    
    ?>
   <h5 style='color:red;margin-top:10px' id='notip'></h5>
</div>

<?php echo ajax_modal_template_footer() ?>
</form>

<script>
    var editor = CKEDITOR.instances.description;
    editor.on('key', function(event) {
      // Mengambil isi teks setelah keyup
      var content = event.editor.getData();
      $("#description").val(content);
    });
    
    
 $(function (){
    $("#modal_form").submit(function(event) {
    
    if('<?=$_GET['status_approve']?>' !== 'Tolak') return true;
    if($("#description").val() != "") return true;
    
        $("#notip").text("Input keterangan");
        return false; 
         
     })
 })
    	  // Menambahkan event keyup
        
            

  
</script>
