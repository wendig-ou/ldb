<date-picker>
  <input
    id={opts.dataId}
    class="form-control"
    type="text"
    name={opts.name}
    value={opts.value}
    ref="input"
    placeholder={opts.placeholder}
  />

  <small class="text-danger" if={!valid}>
    This shouldn't be set to a date earlier than the start date
  </small>

  <script type="text/javascript">
    var tag = this;
    tag.valid = true;

    tag.on('mount', function() {
      $(tag.refs.input).datepicker({
        dateFormat: 'dd.mm.yy',
        numberOfMonths: 2,
        stepMonths: 2,
        showOtherMonths: true,
        selectOtherMonths: true,
        showButtonPanel: true,
        changeYear: true,
        changeMonth: true,
        yearRange: 'c-20:+2'
      });

      $(tag.refs.input).on('change', validate);
    });

    var validate = function(event) {
      if (opts.name == 'end_date') {
        var date = $(tag.refs.input).datepicker('getDate');
        var fromDate = $('date-picker[name=edate] input').datepicker('getDate');
        // console.log(fromDate, date);
        tag.valid = (fromDate <= date);
        tag.update();
      }
    }

  </script>
</date-picker>