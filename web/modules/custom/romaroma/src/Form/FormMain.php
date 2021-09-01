<?php

namespace Drupal\romaroma\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Provides a romaroma form.
 */
class FormMain extends FormBase {

  /**
   * Getting the form ID.
   *
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'romaroma_form_main';
  }

  /**
   * Building the form rows.
   *
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

    // 'Add a row' & 'Add a form' & 'submit' buttons.
    $form['actions']['add_row']     = [
      '#type'       => 'submit',
      '#value'      => t('+ Row'),
      '#submit'     => ['::addOneRow'],
      '#attributes' => ['class' => ['btn-transparent']],
      '#ajax'       => [
        'callback' => '::addElementAjax',
        'wrapper'  => 'veritas-id-wrapper',
      ],
    ];
    $form['actions']['add_form']    = [
      '#type'   => 'submit',
      '#value'  => t('+ Form'),
      '#submit' => ['::addOneForm'],
      '#ajax'   => [
        'callback' => '::addElementAjax',
        'wrapper'  => 'veritas-id-wrapper',
      ],
    ];
    $form['actions']['submit']      = [
      '#name'  => 'Send',
      '#type'  => 'submit',
      '#value' => $this->t('Send'),
      '#ajax'  => [
        'callback' => '::addElementAjax',
        'wrapper'  => 'veritas-id-wrapper',
      ],
    ];
    $form['#attached']['library'][] = 'romaroma/romaroma-style';

    return $form;
  }

  /**
   * Function 2 search the 1st filled element of a row.
   */
  public function firstValueFilled($array) {
    foreach ($array as $firstNeedle) {
      if ($firstNeedle) {
        return array_search($firstNeedle, $array);
      }
    }
    return NULL;
  }

  /**
   * Function 2 search the last filled element of a row.
   */
  public function lastValueFilled($array) {
    $reversedArray = array_reverse($array);
    foreach ($reversedArray as $lastNeedle) {
      if ($lastNeedle) {
        return array_search($lastNeedle, $reversedArray);
      }
    }
    return NULL;
  }

  /**
   * Basic form validation.
   *
   * {@inheritdoc}
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

          // Validating the year`s and month`s integrity.
          // Logic: We merge all the cells (in context of 1 table) into 1 array
          // Segment from 1st to last filled value - 1st array 2 compare.
          // Delete all unfilled cells from this segment - 2nd array 2 compare.
          // Check if the number of 1st arr elements === 2nd arr elements.
          // If so- there`s no empty cells. Otherwise - error. Easy - peasy.
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
        $enteredDataLength       = count($enteredData);
        $enteredDataDataSegment  = $enteredDataLength - $enteredDataLastFilled
          - $enteredDataFirstFilled;
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
   * AJAX adding a row - table.
   */
  public function addElementAjax(array &$form, FormStateInterface $form_state) {
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
    $add_button      = $number_of_forms + 1;
    $form_state->set('number_of_forms', $add_button);
    $form_state->setRebuild();
  }

  /**
   * Submit event.
   *
   * {@inheritDoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $this->messenger()->addStatus($this->t('The message has been sent.'));

    // Putting the quater values.
    // Logic: We split every row (year) into 4 separate parts (3 items each)- it
    // will correspond every separate quater. Then we count the sum of every
    // part- save this value into the variable. After we`ll get 4 sums we`ll
    // need to find the sum of them and put it as the year value. Easy-peasy.
    $value       = $form_state->getUserInput()['table'];
    $quarterName = ['q1', 'q2', 'q3', 'q4'];

    // Getting the separate arrays (each is 3 items length) from the row(year).
    $chunkedArray = [];
    $quarterTotal = [];
    $yearTotal    = [];
    foreach ($value as $key => $table) {
      foreach ($table as $row) {
        $chunkedArray[$key][] = array_chunk($row, 3);
      }
    }

    // Checking whether entered chunks aren`t empty.
    // Putting the sum of every chunked arr into it`s separate variable.
    foreach ($chunkedArray as $key => $table) {
      foreach ($table as $yearKey => $year) {
        foreach ($year as $quarterKey => $quarter) {
          if (array_sum($quarter) !== 0) {
            $quarterTotal[$key][$yearKey][$quarterKey] = round((array_sum($quarter) + 1) / 3, 2);
          }
        }
      }
    }

    // Filling the quarters cells with the data from quarter total var.
    foreach ($quarterTotal as $key => $table) {
      foreach ($table as $yearKey => $row) {
        foreach ($row as $quarterKey => $quarter) {
          if ($quarter !== '') {
            $form['table'][$key][$yearKey][$quarterName[$quarterKey]]['#value'] = $quarter;
          }
        }
      }
    }

    // Checking whether counted quarters values aren`t empty.
    // Putting the sum of all the quarters into separate variable.
    foreach ($quarterTotal as $key => $table) {
      foreach ($table as $yearKey => $row) {
        if (array_sum($row) !== 0) {
          $yearTotal[$key][$yearKey] = round((array_sum($row) + 1) / 4, 2);
        }
      }
    }

    // Filling the year cell with the data from year total var.
    foreach ($yearTotal as $key => $table) {
      foreach ($table as $yearKey => $row) {
        if ($row !== 0) {
          $form['table'][$key][$yearKey]['ytd']['#value'] = $row;
        }
      }
    }

    return $form;
  }

}
