<?php

namespace Drupal\video_track\Plugin\Field\FieldWidget;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\file\Plugin\Field\FieldWidget\FileWidget;
use Drupal\Core\Form\FormStateInterface;

/**
 * Plugin implementation of the 'video_track_widget' widget.
 *
 * @FieldWidget(
 *   id = "video_track_widget",
 *   module = "video_track",
 *   label = @Translation("Video track widget"),
 *   field_types = {
 *     "video_track_field_type"
 *   }
 * )
 */
class VideoTrackWidget extends FileWidget {

  /**
   * {@inheritdoc}
   */
  public function formElement(FieldItemListInterface $items, $delta, array $element, array &$form, FormStateInterface $form_state) {
    $widget = parent::formElement($items, $delta, $element, $form, $form_state);

    
    $widget['kind'] = [
      '#type' => 'textfield',
      '#title' => 'Kind',
      '#description' => 'Kind of what type track file',
      '#default_value' => isset($items[$delta]) ? $items[$delta]->kind : '',
    ];
    $widget['label'] = [
      '#type' => 'textfield',
      '#title' => 'Label',
      '#description' => 'Label Attribute',
      '#default_value' => isset($items[$delta]) ? $items[$delta]->label : '',
    ];
    $widget['srclang'] = [
      '#type' => 'textfield',
      '#title' => 'Source language',
      '#description' => 'Kind of what type track file',
      '#default_value' => isset($items[$delta]) ? $items[$delta]->srclang : '',
    ];
    $widget['default'] = [
      '#type' => 'checkbox',
      '#title' => 'default',
      '#description' => 'Check if this is a default value.',
      '#default_value' => isset($items[$delta]) ? $items[$delta]->default : 0,
    ];

    return $widget;
  }

}
