<checkbox-selector>
  <div class="form-group">
    <input type="hidden" name={opts.name} value={serialize()} />

    <label form-label>{t(opts.label, true)}</label>

    <span
      if={opts.required}
      class="ldb-required"
    >*</span>

    <div class="options">
      <div class="checkbox" each={choice in choices}>
        <label>
          <input
            type="checkbox"
            value={choice}
            onchange={onChange}
          />
          {choice}
        </label>
      </div>
    </div>

    <span if={opts.help} class="help-block">{opts.help}</span>
  </div>

  <script type="text/javascript">
    var tag = this;
    tag.data = [];

    tag.on('mount', function() {
      var o = tag.opts.choices
      tag.choices = (typeof o == 'string' ? o.split(/,/) : o)

      parseOpts();
      tag.update();

      $(tag.root).find('input[type=checkbox]').each(function(i, e){
        e = $(e);
        if (tag.data.indexOf(e.val()) != -1) {
          e.prop('checked', true);
        }
      });
    })

    tag.t = function(key, cap = false) {
      var result = translations[key];
      return (cap ? result.charAt(0).toUpperCase() + result.slice(1) : result);
    }

    tag.onChange = function(event) {
      tag.data = [];
      $(tag.root).find('input[type=checkbox]').each(function(i, e){
        e = $(e);
        if (e.prop('checked')) {
          tag.data.push(e.val())
        }
      });
    }

    tag.serialize = function (argument) {
      return tag.data.join(',');
    }

    parseOpts = function() {
      if (!tag.opts.value) {
        tag.data = [];
      } else {
        tag.data = tag.opts.value.split(/,/);
      }
    }
  </script>
</checkbox-selector>
