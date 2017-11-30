<autocomplete class="ui-front">
  <input
    id="{opts.id}"
    class="form-control"
    type="text"
    name={opts.name}
    value={opts.riotValue}
    placeholder={t('igb_prompt_start_typing')}
    ref="input"
    data-placement="left"
    data-trigger="focus"
    data-title={opts.popoverTitle}
    data-content={opts.popoverContent}
  />

  <script type="text/javascript">
    var tag = this;

    tag.on('mount', function(){
      if (tag.opts.popoverTitle) {
        $(tag.refs.input).popover();
      }

      $(tag.refs.input).autocomplete({
        minLength: 2,
        appendTo: null,
        focus: function(event, ui) {
          // console.log('item', ui.item);
          event.preventDefault();
          $(tag.refs.input).val(ui.item.label);
        },
        select: function(event, ui) {
          // console.log('select');
          event.preventDefault();
          if (event.originalEvent.originalEvent.keyCode == 13) {
            tag.ignoreKeydown = true;
          }
          $(tag.refs.input).val(ui.item.label);
          if (oe = tag.opts.onExisting) {
            oe(ui.item.value, ui.item.label);
          }
        },
        source: function(request, response) {
          lookup(request.term).done(function(data) {
            response(data);
          })
        }
      });

      $(tag.refs.input).on('keyup', function(event) {
        // console.log('keyup');
        if (tag.ignoreKeydown) {
          tag.ignoreKeydown = false;
        } else {
          if (event.keyCode != 38 && event.keyCode != 40) {
            if (oc = tag.opts.onCustom) {
              var label = $(event.target).val();
              oc(label);
            }
          }
        }
      });
    })

    var lookup = function(terms) {
      return $.ajax({
        type: 'GET',
        url: "/autocomplete/" + tag.opts.type,
        data: {terms: terms}
      });
    }

    tag.t = function(key, cap = false) {
      var result = translations[key];
      return (cap ? result.charAt(0).toUpperCase() + result.slice(1) : result);
    }
  </script>

</autocomplete>