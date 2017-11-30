<institution-selector>
  <div class="form-group {'has-success': lockedIn}">
    <input type="hidden" name={opts.name} ref="input" />
    <label for="field_{opts.name}" form-label>{t(opts.label, true)}</label>
    <span class="ldb-required">{opts.required ? '*' : ''}</span>
    <autocomplete
      id="field_{opts.name}"
      on-existing={onExisting}
      on-custom={onCustom}
      type="institutions"
      value={opts.labelValue}
      name={opts.labelName}
      popover-title={t('igb_notice_is_institution_autocomplete_title', true)}
      popover-content={t('igb_notice_is_institution_autocomplete_content', true)}
    ></autocomplete>
    <span if={opts.help} class="help-block">{opts.help}</span>
  </div>

  <script type="text/javascript">
    var tag = this;

    tag.on('mount', function() {
      var v = tag.opts.value
      if (v) {
        $(tag.refs.input).val(v);
        tag.lockedIn = true;

        $.ajax({
          url: '/institutions/by_id/' + v,
          success: function(data) {
            // console.log(data);
            $(tag.root).find('autocomplete input').val(data['institut']);
          }
        });
      } else {
        tag.lockedIn = false;
      }

      tag.update();
    })

    tag.t = function(key, cap = false) {
      var result = translations[key];
      return (cap ? result.charAt(0).toUpperCase() + result.slice(1) : result);
    }

    tag.onCustom = function(name) {
      // console.log('custom', name);
      $(tag.refs.input).val('');
      tag.lockedIn = false;
      tag.update();
    }

    tag.onExisting = function(id, name) {
      // console.log('existing', id, name);
      $(tag.refs.input).val(id);
      tag.lockedIn = true;
      tag.update();
    }
  </script>
</institution-selector>