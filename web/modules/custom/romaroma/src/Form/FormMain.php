<?php

namespace Drupal\romaroma\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Provides a romaroma form.
 */
class FormMain extends FormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'romaroma_form_main';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    // Current year.
    $year = date('Y');
    // Counters for forms and rows.
    $number_of_forms = $form_state->get('number_of_forms');
    $number_of_rows  = $form_state->get('number_of_rows');
    if ($number_of_forms === NULL) {
      $number_of_forms = $form_state->set('number_of_forms', 1);
      $number_of_forms = 1;
    }
    if ($number_of_rows === NULL) {
      $number_of_rows = $form_state->set('number_of_rows', 1);
      $number_of_rows = 1;
    }

    // Building a form.
    // Creating a wrapper.
    $form['table'] = [
      '#type'   => 'fieldset',
      '#prefix' => '<div id="veritas-id-wrapper">',
      '#suffix' => '</div>',
    ];
    // Form generator.
    for ($tables = 0; $tables < $number_of_forms; $tables++) {
      $form['#tree']          = TRUE;
      $form['table'][$tables] = [
        '#type'   => 'table',
        '#header' => [
          'Year',
          'Jan',
          'Feb',
          'Mar',
          'Q1',
          'Apr',
          'May',
          'Jun',
          'Q2',
          'Jul',
          'Aug',
          'Sep',
          'Q3',
          'Oct',
          'Nov',
          'Dec',
          'Q4',
          'YTD',
        ],
      ];
      // Super- dummy rows generator.
      for ($rows = 0; $rows < $number_of_rows; $rows++) {
        //        $input = $form_state->getUserInput();
        //        $trigered_element = $form_state->getTriggeringElement();
        //        $trigered_button = $trigered_element['#value'];
        //        if ($trigered_button == 'Send') {
        //          $counted    = $this->countData($form, $form_state);
        //          $quaterData = $counted['table'][$tables][$rows];
        //        }
        //        else {
        //          $rr = 1;
        //        }
        $form['table'][$tables][$rows]['year'] = [
          '#type'     => 'number',
          '#value'    => $year - $rows,
          '#disabled' => TRUE,
        ];
        $form['table'][$tables][$rows]['1']    = [
          '#type' => 'number',
        ];
        $form['table'][$tables][$rows]['2']    = [
          '#type' => 'number',
        ];
        $form['table'][$tables][$rows]['3']    = [
          '#type' => 'number',
        ];
        $form['table'][$tables][$rows]['q1']   = [
          '#type'     => 'number',
          '#value'    => '777',
          '#disabled' => TRUE,
        ];
        $form['table'][$tables][$rows]['4']    = [
          '#type' => 'number',
        ];
        $form['table'][$tables][$rows]['5']    = [
          '#type' => 'number',
        ];
        $form['table'][$tables][$rows]['6']    = [
          '#type' => 'number',
        ];
        $form['table'][$tables][$rows]['q2']   = [
          '#type'     => 'number',
          '#value'    => '777',
          '#disabled' => TRUE,
        ];
        $form['table'][$tables][$rows]['7']    = [
          '#type' => 'number',
        ];
        $form['table'][$tables][$rows]['8']    = [
          '#type' => 'number',
        ];
        $form['table'][$tables][$rows]['9']    = [
          '#type' => 'number',
        ];
        $form['table'][$tables][$rows]['q3']   = [
          '#type'     => 'number',
          '#value'    => '777',
          '#disabled' => TRUE,
        ];
        $form['table'][$tables][$rows]['10']   = [
          '#type' => 'number',
        ];
        $form['table'][$tables][$rows]['11']   = [
          '#type' => 'number',
        ];
        $form['table'][$tables][$rows]['12']   = [
          '#type' => 'number',
        ];
        $form['table'][$tables][$rows]['q4']   = [
          '#type'     => 'number',
          '#value'    => '777',
          '#disabled' => TRUE,
        ];
        $form['table'][$tables][$rows]['ytd']  = [
          '#type'     => 'number',
          '#disabled' => TRUE,
        ];
      }
    }

    // Buttons.
    // 'Add a row' button.
    $form['actions']['add_row'] = [
      '#type'       => 'submit',
      '#value'      => t('+ Row'),
      '#submit'     => ['::addOneRow'],
      '#attributes' => ['class' => ['btn-transparent']],
      '#ajax'       => [
        'callback' => '::addRowAjax',
        'wrapper'  => 'veritas-id-wrapper',
      ],
    ];
    // 'Add a form' button.
    $form['actions']['add_form'] = [
      '#type'   => 'submit',
      '#value'  => t('+ Form'),
      '#submit' => ['::addOneForm'],
      '#ajax'   => [
        'callback' => '::addFormAjax',
        'wrapper'  => 'veritas-id-wrapper',
      ],
    ];
    // 'Submit' button.
    $form['actions']['submit'] = [
      '#type'  => 'submit',
      '#value' => $this->t('Send'),
    ];

    return $form;
  }

  public function addQuaterOne(array &$form, FormStateInterface $form_state) {
    // Do smt.
  }

  /**
   * Searching the 1st filled element of a row.
   */
  function firstValueFilled($array) {
    foreach ($array as $firstNeedle) {
      if ($firstNeedle) {
        return array_search($firstNeedle, $array);
      }
    }
    return NULL;
  }

  /**
   * Searching the last filled element of a row.
   */
  function lastValueFilled($array) {
    $reversedArray = array_reverse($array);
    foreach ($reversedArray as $lastNeedle) {
      if ($lastNeedle) {
        return array_search($lastNeedle, $reversedArray);
      }
    }
    return NULL;
  }

  /**
   * Filter the array according to the integrity.
   * (Remove all the empty values from the new arr.
   */
  function filterTheArray($filtered) {
    return $filtered !== '';

  }

  /**
   * {@inheritdoc}
   *
   * Basic form validation.
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    // Getting the number of tables and rows.
    $tables = $form_state->get('number_of_forms');
    $rows   = $form_state->get('number_of_rows');
    $keys   = [
      '1',
      '2',
      '3',
      '4',
      '5',
      '6',
      '7',
      '8',
      '9',
      '10',
      '11',
      '12',
    ];
    // Repeating the validation 4 every table.
    $value = $form_state->getUserInput()['table'];
    for ($table_count = 0; $table_count < $tables; $table_count++) {

      // Repeating the validation 4 every row.
      for ($rows_count = 0; $rows_count < $rows; $rows_count++) {
        // Validating the row integrity .
        // Logic: take 1st, take last, check what`s between them - get the length.
        // Logic: Delete all the empty cells, compare length of 2 arr.
        $arrayToFilter    = $value[$table_count][$rows_count];
        $first            = $this->firstValueFilled($arrayToFilter);
        $last             = $this->lastValueFilled($arrayToFilter) + 1;
        $fullArrLength    = 12 - $last - $first + 2;
        $preFilteredArray = array_slice($arrayToFilter, $first - 1, $fullArrLength);
        $filteredArray    = array_filter($preFilteredArray, function ($filtered) {
          return $filtered !== '';
        });
        if (count($preFilteredArray) !== count($filteredArray)) {
          return $form_state->setErrorByName('Tables validation', $this->t(
            'Invalid'));
        }

        // Repeating the validation 4 every cell.
        for ($cell_count = 0; $cell_count < count($keys); $cell_count++) {
          $headerKey              = $keys[$cell_count];
          $firstRowCellToCompare  = $value[0][$rows_count][$headerKey];
          $secondRowCellToCompare = $value[$table_count][$rows_count][$headerKey];

          // One-line multi-table validation.
          if ($tables != 1) {
            if ($firstRowCellToCompare == '' && $secondRowCellToCompare == '') {
              $correct = TRUE;
            }
            elseif ($firstRowCellToCompare != '' && $secondRowCellToCompare != '') {
              $correct = TRUE;
            }
            else {
              $form_state->setErrorByName('Tables validation', $this->t(
                'Invalid'));
            }
          }
        }
      }
    }
  }

  /**
   * AJAX adding a row.
   */
  public function addRowAjax(array &$form, FormStateInterface $form_state) {
    $form = $form_state->getCompleteForm();
    return $form['table'];
  }

  /**
   * AJAX adding a form.
   */
  public function addFormAjax(array &$form, FormStateInterface $form_state) {
    $form = $form_state->getCompleteForm();
    return $form['table'];
  }

  /**
   * Increment the number of rows.
   */
  public function addOneRow(array &$form, FormStateInterface $form_state) {
    $number_of_rows = $form_state->get('number_of_rows');
    $add_button1    = $number_of_rows + 1;
    $form_state->set('number_of_rows', $add_button1);
    $form_state->setRebuild();
  }

  /**
   * Increment the number of forms.
   */
  public function addOneForm(array &$form, FormStateInterface $form_state) {
    $number_of_forms = $form_state->get('number_of_forms');
    $add_button2     = $number_of_forms + 1;
    $form_state->set('number_of_forms', $add_button2);
    $form_state->setRebuild();
  }

  /**
   * Submit event.
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $this->messenger()->addStatus($this->t('The message has been sent.'));
    $form_state->setRedirect('romaroma.form_main');
  }

}
