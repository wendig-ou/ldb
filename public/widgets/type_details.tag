<type-details>
  <div
    if={active()}
    class="alert alert-info"
  >
    <strong>Heads up!</strong><br /><br />
    <div ref="text"></div>
  </div>

  <script type="text/javascript">
    var tag = this;

    tag.on('mount', function() {
      window.igb.bus.on('type-selected', handler);
      handler();
    });

    tag.on('updated', function() {
      $(tag.refs.text).html(tag.text());
    })

    tag.active = function() {
      return anySelected() && tag.text() != undefined;
    }

    tag.text = function() {
      return {
        '04.01': 'Habilitations by IGB scientists are <strong>registered by the habilitated person</strong>. Since supervision in this career stage is more a mentoring than an academic supervision, supervisors are not registered here.',
        '04.02': '<p>Doctoral degrees are counted if candidates have conducted their research at IGB for <strong>at least 6 months with an IGB contract</strong>. An IGB researcher must be the main supervisor for a substantial part of the thesis (1 of 3 publications or equivalent).<br /><i>exception</i>: If candidates conduct their practical research at another location <strong>and do not have an academic supervisor there</strong>. An IGB researcher must be the main supervisor / PI of the entire doctoral research project.</p><p><strong>Not registered are doctoral degrees</strong> for which IGB scientists only formally act as supervisor for university purposes because they are professors or such. Also not sufficient is the mere presence on the reviewing or defence board.</p>',
        '04.03': '<p>Supervisions of Master or Diploma degrees are only registered if the <strong>main supervisor</strong> (development of topic, supervision of most important steps) is an IGB scientist or if the <strong>supervision contribution</strong> by an IGB scientist was so substantial and extensive that the research would have been impossible without this contribution.</p><p>Not registered are academic degrees for which IGB scientists only formally act as supervisor for university purposes because of their status as professors or such. Also not sufficient is the mere function as an examiner.</p>',
        '04.04': '<p>Supervisions of Bachelor degrees are only registered if the <strong>main supervisor</strong> (development of topic, supervision of most important steps) is an IGB scientist or if the <strong>supervision contribution</strong> by an IGB scientist was so substantial and extensive that the research would have been impossible without this contribution.</p><p>Not registered are academic degrees for which IGB scientists only formally act as supervisor for university purposes because of their status as professors or such. Also not sufficient is the mere function as an examiner.</p>'
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