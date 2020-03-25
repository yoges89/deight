<?php

namespace Drupal\video_track\Plugin\Field\FieldType;

use Drupal\Core\Field\FieldStorageDefinitionInterface;
use Drupal\file\Plugin\Field\FieldType\FileItem;
use Drupal\Core\TypedData\DataDefinition;
use Drupal\Core\StringTranslation\TranslatableMarkup;

/**
 * Plugin implementation of the 'video_track_field_type' field type.
 *
 * @FieldType(
 *   id = "video_track_field_type",
 *   label = @Translation("Video track field type"),
 *   description = @Translation("A field that gives an option to enter subtitle."),
 *   category = @Translation("Reference"),
 *   default_widget = "file_generic",
 *   default_formatter = "file_default",
 *   list_class = "\Drupal\file\Plugin\Field\FieldType\FileFieldItemList",
 *   constraints = {"ReferenceAccess" = {}, "FileValidation" = {}}
 * )
 */
class VideoTrackFieldType extends FileItem {

  /**
   * {@inheritdoc}
   */
  public static function propertyDefinitions(FieldStorageDefinitionInterface $field_definition) {
    $properties = parent::propertyDefinitions($field_definition);
    
    $properties['kind'] = DataDefinition::create('string')
      ->setLabel(new TranslatableMarkup('Kind'))
      ->setDescription(new TranslatableMarkup('kind is given a value of subtitles, indicating the type of content the files contain'));
    
    $properties['label'] = DataDefinition::create('string')
      ->setLabel(new TranslatableMarkup('Label'))
      ->setDescription(new TranslatableMarkup('label is given a value indicating which language that subtitle set is for'));
    
    $properties['srclang'] = DataDefinition::create('string')
      ->setLabel(new TranslatableMarkup('Source Lang'))
      ->setDescription(new TranslatableMarkup('indicates what language each subtitle files\' contents are in'));
    
    $properties['default'] = DataDefinition::create('boolean')
      ->setLabel(new TranslatableMarkup('Default'))
      ->setDescription(new TranslatableMarkup('Indicate this track should be loaded as default'));

    return $properties;
  }

  /**
   * {@inheritdoc}
   */
  public static function schema(FieldStorageDefinitionInterface $field_definition) {
    return [
      'columns' => [
        'target_id' => [
          'description' => 'The ID of the file entity.',
          'type' => 'int',
          'unsigned' => TRUE,
        ],
        'display' => [
          'description' => 'Flag to control whether this file should be displayed when viewing content.',
          'type' => 'int',
          'size' => 'tiny',
          'unsigned' => TRUE,
          'default' => 1,
        ],
        'description' => [
          'description' => 'A description of the file.',
          'type' => 'text',
        ],
        'kind' => [
          'type' => 'text',
          'description' => 'Track type',
        ],
        'srclang' => [
          'type' => 'text',
          'description' => 'Language code for the track type',
        ],
        'label' => [
          'type' => 'text',
          'description' => 'Label of the track type',
        ],
        'default' => [
          'type' => 'int',
          'size' => 'tiny',
          'description' => 'Set default track',
        ],
      ],
      'indexes' => [
        'target_id' => ['target_id'],
      ],
      'foreign keys' => [
        'target_id' => [
          'table' => 'file_managed',
          'columns' => ['target_id' => 'fid'],
        ],
      ],
    ];
  }

}
