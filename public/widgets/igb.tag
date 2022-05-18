<igb style="display: none">
  <script type="text/javascript">
    var tag = this;

    tag.on('mount', function() {
      window.igb = {
        bus: riot.observable(),
        currentType: null,
        setType: setType
      }

      // igb.bus.on('type-selected', setType);
    })

    // tag.on('unmount', function(event) {
    //   igb.bus.off('type-selected', setType);
    // })

    var setType = function(type) {
      window.igb['currentType'] = type;
      window.igb.bus.trigger('type-selected')
    }
  </script>
</igb>