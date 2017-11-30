<html>
  <head>
    <link rel="shortcut icon" href="<?= getenv('LDB_FAVICON_URL') ?>" />

    <title>LDB – <?= ucfirst($title) ?></title>

    <link rel="stylesheet" type="text/css" href="/jquery-ui.min.css">
    <link rel="stylesheet" type="text/css" href="/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="/app.css">

    <script type="text/javascript" src="/jquery.min.js"></script>
    <script type="text/javascript" src="/jquery-ui.min.js"></script>
    <script type="text/javascript" src="/bootstrap.min.js"></script>
    <script type="text/javascript" src="/riot+compiler.min.js"></script>

    <script type="riot/tag" data-src="/widgets/igb.tag"></script>
    <script type="riot/tag" data-src="/widgets/confirm_anchor.tag"></script>
    <script type="riot/tag" data-src="/widgets/pagination.tag"></script>
    <script type="riot/tag" data-src="/widgets/date_picker.tag"></script>
    <script type="riot/tag" data-src="/widgets/back_button.tag"></script>
    <script type="riot/tag" data-src="/widgets/autocomplete.tag"></script>
    <script type="riot/tag" data-src="/widgets/people_editor.tag"></script>
    <script type="riot/tag" data-src="/widgets/periodical_selector.tag"></script>
    <script type="riot/tag" data-src="/widgets/institution_selector.tag"></script>
    <script type="riot/tag" data-src="/widgets/type_notifier.tag"></script>
    <script type="riot/tag" data-src="/widgets/if_type.tag"></script>
    <script type="riot/tag" data-src="/widgets/end_year.tag"></script>
    <script type="riot/tag" data-src="/widgets/departments_selector.tag"></script>
    <script type="riot/tag" data-src="/widgets/panel_clicker.tag"></script>
    <script type="riot/tag" data-src="/widgets/file_select_feedback.tag"></script>

    <script type="text/javascript">
      var translations = <?= json_encode($translations) ?>;
    </script>

    <script type="text/javascript">
      $(document).ready(function(event){
        riot.mount('*');
      });
    </script>
  </head>
  <body>
    <igb></igb>
    <?php $this->load->view('templates/navbar'); ?>

    <div class="container">
      <div class="row hidden-print">
        <div class="col-md-6 col-md-offset-3">
          <?php $this->load->view('templates/flash'); ?>
        </div>
      </div>