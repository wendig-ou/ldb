<type-details>
  <div
    if={active()}
    class="alert alert-info"
  >
    <strong>Heads up!</strong><br />
    {text()}
  </div>

  <script type="text/javascript">
    var tag = this;

    tag.on('mount', function() {
      window.igb.bus.on('type-selected', handler);
      handler();
    });

    tag.active = function() {
      return anySelected() && tag.text() != undefined;
    }

    tag.text = function() {
      return {
        '04.01': 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque molestie lacus sed lectus eleifend, vitae elementum metus commodo.',
        '04.02': 'Ut fermentum elit euismod, scelerisque mauris vel, semper lorem. Nunc sollicitudin mauris urna, at ultricies augue aliquam eu.',
        '04.03': 'Cras faucibus sed lacus vitae bibendum. Vivamus pulvinar tincidunt nibh eget eleifend. Interdum et malesuada fames ac ante ipsum primis in faucibus.',
        '04.04': 'Vivamus iaculis vestibulum efficitur. Nam cursus auctor risus eget viverra. Cras dignissim venenatis turpis. Praesent quis cursus nunc.'
      }[tag.type];
    }

    var anySelected = function() {
      return(
        tag.type != null &&
        tag.type != undefined &&
        tag.type != '' &&
        tag.type != []
      );
    }

    var handler = function(type) {
      tag.type = type;
      tag.update();
    }
  </script>

</type-details>