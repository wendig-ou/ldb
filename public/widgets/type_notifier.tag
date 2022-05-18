<type-notifier>
  <yield />

  <script type="text/javascript">
    var tag = this;

    tag.on('mount', function() {
      $(tag.opts.selector).on('click', function(event) {
        notify();
      });

      notify();
    })

    var value = function() {
      return $(tag.opts.selector + ':checked').val();
    }

    var notify = function() {
      window.igb.setType(value())
      // window.igb.bus.trigger('type-selected', value())
    }
  </script>
</type-notifier>