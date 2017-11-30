<div class="row">
  <div class="col-md-6 col-md-offset-3">
    <form
      action="/people/<?= (isset($id) ? 'edit/'.$id : 'new') ?>"
      method="POST"
    >
      <h1>
        <?php if (isset($id))
          echo ucfirst(sprintf(lang('igb_edit'), $id));
        else
          echo ucfirst(sprintf(lang('igb_create_new'), lang('igb_person')));
        ?>
      </h1>

      <?= validation_errors() ?>

      <?php if (isset($id)): ?>
        <input type="hidden" name="id" value="<?= $id ?>">
        <input type="hidden" name="return_to" value="<?= set_value('return_to', $referrer) ?>" />
      <?php endif; ?>

      <?= text_field('Person', [
        'label' => 'igb_field_name',
        'value' => $person['Person'],
        'autofocus' => TRUE,
        'required' => TRUE
      ]); ?>

      <?= text_field('reference_1', [
        'label' => 'igb_field_reference_1',
        'value' => $person['Verweisung1'],
      ]); ?>

      <?= text_field('reference_1', [
        'label' => 'igb_field_reference_2',
        'value' => $person['Verweisung2'],
      ]); ?>

      <?= text_field('reference_1', [
        'label' => 'igb_field_reference_3',
        'value' => $person['Verweisung3'],
      ]); ?>

      <?= text_field('reference_1', [
        'label' => 'igb_field_reference_4',
        'value' => $person['Verweisung4'],
      ]); ?>

      <?= text_field('reference_1', [
        'label' => 'igb_field_reference_5',
        'value' => $person['Verweisung5'],
      ]); ?>

      <?= text_field('reference_1', [
        'label' => 'igb_field_reference_6',
        'value' => $person['Verweisung6'],
      ]); ?>

      <?= text_field('reference_1', [
        'label' => 'igb_field_reference_7',
        'value' => $person['Verweisung7'],
      ]); ?>
      
      <hr />

      <div class="pull-right">
        <input
          class="btn btn-primary"
          type="submit"
          value="<?= lang('igb_save') ?>"
        />
      </div>
    </form>
  </div>
</div>
