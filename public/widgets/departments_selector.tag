<departments-selector>

  <div class="form-group">
    <input type="hidden" name="dpmt" value={serialize()} />

    <label form-label>{t(opts.label, true)}</label>
    <span class="ldb-required">*</span>

    <div class="departments">
      <div class="checkbox" each={department in departments}>
        <label>
          <input
            type="checkbox"
            value={department}
            onchange={onChange}
          />
          {department}
        </label>
      </div>
    </div>

    <span if={opts.help} class="help-block">{opts.help}</span>
  </div>

  <script type="text/javascript">
    var tag = this;

    tag.on('before-mount', function() {
      tag.data = [];
      tag.departments = [];
      parseOpts();
    })

    tag.on('mount', function() {
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
      tag.departments = tag.opts.departments.split(/,/);
      if (tag.opts.value == '') {
        tag.data = [];
      } else {
        tag.data = tag.opts.value.split(/,/);
      }
    }
  </script>
</departments-selector>