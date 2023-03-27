<?php

namespace Drupal\swiper_cards\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\node\Entity\Node;
use Drupal\file\Entity\File;

/**
 * Provides the Swiper Cards.
 *
 * @Block(
 *   id="swiper_cards",
 *   admin_label = @Translation("Swiper Cards"),
 * )
 */
class SwiperCardsBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function defaultConfiguration() {
    return parent::defaultConfiguration() + [
      'swiper_cards' => [],
    ];
  }

  /**
   * Overrides \Drupal\Core\Block\BlockBase::blockForm().
   *
   * Adds body and description fields to the block configuration form.
   */
  public function blockForm($form, FormStateInterface $form_state) {
    $form = parent::blockForm($form, $form_state);
    $config = $this->getConfiguration();

    $items = [];
    if (isset($config['swiper_cards_data'])) {
      $items = $config['swiper_cards_data'];
      if($items != '') {
        $items = json_decode($items);
      }
    }

    $form['swiper_card_header'] = array(
      '#type' => 'text_format',
      '#title' => $this->t('Swiper cards header content'),
      '#description' => $this->t('Swiper cards header content'),
      '#default_value' => $config['swiper_card_header']??'',
      '#format' => $config['swiper_card_header_format']??'basic_html',
    );

    $form['swiper_card_layout'] = array(
      '#type' => 'select',
      '#title' => $this->t('Swiper Cards Display Layout'),
      '#options' => array(
        'layout_1' => $this->t('Layout 1'),
        'layout_2' => $this->t('Layout 2'),
        'layout_3' => $this->t('Layout 3'),
        'layout_4' => $this->t('Layout 4'),
      ),
      '#description' => $this->t('Swiper Card Layout'),
      '#default_value' => $config['swiper_card_layout']??'layout_1',
    );

    $form['has_background'] = array(
      '#type' => 'checkbox',
      '#title' => $this->t('Has Background Color'),
      '#description' => $this->t('Swiper Cards Container has Background Color'),
      '#default_value' => $config['has_background']??'false'
    );

    $form['background_color'] = array(
      '#type' => 'color',
      '#title' => $this->t('Swiper Cards Background Color'),
      '#description' => $this->t('Swiper Cards Container Background Color'),
      '#default_value' => $config['background_color']??'#212121',
      '#states' => array(
        'visible' => array(
          ':input[name="settings[has_background]"]' => ['checked' => TRUE],
        )
      )
    );

    $form['#tree'] = TRUE;

    $form['items_fieldset'] = [
      '#type' => 'fieldset',
      '#title' => $this->t('Swiper Cards'),
      '#prefix' => '<div id="items-fieldset-wrapper">',
      '#suffix' => '</div>',
    ];


    if (!$form_state->has('num_items')) {
      if(is_array($items)) {
        $count_items = count($items);
      } else {
        $count_items = 0;
      }
      $form_state->set('num_items', $count_items);
    }
    $number_of_items = $form_state->get('num_items');

    for ($i = 0; $i < $number_of_items; $i++) {

      $is_active_row = $form_state->get("row_" . $i );

      if($is_active_row != 'inactive') {

        $j = $i+1;
        $form['items_fieldset']['items'][$i] = [
          '#type' => 'details',
          '#title' => $this->t('Swiper Card '. $j),
          '#prefix' => '<div id="items-fieldset-wrapper">',
          '#suffix' => '</div>',
          '#open' => TRUE,
        ];

        $form['items_fieldset']['items'][$i]['card_image'] = [
         '#title' => $this->t('Card image'),
         '#type' => 'managed_file',
         '#upload_location' => 'public://module-images/home-slider-images/',
         '#multiple' => FALSE,
         '#description' => $this->t('Allowed extensions: png jpg jpeg.'),
         '#upload_validators' => [
          'file_validate_is_image' => array(),
          'file_validate_extensions' => array('png jpg jpeg'),
          'file_validate_size' => array(25600000)
        ],
        '#theme' => 'image_widget',
        '#preview_image_style' => 'medium',
        '#default_value' => ( isset($items[$i]->card_image[0]) ) ? [$items[$i]->card_image[0]] : NULL,
      ];

      $form['items_fieldset']['items'][$i]['card_title'] = [
        '#type' => 'textfield',
        '#title' => $this->t('Card title'),
        '#description' => $this->t('Card title'),
        '#default_value' => $items[$i]->card_title??'',
      ];

      $form['items_fieldset']['items'][$i]['card_subtitle'] = [
        '#type' => 'textfield',
        '#title' => $this->t('Card subtitle'),
        '#description' => $this->t('Card subtitle'),
        '#default_value' => $items[$i]->card_subtitle??'',
      ];

      $form['items_fieldset']['items'][$i]['card_description'] = [
        '#type' => 'text_format',
        '#title' => $this->t('Card description'),
        '#description' => $this->t('Card description'),
        '#default_value' => (isset($items[$i]->card_description->value))?$items[$i]->card_description->value:'',
        '#format' => (isset($items[$i]->card_description))?$items[$i]->card_description->format:'basic_html',
      ];

      $form['items_fieldset']['items'][$i]['weight'] = [
        '#type' => 'number',
        '#min' => 1,
        '#max' => 120,
        '#title' => $this->t('Swiper Card order weight'),
        '#description' => $this->t('The weight field can be used to provide customized sorting of swiper_cards.'),
        '#default_value' => $items[$i]->weight??$j,
      ];

      $form['items_fieldset']['items'][$i]['remove_single_item'] = [
        '#type' => 'submit',
        '#value' => $this->t('Remove item'),
        '#name' => 'row_'.$i,
        '#submit' => [[$this, 'removeItemCallback']],
        '#ajax' => [
          'callback' => [$this, 'addmoreCallback'],
          'wrapper' => 'items-fieldset-wrapper',
        ],
        '#button_type' => 'danger',
      ];
    }
  }

  $form['items_fieldset']['actions'] = [
    '#type' => 'actions',
  ];

  $form['items_fieldset']['actions']['add_item'] = [
    '#type' => 'submit',
    '#value' => $this->t('Add swiper card'),
    '#submit' => [[$this, 'addOne']],
    '#ajax' => [
        'callback' => [$this, 'addmoreCallback'], //'\Drupal\swiper_cards\Plugin\Block\ALaUneBlock::addmoreCallback',
        'wrapper' => 'items-fieldset-wrapper',
      ],
      '#button_type' => 'primary',
    ];

    return $form;
  }

     /**
     * Submit handler for the "remove one" button.
     *
     * Decrements the max counter and causes a form rebuild.
     */
     public function removeItemCallback(array &$form, FormStateInterface $form_state) {
      $button_clicked = $form_state->getTriggeringElement()['#name'];

      $form_state->set($button_clicked, 'inactive');

      $form_state->setRebuild();

    }

  /**
   * @param array $form
   * @param \Drupal\Core\Form\FormStateInterface $form_state
   */
  public function addOne(array &$form, FormStateInterface $form_state) {
    $number_of_items = $form_state->get('num_items');
    $add_button = $number_of_items + 1;
    $form_state->set('num_items', $add_button);
    $form_state->setRebuild();
  }

  /**
   * @param array $form
   * @param \Drupal\Core\Form\FormStateInterface $form_state
   * @return mixed
   */
  public function addmoreCallback(array &$form, FormStateInterface $form_state) {
    // The form passed here is the entire form, not the subform that is
    // passed to non-AJAX callback.
    return $form['settings']['items_fieldset'];
  }

  /**
   * @param array $form
   * @param \Drupal\Core\Form\FormStateInterface $form_state
   */
  public function removeCallback(array &$form, FormStateInterface $form_state) {
    $number_of_items = $form_state->get('num_items');
    if ($number_of_items > 1) {
      $remove_button = $number_of_items - 1;
      $form_state->set('num_items', $remove_button);
    }
    $form_state->setRebuild();
  }
  /**
   * @param array $form
   * @param \Drupal\Core\Form\FormStateInterface $form_state
   */
  public function removeCallbackSingle(array &$form, FormStateInterface $form_state) {
    $number_of_items = $form_state->get('num_items');
    if ($number_of_items > 1) {
      $remove_button = $number_of_items - 1;
      $form_state->set('num_items', $remove_button);
    }
    $form_state->setRebuild();
  }

  /**
   * {@inheritdoc}
   */
  public function blockSubmit($form, FormStateInterface $form_state) {

    $swiper_cards_data_config = $this->configuration['swiper_cards_data']??'';
    $getCardssOldImageIds = getCardssOldImageIds($swiper_cards_data_config);

    $current_image_ids = array();
    $items = array();

    $values = $form_state->getValues();
    foreach ($values as $key => $value) {

      if ($key === 'items_fieldset') {
        if (isset($value['items']) && !empty($value['items'])) {
          $items = $value['items'];

          usort($items, function($x, $y) {
            if(is_numeric($x['weight']) && is_numeric($y['weight'])) {
              return $x['weight'] - $y['weight'];
            }
          });

          foreach ($items as $key => $item) {
            if (trim($item['card_title']) === '') {
              unset($items[$key]);
            } else {
              if(!is_numeric($item['weight'])) {
                $items[$key]['weight'] = 1;
              }

              if(isset($item['card_image'][0])) {
                $image_id = $item['card_image'][0];
                $file = File::load( $image_id );
                $file->setPermanent();
                $file->save();
                $current_image_ids[] = $image_id;
              }
            }
          }

          $swiper_cards_data = array_values($items);
          $swiper_cards_data = json_encode($swiper_cards_data);

          $this->configuration['swiper_cards_data'] = $swiper_cards_data;
        } else {
          $this->configuration['swiper_cards_data'] = '';
        }

        // remove old images

        $result = array_diff($getCardssOldImageIds, $current_image_ids);
        if(!empty($result)) {
          foreach ($result as $key => $card_image_id) {
            $file = File::load($card_image_id);
            $file->setTemporary();
            $file->save();
          }
        }
      }
    }

    $this->configuration['swiper_card_header'] = $values['swiper_card_header']['value']??'';
    $this->configuration['swiper_card_header_format'] = $values['swiper_card_header']['format'];
    $this->configuration['swiper_card_layout'] = $values['swiper_card_layout'];
    $this->configuration['has_background'] = $values['has_background'];
    $this->configuration['background_color'] = $values['background_color'];

  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    $configuration = $this->configuration;
    $swiper_cards_data_config = $configuration['swiper_cards_data']??'';

    $swiper_card_layout = $configuration['swiper_card_layout']??'layout_1';

    $default_data = array(
      'swiper_card_header' => $configuration['swiper_card_header']??''
    );
    $background_color = '';
    if($configuration['has_background']) {
      $background_color = $configuration['background_color'];
    }
    $default_data['background_color'] = $background_color;

    $swiper_cards_data = array();
    if($swiper_cards_data_config != '') {
      $swiper_cards_data = json_decode($swiper_cards_data_config);

      foreach ($swiper_cards_data as $key => $swiper_card) {
        $image_url = '';
        $card_image_id = $swiper_card->card_image[0]??'';
        if($card_image_id != '') {
          $file = File::load($card_image_id);
          if($file) {
            $image_url = file_create_url($file->getFileUri());
          }
        }
        $swiper_cards_data[$key]->image_url = $image_url;
      }
    }
    $build = [];
    $build['swiper_cards'] = [
      '#theme' => 'swiper_cards',
      '#swiper_cards_data' => $swiper_cards_data,
      '#swiper_card_layout' => $swiper_card_layout,
      '#default_data' => $default_data
    ];

    $build['#attached']['library'][] = 'swiper_cards/swiper_cards';
    return $build;
  }

}