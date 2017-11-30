<back-button>
  <a class="btn btn-default" onclick={onClick} href="#"><yield /></a>

  <script type="text/javascript">
    var tag = this;

    tag.onClick = function(event) {
      event.preventDefault();
      window.history.back();
    }
  </script>
</back-button>