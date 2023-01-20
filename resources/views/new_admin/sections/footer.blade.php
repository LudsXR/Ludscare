<footer class="main-footer">
    <strong>Copyright &copy; {{date("Y")}} </strong>
    All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
      {{-- <b>Version</b> 1.2.1 --}}
    </div>
  </footer>
<script>
    function openFile(event){
      let image = event.files[0];
      let image_url= URL.createObjectURL(image);
      let image_tag="<img src='"+image_url+"' hieght='150px' width='100px' id='img_preview' />"
      $('.image_preview').html(image_tag);

}
    </script>
