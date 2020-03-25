<?php

namespace Drupal\video_track\Plugin\Field\FieldFormatter;

use Drupal\videojs\Plugin\Field\FieldFormatter\VideoJsPlayerListFormatter;
use Drupal\Core\Url;
use Drupal\Core\Field\FieldItemListInterface;

/**
 * Plugin implementation of the 'video_track_formatter' formatter.
 *
 * @FieldFormatter(
 *   id = "video_track_formatter",
 *   label = @Translation("Video track formatter"),
 *   field_types = {
 *     "video_track_field_type"
 *   }
 * )
 */
class VideoTrackFormatter extends VideoJsPlayerListFormatter {

  public function viewElements(FieldItemListInterface $items, $langcode) {
    $elements = array();
    $files = $this->getEntitiesToView($items, $langcode);

    // Early opt-out if the field is empty.
    if (empty($files)) {
      return $elements;
    }

    // Collect cache tags to be added for each item in the field.
    $video_items = array();
    $track_items = [];
    $track_values = $items->getValue();
    
    foreach ($files as $delta => $file) {
      $video_uri = $file->getFileUri();
      if ($file->getMimeType() == 'video/mp4') {
        $video_items[] = Url::fromUri(file_create_url($video_uri));
      }
      if ($file->getMimeType() == 'text/vtt') {
        $track_items[] = [
          'kind' => $track_values[$delta]['kind'],
          'label' => $track_values[$delta]['label'],
          'srclang' => $track_values[$delta]['srclang'],
          'src' => Url::fromUri(file_create_url($video_uri)),
          'default' => $track_values[$delta]['default'],
        ];
      }
    }

    $elements[] = array(
      '#theme' => 'video_track',
      '#items' => $video_items,
      '#player_attributes' => $this->getSettings(),
      '#tracks' => $track_items,
      '#attached' => array(
        'library' => array('videojs/videojs'),
      ),
    );

    return $elements;
  }

}
