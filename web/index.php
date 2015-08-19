<?php

require_once __DIR__ . '../../vendor/autoload.php';
require_once '../src/Guestbook/Helpers/Form.php';
require_once '../src/Guestbook/Helpers/ModelFactory.php';
require_once '../src/Guestbook/Models/GuestBookFileModel.php';

$app = new Silex\Application();
$app->register(new Silex\Provider\TwigServiceProvider(), [
    'twig.path' =>'../src/views',
]);
$app->register(new Silex\Provider\UrlGeneratorServiceProvider());
$app->register(new \Silex\Provider\FormServiceProvider());
$app->register(new Silex\Provider\TranslationServiceProvider(), [
    'translator.domains' => [],
]);

$app['debug'] = true;

/**
 * index Action
 */
$app->get('/symfony/', function() use($app) {
    $objModel = GuestBook\Helpers\ModelFactory::getGuestBookModel();
    return $app['twig']->render('index.html.twig', [
        'entries' => (array)$objModel->getAllEntries(),
    ]);
})->bind('home');

/**
 * add action
 */
$app->get('/symfony/add', function() use($app) {
    return $app['twig']->render('add.html.twig', [
            'form' => GuestBook\Helpers\Form::getGuestBookForm($app)->createView()
        ]);
})->bind('add');

/**
* Save Action
 */
$app->post('/symfony/save', function() use($app) {

    $objModel = GuestBook\Helpers\ModelFactory::getGuestBookModel();
    $objFormBuilder = GuestBook\Helpers\Form::getGuestBookForm($app);
    $objFormBuilder->handleRequest(\Symfony\Component\HttpFoundation\Request::createFromGlobals());

    if ($objFormBuilder->isValid()) {
        $data = $objFormBuilder->getData();

        /* creating new Entry-Object and add to Entry-index.
        Has to be replaced by a Class (e.g. Entry) with its Attributes "Username" and "Message"
        to solve it in a proper way */

        $objStd = new \stdClass();
        $objStd->Username = $data['Username'];
        $objStd->Message = $data['Message'];

        $objModel->addNewEntry($objStd);
    }

    return new \Symfony\Component\HttpFoundation\RedirectResponse($app['url_generator']->generate('home'));

})->bind('save');


/**
 * delete action
 */
$app->get('/symfony/delete/{id}', function($id) use($app) {
    $objModel = GuestBook\Helpers\ModelFactory::getGuestBookModel();
    $objModel->deleteEntry($id);
    return new \Symfony\Component\HttpFoundation\RedirectResponse($app['url_generator']->generate('home'));
})->bind('delete');


$app->run();