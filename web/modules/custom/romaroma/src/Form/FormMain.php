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
    $form['actions']['submit']      = [
      '#name'  => 'Send',
      '#type'  => 'submit',
      '#value' => $this->t('Send'),
      '#ajax'  => [
        'callback' => '::addFormAjax',
        'wrapper'  => 'veritas-id-wrapper',
      ],
    ];
    $form['#attached']['library'][] = 'romaroma/romaroma-style';


    return $form;
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
   * {@inheritdoc}
   *
   * Basic form validation.
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    // Ensuring that the triggering element is real 'submit' button.
    $triggeredElement = $form_state->getTriggeringElement()['#name'];
    if ($triggeredElement === 'Send') {

      // Getting the number of tables, rows and entered data.
      $tables = $form_state->get('number_of_forms');
      $rows   = $form_state->get('number_of_rows');
      $keys   = ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12'];
      $value  = $form_state->getUserInput()['table'];

      // Repeating 4 every table.
      for ($table_count = 0; $table_count < 1; $table_count++) {
        // Repeating 4 every row.
        for ($rows_count = 0; $rows_count < $rows; $rows_count++) {
          // Validating the year`s integrity.
          // Logic: We merge all the cells (in context of one table into 1 array
          // 1st and last filled value - 1st array 2 compare.
          // Delete all unfilled cells - 2nd array 2 compare.
          // Check if the number of 1st arr elements === 2nd arr elements.
          // If so- there`s no empty cells. Otherwise - error.
          foreach ($value[$table_count][$rows_count] as $seperateValue) {
            $enteredData[] = $seperateValue;
          }
          // Getting the cells values.
          for ($cell_count = 0; $cell_count < count($keys); $cell_count++) {
            // Multi-table validation.
            if ($tables > 1) {
              $headerKey              = $keys[$cell_count];
              $firstRowCellToCompare  = $value[0][$rows_count][$headerKey];
              $secondRowCellToCompare = $value[$table_count + 1][$rows_count][$headerKey];
              if ($firstRowCellToCompare == '' && $secondRowCellToCompare != ''
                || $firstRowCellToCompare != '' && $secondRowCellToCompare == '') {
                return $form_state->setErrorByName('Tables validation', $this->t(
                  'Invalid'));
              }
            }
          }
        }
        $enteredDataFirstFilled  = $this->firstValueFilled($enteredData);
        $enteredDataLastFilled   = $this->lastValueFilled($enteredData);
        $enteredDataLength       = count($enteredData) - 1;
        $enteredDataDataSegment  = $enteredDataLength - $enteredDataLastFilled
          - $enteredDataFirstFilled + 1;
        $enteredDataPreFiltered  = array_slice($enteredData,
          $enteredDataFirstFilled, $enteredDataDataSegment);
        $enteredDataDataFiltered = array_filter($enteredDataPreFiltered);
        if (count($enteredDataPreFiltered) !== count($enteredDataDataFiltered)) {
          return $form_state->setErrorByName('Tables validation', $this->t(
            'Invalid'));
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

    // Putting the quater values.
    // Getting the number of tables, rows and entered data.
    $tables     = $form_state->get('number_of_forms');
    $rows       = $form_state->get('number_of_rows');
    $value      = $form_state->getUserInput()['table'];
    $quaterName = ['q1', 'q2', 'q3', 'q4'];

    foreach ($value as $key => $tables) {
      foreach ($tables as $years) {
        $chunkedArray[$key][] = array_chunk($years, 3);
      }
    }

    foreach ($chunkedArray as $key => $tables) {
      foreach ($tables as $yearKey => $years) {
        foreach ($years as $quarterKey => $quarter) {
          array_sum($quarter) == 0 ?
            $quarterSumArray[$key][$yearKey][$quarterKey] = array_sum($quarter) :
            $quarterSumArray[$key][$yearKey][$quarterKey] = round((array_sum($quarter) + 1) / 3, 2);
        }
      }
    }

    foreach ($quarterSumArray as $key => $tables) {
      foreach ($tables as $yearKey => $years) {
        foreach ($years as $quarterKey => $quarter) {
          $quarter != 0 ? $form['table'][$key][$yearKey][$quaterName[$quarterKey]]['#value'] = $quarter :
            $form['table'][$key][$yearKey][$quaterName[$quarterKey]]['#value'] = "";
        }
      }
    }

    foreach ($quarterSumArray as $key => $tables) {
      foreach ($tables as $yearKey => $years) {
        array_sum($years) == 0 ?
          $yearSumArray[$key][$yearKey] = array_sum($years) :
          $yearSumArray[$key][$yearKey] = round((array_sum($years) + 1) / 4, 2);
      }
    }

    foreach ($yearSumArray as $key => $tables) {
      foreach ($tables as $yearKey => $years) {
        $years != 0 ? $form['table'][$key][$yearKey]['ytd']['#value'] = $years :
          $form['table'][$key][$yearKey]['ytd']['#value'] = "";
      }
    }

    return $form;
  }

}
