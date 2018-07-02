<?php
if(!defined('DOKU_INC')) die();

class action_plugin_lockdown extends DokuWiki_Action_Plugin {
  function getInfo() {
    return array(
      'author' => 'Adrian Heine',
      'email'  => 'mail@adrianheine.de',
      'date'   => '2009-11-22',
      'name'   => 'Lockdown',
      'desc'   => 'Prohibit most actions for anon users',
      'url'    => 'https://github.com/adrianheine/dokuwiki-plugin-lockdown'
    );
  }

  function register(Doku_Event_Handler $controller) {
    $controller->register_hook('ACTION_ACT_PREPROCESS', 'BEFORE', $this, 'action');
  }

  function action(Doku_Event $event, $param) {
    global $ID;
    $allowed_actions = array('show', 'search', 'login', 'resendpwd', 'index');
    if (!isset($_SERVER['REMOTE_USER']) && !in_array($event->data, $allowed_actions)) {
      $event->data = 'show';
    }
    if ($event->data === 'show' && !page_exists($ID) && page_exists('')) {
      act_redirect('');
    }
  }
}
