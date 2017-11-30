<panel-clicker>
  <script type="text/javascript">
    var tag = this;

    tag.on('mount', function() {
      $(document).on('click', 'a[disabled]', function(event) {
        event.preventDefault();
      });
    });
  </script>
</panel-clicker>