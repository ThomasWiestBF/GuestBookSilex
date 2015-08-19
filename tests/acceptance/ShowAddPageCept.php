<?php
$I = new AcceptanceTester($scenario);
$I->wantTo('See the add page');
$I->amOnPage('/add');
$I->see('Username');
$I->see('Message');
