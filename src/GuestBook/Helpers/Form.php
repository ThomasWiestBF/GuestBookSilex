<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 11.08.2015
 * Time: 08:06
 */
namespace GuestBook\Helpers;
class Form {

    /**
     * @param $app
     *
     * @return \Symfony\Component\Form\Form
     */
    public static function getGuestBookForm($app){
        return $app['form.factory']->createBuilder('form', null, [
            'action' => $app['url_generator']->generate('save'),
            'method' => 'POST',
        ])->add('Username', 'text')->add('Message', 'textarea')->add('save', 'submit')->getForm();
    }
}