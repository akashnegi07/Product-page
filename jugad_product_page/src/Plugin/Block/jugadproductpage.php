<?php

namespace Drupal\jugad_product_page\Plugin\Block;
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelHigh;
use Endroid\QrCode\Writer\PngWriter;

use Drupal\Core\Block\BlockBase;
/**
 * @Block(
 *   id = "jugad_product_page",
 *   admin_label = @Translation("new jugad module"),
 *   category = @Translation("Building a product module for drupal 9"),
 * )
 */

class jugadproductpage extends BlockBase {


  public function build() {

  $node = \Drupal::routeMatch()->getParameter('node');

    if ($node->getType() === 'product') {

       
      $data=$node->field_purchase_link->uri;
      
      return [
        '#theme' => 'code_block',
        '#code_path' => $this->newQRCode($data),
      ];
    }

  }

  protected function newQRCode(string $data) {

    $result = Builder::create()
      ->writer(new PngWriter())
      ->writerOptions([])
      ->data($data)
      ->encoding(new Encoding('UTF-8'))
      ->errorCorrectionLevel(new ErrorCorrectionLevelHigh())
      ->size(300)
      ->margin(10)
      ->build();
    return $result->getDataUri();


  }
}