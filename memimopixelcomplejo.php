<?php

class MemimoPixelComplejo extends Module
{
  public function __construct()
  {
    $this->name = 'memimopixelcomplejo';
    $this->tab = 'Stats';
    $this->version = '0.2';

    parent::__construct();

    /* The parent construct is required for translations */
    $this->page = basename(__FILE__, '.php');
    $this->displayName = $this->l('Memimo pixel complejo');
    $this->description = $this->l('Muestra el pixel complejo de Memimo luego de la confirmación de una venta');
  }

  public function install()
  {
    return parent::install() &&
      $this->registerHook('orderConfirmation');
  }

  public function uninstall()
  {
    return parent::uninstall();
  }

  public function hookOrderConfirmation($params)
  {
    global $smarty;

    $order = $params['objOrder'];
    $currency = $params['currencyObj'];
    $smarty->assign(array(
      'orderId' => $order->id,
      'total' => $order->total_paid - $order->total_shipping,
      'totalPaid' => $order->total_paid,
      'totalProducts' => $order->total_products,
      'totalCommision' => $order->total_products * 10 / 100,
      'currency' => $currency->iso_code
    ));

    return $this->display(__FILE__, 'memimopixelcomplejo.tpl');
  }
}

?>
