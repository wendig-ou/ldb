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
        '03.01': 'Scientific keynote, plenary or invited talk (national and international), including moderation and podium discussion.',
        '03.04': 'Contributed or other <strong>scientific</strong> talk, but no posters.',
        '03.06': 'Participation in <strong>non-scientific high-level panels</strong> (e.g. expert panels, invited talks), i.e. in the environmental committee of the Bundestag or state parliaments.',
        '03.07': 'Talk or contribution to a (partially) public transfer event for stakeholders from politics, business, administration or associations such as IGB Lake Dialogues and IGB Academies.',
        '03.08': 'Talk, guided tour or other contribution to a non-scientific, (partly) public event (co-) organised by the Institute such as Meet/Book a Scientist, Girls’ Day, Open Days, Long Night of Science, Long Day of Urban Nature.',
        '04.01': 'Habilitations by IGB scientists are <strong>registered by the habilitated person</strong>. Since supervision in this career stage is more a mentoring than an academic supervision, supervisors are not registered here.',
        '04.02': '<p>Doctoral degrees are counted if candidates have conducted their research at IGB for <strong>at least 6 months with an IGB contract</strong>. An IGB researcher must be the main supervisor for a substantial part of the thesis (1 of 3 publications or equivalent).<br /><i>exception</i>: If candidates conduct their practical research at another location <strong>and do not have an academic supervisor there</strong>. An IGB researcher must be the main supervisor / PI of the entire doctoral research project.</p><p><strong>Not registered are doctoral degrees</strong> for which IGB scientists only formally act as supervisor for university purposes because they are professors or such. Also not sufficient is the mere presence on the reviewing or defence board.</p>',
        '04.03': '<p>Supervisions of Master or Diploma degrees are only registered if the <strong>main supervisor</strong> (development of topic, supervision of most important steps) is an IGB scientist or if the <strong>supervision contribution</strong> by an IGB scientist was so substantial and extensive that the research would have been impossible without this contribution.</p><p>Not registered are academic degrees for which IGB scientists only formally act as supervisor for university purposes because of their status as professors or such. Also not sufficient is the mere function as an examiner.</p>',
        '04.04': '<p>Supervisions of Bachelor degrees are only registered if the <strong>main supervisor</strong> (development of topic, supervision of most important steps) is an IGB scientist or if the <strong>supervision contribution</strong> by an IGB scientist was so substantial and extensive that the research would have been impossible without this contribution.</p><p>Not registered are academic degrees for which IGB scientists only formally act as supervisor for university purposes because of their status as professors or such. Also not sufficient is the mere function as an examiner.</p>',
        '06.01': 'Position as editor-in-chief, co-editor or associate editor in a scientific journal. Not for editorship of a book or journal issue. Not for peer-review.',
        '06.02': 'Position in a <strong>scientific</strong> committee, society or association.',
        '06.03': 'Participation in working groups or committees with stakeholders beyond the scientific community, e.g. on concrete water management issues (no pure scientific committees, no simple memberships in associations).',
        '07.01': '<strong>Scientific</strong> conference or workshop, including session organization.',
        '07.03': '(Co-) Organisation of a non-scientific, (at least partly) public outreach event or workshop.',
        '07.04': '(Co-) Organisation of a (at least partly) public transfer event for stakeholders from politics, business, administration or associations such as IGB Lake Dialogues and IGB Academies.',
        '09.05': 'Given interviews for press, radio and/or television, corporate magazines or podcasts.',
        '09.09': "Self-produced videos or podcasts for the general public, published via the Institute's channels, explaining the own research work or project.",
        '09.10': 'Author contributions to an official IGB Dossier with a target audience outside the scientific community.',
        '09.11': 'Author contributions to an official IGB Fact Sheet with a target audience outside the scientific community.',
        '09.12': 'Author contributions to an official IGB Policy Brief with a target audience outside the scientific community.',
        '09.13': 'Single publication of corporate publishing, i.e. annuals, information brochures, flyers, popular science books, conference proceedings, websites.',
        '09.14': 'Official press releases issued by IGB, addressed to the media and the public in the widest sense.',
        '09.15': 'News articles, that are written by the Institute and publicly available such as short news items and background reports, but no press releases.',
        '09.16': 'Newsletters officially composed and distributed by the Institute, no newsletter contributions for external formats.',
        '10.01': 'Review activities for EU projects.',
        '10.02': 'Verbal or non-formally written advisory services for stakeholders from politics, business, administration, associations, (civil society), i.e. in meetings with members of the Bundestag or federal parliaments, ministers, officials/officers in ministries, but no meetings with non-professionals, citizens or private individuals.',
        '10.03': 'Formally written self-intiated advisory services. These are addressed, for example, to the political sphere (e.g. members of parliament), the administrative sector at EU, federal, Länder or municipal level, or stakeholders from civil society (NGOs). Not to be included are peer reviews of publications and expert opinions on externally funded projects as well as expert opinions on final theses/qualifications (including doctorates). Publications of the official IGB Outlines series (e.g. IGB Policy Brief) are being documented separately by IGB Library.',
        '10.04': 'Formally written commissioned advisory services. These are addressed, for example, to the political sphere (e.g. members of parliament), the administrative sector at EU, federal, Länder or municipal level, or stakeholders from civil society (NGOs). Not to be included are peer reviews of publications and expert opinions on externally funded projects as well as expert opinions on final theses/qualifications (including doctorates).',
        '11.01': 'Award or prize for special achievement in research, transfer or communication.'
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