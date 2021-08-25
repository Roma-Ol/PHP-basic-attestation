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
    // Counters for forms and lines.
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

    $form['table'] = [
      '#type' => 'fieldset',
      '#prefix' => '<div id="veritas-id-wrapper">',
      '#suffix' => '</div>',
    ];

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
        '#prefix' => '<div id="veritas-id-wrapper">',
        '#suffix' => '</div>',
      ];

      for ($rows = 0; $rows < $number_of_rows; $rows++) {
        $form['table'][$tables][$rows]['year'] = [
          '#type'     => 'number',
          '#value'    => $year - $rows,
          '#disabled' => TRUE,
        ];
        for ($cells = 1; $cells <= 17; $cells++) {
          $form['table'][$tables][$rows][$cells] = [
            '#type' => 'number',
          ];
        }
      }
    }

    // Add a row button.
    $form['actions']['add_row'] = [
      '#type'       => 'submit',
      '#value'      => t('+ Row'),
      '#submit'     => ['::addOneRow'],
      '#attributes' => ['class' => ['btn-transparent']],
      '#ajax'       => [
        'callback' => '::addRowAJAX',
        'wrapper'  => 'veritas-id-wrapper',
      ],
    ];
    // Add form button.
    $form['actions']['add_form'] = [
      '#type'   => 'submit',
      '#value'  => t('+ Form'),
      '#submit' => ['::addOneForm'],
      '#ajax'   => [
        'callback' => '::addFormAJAX',
        'wrapper'  => 'veritas-id-wrapper',
      ],
    ];
    // Add a submit button that handles the submission of the form.
    $form['actions']['submit'] = [
      '#type'  => 'submit',
      '#value' => $this->t('Send'),
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    // Do validation.
  }

  /**
   * AJAX adding a field.
   */
  public function addRowAJAX(array &$form, FormStateInterface $form_state) {
    $form = $form_state->getCompleteForm();
    return $form['table'];
  }

  public function addFormAJAX(array &$form, FormStateInterface $form_state) {
    $form = $form_state->getCompleteForm();
    return $form['table'];
  }

  /**
   * Increment number of rows.
   */
  public function addOneRow(array &$form, FormStateInterface $form_state) {
    $number_of_rows = $form_state->get('number_of_rows');
    $add_button1 = $number_of_rows +1;
    $form_state->set('number_of_rows', $add_button1);
    $form_state->setRebuild();
  }

  /**
   * Increment number of tables.
   */
  public function addOneForm(array &$form, FormStateInterface $form_state) {
    $number_of_forms = $form_state->get('number_of_forms');
    $add_button2 = $number_of_forms +1;
    $form_state->set('number_of_forms', $add_button2);
    $form_state->setRebuild();
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $this->messenger()->addStatus($this->t('The message has been sent.'));
    $form_state->setRedirect('romaroma.form_main');
  }

}