<confirm-anchor>
  <a
    href={opts.href}
    target={opts.target}
    class={opts.class}
    onclick={anchorClicked}
  ><yield /></a>

  <script type="text/javascript">
    var tag = this;

    tag.anchorClicked = function(event) {
      if (!window.confirm("Are you sure?")) {
        event.preventDefault();
      }
    };
  </script>
</confirm-anchor>