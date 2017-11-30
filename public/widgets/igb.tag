<igb style="display: none">
  <script type="text/javascript">
    var tag = this;

    tag.on('mount', function() {
      window.igb = {
        bus: riot.observable(),
        currentType: null
      }

      igb.bus.on('type-selected', setType);
    })

    tag.on('unmount', function(event) {
      igb.bus.off('type-selected', setType);
    })

    var setType = function(type) {
      igb['currentType'] = type;
    }
  </script>
</igb>