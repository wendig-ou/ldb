<end-year>

  <div class="form-group">
    <label class="form-label" for="field_{opts.name}" if={opts.label}>
      {opts.label}
    </label>
    <div class="input-group">
      <span class="input-group-addon">
        <input
          type="checkbox"
          aria-label={t('igb_ongoing')}
          onchange={toggle}
          ref="checkbox"
        />
        <span class="igb-text">{t('igb_ongoing')}</span>
      </span>
      <input
        if="ongoing"
        type="hidden"
        name={opts.name}
        value="-"
        ref="hidden"
      />
      <input
        id="field_{opts.name}"
        class="form-control"
        type="text"
        name={opts.name}
        riot-value={opts.value}
        placeholder={opts.help}
        ref="input"
      />
    </div>
  </div>

  <script type="text/javascript">
    var tag = this;
    tag.ongoing = false;

    tag.on('mount', function() {
      console.log(tag.opts);
      tag.ongoing = (tag.opts.value == '-');
      $(tag.refs.checkbox).prop('checked', tag.ongoing);
      tag.update();
    });

    tag.on('update', function() {
      console.log(tag.ongoing);
      $(tag.refs.input).prop('disabled', tag.ongoing);
      $(tag.refs.hidden).prop('disabled', !tag.ongoing);

      if (tag.ongoing) {
        $(tag.refs.input).val('');
      }
    });

    tag.toggle = function(event) {
      tag.ongoing = $(tag.refs.checkbox).prop('checked');
      tag.update();
    }

    // tag.toggle = function() {
    //   var input = $(tag.refs.input);
    //   if ($(tag.refs.checkbox).prop('checked')) {
    //     input.prop('disabled', true);
    //     input.val('');
    //     tag.ongoing = true;
    //   } else {
    //     input.prop('disabled', false);
    //     input.val($('input[name=fdate]').val());
    //     tag.ongoing = false;
    //   }
    // }

    tag.t = function(key, cap = false) {
      var result = translations[key];
      return (cap ? result.charAt(0).toUpperCase() + result.slice(1) : result);
    }
  </script>

</end-year>