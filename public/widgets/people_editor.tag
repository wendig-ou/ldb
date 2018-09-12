<people-editor class="ui-front">
  <div class="form-group">
    <input type="hidden" name={opts.name} value={JSON.stringify(data)} />

    <label form-label>{opts.label}</label>
    <span class="ldb-required">*</span>
    <input
      class="form-control"
      type="text"
      placeholder={t('igb_prompt_start_typing')}
      ref="input"
      data-placement="left"
      data-title={t('igb_notice_is_people_autocomplete_title', true)}
      data-content={t('igb_notice_is_people_autocomplete_content', true)}
      data-trigger="focus"
    />
    <div show={data.length > 0}>
      <hr />
      <ul class="list-group" ref="list">
        <li
          class="list-group-item"
          each={record, i in data}
          person-id={record[1]}
          onclick={toggleIGB}
          position={i}
        >
          <i onclick={remove} class="glyphicon glyphicon-remove"></i>
          <div class="igb-label pull-right">
            <span if={toBool(record[2])} class="label label-primary">IGB</span>
            <span if={!toBool(record[2])} class="label label-default">IGB</span>
          </div>
          {labelFor(record)}
        </li>
      </ul>
    </div>
    <span if={opts.help} class="help-block">{opts.help}</span>
  </div>

  <script type="text/javascript">
    var tag = this;
    tag.data = [];
    tag.people = {};

    tag.on('mount', function() {
      $(tag.refs.input).popover();

      parseExisting();

      $(tag.refs.input).autocomplete({
        minLength: 3,
        appendTo: null,
        select: function(event, ui) {
          if (event.originalEvent.originalEvent.keyCode == 13) {
            tag.ignoreKeydown = true;
          }
          event.preventDefault();
          $(tag.refs.input).val('');
          tag.addExisting(ui.item.value, ui.item.label);
          return false;
        },
        source: function(request, response) {
          lookup(request.term).done(function(data) {
            response(data);
          })
        }
      });

      $(tag.refs.input).on('keydown', function(event) {
        if (event.keyCode == 13 && !tag.ignoreKeydown) {
          event.preventDefault();
          var e = $(event.target);
          var name = e.val();
          e.val('');
          e.autocomplete('close');
          tag.addCustom(name);
          // console.log(hasFocusedItem());
        } else {
          tag.ignoreKeydown = false;
        }
      });

      $(tag.refs.list).sortable({
        helper: 'clone',
        stop: function(event, ui) {
          var positions = [];
          var elements = ui.item.parent().find('li');
          for (var i = 0; i < elements.length; i++) {
            var position = parseInt($(elements[i]).attr('position'));
            positions.push(position);
          }
          // console.log(ids);
          reorder(positions);
          tag.update();
        }
      });
    })

    tag.toggleIGB = function(event) {
      event.item.record[2] = !tag.toBool(event.item.record[2]);
      tag.update();
    }

    tag.labelFor = function(record) {
      if ($.isNumeric(record[1]))
        return tag.people[record[1]];
      else
        return record[1];
    }

    tag.addExisting = function(id, name) {
      if (!exists(id)) {
        tag.data.push([null, id, false]);
        tag.people[id] = name;
        tag.update();
      } else {
        // TODO: translate
        alert('Person "' + name + '" already added');
      }
    }

    tag.addCustom = function(string) {
      // console.log(string);
      tag.data.push([null, string, false]);
      // tag.people[string] = string;
      tag.update();
    }

    tag.remove = function(event) {
      event.stopPropagation();
      var i = tag.data.indexOf(event.item.record);
      tag.data.splice(i, 1);
      tag.update();
    }

    tag.t = function(key, cap = false) {
      var result = translations[key];
      return (cap ? result.charAt(0).toUpperCase() + result.slice(1) : result);
    }

    tag.toBool = function(value) {
      if (value == '0') return false;
      return !!value;
    }

    var exists = function(id) {
      for (var i = 0; i < tag.data.length; i++) {
        if (tag.data[i][1] == id)
          return true; 
      }
      return false;
    }

    var parseExisting = function() {
      tag.data = JSON.parse(tag.opts.value);
      // console.log(tag.data);
      var ids = [];
      for (var i = 0; i < tag.data.length; i++) {
        var personId = tag.data[i][1];
        // console.log(tag.data, i, personId);
        if ($.isNumeric(personId)) {
          ids.push(personId);
        } else {
          tag.people[personId] = personId;
        }
      }
      fetch(ids);
      tag.update();
    }

    var reorder = function(positions) {
      newData = []
      for (var i = 0; i < positions.length; i++) {
        newData[i] = tag.data[positions[i]];
      }
      tag.data = newData;
    }

    var fetch = function(ids) {
      if (ids.length > 0) {
        $.ajax({
          type: 'GET',
          url: '/people/by_id',
          data: {ids: ids.join(',')},
          success: function(data) {
            for (var i = 0; i < data.length; i++)
              tag.people[data[i].lpid] = data[i].Person;
            tag.update();
          }
        });
      }
    }

    var lookup = function(terms) {
      return $.ajax({
        type: 'GET',
        url: '/autocomplete/people',
        data: {terms: terms}
      });
    }

  </script>
</people-editor>