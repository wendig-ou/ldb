<file-select-feedback>
  <span if={selection}>
    <strong>Selected file: </strong>
    {selection}
  </span>

  <script type="text/javascript">
    var tag = this;
    window.t = tag;

    tag.on('mount', function() {
      $(tag.root).parent().on('change', ':file', function() {
        fileselect(
          input().get(0).files ? input().get(0).files.length : 1,
          input().val().replace(/\\/g, '/').replace(/.*\//, '')
        );
      });
    });

    var fileselect = function(numFiles, label) {
      display().val(label);
    }

    var input = function() {
      return $(tag.root).parent().find('input[type=file]');
    }

    var display = function() {
      return $(tag.root).parent().find('input[name="file-feedback"]')
    }
  </script>

</file-select-feedback>