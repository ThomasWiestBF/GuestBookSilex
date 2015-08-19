<?php

//Check the index page
$I = new AcceptanceTester($scenario);
$I->wantTo('See the index page');
$I->amOnPage('/');
$I->see('Add');