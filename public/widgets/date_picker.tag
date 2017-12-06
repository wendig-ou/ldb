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

  <script type="text/javascript">
    var tag = this;

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
      })
    });

  </script>
</date-picker>