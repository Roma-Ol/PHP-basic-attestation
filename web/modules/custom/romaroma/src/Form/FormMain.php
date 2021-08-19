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
    // Number of rows.
    $number_of_tags = $form_state->get('number_of_tags');
    $zz             = 0;

    for ($i = 1; $i <= 4; $i++) {
      $zz++;
    }

    $form['table'] = [
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

    for ($i = 1; $i <= $number_of_tags - 1; $i++) {
      $form['table'][$i]['year'] = [
        '#type'  => 'number',
        '#value' => $year - $i,
      ];
      $form['table'][$i]['jan']  = [
        '#type' => 'number',
      ];
      $form['table'][$i]['feb']  = [
        '#type' => 'number',
      ];
    }

    // Add a row button.
    $form['addRow'] = [
      '#type'   => 'submit',
      '#value'  => t('+ Row'),
      '#submit' => ['::addOneTag'],
    ];
    // Add form button.
    $form['addForm'] = [
      '#type'       => 'submit',
      '#value'      => t('+ Form'),
      '#submit'     => ['::addOneTag'],
      '#attributes' => ["onclick" => "javascript: this.disabled = true;"],
    ];
    // Add a submit button that handles the submission of the form.
    $form['actions']['submit'] = [
      '#type'       => 'submit',
      '#value'      => $this->t('Send'),
      '#attributes' => ["onclick" => "javascript: this.disabled = true;"],
    ];

    if (empty($number_of_tags)) {
      $number_of_tags = 1;
      $form_state->set('number_of_tags', $number_of_tags);
    }

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    // Do validation.
  }

  /**
   * Increment number of rows.
   */
  public function addOneTag(array &$form, FormStateInterface $form_state) {
    $number_of_tags = $form_state->get('number_of_tags');
    $form_state->set('number_of_tags', $number_of_tags + 1);
    $form_state->setRebuild(TRUE);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $this->messenger()->addStatus($this->t('The message has been sent.'));
    $form_state->setRedirect('romaroma.form_main');
  }

}
