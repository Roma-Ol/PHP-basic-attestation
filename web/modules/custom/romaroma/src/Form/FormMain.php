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
        $form['table'][$tables][$rows]['jan']  = [
          '#type' => 'number',
        ];
        $form['table'][$tables][$rows]['feb']  = [
          '#type' => 'number',
        ];
        $form['table'][$tables][$rows]['mar']  = [
          '#type' => 'number',
        ];
        $form['table'][$tables][$rows]['q1']   = [
          '#type'     => 'number',
          '#value'    => '777',
          '#disabled' => TRUE,
        ];
        $form['table'][$tables][$rows]['apr']  = [
          '#type' => 'number',
        ];
        $form['table'][$tables][$rows]['may']  = [
          '#type' => 'number',
        ];
        $form['table'][$tables][$rows]['jun']  = [
          '#type' => 'number',
        ];
        $form['table'][$tables][$rows]['q2']   = [
          '#type'     => 'number',
          '#value'    => '777',
          '#disabled' => TRUE,
        ];
        $form['table'][$tables][$rows]['jul']  = [
          '#type' => 'number',
        ];
        $form['table'][$tables][$rows]['aug']  = [
          '#type' => 'number',
        ];
        $form['table'][$tables][$rows]['sep']  = [
          '#type' => 'number',
        ];
        $form['table'][$tables][$rows]['q3']   = [
          '#type'     => 'number',
          '#value'    => '777',
          '#disabled' => TRUE,
        ];
        $form['table'][$tables][$rows]['oct']  = [
          '#type' => 'number',
        ];
        $form['table'][$tables][$rows]['nov']  = [
          '#type' => 'number',
        ];
        $form['table'][$tables][$rows]['dec']  = [
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

  /**
   * {@inheritdoc}
   *
   * Basic form validation.
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    // Getting the number of tables and rows.
    $tables = $form_state->get('number_of_forms');
    $rows   = $form_state->get('number_of_rows');
    // Repeating the validation 4 every table.
    for ($table_count = 0; $table_count < $tables; $table_count++) {
      // Repeating the validation 4 every row.
      for ($rows_count = 0; $rows_count < $rows; $rows_count++) {
        $value    = $form_state->getValues();
        $valueJan = $value['table'][$table_count][$rows_count]['jan'];
        $valueFeb = $value['table'][$table_count][$rows_count]['feb'];
        $valueMar = $value['table'][$table_count][$rows_count]['mar'];
        $valueApr = $value['table'][$table_count][$rows_count]['apr'];
        $valueMay = $value['table'][$table_count][$rows_count]['may'];
        $valueJun = $value['table'][$table_count][$rows_count]['jun'];
        $valueJul = $value['table'][$table_count][$rows_count]['jul'];
        $valueAug = $value['table'][$table_count][$rows_count]['aug'];
        $valueSep = $value['table'][$table_count][$rows_count]['sep'];
        $valueOct = $value['table'][$table_count][$rows_count]['oct'];
        $valueNov = $value['table'][$table_count][$rows_count]['nov'];
        $valueDec = $value['table'][$table_count][$rows_count]['dec'];
        $status1  = 1;
        $status2  = 2;
        $status3  = 3;

        if ($rows === 1) {
          // One-str validation.
          if (!empty($valueJan) && !empty($valueFeb) && !empty($valueMar)) {
            $status1 = 3;
          }
        }
        else {
          // Multi-str validation..
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
