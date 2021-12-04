<?php
  if (!function_exists('human_date')) {
    function human_date($date)
    {
      if (!$date) {return '';}
      $result = strftime('%d.%m.%Y', strtotime($date));
      return ($result == '01.01.1970' ? $date : $result);
    }
  }

  if (!function_exists('to_year')) {
    function to_year($date)
    {
      if (!$date) {return '';}
      $date = preg_replace('/0000$/', '0101', $date);
      $date = preg_replace('/^[0-9]{4}$/', '${0}0101', $date);
      return strftime('%Y', strtotime($date));
    }
  }

  if (!function_exists('to_year_range')) {
    function to_year_range($from, $to)
    {
      $from = to_year($from);
      if ($to == '-') {
        return $from.' ongoing';
      } else {
        if ($from && $to) {
          return substr($from, 0, 4) == substr($to, 0, 4) ? $from : $from.'-'.$to;
        } else {
          return $from ?? $to;
        }
      }
    }
  }

  if (!function_exists('human_bool')) {
    function human_bool($value)
    {
      $true = array(TRUE, 1, '+', 'yes', 'on', 'x');
      if (in_array($value, $true)) {
        return lang('igb_yes');
      } else {
        return lang('igb_no');
      }
    }
  }

  if (!function_exists('author_list')) {
    function author_list($str)
    {
      return implode('; ',  preg_split('/\s*;\s*/', $str));
    }
  }

  if (!function_exists('people_list')) {
    function people_list($people) {
      $result = [];
      foreach ($people as $person) {
        if ($person['igb']) {
          $result[] = '<strong>'.$person['Person'].'</strong>';
        } else {
          $result[] = $person['Person'];
        }
      }
      return implode('; ', $result);
    }
  }

  if (!function_exists('human_person_references')) {
    function human_person_references($person)
    {
      $refs = array(
        $person['Verweisung1'],
        $person['Verweisung2'],
        $person['Verweisung3'],
        $person['Verweisung4'],
        $person['Verweisung5'],
        $person['Verweisung6'],
        $person['Verweisung7']
      );

      $refs = array_filter($refs);
      return implode('; ', $refs);
    }
  }

  if (!function_exists('people_role_for_super_type')) {
    function people_role_for_super_type($super_type)
    {
      switch ($super_type) {
        case 'presentation':
          return lang('igb_field_presenters');
        case 'organisation of conference or workshop':
          return lang('igb_field_organizers');
        default:
          return lang('igb_field_people');
      }
    }
  }

  if (!function_exists('text_field')) {
    function text_field($name, $options = [])
    {
      $defaults = [
        'name' => $name,
        'type' => 'text',
        'label' => FALSE,
        'help' => FALSE,
        'required' => FALSE,
        'value' => FALSE,
        'autofocus' => FALSE,
        'disabled' => FALSE
      ];
      $options = array_merge($defaults, $options);

      if ($k = $options['label']) {$options['label'] = lang($k);}
      if ($k = $options['help']) {$options['help'] = lang($k);}

      return get_instance()->load->view('partials/text_field', $options, TRUE);
    }
  }

  if (!function_exists('file_field')) {
    function file_field($name, $options = [])
    {
      $defaults = [
        'name' => $name,
        'label' => FALSE,
        'required' => FALSE,
        'autofocus' => FALSE
      ];
      $options = array_merge($defaults, $options);

      if ($k = $options['label']) {$options['label'] = lang($k);}

      return get_instance()->load->view('partials/file_field', $options, TRUE);
    }
  }

  if (!function_exists('check_box')) {
    function check_box($name, $options = [])
    {
      $defaults = [
        'name' => $name,
        'label' => FALSE,
        'help' => FALSE,
        'value' => FALSE,
        'disabled' => FALSE
      ];
      $options = array_merge($defaults, $options);

      if ($k = $options['label']) {$options['label'] = lang($k);}
      if ($k = $options['help']) {$options['help'] = lang($k);}

      return get_instance()->load->view('partials/check_box', $options, TRUE);
    }
  }

  if (!function_exists('text_area')) {
    function text_area($name, $options = [])
    {
      $defaults = [
        'name' => $name,
        'label' => FALSE,
        'help' => FALSE,
        'required' => FALSE,
        'value' => FALSE,
        'autofocus' => FALSE,
        'disabled' => FALSE
      ];
      $options = array_merge($defaults, $options);

      if ($k = $options['label']) {$options['label'] = lang($k);}
      if ($k = $options['help']) {$options['help'] = lang($k);}

      return get_instance()->load->view('partials/text_area', $options, TRUE);
    }
  }

  if (!function_exists('department_selector')) {
    function department_selector($name, $options = [])
    {
      $defaults = [
        'name' => $name,
        'label' => FALSE,
        'help' => FALSE,
        'required' => FALSE,
        'value' => FALSE,
        'departments' => get_instance()->departments(),
        'autofocus' => FALSE
      ];
      $options = array_merge($defaults, $options);

      if ($k = $options['label']) {$options['label'] = lang($k);}
      if ($k = $options['help']) {$options['help'] = lang($k);}

      return get_instance()->load->view('partials/department_selector', $options, TRUE);
    }
  }

  if (!function_exists('date_field')) {
    function date_field($name, $options = [])
    {
      $defaults = [
        'name' => $name,
        'label' => FALSE,
        'help' => FALSE,
        'required' => FALSE,
        'value' => FALSE,
        'autofocus' => FALSE
      ];
      $options = array_merge($defaults, $options);

      if ($k = $options['label']) {$options['label'] = lang($k);}
      if ($k = $options['help']) {$options['help'] = lang($k);}

      return get_instance()->load->view('partials/date_field', $options, TRUE);
    }
  }

  if (!function_exists('type_selector')) {
    function type_selector($name, $options = [])
    {
      $defaults = [
        'name' => $name,
        'label' => lang('igb_field_klr_tow'),
        'help' => FALSE,
        'value' => FALSE,
        'super_type_id' => FALSE,
        'autofocus' => FALSE,
        'required' => TRUE,
        'variant' => 'select'
      ];
      $options = array_merge($defaults, $options);

      if ($id = $options['super_type_id']) {
        $options['types'] = get_instance()->types_model->by_super_type_id($id);
      }
      if ($k = $options['help']) {$options['help'] = lang($k);}

      if ($options['variant'] == 'select') {
        return get_instance()->load->view('partials/type_selector_select', $options, TRUE);
      } else {
        return get_instance()->load->view('partials/type_selector_radios', $options, TRUE);
      }
    }
  }

  if (!function_exists('sortable_column')) {
    function sortable_column($name, $options) {
      $defaults = [
        'label' => lang('igb_field_'.$name),
        'default_direction' => 'asc'
      ];
      $options = array_merge($defaults, $options);

      $c = get_instance();

      if ($k = $options['label']) {$options['label'] = lang($k);}

      $params = $c->input->get();
      if ($c->input->get('sort-column') != $name) {
        $params['sort-column'] = $name;
        $params['sort-direction'] = $options['default_direction'];
        $options['current_direction'] = '';
      } else {
        $invert_map = ['asc' => 'desc', 'desc' => 'asc'];
        $current_direction = $c->input->get('sort-direction');
        $params['sort-direction'] = $invert_map[$current_direction];
        $options['current_direction'] = $current_direction;
      }

      $options['url'] = '?'.http_build_query($params);

      return $c->load->view('partials/sortable_column', $options, TRUE);
    }
  }

  if (!function_exists('semester_selector')) {
    function semester_selector($name, $options = [])
    {
      $defaults = [
        'name' => $name,
        'label' => lang('igb_field_semester'),
        'value' => FALSE,
      ];
      $options = array_merge($defaults, $options);

      $options['semesters'] = [];
      foreach (range(date('Y') + 1, 2010) as $year) {
        array_push($options['semesters'], 'WS '.$year.'/'.($year+1-2000));
        array_push($options['semesters'], 'SS '.$year);
      }

      return get_instance()->load->view('partials/semester_selector', $options, TRUE);
    }
  }

  if (!function_exists('has_role')) {
    function has_role($roles = ['admin'])
    {
      return get_instance()->has_role($roles);
    }
  }

  if (!function_exists('can_edit')) {
    function can_edit($user, $publication)
    {
      return get_instance()->can_edit($user, $publication);
    }
  }

  if (!function_exists('can_delete')) {
    function can_delete($user, $publication)
    {
      return get_instance()->can_delete($user, $publication);
    }
  }

  if (!function_exists('can_verify')) {
    function can_verify($user, $publication)
    {
      return get_instance()->can_verify($user, $publication);
    }
  }

  if (!function_exists('filters_for_print')) {
    function filters_for_print($criteria)
    {
      $results = [];
      foreach ($criteria as $key => $value) {
        if ($value) {
          array_push($results, $value);
        }
      }

      return implode(', ', $results);
    }
  }

  if (!function_exists('dimension_badge')) {
    function dimension_badge($doi, $options = []) {
      $defaults = [
        'style' => 'small_circle',
        'doi' => $doi,
        'data_legend' => 'never'
      ];
      $options = array_merge($defaults, $options);

      if ($doi) {
        return get_instance()->load->view('partials/dimension_badge', $options, TRUE);
      }
    }
  }

  if (!function_exists('altmetric_badge')) {
    function altmetric_badge($doi, $options = []) {
      $defaults = [
        'doi' => $doi
      ];
      $options = array_merge($defaults, $options);

      if ($doi) {
        return get_instance()->load->view('partials/altmetric_badge', $options, TRUE);
      }
    }
  }

?>