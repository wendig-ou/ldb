<periodical-selector>
  <div class="form-group">
    <input type="hidden" name={opts.name} ref="input" />
    <label form-label>{t(opts.label, true)}</label>
    <span class="ldb-required">{opts.required ? '*' : ''}</span>
    <autocomplete
      on-existing={onExisting}
      on-custom={onCustom}
      type="periodicals"
      value={opts.labelValue}
      name={opts.labelName}
      popover-title={t('igb_notice_is_periodical_autocomplete_title', true)}
      popover-content={t('igb_notice_is_periodical_autocomplete_content', true)}
    ></autocomplete>
    <span if={opts.help} class="help-block">{opts.help}</span>
  </div>

  <script type="text/javascript">
    var tag = this;

    tag.on('mount', function() {
      var v = tag.opts.value
      if (v) {
        $(tag.refs.input).val(v);

        $.ajax({
          url: '/periodicals/by_id/' + v,
          success: function(data) {
            $(tag.root).find('autocomplete input').val(data['pname']);
          }
        });
      }
    })

    tag.t = function(key, cap = false) {
      var result = translations[key];
      return (cap ? result.charAt(0).toUpperCase() + result.slice(1) : result);
    }

    tag.onCustom = function(name) {
      // console.log('resetting pname_id', name);
      $(tag.refs.input).val('');
      tag.update();
    }

    tag.onExisting = function(id, name) {
      // console.log('setting pname_id to value ', id);
      $(tag.refs.input).val(id);
      tag.update();
    }
  </script>
</periodical-selector>